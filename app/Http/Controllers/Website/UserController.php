<?php

namespace App\Http\Controllers\Website;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Hash;

use App\Models\Customer;
use App\Models\Listing;
use App\Models\ListingImage;
use App\Models\ListingCategory;

class UserController extends Controller
{
    protected $providers = [
        'facebook', 'google', 'twitter', 'kakao'
    ];

    public function redirectToProvider($driver)
    {
        session()->put('redirectURL', url()->previous());

        if(!$this->isProviderAllowed($driver) ) {
            return $this->sendFailedResponse("{$driver} is not currently supported");
        }
        try {
            return Socialite::driver($driver)->redirect();            
        } catch (Exception $e) {
            // You should show something simple fail message
            return $this->sendFailedResponse($e->getMessage());
        }
    }

    private function isProviderAllowed($driver)
    {
        return in_array($driver, $this->providers) && config()->has("services.{$driver}");
    }

    protected function sendSuccessResponse()
    {
        return redirect()->to(session('redirectURL'));
    }

    protected function sendFailedResponse($msg = null)
    {
        return redirect()->to(session('redirectURL'))
            ->withErrors(['msg' => $msg ?: 'Unable to login, try with another provider to login.']);
    }

    public function handleProviderCallback( $driver )
    {
        try {
            $user = Socialite::driver($driver)->user();
        } catch (Exception $e) {
            return $this->sendFailedResponse($e->getMessage());
        }

        // check for email in returned user
        return empty( $user->id )
            ? $this->sendFailedResponse("No email id returned from {$driver} provider.")
            : $this->loginOrCreateAccount($user, $driver);
    }

    protected function loginOrCreateAccount($providerUser, $driver)
    {
        // check for already has account
        $user = Customer::where('provider_id', $providerUser->getId())->first();

        // if user already found
        if( $user ) {
            // update the avatar and provider that might have changed
            $user->update([
                'name' => $providerUser->getName(),
                'email' => $providerUser->getEmail(),
                'avatar' => $providerUser->avatar,
                'provider' => $driver,
                'provider_id' => $providerUser->id,
                'access_token' => $providerUser->token,
                'refresh_token' => isset($providerUser->refreshToken) ? $providerUser->refreshToken : '',
                'expires_in' => isset($providerUser->expiresIn) ? $providerUser->expiresIn : '',
                // 'refresh_token_expires_in' => $providerUser->accessTokenResponseBody['refresh_token_expires_in'],
            ]);
        } else {
            $user = Customer::create([
                'name' => $providerUser->getName(),
                'email' => $providerUser->getEmail(),
                'avatar' => $providerUser->getAvatar(),
                'provider' => $driver,
                'provider_id' => $providerUser->getId(),
                'access_token' => $providerUser->token,
                'refresh_token' => isset($providerUser->refreshToken) ? $providerUser->refreshToken : '',
                'expires_in' => isset($providerUser->expiresIn) ? $providerUser->expiresIn : '',
                // 'refresh_token_expires_in' => $providerUser->accessTokenResponseBody['refresh_token_expires_in'],
                'password' => ''
            ]);
        }

        // login the user
        Auth::guard('customer')->login($user);

        return $this->sendSuccessResponse();
    }

    public function login(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
            
            if (Auth::guard('customer')->attempt($credentials, $request->boolean('remember'))) {
                return response()->json([
                    'success' => true,
                    'message' => 'Đăng nhập thành công!',
                    'redirect' => session('redirectURL', url('/'))
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Email hoặc mật khẩu không chính xác'
            ], 401);
        }
        
        // Fallback cho trường hợp không phải Ajax
        if ($request->isMethod('post')) {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
            
            if (Auth::guard('customer')->attempt($credentials, $request->boolean('remember'))) {
                return redirect()->to(session('redirectURL', url('/')))->with('success', 'Đăng nhập thành công');
            }
            
            return redirect()->back()->with('error', 'Email hoặc mật khẩu không chính xác');
        }
        
        session()->put('redirectURL', url()->previous());
        return view('website.user.login');
    }

    public function register(Request $request)
    {

        if ($request->ajax() || $request->wantsJson()) {
            $validator = Validator::make($request->all(), [
                'name' => 'nullable|string|max:255',
                'email' => 'required|email|unique:customers',
                'phone' => 'nullable|string|max:20',
                'password' => 'required|min:6|confirmed',
            ], [
                'email.email' => 'Định dạng email không hợp lệ',
                'email.required' => 'Địa chỉ email không được để trống',
                'email.unique' => 'Địa chỉ email đã tồn tại',
                'password.required' => 'Mật khẩu không được để trống',
                'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
                'password.confirmed' => 'Xác nhận mật khẩu không trùng khớp',
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            
            $customer = Customer::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
            ]);
            
            if ($customer) {
                // Có thể tự động đăng nhập sau khi đăng ký
                // Auth::guard('customer')->login($customer);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Đăng ký tài khoản thành công! Vui lòng đăng nhập để tiếp tục.'
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Đăng ký thất bại. Vui lòng thử lại!'
            ], 500);
        }
        
        // Fallback cho trường hợp không phải Ajax
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'email' => 'email|required|unique:customers',
                'password' => 'required|min:6|confirmed',
            ], [
                'email.email' => 'Định dạng email không hợp lệ',
                'email.required' => 'Địa chỉ email không được để trống',
                'email.unique' => 'Địa chỉ email đã tồn tại',
                'password.required' => 'Mật khẩu không được để trống',
                'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
                'password.confirmed' => 'Xác nhận mật khẩu không trùng khớp',
            ]);
            
            $data = $request->only(['name', 'email', 'phone', 'password']);
            $data['password'] = Hash::make($data['password']);
            
            $customer = Customer::create($data);
            
            if ($customer) {
                return redirect()->route('user.login')
                    ->with('success', 'Tạo tài khoản mới thành công')
                    ->with('email', $data['email']);
            }
            
            return back()->with('error', 'Đăng ký thất bại, xin hãy thử lại');
        }
        
        return view('website.user.register');
    }

    public function logout() {
        Auth::guard('customer')->logout();
        return redirect()->route('home');
    }

    public function profile(Request $request)
    {
        $user = Auth::guard('customer')->user();
        
        // Thống kê tin đăng
        $totalListings = Listing::where('customer_id', $user->id)->count();
        $approvedListings = Listing::where('customer_id', $user->id)->where('status', 1)->count();
        $pendingListings = Listing::where('customer_id', $user->id)->where('status', 0)->count();
        
        // Xử lý POST request (cập nhật thông tin)
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'address' => 'nullable|string|max:500',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ], [
                'name.required' => 'Họ tên không được để trống',
                'phone.required' => 'Số điện thoại không được để trống',
                'avatar.image' => 'File phải là hình ảnh',
                'avatar.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif',
                'avatar.max' => 'Ảnh không được vượt quá 2MB',
            ]);
            
            if ($validator->fails()) {
                return redirect()->route('user.profile')
                    ->withErrors($validator)
                    ->withInput();
            }
            
            try {
                $data = [
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'address' => $request->address,
                ];
                
                // Xử lý upload avatar
                if ($request->hasFile('avatar')) {
                    $avatar = $request->file('avatar');
                    $extension = $avatar->getClientOriginalExtension();
                    $fileName = 'avatar_' . $user->id . '_' . time() . '.' . $extension;
                    
                    // Thư mục lưu avatar
                    $folderPath = 'uploads/avatars';
                    $fullPath = public_path($folderPath);
                    
                    if (!file_exists($fullPath)) {
                        mkdir($fullPath, 0775, true);
                    }
                    
                    // Xóa avatar cũ nếu có
                    if ($user->avatar && file_exists(public_path($user->avatar))) {
                        unlink(public_path($user->avatar));
                    }
                    
                    // Lưu avatar mới
                    $avatar->move($fullPath, $fileName);
                    $data['avatar'] = $folderPath . '/' . $fileName;
                }
                
                // Cập nhật thông tin user
                $status = $user->update($data);
                
                if ($status) {
                    return redirect()->route('user.profile')
                        ->with('success', 'Cập nhật thông tin thành công!');
                } else {
                    return redirect()->route('user.profile')
                        ->with('error', 'Cập nhật thông tin thất bại!');
                }
                
            } catch (\Exception $e) {
                \Log::error('Error updating profile: ' . $e->getMessage());
                return redirect()->route('user.profile')
                    ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
            }
        }
        
        return view('website.user.profile', compact(
            'user', 
            'totalListings', 
            'approvedListings', 
            'pendingListings'
        ));
    }

    public function password(Request $request)
    {
        $user = Auth::guard('customer')->user();
        
        // Xử lý POST request (đổi mật khẩu)
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'current_password' => 'required',
                'password' => 'required|min:6|confirmed',
            ], [
                'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại',
                'password.required' => 'Vui lòng nhập mật khẩu mới',
                'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
                'password.confirmed' => 'Xác nhận mật khẩu không khớp',
            ]);
            
            // Kiểm tra mật khẩu hiện tại
            if (!Hash::check($request->current_password, $user->password)) {
                $validator->errors()->add('current_password', 'Mật khẩu hiện tại không đúng');
                return redirect()->route('user.password')
                    ->withErrors($validator)
                    ->withInput();
            }
            
            if ($validator->fails()) {
                return redirect()->route('user.password')
                    ->withErrors($validator)
                    ->withInput();
            }
            
            try {
                // Cập nhật mật khẩu mới
                $user->password = Hash::make($request->password);
                $status = $user->save();
                
                if ($status) {
                    return redirect()->route('user.password')
                        ->with('success', 'Đổi mật khẩu thành công!');
                } else {
                    return redirect()->route('user.password')
                        ->with('error', 'Đổi mật khẩu thất bại!');
                }
                
            } catch (\Exception $e) {
                \Log::error('Error changing password: ' . $e->getMessage());
                return redirect()->route('user.password')
                    ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
            }
        }
        
        return view('website.user.password', compact('user'));
    }

    public function history(Request $request) {
        return view('user.history');
    }

    public function order(Request $request) {
        return view('user.order');
    }

     // Hàm đăng tin mới
     public function storeListing(Request $request)
    {
        // Kiểm tra đăng nhập
        if (!Auth::guard('customer')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn cần đăng nhập để đăng tin'
            ], 401);
        }

        // Validation
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:listing_categories,id',
            'type' => 'required|in:sale,rent,buy,rental',
            'price' => 'required|string|max:100',
            'area' => 'required|string|max:50',
            'location' => 'required|string|max:500',
            'description' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ], [
            'title.required' => 'Tiêu đề không được để trống',
            'category_id.required' => 'Vui lòng chọn loại bất động sản',
            'type.required' => 'Vui lòng chọn hình thức',
            'price.required' => 'Giá không được để trống',
            'area.required' => 'Diện tích không được để trống',
            'location.required' => 'Địa chỉ không được để trống',
            'description.required' => 'Mô tả không được để trống',
            'images.*.image' => 'File phải là hình ảnh',
            'images.*.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, webp',
            'images.*.max' => 'Hình ảnh không được vượt quá 5MB',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Tạo slug từ tiêu đề
            $slug = Str::slug($request->title);
            $originalSlug = $slug;
            $counter = 1;
            
            // Kiểm tra slug trùng
            while (Listing::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            // Tạo excerpt từ description (lấy 200 ký tự đầu)
            $excerpt = Str::limit(strip_tags($request->description), 200);

            // Lấy user hiện tại
            $user = Auth::guard('customer')->user();

            // Tạo listing
            $listing = Listing::create([
                'category_id' => $request->category_id,
                'type' => $request->type,
                'name' => $request->title,
                'slug' => $slug,
                'excerpt' => $excerpt,
                'content' => $request->description,
                'status' => 0, // 0 = chờ duyệt
                'is_highlight' => 0,
                'price' => $request->price,
                'area' => $request->area,
                'location' => $request->location,
                'meta_keywords' => $request->title,
                'meta_description' => $excerpt,
                'customer_id' => $user->id,
                'customer_name' => $user->name ?? '',
                'customer_phone' => $user->phone ?? '',
                'customer_email' => $user->email ?? '',
            ]);

            // Xử lý upload ảnh
            if ($request->hasFile('images')) {
                // Tạo thư mục dựa trên slug
                $folderPath = 'uploads/listings/' . $slug;
                $fullPath = public_path($folderPath);
                
                // Tạo thư mục nếu chưa tồn tại
                if (!file_exists($fullPath)) {
                    mkdir($fullPath, 0775, true);
                }
                
                foreach ($request->file('images') as $key => $image) {
                    // Tạo tên file đơn giản
                    $extension = $image->getClientOriginalExtension();
                    $fileName = ($key + 1) . '.' . $extension; // 1.jpg, 2.jpg, ...
                    
                    // Lưu ảnh
                    $image->move($fullPath, $fileName);
                    
                    // Lưu vào database
                    $listingImage = ListingImage::create([
                        'listing_id' => $listing->id,
                        'image' => $folderPath . '/' . $fileName,
                        'name' => $image->getClientOriginalName(),
                        'is_avatar' => $key === 0 ? 1 : 0,
                    ]);
                    
                    // Nếu là ảnh đầu tiên, cập nhật làm ảnh đại diện cho listing
                    if ($key === 0) {
                        $listing->update(['image' => $folderPath . '/' . $fileName]);
                    }
                }
            } else {
                // Nếu không có ảnh, đặt ảnh mặc định
                $listing->update(['image' => 'uploads/no-image.jpg']);
            }

            return response()->json([
                'success' => true,
                'message' => 'Tin đăng của bạn đã được gửi thành công! Tin sẽ được duyệt trong vòng 24 giờ.',
                'listing_id' => $listing->id,
                'redirect' => route('user.order')
            ]);

        } catch (\Exception $e) {
            \Log::error('Error creating listing: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra trong quá trình đăng tin. Vui lòng thử lại!'
            ], 500);
        }
    }
 
    public function myListings(Request $request)
    {
        if (!Auth::guard('customer')->check()) {
            return redirect()->route('user.login');
        }

        $userId = Auth::guard('customer')->id();
        
        // Lấy danh sách tin đăng
        $listings = Listing::where('customer_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        // Thống kê
        $totalCount = $listings->total();
        $approvedCount = Listing::where('customer_id', $userId)
            ->where('status', 1)
            ->count();
        $pendingCount = Listing::where('customer_id', $userId)
            ->where('status', 0)
            ->count();

        return view('website.user.my-listings', compact(
            'listings', 
            'totalCount',
            'approvedCount', 
            'pendingCount'
        ));
    }

    public function destroyListing($id)
    {
        if (!Auth::guard('customer')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn cần đăng nhập để thực hiện thao tác này'
            ], 401);
        }

        $listing = Listing::where('id', $id)
            ->where('customer_id', Auth::guard('customer')->id())
            ->first();

        if (!$listing) {
            return response()->json([
                'success' => false,
                'message' => 'Tin đăng không tồn tại hoặc bạn không có quyền xóa'
            ], 404);
        }

        try {
            $listingSlug = $listing->slug;
            
            // 1. Xóa tất cả ảnh từ database
            foreach ($listing->images as $image) {
                // Xóa file ảnh nếu tồn tại
                if (file_exists(public_path($image->image))) {
                    unlink(public_path($image->image));
                }
                $image->delete();
            }
            
            // 2. Xóa thư mục ảnh của listing
            $folderPath = public_path('uploads/listings/' . $listingSlug);
            if (file_exists($folderPath) && is_dir($folderPath)) {
                // Xóa tất cả file trong thư mục
                $files = glob($folderPath . '/*');
                foreach ($files as $file) {
                    if (is_file($file)) {
                        unlink($file);
                    }
                }
                // Xóa thư mục rỗng
                rmdir($folderPath);
            }
            
            // 3. Xóa bản ghi listing
            $listing->delete();

            return response()->json([
                'success' => true,
                'message' => 'Tin đăng đã được xóa thành công!'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error deleting listing: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa tin đăng: ' . $e->getMessage()
            ], 500);
        }
    }
}

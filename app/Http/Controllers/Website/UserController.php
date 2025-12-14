<?php

namespace App\Http\Controllers\Website;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Hash;

use App\Models\Customer;

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

    public function login(Request $request) {

        if ($request->isMethod('post')) {
            $email = $request->email;
            $password = $request->password;
            if(Auth::guard('customer')->attempt(['email' => $email, 'password' => $password])) {
                // return redirect()->route('home')->with('success','Đăng nhập thành công');
                return redirect()->to(session('redirectURL'))->with('success','Đăng nhập thành công');
            }
            else{
                return redirect()->back()->with('error','Email hoặc mật khẩu không chính xác');
            }
        }

        session()->put('redirectURL', url()->previous());
        
        return view('website.user.login');
    }

    public function register(Request $request) {

        if ($request->isMethod('post')) {
            $this->validate($request, [
                'email'=>'email|required|unique:customers',
                'password'=>'required|min:6|confirmed',
            ], [
                'email.email' => 'Định dạng email không hợp lệ',
                'email.required' => 'Địa chỉ email không được để trống',
                'email.unique' => 'Địa chỉ email đã tồn tại',
                'password.required' => 'Mật khẩu không được để trống',
                'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
                'password.confirmed' => 'Xác nhận mật khẩu không trùng khớp',
            ]);

            $data['email'] = $request->email;
            $data['password'] = Hash::make($request->password);

            $customer = Customer::create($data);
            if($customer){
                return redirect()->route('user.login')
                ->with('success', 'Tạo tài khoản mới thành công')
                ->with('email', $data['email']);
            }
            else{
                return back()->flash('error','Đăng ký thất bại, xin hãy thử lại');
            }
        }

        return view('website.user.register');
    }

    public function logout() {
        Auth::guard('customer')->logout();
        return redirect()->route('home');
    }

    public function profile(Request $request) {

        $user = Auth::guard('customer')->user();

        if ($request->isMethod('post')) {
            $this->validate($request, [
                'name'    => 'required',
                'phone'   => 'required',
                'address' => 'required',
            ],
            [
                'name.required'    => 'Họ tên không được để trống',
                'phone.required'   => 'Số điện thoại không được để trống',
                'address.required' => 'Địa chỉ không được để trống',
            ]);

            $data = $request->except('email');
            $status = Customer::find($user->id)->update($data);

            if($status){
                return redirect()->route('user.profile')->with('success', 'Cập nhật thông tin thành công');
            }
            else{
                return redirect()->route('user.profile')->with('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
            }
        }

        
        return view('website.user.profile', compact('user'));
    }

    public function password(Request $request) {

        if ($request->isMethod('post')) {
            $this->validate($request, [
                'password'=>'required|min:6|confirmed',
            ], [
                'password.required' => 'Mật khẩu không được để trống',
                'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
                'password.confirmed' => 'Xác nhận mật khẩu không trùng khớp',
            ]);

            $user = Auth::guard('customer')->user();
            $data['password'] = Hash::make($request->password);
            $status = $user->update($data);

            if($status){
                return redirect()->route('user.password')->with('success', 'Cập nhật thông tin thành công');
            }
            else{
                return redirect()->route('user.password')->with('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
            }
        }

        return view('website.user.password');
    }

    public function history(Request $request) {
        return view('user.history');
    }

    public function order(Request $request) {
        return view('user.order');
    }
}

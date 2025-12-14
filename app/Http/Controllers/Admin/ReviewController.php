<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use File;
use App\Models\Review;

class ReviewController extends Controller
{
    private $PATH_IMAGE = 'uploads/reviews/';

    public function index()
    {
        $reviews = Review::orderBy('id', 'desc')->paginate(20);
        return view('admin.review.index', compact('reviews'));
    }

    public function create()
    {
        return view('admin.review.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'   => 'required',
            'status' => 'required',
        ]);

        $data = $request->all();

        if($request->hasFile('image')) {
            $file = $request->file('image');
            $fileExtension = $file->getClientOriginalExtension();
            $fileName = md5(time()).'.'.$fileExtension;
            $file->move($this->PATH_IMAGE, $fileName);
            $data['image'] = $this->PATH_IMAGE.$fileName;
        } else {
            $data['image'] = null;
        }

        if(Review::create($data)){
            request()->session()->flash('success', 'Thêm đánh giá thành công');
        }
        else{
            request()->session()->flash('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('review.index');

    }

    public function edit($id)
    {
        $review = Review::find($id);
        return view('admin.review.edit', compact('review'));
    }

    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        $this->validate($request, [
            'name'   => 'required',
            'status' => 'required',
        ]);

        $data = $request->all();

        if($request->hasFile('image')) {

            if ($review->image != '') {
                if(File::exists($review->image)){
                    File::delete($review->image);
                }
            }

            $file = $request->file('image');
            $fileExtension = $file->getClientOriginalExtension();
            $fileName = md5(time()).'.'.$fileExtension;
            $file->move($this->PATH_IMAGE, $fileName);
            $data['image'] = $this->PATH_IMAGE.$fileName;
        }

        if($review->fill($data)->save()){
            request()->session()->flash('success', 'Cập nhật đánh giá thành công');
        }
        else{
            request()->session()->flash('error', 'Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('review.index');
    }


    public function replyReview(Request $request) {
        
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        if($review->delete()){
            request()->session()->flash('success','Xóa đánh giá thành công');
        }
        else{
            request()->session()->flash('error','Đã xảy ra lỗi, xin hãy thử lại!');
        }
        return redirect()->route('review.index');
    }

    public function massUpdate(Request $request) {

        $data = json_decode($request->getContent(), true);
        $result['success'] = false;

        if (!empty($data)) {
            foreach($data as $item) {
                Review::where('id', $item['id'])->update($item);
            }
            $result['success'] = true;
        }

        return response()->json($result);
    }
}

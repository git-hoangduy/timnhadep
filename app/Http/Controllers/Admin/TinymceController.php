<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TinymceController extends Controller
{
    public function uploadImage(Request $request)
    {
        $destinationPath = 'uploads/tinymce/';
        $myimage = $request->file->getClientOriginalName();
        $request->file->move(public_path($destinationPath), $myimage);
        return response()->json(['location' => asset($destinationPath.$myimage)]);

    }
}

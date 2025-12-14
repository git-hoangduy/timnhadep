<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use File;

use App\Models\Setting;
use App\Models\Bank;

class SettingController extends Controller
{
    private $PATH_IMAGE = 'uploads/settings/';

    public function info(Request $request) {

        $type = 'info';

        if ($request->isMethod('post')) {

            $params = $request->except(['_token']);

            foreach ($params as $key => $item) {

                $code = $type.'.'.$key;
                $data = [
                    'type' => $type,
                    'code' => $code,
                    'value' => $item,
                ];

                $setting = Setting::where(['type' => $type, 'code' => $code])->first();

                if (!empty($setting)) {

                    if (in_array($key, ['logo', 'shortcut'])) {
                        if($request->hasFile($key)) {

                            if ($setting->value != '') {
                                if(File::exists($setting->value)){
                                    File::delete($setting->value);
                                }
                            }

                            $file = $request->file($key);
                            $fileExtension = $file->getClientOriginalExtension();
                            $fileName = md5(time().$key).'.'.$fileExtension;
                            $file->move($this->PATH_IMAGE, $fileName);
                            $data['value'] = $this->PATH_IMAGE.$fileName;
                        } else {
                            $data['value'] = $setting->value;
                        }
                    }
                    
                    $setting->fill($data)->save();

                } else {

                    if (in_array($key, ['logo', 'shortcut'])) {
                        if($request->hasFile($key)) {
                            $file = $request->file($key);
                            $fileExtension = $file->getClientOriginalExtension();
                            $fileName = md5(time().$key).'.'.$fileExtension;
                            $file->move($this->PATH_IMAGE, $fileName);
                            $data['value'] = $this->PATH_IMAGE.$fileName;
                        } else {
                            $data['value'] = null;
                        }
                    }

                    Setting::create($data);
                }
            }

            $this->generateSetting();

            return redirect()->route('setting.'.$type)->with('success', 'Cập nhật cài đặt thành công');
        }

        $setting = Setting::where(['type' => $type])->get();
        $setting = $setting->mapWithKeys(function ($item) {
            return [$item['code'] => $item['value']];
        });

        return view('admin.setting.'.$type, compact('setting'));
    }

    public function social(Request $request) {

        $type = 'social';

        if ($request->isMethod('post')) {

            $params = $request->except(['_token']);

            foreach ($params as $key => $item) {

                $code = $type.'.'.$key;
                $data = [
                    'type' => $type,
                    'code' => $code,
                    'value' => $item,
                ];

                $setting = Setting::where(['type' => $type, 'code' => $code])->first();

                if (!empty($setting)) {
                    $setting->fill($data)->save();
                } else {
                    Setting::create($data);
                }  
            }

            $this->generateSetting();

            return redirect()->route('setting.'.$type)->with('success', 'Cập nhật cài đặt thành công');
        }

        $setting = Setting::where(['type' => $type])->get();
        $setting = $setting->mapWithKeys(function ($item) {
            return [$item['code'] => $item['value']];
        });

        return view('admin.setting.'.$type, compact('setting'));
    }

    public function seo(Request $request) {

        $type = 'seo';

        if ($request->isMethod('post')) {

            $params = $request->except(['_token']);

            foreach ($params as $key => $item) {

                $code = $type.'.'.$key;
                $data = [
                    'type' => $type,
                    'code' => $code,
                    'value' => $item,
                ];

                $setting = Setting::where(['type' => $type, 'code' => $code])->first();

                if (!empty($setting)) {
                    if (in_array($key, ['ogimage'])) {
                        if($request->hasFile($key)) {

                            if ($setting->value != '') {
                                if(File::exists($setting->value)){
                                    File::delete($setting->value);
                                }
                            }

                            $file = $request->file($key);
                            $fileExtension = $file->getClientOriginalExtension();
                            $fileName = md5(time().$key).'.'.$fileExtension;
                            $file->move($this->PATH_IMAGE, $fileName);
                            $data['value'] = $this->PATH_IMAGE.$fileName;
                        } else {
                            $data['value'] = $setting->value;
                        }
                    }
                    $setting->fill($data)->save();
                } else {
                    if (in_array($key, ['ogimage'])) {
                        if($request->hasFile($key)) {
                            $file = $request->file($key);
                            $fileExtension = $file->getClientOriginalExtension();
                            $fileName = md5(time().$key).'.'.$fileExtension;
                            $file->move($this->PATH_IMAGE, $fileName);
                            $data['value'] = $this->PATH_IMAGE.$fileName;
                        } else {
                            $data['value'] = null;
                        }
                    }
                    Setting::create($data);
                }
            }

            $this->generateSetting();

            return redirect()->route('setting.'.$type)->with('success', 'Cập nhật cài đặt thành công');
        }

        $setting = Setting::where(['type' => $type])->get();
        $setting = $setting->mapWithKeys(function ($item) {
            return [$item['code'] => $item['value']];
        });

        return view('admin.setting.'.$type, compact('setting'));
    }

    private function generateSetting() {
        $settings = Setting::select('code', 'value')->get();
        $settings = $settings->mapWithKeys(function ($item) {
            return [$item['code'] => $item['value']];
        });
        Storage::disk('local')->put('json/setting.json', json_encode($settings));
    }

}

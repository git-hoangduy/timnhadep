<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use File;

use Illuminate\Support\Facades\Http;

use App\Models\Setting;
use App\Models\Bank;
use App\Models\Province;
use App\Models\Ward;

class SettingController extends Controller
{
    private $PATH_IMAGE = 'uploads/settings/';

    public function info(Request $request) {

        // load province 
        // $provinces = Province::all();
        // $apiKey = 'hvn_kE9EqK9i3pP26rHYV5PJ6358KyroC5f6';

        // foreach ($provinces as $province) {
        //     $page = 1;
            
        //     do {
        //         $response = Http::withHeaders([
        //             'Authorization' => $apiKey
        //         ])->get("https://tinhthanhpho.com/api/v1/new-provinces/{$province->code}/wards", [
        //             'page' => $page
        //         ]);
                
        //         if ($response->successful()) {
        //             $data = $response->json();
                    
        //             foreach ($data['data'] as $ward) {
        //                 Ward::firstOrCreate(
        //                     ['code' => $ward['code']], // Kiểm tra trùng code
        //                     [
        //                         'name' => $ward['name'],
        //                         'type' => $ward['type'],
        //                         'province_code' => $ward['province_code']
        //                     ]
        //                 );
        //             }
                    
        //             $page++;
        //             $totalPages = ceil($data['metadata']['total'] / $data['metadata']['limit']);
        //         } else {
        //             break;
        //         }
                
        //         usleep(500000); // Giảm delay xuống 0.5 giây
        //         set_time_limit(30); // Reset time limit mỗi vòng lặp
                
        //     } while ($page <= $totalPages);
        // }
        // end

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

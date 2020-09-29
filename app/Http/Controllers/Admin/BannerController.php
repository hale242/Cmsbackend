<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DataTables;
use App\Helper;
use App\MenuSystem;
use App\Banner;
use App\BannerDetail;

use App\Language;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['MainMenus'] = MenuSystem::where('menu_system_part', 'Banner')->with('MainMenu')->first();
        $data['Menus'] = MenuSystem::ActiveMenu()->get();
        // $data['BannerCategory'] = BannerCategory::where('banner_category_status', '1')->get();
        $data['Language'] = Language::where('languages_status', '1')->get();
        // $data['SeoTypes'] = [
        //     "0" => "ใช้ SEO หลัก",
        //     "1" => "ใช้ SEO ตามภาษา"
        // ];
        if (Helper::CheckPermissionMenu('Banner', '1')) {
            return view('admin.Banner.banner', $data);
        } else {
            return redirect('admin/');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $banner_lang = $request->input('lang');
        $banner = $request->input('banner');

        $url_temp = public_path('uploads/BannerImageTemp');
        $url_upload = public_path('uploads/BannerImage');
        $file_name_all = $this->readDir($url_temp);

        $validator = Validator::make($request->all(), [
            // 'banner_seo_title' => 'required',
        ]);
        $array = array();

        // foreach ($banner_lang as $key => $val) {
        // }
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                if ($banner) {
                    $Banner = new Banner;
                    $Language = Language::where('languages_type', '1')->first();
                    foreach ($banner as $key => $val) {
                        $Banner->{$key} = $val;
                    }
                    if (!isset($banner['banner_status'])) {
                        $Banner->banner_status = 0;
                    }

                    $Banner->save();
                    $banner_id = $Banner->getKey();
                }
                if ($banner_lang) {
                    foreach ($banner_lang as $val1) {
                        $BannerDetail = new BannerDetail;
                        foreach ($val1 as $key => $val) {
                            $BannerDetail->{$key} = $val;
                            if (isset($val1['banner_lang_image'])) {
                                $image_cut = str_replace("BannerImageTemp/", "", $val1['banner_lang_image']);
                                $BannerDetail->banner_lang_image = $image_cut;
                                copy($url_temp . '/' . $image_cut, $url_upload . '/' . $image_cut);
                            }

                            $BannerDetail->banner_id = $Banner->getKey();
                            $BannerDetail->save();
                        }
                    }
                }

                if ($file_name_all) {
                    foreach ($file_name_all as $val) {
                        $data_pic = explode('/', $val);
                        $cout_path = count($data_pic);
                        $pic_name =  $data_pic[$cout_path - 1];

                        // copy($url_temp . '/' . $pic_name, $url_upload . '/' . $pic_name);
                        unlink($url_temp . '/' . $pic_name);
                    }
                }

                \DB::commit();
                $return['status'] = 1;
                $return['content'] = 'Success';
            } catch (Exception $e) {
                \DB::rollBack();
                $return['status'] = 0;
                $return['content'] = 'Unsuccess';
            }
        } else {
            $failedRules = $validator->failed();
            $return['content'] = 'Unsuccess';
            if (isset($failedRules['banner_seo_title']['required'])) {
                $return['status'] = 2;
                $return['title'] = "Banner is required";
            }
        }
        $return['title'] = 'Insert';
        return $return;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $content = Banner::select()->with('BannerDetail')->find($id);
        $content['BannerImagePath'] = asset('uploads/BannerImage');
        $return['status'] = 1;
        $return['title'] = 'Get Banner';
        $return['content'] = $content;
        return $return;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $old_image = $request->input('old_image');
        $banner_lang = $request->input('lang');
        $banner = $request->input('banner');

        $url_temp = public_path('uploads/BannerImageTemp');
        $url_upload = public_path('uploads/BannerImage');
        $file_name_all = $this->readDir($url_temp);

        $imageTemp = [];

        $validator = Validator::make($request->all(), [
            // 'banner_seo_title' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                if ($banner) {
                    $Banner = Banner::find($id);
                    foreach ($banner as $key => $val) {
                        $Banner->{$key} = $val;
                    }
                    if (!isset($banner['banner_status'])) {
                        $Banner->banner_status = 0;
                    }
                    if (isset($banner['banner_image'])) {
                        $Banner->banner_image = str_replace("BannerCover/", "", $banner['banner_image']);
                    }
                    $Banner->save();
                    $banner_id = $Banner->getKey();
                }
                if ($banner_lang) {
                    foreach ($banner_lang as $key1 => $val1) {
                        $BannerDetail = BannerDetail::where('banner_id', $banner_id)->where('languages_id', $key1)->first();
                        foreach ($val1 as $key => $val) {
                            $old_image = $BannerDetail->banner_lang_image;
                            $BannerDetail->{$key} = $val;
                            $BannerDetail->banner_id = $banner_id;
                            if (isset($val1['banner_lang_image'])) {
                                if($old_image){
                                    unlink($url_upload . '/' . $old_image);
                                }
                                $image_cut = str_replace("BannerImageTemp/", "", $val1['banner_lang_image']);
                                $BannerDetail->banner_lang_image = $image_cut;
                                copy($url_temp . '/' . $image_cut, $url_upload . '/' . $image_cut);
                               
                            }
                            $BannerDetail->save();
                        }
                       
                    }
                }
                // return $imageTemp;
                if ($file_name_all) {
                    foreach ($file_name_all as $val) {
                        $data_pic = explode('/', $val);
                        $cout_path = count($data_pic);
                        $pic_name =  $data_pic[$cout_path - 1];
 
                        unlink($url_temp . '/' . $pic_name);
                    }
                }

                \DB::commit();
                $return['status'] = 1;
                $return['content'] = 'Success';
            } catch (Exception $e) {
                \DB::rollBack();
                $return['status'] = 0;
                $return['content'] = 'Unsuccess';
            }
        } else {
            $failedRules = $validator->failed();
            $return['content'] = 'Unsuccess';
            if (isset($failedRules['banner_seo_title']['required'])) {
                $return['status'] = 2;
                $return['title'] = "Banner is required";
            }
        }
        $return['title'] = 'Update';
        return $return;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function DeleteImageOld($request)
	{
        $url_upload = public_path('uploads/BannerImage');

		unlink($url_upload . '/' . $request);
	}

    public function lists(Request  $request)
    {
        $result = Banner::select();
        $banner_seo_title = $request->input('banner_seo_title');
        $banner_seo_description = $request->input('banner_seo_description');
        if ($banner_seo_title) {
            $result->where('banner_seo_title', 'like', '%' . $banner_seo_title . '%');
        };
        if ($banner_seo_description) {
            $result->where('banner_seo_description', 'like', '%' . $banner_seo_description . '%');
        };
        return Datatables::of($result)
            ->addColumn('checkbox', function ($res) {
                $str = '<div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input checkbox-table" id="checkbox-item-' . $res->banner_id . '">
                        <label class="custom-control-label" for="checkbox-item-' . $res->banner_id . '"></label>
                    </div>';
                return $str;
            })

            ->addColumn('action', function ($res) {
                $view = Helper::CheckPermissionMenu('Banner', '1');
                $insert = Helper::CheckPermissionMenu('Banner', '2');
                $update = Helper::CheckPermissionMenu('Banner', '3');
                $delete = Helper::CheckPermissionMenu('Banner', '4');
                if ($res->banner_status == 1) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }
                $btnStatus = '<input type="checkbox" class="toggle change-status" ' . $checked . ' data-id="' . $res->banner_id . '" data-style="ios" data-on="On" data-off="Off">';
                $btnView = '<button type="button" class="btn btn-success btn-md btn-view" data-id="' . $res->banner_id . '">View</button>';
                $btnEdit = '<button type="button" class="btn btn-info btn-md btn-edit" data-id="' . $res->banner_id . '">Edit</button>';
                $str = '';
                if ($update) {
                    $str .= ' ' . $btnStatus;
                }
                if ($view) {
                    $str .= ' ' . $btnView;
                }
                if ($update) {
                    $str .= ' ' . $btnEdit;
                }
                return $str;
            })
            ->addIndexColumn()
            ->rawColumns(['checkbox', 'banner_category', 'banner_tag', 'banner_date_set', 'banner_date_end', 'action'])
            ->make(true);
    }

    public function ChangeStatus(Request $request, $id)
    {
        $status = $request->input('status');
        \DB::beginTransaction();
        try {
            $input_all['banner_status'] = $status;
            $input_all['updated_at'] = date('Y-m-d H:i:s');
            Banner::where('banner_id', $id)->update($input_all);
            \DB::commit();
            $return['status'] = 1;
            $return['content'] = 'Success';
        } catch (Exception $e) {
            \DB::rollBack();
            $return['status'] = 0;
            $return['content'] = 'Unsuccess';
        }
        $return['title'] = 'Update Status';
        return $return;
    }
    public function readDir($dir)
    {
        $dirs = array($dir);
        $files = array();
        for ($i = 0;; $i++) {
            if (isset($dirs[$i]))
                $dir =  $dirs[$i];
            else
                break;

            if ($openDir = @opendir($dir)) {
                while ($readDir = @readdir($openDir)) {
                    if ($readDir != "." && $readDir != "..") {

                        if (is_dir($dir . "/" . $readDir)) {
                            $dirs[] = $dir . "/" . $readDir;
                        } else {
                            $files[] = $dir . "/" . $readDir;
                        }
                    }
                }
            }
        }

        return $files;
    }
}

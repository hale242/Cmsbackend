<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DataTables;
use App\Helper;
use App\MenuSystem;
use App\AboutUs;
use App\Language;
use App\AboutUsCategory;
use App\AboutUsHasAboutUsCategory;

class AboutUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['MainMenus'] = MenuSystem::where('menu_system_part', 'AboutUs')->with('MainMenu')->first();
        $data['Menus'] = MenuSystem::ActiveMenu()->get();
        $data['Language'] = Language::where('languages_status', '1')->get();
        $data['AboutUsCategorys'] = AboutUsCategory::where('aboutus_category_status', '1')->get();

        if (Helper::CheckPermissionMenu('AboutUs', '1')) {
            return view('admin.AboutUs.aboutus_list', $data);
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
        // $input_all = $request->all();

        $aboutus_input = $request->input('lang');
        $category_id = $request->input('category_id');

        $url_temp = public_path('uploads/AboutusImageTemp');
        $url_upload = public_path('uploads/AboutusImage');
        $file_name_all = $this->readDir($url_temp);

        $validator = Validator::make($request->all(), [
            // 'aboutus_list_seo_title' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                // return $aboutus;
                if ($aboutus_input) {
                    foreach ($aboutus_input as $key1 => $val1) {
                        $AboutUs = AboutUs::where('aboutus_list_id', $val1['aboutus_list_id'])->first();
                        foreach ($val1 as $key => $val) {
                            $old_image = $AboutUs->aboutus_list_image;
                            $AboutUs->{$key} = $val;
                            if (isset($val1['aboutus_list_image'])) {
                                if($old_image){
                                    unlink($url_upload . '/' . $old_image);
                                }
                                $image_cut = str_replace("AboutusImageTemp/", "", $val1['aboutus_list_image']);
                                $AboutUs->aboutus_list_image = $image_cut;
                                copy($url_temp . '/' . $image_cut, $url_upload . '/' . $image_cut);
                               
                            }
                            $AboutUs->save();
                        }
                    }
                }
                if ($category_id) {
                    foreach ($category_id as $key => $val1) {
                        $AboutUsKey = AboutUs::where('languages_id', $key)->first();
                        AboutUsHasAboutUsCategory::where('aboutus_list_id', $AboutUsKey->aboutus_list_id)->delete();

                        foreach ($val1 as $val_category_id) {
                            $AboutUsHasAboutUsCategory = new AboutUsHasAboutUsCategory;
                            $AboutUsHasAboutUsCategory->aboutus_list_id = $AboutUsKey->aboutus_list_id;
                            $AboutUsHasAboutUsCategory->aboutus_category_id = $val_category_id;
                            $AboutUsHasAboutUsCategory->aboutus_list_has_aboutus_category_status  = 1;
                            $AboutUsHasAboutUsCategory->save();
                        }
                    }
                }
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
            if (isset($failedRules['aboutus_list_seo_title']['required'])) {
                $return['status'] = 2;
                $return['title'] = "About Us is required";
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
    public function show()
    {
        $content = AboutUs::select();
        $return['status'] = 1;
        $return['title'] = 'Get About Us';
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
        $input_all = $request->all();
        $validator = Validator::make($request->all(), [
            'aboutus_list_seo_title' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $AboutUs = AboutUs::find($id);
                foreach ($input_all as $key => $val) {
                    $AboutUs->{$key} = $val;
                }
                if (!isset($input_all['aboutus_list_status'])) {
                    $AboutUs->aboutus_list_status = 0;
                }
                $AboutUs->save();
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
            if (isset($failedRules['aboutus_list_seo_title']['required'])) {
                $return['status'] = 2;
                $return['title'] = "About Us is required";
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

    public function lists(Request  $request)
    {
        $result = AboutUs::select();
        $aboutus_list_seo_title = $request->input('aboutus_list_seo_title');
        $aboutus_list_detail = $request->input('aboutus_list_detail');
        if ($aboutus_list_seo_title) {
            $result->where('aboutus_list_seo_title', 'like', '%' . $aboutus_list_seo_title . '%');
        };
        if ($aboutus_list_detail) {
            $result->where('aboutus_list_details', 'like', '%' . $aboutus_list_detail . '%');
        };
        return Datatables::of($result)
            ->addColumn('checkbox', function ($res) {
                $str = '<div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input checkbox-table" id="checkbox-item-' . $res->aboutus_list_id . '">
                        <label class="custom-control-label" for="checkbox-item-' . $res->aboutus_list_id . '"></label>
                    </div>';
                return $str;
            })
            ->addColumn('action', function ($res) {
                $view = Helper::CheckPermissionMenu('AboutUs', '1');
                $insert = Helper::CheckPermissionMenu('AboutUs', '2');
                $update = Helper::CheckPermissionMenu('AboutUs', '3');
                $delete = Helper::CheckPermissionMenu('AboutUs', '4');
                if ($res->aboutus_list_status == 1) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }
                $btnStatus = '<input type="checkbox" class="toggle change-status" ' . $checked . ' data-id="' . $res->aboutus_list_id . '" data-style="ios" data-on="On" data-off="Off">';
                $btnView = '<button type="button" class="btn btn-success btn-md btn-view" data-id="' . $res->aboutus_list_id . '">View</button>';
                $btnEdit = '<button type="button" class="btn btn-info btn-md btn-edit" data-id="' . $res->aboutus_list_id . '">Edit</button>';
                $btnDelete = '<button type="button" class="btn btn-danger btn-md btn-delete" data-id="' . $res->aboutus_list_id . '">Delete</button>';
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
                if ($delete) {
                    $str .= ' ' . $btnDelete;
                }
                return $str;
            })
            ->addIndexColumn()
            ->rawColumns(['checkbox', 'action'])
            ->make(true);
    }

    public function ChangeStatus(Request $request, $id)
    {
        $status = $request->input('status');
        \DB::beginTransaction();
        try {
            $input_all['aboutus_list_status'] = $status;
            $input_all['updated_at'] = date('Y-m-d H:i:s');
            AboutUs::where('aboutus_list_id', $id)->update($input_all);
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

    public function GetAboutUs(Request  $request)
    {
        $content = AboutUs::select()->with('AboutUsHasAboutUsCategory.AboutUsCategory')->get();
        $content['AboutImagePath'] = asset('uploads/AboutusImage');
        $return['status'] = 1;
        $return['title'] = 'Get About Us';
        $return['content'] = $content;
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

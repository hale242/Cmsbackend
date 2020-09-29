<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DataTables;
use App\Helper;
use App\MenuSystem;
use App\ContactInfo;
use App\Language;

class ContactInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['MainMenus'] = MenuSystem::where('menu_system_part', 'ContactInfo')->with('MainMenu')->first();
        $data['Menus'] = MenuSystem::ActiveMenu()->get();
        $data['Language'] = Language::where('languages_status', '1')->get();

        if (Helper::CheckPermissionMenu('ContactInfo', '1')) {
            return view('admin.ContactInfo.contact_info', $data);
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
        $ContactInfo_input = $request->input('lang');

        $url_temp_map = public_path('uploads/ContactInfoMapImageTemp');
        $url_upload_map = public_path('uploads/ContactInfoMapImage');
        $file_name_all_map = $this->readDir($url_temp_map);

        $url_temp = public_path('uploads/ContactInfoImageTemp');
        $url_upload = public_path('uploads/ContactInfoImage');
        $file_name_all = $this->readDir($url_temp);


        $validator = Validator::make($request->all(), [
            // 'contact_info_company' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                // return $ContactInfo;
                if ($ContactInfo_input) {
                    foreach ($ContactInfo_input as $key => $val1) {
                        $ContactInfo = ContactInfo::where('contact_info_id', $val1['contact_info_id'])->first();
                        foreach ($val1 as $key => $val) {
                            $old_image_map = $ContactInfo->contact_info_image_map;
                            $old_image = $ContactInfo->contact_info_image;
                            $ContactInfo->{$key} = $val;

                            if (isset($val1['contact_info_image_map'])) {
                                if ($old_image_map) {
                                    unlink($url_upload_map . '/' . $old_image_map);
                                }
                                $image_map_cut = str_replace("ContactInfoMapImageTemp/", "", $val1['contact_info_image_map']);
                                $ContactInfo->contact_info_image_map = $image_map_cut;
                                copy($url_temp_map . '/' . $image_map_cut, $url_upload_map . '/' . $image_map_cut);
                            }
                            if (isset($val1['contact_info_image'])) {
                                if ($old_image) {
                                    unlink($url_upload . '/' . $old_image);
                                }
                                
                                $image_cut = str_replace("ContactInfoImageTemp/", "", $val1['contact_info_image']);
                                $ContactInfo->contact_info_image = $image_cut;
                                copy($url_temp . '/' . $image_cut, $url_upload . '/' . $image_cut);
                            }
                            $ContactInfo->save();
                        }
                    }
                }
                if ($file_name_all_map) {
                    foreach ($file_name_all_map as $val) {
                        $data_pic_map = explode('/', $val);
                        $cout_path_map = count($data_pic_map);
                        $pic_name_map =  $data_pic_map[$cout_path_map - 1];

                        unlink($url_temp_map . '/' . $pic_name_map);
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
            if (isset($failedRules['contact_info_seo_title']['required'])) {
                $return['status'] = 2;
                $return['title'] = "ContactInfo Us is required";
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
        $content = ContactInfo::select();
        $return['status'] = 1;
        $return['title'] = 'Get ContactInfo Us';
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
            'contact_info_company' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $ContactInfo = ContactInfo::find($id);
                foreach ($input_all as $key => $val) {
                    $ContactInfo->{$key} = $val;
                }
                if (!isset($input_all['contact_info_status'])) {
                    $ContactInfo->contact_info_status = 0;
                }
                if (isset($input_all['contact_info_image_map'])) {
                    $ContactInfo->contact_info_image_map = str_replace("ContactInfoMapImage/", "", $input_all['contact_info_image_map']);
                }
                if (isset($input_all['contact_info_image'])) {
                    $ContactInfo->contact_info_image = str_replace("ContactInfoImage/", "", $input_all['contact_info_image']);
                }
                $ContactInfo->save();
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
            if (isset($failedRules['contact_info_seo_title']['required'])) {
                $return['status'] = 2;
                $return['title'] = "ContactInfo Us is required";
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
        $result = ContactInfo::select();
        $contact_info_seo_title = $request->input('contact_info_seo_title');
        $contact_info_detail = $request->input('contact_info_detail');
        if ($contact_info_seo_title) {
            $result->where('contact_info_seo_title', 'like', '%' . $contact_info_seo_title . '%');
        };
        if ($contact_info_detail) {
            $result->where('contact_info_details', 'like', '%' . $contact_info_detail . '%');
        };
        return Datatables::of($result)
            ->addColumn('checkbox', function ($res) {
                $str = '<div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input checkbox-table" id="checkbox-item-' . $res->contact_info_id . '">
                        <label class="custom-control-label" for="checkbox-item-' . $res->contact_info_id . '"></label>
                    </div>';
                return $str;
            })
            ->addColumn('action', function ($res) {
                $view = Helper::CheckPermissionMenu('ContactInfo', '1');
                $insert = Helper::CheckPermissionMenu('ContactInfo', '2');
                $update = Helper::CheckPermissionMenu('ContactInfo', '3');
                $delete = Helper::CheckPermissionMenu('ContactInfo', '4');
                if ($res->contact_info_status == 1) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }
                $btnStatus = '<input type="checkbox" class="toggle change-status" ' . $checked . ' data-id="' . $res->contact_info_id . '" data-style="ios" data-on="On" data-off="Off">';
                $btnView = '<button type="button" class="btn btn-success btn-md btn-view" data-id="' . $res->contact_info_id . '">View</button>';
                $btnEdit = '<button type="button" class="btn btn-info btn-md btn-edit" data-id="' . $res->contact_info_id . '">Edit</button>';
                $btnDelete = '<button type="button" class="btn btn-danger btn-md btn-delete" data-id="' . $res->contact_info_id . '">Delete</button>';
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
            $input_all['contact_info_status'] = $status;
            $input_all['updated_at'] = date('Y-m-d H:i:s');
            ContactInfo::where('contact_info_id', $id)->update($input_all);
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

    public function GetContactInfo(Request  $request)
    {
        $content = ContactInfo::select()->get();
        $content['ContactInfoImageMapPath'] = asset('uploads/ContactInfoMapImage');
        $content['ContactInfoImagePath'] = asset('uploads/ContactInfoImage');
        $return['status'] = 1;
        $return['title'] = 'Get ContactInfo Us';
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

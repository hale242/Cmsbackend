<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DataTables;
use App\Helper;
use App\MenuSystem;
use App\Knowledge;
use App\KnowledgeCategory;
use App\KnowledgeDetail;
use App\KnowledgeHasKnowledgeCategory;

use App\Language;

class KnowledgeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['MainMenus'] = MenuSystem::where('menu_system_part', 'Knowledge')->with('MainMenu')->first();
        $data['Menus'] = MenuSystem::ActiveMenu()->get();
        $data['KnowledgeCategory'] = KnowledgeCategory::where('knowledge_category_status', '1')->get();
        $data['Language'] = Language::where('languages_status', '1')->get();
        // $data['SeoTypes'] = [
        //     "0" => "ใช้ SEO หลัก",
        //     "1" => "ใช้ SEO ตามภาษา"
        // ];
        if (Helper::CheckPermissionMenu('Knowledge', '1')) {
            return view('admin.Knowledge.knowledge', $data);
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
        $knowledge_category_id = $request->input('knowledge_category_id');
        $knowledge_detail = $request->input('lang');
        $knowledge = $request->input('knowledge');

        $validator = Validator::make($request->all(), [
            // 'knowledge_seo_title' => 'required',
        ]);
        $array = array();

        // foreach ($knowledge_detail as $key => $val) {
        // }
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                if ($knowledge) {
                    $Knowledge = new Knowledge;
                    $Language = Language::where('languages_type', '1')->first();
                    foreach ($knowledge as $key => $val) {
                        $Knowledge->{$key} = $val;
                    }
                    if (!isset($knowledge['knowledge_status'])) {
                        $Knowledge->knowledge_status = 0;
                    }
                    if (isset($knowledge['knowledge_image'])) {
                        $Knowledge->knowledge_image = str_replace("KnowledgeCover/", "", $knowledge['knowledge_image']);
                    }
                    $Knowledge->save();
                    $knowledge_id = $Knowledge->getKey();
                }
                if ($knowledge_detail) {
                    foreach ($knowledge_detail as $val1) {
                        $KnowledgeDetail = new KnowledgeDetail;
                        foreach ($val1 as $key => $val) {
                            // return $val1['knowledge_details_image'];
                            $KnowledgeDetail->{$key} = $val;
                            if (isset($val1['knowledge_details_image'])) {
                                $KnowledgeDetail->knowledge_details_image = str_replace("KnowledgeImage/", "", $val1['knowledge_details_image']);
                            }
                            $KnowledgeDetail->knowledge_id = $Knowledge->getKey();
                            $KnowledgeDetail->save();
                        }
                    }
                }

                if ($knowledge_category_id) {
                    foreach ($knowledge_category_id as $val) {
                        $KnowledgeHasKnowledgeCategory = new KnowledgeHasKnowledgeCategory;
                        $KnowledgeHasKnowledgeCategory->knowledge_category_id = $val;
                        $KnowledgeHasKnowledgeCategory->knowledge_has_knowledge_category_status = '1';
                        $KnowledgeHasKnowledgeCategory->knowledge_id = $knowledge_id;
                        $KnowledgeHasKnowledgeCategory->save();
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
            if (isset($failedRules['knowledge_seo_title']['required'])) {
                $return['status'] = 2;
                $return['title'] = "Knowledge is required";
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
        $content = Knowledge::select()->with('KnowledgeHasKnowledgeCategory.KnowledgeCategory', 'KnowledgeDetail')->find($id);
        $content['KnowledgeCoverPath'] = asset('uploads/KnowledgeCover');
        $content['KnowledgeImagePath'] = asset('uploads/KnowledgeImage');
        $return['status'] = 1;
        $return['title'] = 'Get Knowledge';
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

        $knowledge_category_id = $request->input('knowledge_category_id');
        $knowledge_detail = $request->input('lang');
        $knowledge = $request->input('knowledge');

        $pic_knowledge_cover_name = '';
        $pic_knowledge_image_name = '';
        $validator = Validator::make($request->all(), [
            // 'knowledge_seo_title' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                if ($knowledge) {
                    $Knowledge = Knowledge::find($id);
                    foreach ($knowledge as $key => $val) {
                        $Knowledge->{$key} = $val;
                    }
                    if (!isset($knowledge['knowledge_status'])) {
                        $Knowledge->knowledge_status = 0;
                    }
                    if (isset($knowledge['knowledge_image'])) {
                        $Knowledge->knowledge_image = str_replace("KnowledgeCover/", "", $knowledge['knowledge_image']);
                    }
                    $Knowledge->save();
                    $knowledge_id = $Knowledge->getKey();
                }
                if ($knowledge_detail) {
                    foreach ($knowledge_detail as $key1 => $val1) {

                        $KnowledgeDetail = KnowledgeDetail::where('knowledge_id', $knowledge_id)->where('languages_id', $key1)->first();
                        foreach ($val1 as $key => $val) {
                            $KnowledgeDetail->{$key} = $val;
                            $KnowledgeDetail->knowledge_id = $knowledge_id;
                            if (isset($val1['knowledge_details_image'])) {
                                $KnowledgeDetail->knowledge_details_image = str_replace("KnowledgeImage/", "", $val1['knowledge_details_image']);
                            }
                            $KnowledgeDetail->save();
                        }
                    }
                }
                if ($knowledge_category_id) {
                    KnowledgeHasKnowledgeCategory::where('knowledge_id', $knowledge_id)->delete();
                    foreach ($knowledge_category_id as $key => $val) {
                        $KnowledgeHasKnowledgeCategory = new KnowledgeHasKnowledgeCategory;
                        $KnowledgeHasKnowledgeCategory->knowledge_category_id = $val;
                        $KnowledgeHasKnowledgeCategory->knowledge_has_knowledge_category_status = '1';
                        $KnowledgeHasKnowledgeCategory->knowledge_id = $knowledge_id;
                        $KnowledgeHasKnowledgeCategory->save();
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
            if (isset($failedRules['knowledge_seo_title']['required'])) {
                $return['status'] = 2;
                $return['title'] = "Knowledge is required";
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
        $result = Knowledge::select()->with('KnowledgeHasKnowledgeCategory.KnowledgeCategory');
        $knowledge_seo_title = $request->input('knowledge_seo_title');
        $knowledge_seo_description = $request->input('knowledge_seo_description');
        if ($knowledge_seo_title) {
            $result->where('knowledge_seo_title', 'like', '%' . $knowledge_seo_title . '%');
        };
        if ($knowledge_seo_description) {
            $result->where('knowledge_seo_description', 'like', '%' . $knowledge_seo_description . '%');
        };
        return Datatables::of($result)
            ->addColumn('checkbox', function ($res) {
                $str = '<div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input checkbox-table" id="checkbox-item-' . $res->knowledge_id . '">
                        <label class="custom-control-label" for="checkbox-item-' . $res->knowledge_id . '"></label>
                    </div>';
                return $str;
            })

            ->addColumn('knowledge_category', function ($res) {
                $html = '';
                foreach ($res->KnowledgeHasKnowledgeCategory as $val) {
                    if ($val->knowledge_category_id) {
                        $html .= '<span class="badge badge-pill badge-primary text-white">' . $val->KnowledgeCategory->knowledge_category_seo_title . '</span></br>';
                    }
                }
                return $html;
            })

            ->addColumn('action', function ($res) {
                $view = Helper::CheckPermissionMenu('Knowledge', '1');
                $insert = Helper::CheckPermissionMenu('Knowledge', '2');
                $update = Helper::CheckPermissionMenu('Knowledge', '3');
                $delete = Helper::CheckPermissionMenu('Knowledge', '4');
                if ($res->knowledge_status == 1) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }
                $btnStatus = '<input type="checkbox" class="toggle change-status" ' . $checked . ' data-id="' . $res->knowledge_id . '" data-style="ios" data-on="On" data-off="Off">';
                $btnView = '<button type="button" class="btn btn-success btn-md btn-view" data-id="' . $res->knowledge_id . '">View</button>';
                $btnEdit = '<button type="button" class="btn btn-info btn-md btn-edit" data-id="' . $res->knowledge_id . '">Edit</button>';
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
            ->rawColumns(['checkbox', 'knowledge_category', 'knowledge_tag', 'knowledge_date_set', 'knowledge_date_end', 'action'])
            ->make(true);
    }

    public function ChangeStatus(Request $request, $id)
    {
        $status = $request->input('status');
        \DB::beginTransaction();
        try {
            $input_all['knowledge_status'] = $status;
            $input_all['updated_at'] = date('Y-m-d H:i:s');
            Knowledge::where('knowledge_id', $id)->update($input_all);
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
}

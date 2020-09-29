<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DataTables;
use App\Helper;
use App\MenuSystem;
use App\KnowledgeCategory;
use App\KnowledgeCategoryDetail;
use App\Language;

class KnowledgeCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['MainMenus'] = MenuSystem::where('menu_system_part', 'KnowledgeCategory')->with('MainMenu')->first();
        $data['Menus'] = MenuSystem::ActiveMenu()->get();
        $data['Language'] = Language::where('languages_status', '1')->get();
        $data['KnowledgeCategoryMain'] = KnowledgeCategory::where('knowledge_category_main_id', '0')->get();

        $data['SeoTypes'] = [
            "0" => "ใช้ SEO หลัก",
            "1" => "ใช้ SEO ตามภาษา"
        ];
        if (Helper::CheckPermissionMenu('KnowledgeCategory', '1')) {
            return view('admin.KnowledgeCategory.knowledge_category', $data);
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
        $knowledge_category_details = $request->input('lang');
        $knowledge_category = $request->input('knowledge_category');

        $validator = Validator::make($request->all(), [
            // 'knowledge_category_seo_title' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                if ($knowledge_category) {
                    $KnowledgeCategory = new KnowledgeCategory;
                    if ($knowledge_category_details) {
                        foreach ($knowledge_category as $key => $val) {
                            $KnowledgeCategory->{$key} = $val;
                        }
                        if (!isset($knowledge_category['knowledge_category_status'])) {
                            $KnowledgeCategory->knowledge_category_status = 0;
                        }
                        if (!isset($knowledge_category['knowledge_category_sub_id'])) {
                            $KnowledgeCategory->knowledge_category_sub_id = null;
                        }
                        $KnowledgeCategory->save();
                        $knowledge_category_id = $KnowledgeCategory->getKey();
                    }
                }
                if ($knowledge_category_details) {
                    foreach ($knowledge_category_details as $key => $val1) {
                        $KnowledgeCategoryDetail = new KnowledgeCategoryDetail;
                        foreach ($val1 as $key => $val) {
                            $KnowledgeCategoryDetail->{$key} = $val;
                            $KnowledgeCategoryDetail->knowledge_category_id = $KnowledgeCategory->getKey();
                            $KnowledgeCategoryDetail->knowledge_category_details_status = 1;
                            $KnowledgeCategoryDetail->save();
                        }
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
            if (isset($failedRules['knowledge_category_seo_title']['required'])) {
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
        $content = KnowledgeCategory::with('KnowledgeCategoryDetail')->find($id);
        $return['status'] = 1;
        $return['title'] = 'Get Knowledge Category';
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
        $knowledge_category_details = $request->input('lang');
        $knowledge_category = $request->input('knowledge_category');
        $input_all = $request->all();
        $validator = Validator::make($request->all(), [
            // 'knowledge_category_seo_title' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                if ($knowledge_category) {
                    $KnowledgeCategory = KnowledgeCategory::find($id);
                    foreach ($knowledge_category as $key => $val) {
                        $KnowledgeCategory->{$key} = $val;
                    }
                    $KnowledgeCategory->save();
                    $knowledge_category_id = $KnowledgeCategory->getKey();
                }
                if ($knowledge_category_details) {
                    foreach ($knowledge_category_details as $key => $val1) {
                        $KnowledgeCategoryDetail = KnowledgeCategoryDetail::where('knowledge_category_id', $knowledge_category_id)->where('languages_id', $key)->first();
                        foreach ($val1 as $key => $val) {
                            $KnowledgeCategoryDetail->{$key} = $val;
                            $KnowledgeCategoryDetail->knowledge_category_id = $KnowledgeCategory->getKey();
                            $KnowledgeCategoryDetail->save();
                        }
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
            if (isset($failedRules['knowledge_category_seo_title']['required'])) {
                $return['status'] = 2;
                $return['title'] = "KnowledgeCategory is required";
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
        $result = KnowledgeCategory::select();
        $knowledge_category_seo_title = $request->input('knowledge_category_seo_title');
        $knowledge_category_seo_keyword = $request->input('knowledge_category_seo_keyword');
        $knowledge_category_seo_description = $request->input('knowledge_category_seo_description');

        if ($knowledge_category_seo_title) {
            $result->where('knowledge_category_seo_title', 'like', '%' . $knowledge_category_seo_title . '%');
        };
        if ($knowledge_category_seo_keyword) {
            $result->where('knowledge_category_seo_keyword', 'like', '%' . $knowledge_category_seo_keyword . '%');
        };
        if ($knowledge_category_seo_description) {
            $result->where('knowledge_category_seo_description', 'like', '%' . $knowledge_category_seo_description . '%');
        };
      

        return Datatables::of($result)
            ->addColumn('checkbox', function ($res) {
                $str = '<div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input checkbox-table" id="checkbox-item-' . $res->knowledge_category_id . '">
                        <label class="custom-control-label" for="checkbox-item-' . $res->knowledge_category_id . '"></label>
                    </div>';
                return $str;
            })
            ->addColumn('action', function ($res) {
                $view = Helper::CheckPermissionMenu('KnowledgeCategory', '1');
                $insert = Helper::CheckPermissionMenu('KnowledgeCategory', '2');
                $update = Helper::CheckPermissionMenu('KnowledgeCategory', '3');
                $delete = Helper::CheckPermissionMenu('KnowledgeCategory', '4');
                if ($res->knowledge_category_status == 1) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }
                $btnStatus = '<input type="checkbox" class="toggle change-status" ' . $checked . ' data-id="' . $res->knowledge_category_id . '" data-style="ios" data-on="On" data-off="Off">';
                $btnView = '<button type="button" class="btn btn-success btn-md btn-view" data-id="' . $res->knowledge_category_id . '">View</button>';
                $btnEdit = '<button type="button" class="btn btn-info btn-md btn-edit" data-id="' . $res->knowledge_category_id . '">Edit</button>';
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
            ->rawColumns(['checkbox', 'action'])
            ->make(true);
    }

    public function ChangeStatus(Request $request, $id)
    {
        $status = $request->input('status');
        \DB::beginTransaction();
        try {
            $input_all['knowledge_category_status'] = $status;
            $input_all['updated_at'] = date('Y-m-d H:i:s');
            KnowledgeCategory::where('knowledge_category_id', $id)->update($input_all);
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

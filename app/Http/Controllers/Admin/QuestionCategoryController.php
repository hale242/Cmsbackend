<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DataTables;
use App\Helper;
use App\MenuSystem;
use App\QuestionCategory;
use App\QuestionCategoryDetail;
use App\Language;

class QuestionCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['MainMenus'] = MenuSystem::where('menu_system_part', 'QuestionCategory')->with('MainMenu')->first();
        $data['Menus'] = MenuSystem::ActiveMenu()->get();
        $data['Language'] = Language::where('languages_status', '1')->get();
        $data['QuestionCategoryMain'] = QuestionCategory::where('main_ques_category_id', '0')->get();

        $data['SeoTypes'] = [
            "0" => "ใช้ SEO หลัก",
            "1" => "ใช้ SEO ตามภาษา"
        ];
        if (Helper::CheckPermissionMenu('QuestionCategory', '1')) {
            return view('admin.QuestionCategory.ques_category', $data);
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
        $ques_category_details = $request->input('lang');
        $ques_category = $request->input('ques_category');

        $validator = Validator::make($request->all(), [
            // 'ques_category_seo_title' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                if ($ques_category) {
                    $QuestionCategory = new QuestionCategory;
                    if ($ques_category_details) {
                        foreach ($ques_category as $key => $val) {
                            $QuestionCategory->{$key} = $val;
                        }
                        if (!isset($ques_category['ques_category_status'])) {
                            $QuestionCategory->ques_category_status = 0;
                        }
                        // if (!isset($ques_category['main_ques_category_id'])) {
                        //     $QuestionCategory->main_ques_category_id = null;
                        // }
                        $QuestionCategory->save();
                        $ques_category_id = $QuestionCategory->getKey();
                    }
                }
                if ($ques_category_details) {
                    foreach ($ques_category_details as $key => $val1) {
                        $QuestionCategoryDetail = new QuestionCategoryDetail;
                        foreach ($val1 as $key => $val) {
                            $QuestionCategoryDetail->{$key} = $val;
                            $QuestionCategoryDetail->ques_category_id = $QuestionCategory->getKey();
                            $QuestionCategoryDetail->ques_category_lang_status = 1;
                            $QuestionCategoryDetail->save();
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
            if (isset($failedRules['ques_category_seo_title']['required'])) {
                $return['status'] = 2;
                $return['title'] = "Question is required";
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
        $content = QuestionCategory::with('QuestionCategoryDetail')->find($id);
        $return['status'] = 1;
        $return['title'] = 'Get Question Category';
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
        $ques_category_details = $request->input('lang');
        $ques_category = $request->input('ques_category');
        $input_all = $request->all();
        $validator = Validator::make($request->all(), [
            // 'ques_category_seo_title' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                if ($ques_category) {
                    $QuestionCategory = QuestionCategory::find($id);
                    foreach ($ques_category as $key => $val) {
                        $QuestionCategory->{$key} = $val;
                    }
                    $QuestionCategory->save();
                    $ques_category_id = $QuestionCategory->getKey();
                }
                if ($ques_category_details) {
                    foreach ($ques_category_details as $key => $val1) {
                        $QuestionCategoryDetail = QuestionCategoryDetail::where('ques_category_id', $ques_category_id)->where('languages_id', $key)->first();
                        foreach ($val1 as $key => $val) {
                            $QuestionCategoryDetail->{$key} = $val;
                            $QuestionCategoryDetail->ques_category_id = $QuestionCategory->getKey();
                            $QuestionCategoryDetail->save();
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
            if (isset($failedRules['ques_category_seo_title']['required'])) {
                $return['status'] = 2;
                $return['title'] = "QuestionCategory is required";
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
        $result = QuestionCategory::select();
        $ques_category_seo_title = $request->input('ques_category_seo_title');
        $ques_category_seo_keyword = $request->input('ques_category_seo_keyword');
        $ques_category_seo_description = $request->input('ques_category_seo_description');

        if ($ques_category_seo_title) {
            $result->where('ques_category_seo_title', 'like', '%' . $ques_category_seo_title . '%');
        };
        if ($ques_category_seo_keyword) {
            $result->where('ques_category_seo_keyword', 'like', '%' . $ques_category_seo_keyword . '%');
        };
        if ($ques_category_seo_description) {
            $result->where('ques_category_seo_description', 'like', '%' . $ques_category_seo_description . '%');
        };
      

        return Datatables::of($result)
            ->addColumn('checkbox', function ($res) {
                $str = '<div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input checkbox-table" id="checkbox-item-' . $res->ques_category_id . '">
                        <label class="custom-control-label" for="checkbox-item-' . $res->ques_category_id . '"></label>
                    </div>';
                return $str;
            })
            ->addColumn('action', function ($res) {
                $view = Helper::CheckPermissionMenu('QuestionCategory', '1');
                $insert = Helper::CheckPermissionMenu('QuestionCategory', '2');
                $update = Helper::CheckPermissionMenu('QuestionCategory', '3');
                $delete = Helper::CheckPermissionMenu('QuestionCategory', '4');
                if ($res->ques_category_status == 1) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }
                $btnStatus = '<input type="checkbox" class="toggle change-status" ' . $checked . ' data-id="' . $res->ques_category_id . '" data-style="ios" data-on="On" data-off="Off">';
                $btnView = '<button type="button" class="btn btn-success btn-md btn-view" data-id="' . $res->ques_category_id . '">View</button>';
                $btnEdit = '<button type="button" class="btn btn-info btn-md btn-edit" data-id="' . $res->ques_category_id . '">Edit</button>';
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
            $input_all['ques_category_status'] = $status;
            $input_all['updated_at'] = date('Y-m-d H:i:s');
            QuestionCategory::where('ques_category_id', $id)->update($input_all);
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

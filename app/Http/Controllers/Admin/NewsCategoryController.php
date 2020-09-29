<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DataTables;
use App\Helper;
use App\MenuSystem;
use App\NewsCategory;
use App\NewsCategoryDetail;
use App\Language;

class NewsCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['MainMenus'] = MenuSystem::where('menu_system_part', 'NewsCategory')->with('MainMenu')->first();
        $data['Menus'] = MenuSystem::ActiveMenu()->get();
        $data['Language'] = Language::where('languages_status', '1')->get();
        $data['SeoTypes'] = [
            "0" => "ใช้ SEO หลัก",
            "1" => "ใช้ SEO ตามภาษา"
        ];
        if (Helper::CheckPermissionMenu('NewsCategory', '1')) {
            return view('admin.NewsCategory.news_category', $data);
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
        $news_category_details = $request->input('lang');
        $news_category = $request->input('news_category');

        $validator = Validator::make($request->all(), [
            // 'news_category_seo_title' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                if ($news_category) {
                    $NewsCategory = new NewsCategory;
                    if ($news_category_details) {
                        foreach ($news_category as $key => $val) {
                            $NewsCategory->{$key} = $val;
                        }
                        if (!isset($news_category['news_category_status'])) {
                            $NewsCategory->news_category_status = 0;
                        }
                        $NewsCategory->save();
                        $news_category_id = $NewsCategory->getKey();
                    }
                }
                if ($news_category_details) {
                    foreach ($news_category_details as $key => $val1) {
                        $NewsCategoryDetail = new NewsCategoryDetail;
                        foreach ($val1 as $key => $val) {
                            $NewsCategoryDetail->{$key} = $val;
                            $NewsCategoryDetail->news_category_id = $NewsCategory->getKey();
                            $NewsCategoryDetail->news_category_details_status = 1;
                            $NewsCategoryDetail->save();
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
            if (isset($failedRules['news_category_seo_title']['required'])) {
                $return['status'] = 2;
                $return['title'] = "Event is required";
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
        $content = NewsCategory::with('NewsCategoryDetail')->find($id);
        $return['status'] = 1;
        $return['title'] = 'Get News Category';
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
        $news_category_details = $request->input('lang');
        $news_category = $request->input('news_category');
        $input_all = $request->all();
        $validator = Validator::make($request->all(), [
            // 'news_category_seo_title' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                if ($news_category) {
                    $NewsCategory = NewsCategory::find($id);
                    if ($news_category_details) {
                        foreach ($news_category as $key => $val) {
                            $NewsCategory->{$key} = $val;
                        }
                        if (!isset($news_category['news_category_status'])) {
                            $NewsCategory->news_category_status = 0;
                        }
                        $NewsCategory->save();
                        $news_category_id = $NewsCategory->getKey();
                    }
                }
                if ($news_category_details) {
                    // $NewsCategoryDetail = NewsCategoryDetail::where('news_category_id', $news_category_id)->delete();
                    foreach ($news_category_details as $key => $val1) {
                        // $NewsCategoryDetail = new NewsCategoryDetail;
                        $NewsCategoryDetail = NewsCategoryDetail::where('news_category_id', $news_category_id)->where('languages_id',$key)->first();

                        foreach ($val1 as $key => $val) {
                            // return $val1;
                            $NewsCategoryDetail->{$key} = $val;
                            $NewsCategoryDetail->news_category_id = $NewsCategory->getKey();
                            $NewsCategoryDetail->news_category_details_status = 1;
                            $NewsCategoryDetail->save();
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
            if (isset($failedRules['news_category_seo_title']['required'])) {
                $return['status'] = 2;
                $return['title'] = "News Category is required";
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
        $result = NewsCategory::select();
        $news_category_seo_title = $request->input('news_category_seo_title');
        $news_category_seo_keyword = $request->input('news_category_seo_keyword');
        $news_category_seo_description = $request->input('news_category_seo_description');
        $news_category_url_slug = $request->input('news_category_url_slug');

        if ($news_category_seo_title) {
            $result->where('news_category_seo_title', 'like', '%' . $news_category_seo_title . '%');
        };
        if ($news_category_seo_keyword) {
            $result->where('news_category_seo_keyword', 'like', '%' . $news_category_seo_keyword . '%');
        };
        if ($news_category_seo_description) {
            $result->where('news_category_seo_description', 'like', '%' . $news_category_seo_description . '%');
        };
        if ($news_category_url_slug) {
            $result->where('news_category_url_slug', 'like', '%' . $news_category_url_slug . '%');
        };

        return Datatables::of($result)
            ->addColumn('checkbox', function ($res) {
                $str = '<div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input checkbox-table" id="checkbox-item-' . $res->news_category_id . '">
                        <label class="custom-control-label" for="checkbox-item-' . $res->news_category_id . '"></label>
                    </div>';
                return $str;
            })
            ->addColumn('action', function ($res) {
                $view = Helper::CheckPermissionMenu('NewsCategory', '1');
                $insert = Helper::CheckPermissionMenu('NewsCategory', '2');
                $update = Helper::CheckPermissionMenu('NewsCategory', '3');
                $delete = Helper::CheckPermissionMenu('NewsCategory', '4');
                if ($res->news_category_status == 1) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }
                $btnStatus = '<input type="checkbox" class="toggle change-status" ' . $checked . ' data-id="' . $res->news_category_id . '" data-style="ios" data-on="On" data-off="Off">';
                $btnView = '<button type="button" class="btn btn-success btn-md btn-view" data-id="' . $res->news_category_id . '">View</button>';
                $btnEdit = '<button type="button" class="btn btn-info btn-md btn-edit" data-id="' . $res->news_category_id . '">Edit</button>';
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
            $input_all['news_category_status'] = $status;
            $input_all['updated_at'] = date('Y-m-d H:i:s');
            NewsCategory::where('news_category_id', $id)->update($input_all);
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

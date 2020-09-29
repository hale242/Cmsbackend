<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DataTables;
use App\Helper;
use App\MenuSystem;
use App\EventCategory;
use App\EventCategoryDetail;
use App\Language;

class EventCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['MainMenus'] = MenuSystem::where('menu_system_part', 'EventCategory')->with('MainMenu')->first();
        $data['Menus'] = MenuSystem::ActiveMenu()->get();
        $data['Language'] = Language::where('languages_status', '1')->get();
        $data['SeoTypes'] = [
            "0" => "ใช้ SEO หลัก",
            "1" => "ใช้ SEO ตามภาษา"
        ];
        if (Helper::CheckPermissionMenu('EventCategory', '1')) {
            return view('admin.EventCategory.event_category', $data);
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
        $event_category_details = $request->input('lang');
        $event_category = $request->input('event_category');

        $validator = Validator::make($request->all(), [
            // 'event_category_seo_title' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                if ($event_category) {
                    $EventCategory = new EventCategory;
                    if ($event_category_details) {
                        foreach ($event_category as $key => $val) {
                            $EventCategory->{$key} = $val;
                        }
                        if (!isset($event_category['event_category_status'])) {
                            $EventCategory->event_category_status = 0;
                        }
                        $EventCategory->save();
                        $event_category_id = $EventCategory->getKey();
                    }
                }
                if ($event_category_details) {
                    foreach ($event_category_details as $key => $val1) {
                        $EventCategoryDetail = new EventCategoryDetail;
                        foreach ($val1 as $key => $val) {
                            $EventCategoryDetail->{$key} = $val;
                            $EventCategoryDetail->event_category_id = $EventCategory->getKey();
                            $EventCategoryDetail->event_category_details_status = 1;
                            $EventCategoryDetail->save();
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
            if (isset($failedRules['event_category_seo_title']['required'])) {
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
        $content = EventCategory::with('EventCategoryDetail')->find($id);
        $return['status'] = 1;
        $return['title'] = 'Get Event Category';
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
        $event_category_details = $request->input('lang');
        $event_category = $request->input('event_category');
        $input_all = $request->all();
        $validator = Validator::make($request->all(), [
            // 'event_category_seo_title' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                if ($event_category) {
                    $EventCategory = EventCategory::find($id);
                    if ($event_category_details) {
                        foreach ($event_category as $key => $val) {
                            $EventCategory->{$key} = $val;
                        }
                        if (!isset($event_category['event_category_status'])) {
                            $EventCategory->event_category_status = 0;
                        }
                        $EventCategory->save();
                        $event_category_id = $EventCategory->getKey();
                    }
                }
                if ($event_category_details) {
                    // $EventCategoryDetail = EventCategoryDetail::where('event_category_id', $event_category_id)->delete();
                    foreach ($event_category_details as $key => $val1) {
                        // $EventCategoryDetail = new EventCategoryDetail;
                        $EventCategoryDetail = EventCategoryDetail::where('event_category_id', $event_category_id)->where('languages_id',$key)->first();

                        foreach ($val1 as $key => $val) {
                            // return $val1;
                            $EventCategoryDetail->{$key} = $val;
                            $EventCategoryDetail->event_category_id = $EventCategory->getKey();
                            $EventCategoryDetail->event_category_details_status = 1;
                            $EventCategoryDetail->save();
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
            if (isset($failedRules['event_category_seo_title']['required'])) {
                $return['status'] = 2;
                $return['title'] = "EventCategory is required";
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
        $result = EventCategory::select();
        $event_category_seo_title = $request->input('event_category_seo_title');
        $event_category_seo_keyword = $request->input('event_category_seo_keyword');
        $event_category_seo_description = $request->input('event_category_seo_description');
        $event_category_url_slug = $request->input('event_category_url_slug');

        if ($event_category_seo_title) {
            $result->where('event_category_seo_title', 'like', '%' . $event_category_seo_title . '%');
        };
        if ($event_category_seo_keyword) {
            $result->where('event_category_seo_keyword', 'like', '%' . $event_category_seo_keyword . '%');
        };
        if ($event_category_seo_description) {
            $result->where('event_category_seo_description', 'like', '%' . $event_category_seo_description . '%');
        };
        if ($event_category_url_slug) {
            $result->where('event_category_url_slug', 'like', '%' . $event_category_url_slug . '%');
        };

        return Datatables::of($result)
            ->addColumn('checkbox', function ($res) {
                $str = '<div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input checkbox-table" id="checkbox-item-' . $res->event_category_id . '">
                        <label class="custom-control-label" for="checkbox-item-' . $res->event_category_id . '"></label>
                    </div>';
                return $str;
            })
            ->addColumn('action', function ($res) {
                $view = Helper::CheckPermissionMenu('EventCategory', '1');
                $insert = Helper::CheckPermissionMenu('EventCategory', '2');
                $update = Helper::CheckPermissionMenu('EventCategory', '3');
                $delete = Helper::CheckPermissionMenu('EventCategory', '4');
                if ($res->event_category_status == 1) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }
                $btnStatus = '<input type="checkbox" class="toggle change-status" ' . $checked . ' data-id="' . $res->event_category_id . '" data-style="ios" data-on="On" data-off="Off">';
                $btnView = '<button type="button" class="btn btn-success btn-md btn-view" data-id="' . $res->event_category_id . '">View</button>';
                $btnEdit = '<button type="button" class="btn btn-info btn-md btn-edit" data-id="' . $res->event_category_id . '">Edit</button>';
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
            $input_all['event_category_status'] = $status;
            $input_all['updated_at'] = date('Y-m-d H:i:s');
            EventCategory::where('event_category_id', $id)->update($input_all);
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

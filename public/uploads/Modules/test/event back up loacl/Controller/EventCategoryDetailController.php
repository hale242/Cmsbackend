<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DataTables;
use App\Helper;
use App\MenuSystem;
use App\EventCategoryDetail;
use App\EventCategory;
use App\Language;

class EventCategoryDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['MainMenus'] = MenuSystem::where('menu_system_part', 'EventCategoryDetail')->with('MainMenu')->first();
        $data['Menus'] = MenuSystem::ActiveMenu()->get();
        $data['EventCategory'] = EventCategory::where('event_category_status', '1')->get();
        $data['Languages'] = Language::where('languages_status', '1')->get();
        $data['SeoTypes'] =[
        "0" => "ใช้ SEO หลัก",
        "1" => "ใช้ SEO ตามภาษา"
        ];

        if (Helper::CheckPermissionMenu('EventCategoryDetail', '1')) {
            return view('admin.EventCategoryDetail.event_category_detail', $data);
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
        $input_all = $request->all();
        $validator = Validator::make($request->all(), [
            'event_category_details_name' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $Event = new EventCategoryDetail;
                foreach ($input_all as $key => $val) {
                    $Event->{$key} = $val;
                }
                if (!isset($input_all['event_category_details_status'])) {
                    $Event->event_category_details_status = 0;
                }
                $Event->save();
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
            if (isset($failedRules['event_category_details_name']['required'])) {
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
        $content = EventCategoryDetail::with('Language','EventCategory')->find($id);
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
        $input_all = $request->all();
        $validator = Validator::make($request->all(), [
            'event_category_details_name' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $Event = EventCategoryDetail::find($id);
                foreach ($input_all as $key => $val) {
                    $Event->{$key} = $val;
                }
                if (!isset($input_all['event_category_details_status'])) {
                    $Event->event_category_details_status = 0;
                }
                $Event->save();
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
            if (isset($failedRules['event_category_details_name']['required'])) {
                $return['status'] = 2;
                $return['title'] = "EventCategoryDetail is required";
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
        $result = EventCategoryDetail::select()->with('Language','EventCategory');
        $event_category_details_name = $request->input('event_category_details_name');
        $event_event_category_details_seo_keyword = $request->input('event_event_category_details_seo_keyword');
        $event_category_details_details = $request->input('event_category_details_details');
        $event_event_category_details_seo_description = $request->input('event_event_category_details_seo_description');

        if ($event_category_details_name) {
            $result->where('event_category_details_name', 'like', '%' . $event_category_details_name . '%');
        };
        if ($event_event_category_details_seo_keyword) {
            $result->where('event_event_category_details_seo_keyword', 'like', '%' . $event_event_category_details_seo_keyword . '%');
        };
        if ($event_event_category_details_seo_description) {
            $result->where('event_event_category_details_seo_description', 'like', '%' . $event_event_category_details_seo_description . '%');
        };
        if ($event_category_details_name) {
            $result->where('event_category_details_details', 'like', '%' . $event_category_details_details . '%');
        };

        return Datatables::of($result)
            ->addColumn('checkbox', function ($res) {
                $str = '<div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input checkbox-table" id="checkbox-item-' . $res->event_category_details_id . '">
                        <label class="custom-control-label" for="checkbox-item-' . $res->event_category_details_id . '"></label>
                    </div>';
                return $str;
            })
            ->addColumn('event_category_id', function ($res) {
                $str = $res->EventCategory->event_category_seo_title;
                return $str;
            })
            ->addColumn('event_category_details_seo_type', function ($res) {
                if($res->event_category_details_seo_type == '1'){
                    $str = "ใช้ SEO หลัก";
                }
                else{
                    $str = "ใช้ SEO ตามภาษา";
                }
                return $str;
            })
            ->addColumn('action', function ($res) {
                $view = Helper::CheckPermissionMenu('EventCategoryDetail', '1');
                $insert = Helper::CheckPermissionMenu('EventCategoryDetail', '2');
                $update = Helper::CheckPermissionMenu('EventCategoryDetail', '3');
                $delete = Helper::CheckPermissionMenu('EventCategoryDetail', '4');
                if ($res->event_category_details_status == 1) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }
                $btnStatus = '<input type="checkbox" class="toggle change-status" ' . $checked . ' data-id="' . $res->event_category_details_id . '" data-style="ios" data-on="On" data-off="Off">';
                $btnView = '<button type="button" class="btn btn-success btn-md btn-view" data-id="' . $res->event_category_details_id . '">View</button>';
                $btnEdit = '<button type="button" class="btn btn-info btn-md btn-edit" data-id="' . $res->event_category_details_id . '">Edit</button>';
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
            ->rawColumns(['checkbox','event_category_id','event_category_details_seo_type','action'])
            ->make(true);
    }

    public function ChangeStatus(Request $request, $id)
    {
        $status = $request->input('status');
        \DB::beginTransaction();
        try {
            $input_all['event_category_details_status'] = $status;
            $input_all['updated_at'] = date('Y-m-d H:i:s');
            EventCategoryDetail::where('event_category_details_id', $id)->update($input_all);
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

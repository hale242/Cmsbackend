<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DataTables;
use App\Helper;
use App\MenuSystem;
use App\EventDetail;
use App\Event;
use App\Language;

class EventDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['MainMenus'] = MenuSystem::where('menu_system_part', 'EventDetail')->with('MainMenu')->first();
        $data['Menus'] = MenuSystem::ActiveMenu()->get();
        $data['Event'] = Event::where('event_status', '1')->get();
        $data['Languages'] = Language::where('languages_status', '1')->get();
        $data['ImageTypes'] = [
            "0" => "ใช้รูปหลักเป็นปก",
            "1" => "ใช้รูปตามเนื้อกิจกรรมเป็นปก (แยกตามภาษา)"
        ];
        $data['SeoTypes'] = [
            "0" => "ใช้ SEO หลัก",
            "1" => "ใช้ SEO ตามภาษา"
        ];

        if (Helper::CheckPermissionMenu('EventDetail', '1')) {
            return view('admin.EventDetail.event_detail', $data);
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
            'event_details_subject' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $Event = new EventDetail;
                foreach ($input_all as $key => $val) {
                    $Event->{$key} = $val;
                }
                if (!isset($input_all['event_details_status'])) {
                    $Event->event_details_status = 0;
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
            if (isset($failedRules['event_details_subject']['required'])) {
                $return['status'] = 2;
                $return['title'] = "Event Detail is required";
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
        $content = EventDetail::with('Language', 'Event')->find($id);
        $return['status'] = 1;
        $return['title'] = 'Get Event Detail';
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
            'event_details_subject' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $Event = EventDetail::find($id);
                foreach ($input_all as $key => $val) {
                    $Event->{$key} = $val;
                }
                if (!isset($input_all['event_details_status'])) {
                    $Event->event_details_status = 0;
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
            if (isset($failedRules['event_details_subject']['required'])) {
                $return['status'] = 2;
                $return['title'] = "EventDetail is required";
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
        $result = EventDetail::select()->with('Language', 'Event');

        return Datatables::of($result)
            ->addColumn('checkbox', function ($res) {
                $str = '<div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input checkbox-table" id="checkbox-item-' . $res->event_details_id . '">
                        <label class="custom-control-label" for="checkbox-item-' . $res->event_details_id . '"></label>
                    </div>';
                return $str;
            })
            ->addColumn('event_id', function ($res) {
                $str = $res->Event->event_seo_title;
                return $str;
            })
            ->addColumn('language_icon', function ($res) {
                $str = '<i class="'.$res->Language->languages_icon.'"></i>  '.$res->Language->languages_name.'';
                return $str;
            })
            ->addColumn('event_details_image_type', function ($res) {
                if ($res->event_details_image_type == '1') {
                    $str = "ใช้รูปตามเนื้อกิจกรรมเป็นปก (แยกตามภาษา)";
                } else {
                    $str = "ใช้รูปหลักเป็นปก";
                }
                return $str;
            })
            ->addColumn('event_details_seo_type', function ($res) {
                if ($res->event_details_seo_type == '1') {
                    $str = "ใช้ SEO หลัก";
                } else {
                    $str = "ใช้ SEO ตามภาษา";
                }
                return $str;
            })
            ->addColumn('action', function ($res) {
                $view = Helper::CheckPermissionMenu('EventDetail', '1');
                $insert = Helper::CheckPermissionMenu('EventDetail', '2');
                $update = Helper::CheckPermissionMenu('EventDetail', '3');
                $delete = Helper::CheckPermissionMenu('EventDetail', '4');
                if ($res->event_details_status == 1) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }
                $btnStatus = '<input type="checkbox" class="toggle change-status" ' . $checked . ' data-id="' . $res->event_details_id . '" data-style="ios" data-on="On" data-off="Off">';
                $btnView = '<button type="button" class="btn btn-success btn-md btn-view" data-id="' . $res->event_details_id . '">View</button>';
                $btnEdit = '<button type="button" class="btn btn-info btn-md btn-edit" data-id="' . $res->event_details_id . '">Edit</button>';
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
            ->rawColumns(['checkbox', 'event_id','language_icon', 'event_details_seo_type','event_details_image_type', 'action'])
            ->make(true);
    }

    public function ChangeStatus(Request $request, $id)
    {
        $status = $request->input('status');
        \DB::beginTransaction();
        try {
            $input_all['event_details_status'] = $status;
            $input_all['updated_at'] = date('Y-m-d H:i:s');
            EventDetail::where('event_details_id', $id)->update($input_all);
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

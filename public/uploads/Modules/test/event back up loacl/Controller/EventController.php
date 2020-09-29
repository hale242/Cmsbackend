<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DataTables;
use App\Helper;
use App\MenuSystem;
use App\Event;
use App\EventCategory;
use App\EventDetail;
use App\EventHasEventCategory;
use App\EventTag;
use App\EventHasEventTag;
use App\Language;
use App\EventGallery;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['MainMenus'] = MenuSystem::where('menu_system_part', 'Event')->with('MainMenu')->first();
        $data['Menus'] = MenuSystem::ActiveMenu()->get();
        $data['EventCategory'] = EventCategory::where('event_category_status', '1')->get();
        $data['EventTag'] = EventTag::where('event_tag_status', '1')->get();
        $data['Language'] = Language::where('languages_status', '1')->get();
        $data['SeoTypes'] = [
            "0" => "ใช้ SEO หลัก",
            "1" => "ใช้ SEO ตามภาษา"
        ];
        $data['ImageTypes'] = [
            "0" => "ใช้รูปหลักเป็นปก",
            "1" => "ใช้รูปตามเนื้อกิจกรรมเป็นปก (แยกตามภาษา)"
        ];
        if (Helper::CheckPermissionMenu('Event', '1')) {
            return view('admin.Event.event', $data);
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
        $event_category_id = $request->input('event_category_id');
        $event_detail = $request->input('lang');
        $event_tag_id = $request->input('event_tag_id');
        $event_gallery_type = $request->input('event_gallery_type');
        $event = $request->input('event');

        // $url_event_cover_temp = public_path('uploads/EventCoverTemp');
        // $url_event_cover_upload = public_path('uploads/EventCover');
        $url_temp = public_path('uploads/EventGalleryTemp');
        $url_upload = public_path('uploads/EventGallery');
        $file_name_all = $this->readDir($url_temp);
        $validator = Validator::make($request->all(), [
            // 'event_seo_title' => 'required',
        ]);
        $array = array();

        // foreach ($event_detail as $key => $val) {
        // }
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                if ($event) {
                    $Event = new Event;
                    $Language = Language::where('languages_type', '1')->first();
                    if ($event_detail) {
                        foreach ($event as $key => $val) {
                            $Event->{$key} = $val;
                        }
                        if (!isset($event['event_status'])) {
                            $Event->event_status = 0;
                        }
                        if (isset($event['event_image'])) {
                            $data_pic = explode('/', $event['event_image']);
                            $cout_path = count($data_pic);
                            $pic_name =  $data_pic[$cout_path - 1];
                            $Event->event_image = $pic_name;
                        }
                        $Event->save();
                        $event_id = $Event->getKey();
                        // copy($url_event_cover_temp . '/' . $pic_name, $url_event_cover_upload . '/' . $pic_name);
                        // unlink($url_event_cover_temp . '/' . $pic_name);
                    }
                }
                if ($event_detail) {
                    foreach ($event_detail as $key => $val1) {
                        $EventDetail = new EventDetail;
                        foreach ($val1 as $key => $val) {
                            $EventDetail->{$key} = $val;
                            $EventDetail->event_id = $Event->getKey();
                            $EventDetail->save();
                        }
                    }
                }

                if ($event_category_id) {
                    foreach ($event_category_id as $val) {
                        $EventHasEventCategory = new EventHasEventCategory;
                        $EventHasEventCategory->event_category_id = $val;
                        $EventHasEventCategory->event_has_event_category_status = '1';
                        $EventHasEventCategory->event_id = $event_id;
                        $EventHasEventCategory->save();
                    }
                }
                if ($event_tag_id) {
                    foreach ($event_tag_id as $val) {
                        $EventHasEventTag = new EventHasEventTag;
                        $EventHasEventTag->event_tag_id = $val;
                        $EventHasEventTag->event_has_event_tag_status = '1';
                        $EventHasEventTag->event_id = $event_id;
                        $EventHasEventTag->save();
                    }
                }
                if ($file_name_all) {
                    foreach ($file_name_all as $val) {
                        $data_pic = explode('/', $val);
                        $cout_path = count($data_pic);
                        $pic_name =  $data_pic[$cout_path - 1];
                        $EventGallery = new EventGallery;
                        $EventGallery->event_id = $Event->getKey();
                        $EventGallery->event_gallery_image_gall = $data_pic[$cout_path - 1];
                        $EventGallery->event_gallery_type = $event_gallery_type;
                        $EventGallery->event_gallery_status = 1;
                        $EventGallery->save();
                        copy($url_temp . '/' . $pic_name, $url_upload . '/' . $pic_name);
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
            if (isset($failedRules['event_seo_title']['required'])) {
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
        $content = Event::select()->with('EventHasEventCategory.EventCategory', 'EventHasEventTag.EventTag', 'EventDetail', 'EventGallery')->find($id);
        $content['format_event_date_set'] = $content->event_date_set ? date("Y-m-d", strtotime($content->event_date_set)) : '';
        $content['format_event_date_end'] = $content->event_date_end ? date("Y-m-d", strtotime($content->event_date_end)) : '';
        $content['test'] = asset('uploads/EventGallery/');
        $content['EventPath'] = asset('uploads/EventImage');
        $content['EventCoverPath'] = asset('uploads/EventCover');

        $return['status'] = 1;
        $return['title'] = 'Get Event';
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

        $event_category_id = $request->input('event_category_id');
        $event_detail = $request->input('lang');
        $event_tag_id = $request->input('event_tag_id');
        $event = $request->input('event');
        $event_gallery_type = $request->input('event_gallery_type');

        $url_temp = public_path('uploads/EventGalleryTemp');
        $url_upload = public_path('uploads/EventGallery');
        $file_name_all = $this->readDir($url_temp);
        $pic_event_cover_name = '';
        $pic_event_image_name = '';
        $validator = Validator::make($request->all(), [
            // 'event_seo_title' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                if ($event) {
                    $Event = Event::find($id);

                    if ($event_detail) {
                        foreach ($event as $key => $val) {
                            $Event->{$key} = $val;
                        }
                        if (!isset($event['event_status'])) {
                            $Event->event_status = 0;
                        }
                        if (isset($event['event_image'])) {
                            $data_pic = explode('/', $event['event_image']);
                            $cout_path = count($data_pic);
                            $pic_event_cover_name =  $data_pic[$cout_path - 1];
                            $Event->event_image = $pic_event_cover_name;
                        }
                        $Event->save();
                        $event_id = $Event->getKey();
                    }
                }
                if ($event_detail) {
                    // $EventDetail = EventDetail::where('event_id', $event_id)->delete();
                    foreach ($event_detail as $key => $val1) {
                        $EventDetail = EventDetail::where('event_id', $event_id)->where('languages_id',$key)->first();
                        // $EventDetail = new EventDetail;
                        foreach ($val1 as $key => $val) {
                            $EventDetail->{$key} = $val;
                            $EventDetail->event_id = $event_id;
                            if (isset($val1['event_details_image'])) {
                                $data_pic = explode('/', $val1['event_details_image']);
                                $cout_path = count($data_pic);
                                $pic_event_image_name =  $data_pic[$cout_path - 1];
                            }
                            $EventDetail->event_details_image = $pic_event_image_name;
                            $EventDetail->save();
                        }
                    }
                }
                if ($event_category_id) {
                    EventHasEventCategory::where('event_id', $event_id)->delete();
                    foreach ($event_category_id as $key => $val) {
                        $EventHasEventCategory = new EventHasEventCategory;
                        $EventHasEventCategory->event_category_id = $val;
                        $EventHasEventCategory->event_has_event_category_status = '1';
                        $EventHasEventCategory->event_id = $event_id;
                        $EventHasEventCategory->save();
                    }
                }
                if ($event_tag_id) {
                    EventHasEventTag::where('event_id', $event_id)->delete();
                    if ($event_tag_id) {
                        foreach ($event_tag_id as $val) {
                            $EventHasEventTag = new EventHasEventTag;
                            $EventHasEventTag->event_tag_id = $val;
                            $EventHasEventTag->event_has_event_tag_status = '1';
                            $EventHasEventTag->event_id = $event_id;
                            $EventHasEventTag->save();
                        }
                    }
                }
                if ($file_name_all) {
                    foreach ($file_name_all as $val) {
                        $data_pic = explode('/', $val);
                        $cout_path = count($data_pic);
                        $pic_name =  $data_pic[$cout_path - 1];
                        $EventGallery = new EventGallery;
                        $EventGallery->event_id = $id;
                        $EventGallery->event_gallery_image_gall = $data_pic[$cout_path - 1];
                        $EventGallery->event_gallery_type = $event_gallery_type;
                        $EventGallery->event_gallery_status = 1;
                        $EventGallery->save();
                        copy($url_temp . '/' . $pic_name, $url_upload . '/' . $pic_name);
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
            if (isset($failedRules['event_seo_title']['required'])) {
                $return['status'] = 2;
                $return['title'] = "Event is required";
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
        $result = Event::select()->with('EventHasEventCategory.EventCategory', 'EventHasEventTag.EventTag');
        $event_seo_title = $request->input('event_seo_title');
        $event_seo_description = $request->input('event_seo_description');
        if ($event_seo_title) {
            $result->where('event_seo_title', 'like', '%' . $event_seo_title . '%');
        };
        if ($event_seo_description) {
            $result->where('event_seo_description', 'like', '%' . $event_seo_description . '%');
        };
        return Datatables::of($result)
            ->addColumn('checkbox', function ($res) {
                $str = '<div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input checkbox-table" id="checkbox-item-' . $res->event_id . '">
                        <label class="custom-control-label" for="checkbox-item-' . $res->event_id . '"></label>
                    </div>';
                return $str;
            })

            ->addColumn('event_category', function ($res) {
                $html = '';
                foreach ($res->EventHasEventCategory as $val) {
                    if ($val->event_category_id) {
                        $html .= '<span class="badge badge-pill badge-primary text-white">' . $val->EventCategory->event_category_seo_title . '</span></br>';
                    }
                }
                return $html;
            })
            ->addColumn('event_tag', function ($res) {
                $html = '';
                foreach ($res->EventHasEventTag as $val) {
                    if ($val->event_tag_id) {
                        $html .= '<span class="badge badge-pill badge-info text-white">' . $val->EventTag->event_tag_name . '</span></br>';
                    }
                }
                return $html;
            })
            ->addColumn('event_date_set', function ($res) {
                $str = $res->event_date_set ? date("Y-m-d", strtotime($res->event_date_set)) : '';
                return $str;
            })
            ->addColumn('event_date_end', function ($res) {
                $str = $res->event_date_end ? date("Y-m-d", strtotime($res->event_date_end)) : '';
                return $str;
            })

            ->addColumn('action', function ($res) {
                $view = Helper::CheckPermissionMenu('Event', '1');
                $insert = Helper::CheckPermissionMenu('Event', '2');
                $update = Helper::CheckPermissionMenu('Event', '3');
                $delete = Helper::CheckPermissionMenu('Event', '4');
                if ($res->event_status == 1) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }
                $btnStatus = '<input type="checkbox" class="toggle change-status" ' . $checked . ' data-id="' . $res->event_id . '" data-style="ios" data-on="On" data-off="Off">';
                $btnView = '<button type="button" class="btn btn-success btn-md btn-view" data-id="' . $res->event_id . '">View</button>';
                $btnEdit = '<button type="button" class="btn btn-info btn-md btn-edit" data-id="' . $res->event_id . '">Edit</button>';
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
            ->rawColumns(['checkbox', 'event_category', 'event_tag', 'event_date_set', 'event_date_end', 'action'])
            ->make(true);
    }

    public function ChangeStatus(Request $request, $id)
    {
        $status = $request->input('status');
        \DB::beginTransaction();
        try {
            $input_all['event_status'] = $status;
            $input_all['updated_at'] = date('Y-m-d H:i:s');
            Event::where('event_id', $id)->update($input_all);
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

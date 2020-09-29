<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DataTables;
use App\Helper;
use App\MenuSystem;
use App\Event;
use App\EventGallery;

class EventGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          $data['MainMenus'] = MenuSystem::where('menu_system_part','EventGallery')->with('MainMenu')->first();
          $data['Menus'] = MenuSystem::ActiveMenu()->get();
          $data['Event'] = Event::where('event_status', '1')->get();
          $data['GalleryType'] = [
            "1" => "รูปภาพทั่วไป",
            "2" => "รูปภาพ cover"
        ];
          if(Helper::CheckPermissionMenu('EventGallery' , '1')){
              return view('admin.EventGallery.event_gallery', $data);
          }else{
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
            // 'event_gallery_name' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $EventGallery = new EventGallery;
                foreach($input_all as $key=>$val){
                    $EventGallery->{$key} = $val;
                }
                if(!isset($input_all['event_gallery_status'])){
                    $EventGallery->event_gallery_status = 0;
                }
                $EventGallery->save();
                \DB::commit();
                $return['status'] = 1;
                $return['content'] = 'Success';
            } catch (Exception $e) {
                \DB::rollBack();
                $return['status'] = 0;
                $return['content'] = 'Unsuccess';
            }
        }else{
            $failedRules = $validator->failed();
            $return['content'] = 'Unsuccess';
            if(isset($failedRules['event_gallery_name']['required'])) {
                $return['status'] = 2;
                $return['title'] = "Event Gallery is required";
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
        $content = EventGallery::with('Event')->find($id);
        $return['status'] = 1;
        $return['title'] = 'Get Event Gallery';
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
            // 'event_gallery_name' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $EventGallery = EventGallery::find($id);
                foreach($input_all as $key=>$val){
                    $EventGallery->{$key} = $val;
                }
                if(!isset($input_all['event_gallery_status'])){
                    $EventGallery->event_gallery_status = 0;
                }
                $EventGallery->save();
                \DB::commit();
                $return['status'] = 1;
                $return['content'] = 'Success';
            } catch (Exception $e) {
                \DB::rollBack();
                $return['status'] = 0;
                $return['content'] = 'Unsuccess';
            }
        }else{
            $failedRules = $validator->failed();
            $return['content'] = 'Unsuccess';
            if(isset($failedRules['event_gallery_name']['required'])) {
                $return['status'] = 2;
                $return['title'] = "Event Gallery is required";
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
      $result = EventGallery::select()->with('Event');
      $event_gallery_type = $request->input('event_gallery_type');
      if($event_gallery_type){
          $result->where('event_gallery_type',$event_gallery_type);
      };
    
      return Datatables::of($result)
        ->addColumn('checkbox' , function($res){
            $str = '<div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input checkbox-table" id="checkbox-item-'.$res->event_gallery_id.'">
                        <label class="custom-control-label" for="checkbox-item-'.$res->event_gallery_id.'"></label>
                    </div>';
            return $str;
        })
        ->addColumn('event', function($res){
            $str = $res->Event->event_seo_title;
            return $str;
        })
        ->addColumn('event_gallery_image_gall',function($res){
            $url_upload = public_path("uploads\EventGallery\$res->event_gallery_image_gall");
            $str = '<img src="'.$url_upload.'"></img>';
            return $str;
        })
        ->addColumn('event_gallery_type', function($res){
            $str = '';
            if($res->event_gallery_type == 1){
                $str = "รูปภาพทั่วไป";
            }
            else{
                $str = "รูปภาพ cover";
            }
            return $str;
        })
        ->addColumn('action' , function($res){
            $view = Helper::CheckPermissionMenu('EventGallery' , '1');
            $insert = Helper::CheckPermissionMenu('EventGallery' , '2');
            $update = Helper::CheckPermissionMenu('EventGallery' , '3');
            $delete = Helper::CheckPermissionMenu('EventGallery' , '4');
            if($res->event_gallery_status == 1){
                $checked = 'checked';
            }else{
                $checked = '';
            }
            $btnStatus = '<input type="checkbox" class="toggle change-status" '.$checked.' data-id="'.$res->event_gallery_id.'" data-style="ios" data-on="On" data-off="Off">';
            $btnView = '<button type="button" class="btn btn-success btn-md btn-view" data-id="'.$res->event_gallery_id.'">View</button>';
            $btnEdit = '<button type="button" class="btn btn-info btn-md btn-edit" data-id="'.$res->event_gallery_id.'">Edit</button>';
            $str = '';
            if($update){
                $str.=' '.$btnStatus;
            }
            if($view){
                $str.=' '.$btnView;
            }
            if($update){
                $str.=' '.$btnEdit;
            }
            return $str;
        })
        ->addIndexColumn()
        ->rawColumns(['checkbox','event','event_gallery_type','event_gallery_image_gall','action'])
        ->make(true);
    }

    public function ChangeStatus(Request $request, $id)
    {
        $status = $request->input('status');
        \DB::beginTransaction();
        try {
            $input_all['event_gallery_status'] = $status;
            $input_all['updated_at'] = date('Y-m-d H:i:s');
            EventGallery::where('event_gallery_id', $id)->update($input_all);
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

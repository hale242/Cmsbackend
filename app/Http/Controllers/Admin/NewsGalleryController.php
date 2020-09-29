<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DataTables;
use App\Helper;
use App\MenuSystem;
use App\News;
use App\NewsGallery;

class NewsGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          $data['MainMenus'] = MenuSystem::where('menu_system_part','NewsGallery')->with('MainMenu')->first();
          $data['Menus'] = MenuSystem::ActiveMenu()->get();
          $data['News'] = News::where('news_status', '1')->get();
          $data['GalleryType'] = [
            "1" => "รูปภาพทั่วไป",
            "2" => "รูปภาพ cover"
        ];
          if(Helper::CheckPermissionMenu('NewsGallery' , '1')){
              return view('admin.NewsGallery.news_gallery', $data);
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
            // 'news_gallery_name' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $NewsGallery = new NewsGallery;
                foreach($input_all as $key=>$val){
                    $NewsGallery->{$key} = $val;
                }
                if(!isset($input_all['news_gallery_status'])){
                    $NewsGallery->news_gallery_status = 0;
                }
                $NewsGallery->save();
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
            if(isset($failedRules['news_gallery_name']['required'])) {
                $return['status'] = 2;
                $return['title'] = "News Gallery is required";
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
        $content = NewsGallery::with('News')->find($id);

        $return['GalleryPath'] = asset('uploads/NewsGallery');
        $return['status'] = 1;
        $return['title'] = 'Get News Gallery';
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
            // 'news_gallery_name' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $NewsGallery = NewsGallery::find($id);
                foreach($input_all as $key=>$val){
                    $NewsGallery->{$key} = $val;
                }
                if(!isset($input_all['news_gallery_status'])){
                    $NewsGallery->news_gallery_status = 0;
                }
                $NewsGallery->save();
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
            if(isset($failedRules['news_gallery_name']['required'])) {
                $return['status'] = 2;
                $return['title'] = "News Gallery is required";
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
      $result = NewsGallery::select()->with('News');
      $news_gallery_type = $request->input('news_gallery_type');
      if($news_gallery_type){
          $result->where('news_gallery_type',$news_gallery_type);
      };
    
      return Datatables::of($result)
        ->addColumn('checkbox' , function($res){
            $str = '<div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input checkbox-table" id="checkbox-item-'.$res->news_gallery_id.'">
                        <label class="custom-control-label" for="checkbox-item-'.$res->news_gallery_id.'"></label>
                    </div>';
            return $str;
        })
        ->addColumn('news', function($res){
            $str = $res->News->news_seo_title;
            return $str;
        })
        ->addColumn('news_gallery_image_gall',function($res){
            $path = asset('uploads/NewsGallery/' .$res->news_gallery_image_gall);
                return '<img src="' . $path .'" style="height: 80px;" >';
            })
        ->addColumn('news_gallery_type', function($res){
            $str = '';
            if($res->news_gallery_type == 1){
                $str = "รูปภาพทั่วไป";
            }
            else{
                $str = "รูปภาพ cover";
            }
            return $str;
        })
        ->addColumn('action' , function($res){
            $view = Helper::CheckPermissionMenu('NewsGallery' , '1');
            $insert = Helper::CheckPermissionMenu('NewsGallery' , '2');
            $update = Helper::CheckPermissionMenu('NewsGallery' , '3');
            $delete = Helper::CheckPermissionMenu('NewsGallery' , '4');
            if($res->news_gallery_status == 1){
                $checked = 'checked';
            }else{
                $checked = '';
            }
            $btnStatus = '<input type="checkbox" class="toggle change-status" '.$checked.' data-id="'.$res->news_gallery_id.'" data-style="ios" data-on="On" data-off="Off">';
            $btnView = '<button type="button" class="btn btn-success btn-md btn-view" data-id="'.$res->news_gallery_id.'">View</button>';
            $btnEdit = '<button type="button" class="btn btn-info btn-md btn-edit" data-id="'.$res->news_gallery_id.'">Edit</button>';
            $btnDelete = '<button type="button" class="btn btn-danger btn-md btn-delete" data-id="' . $res->news_gallery_id . '">Delete</button>';

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
            if ($delete) {
                $str .= ' ' . $btnDelete;
            }
            return $str;
        })
        ->addIndexColumn()
        ->rawColumns(['checkbox','news','news_gallery_type','news_gallery_image_gall','action'])
        ->make(true);
    }

    public function Delete(Request $request, $id)
    {
        \DB::beginTransaction();
        try {
            $img_gallery_url = public_path('uploads/NewsGallery');

            $NewsGallery = NewsGallery::find($id);
            unlink($img_gallery_url . '/' . $NewsGallery->news_gallery_image_gall);
            
            NewsGallery::where('news_gallery_id', $id)->delete();

            \DB::commit();
            $return['status'] = 1;
            $return['content'] = 'Success';
        } catch (Exception $e) {
            \DB::rollBack();
            $return['content'] = 'Unsuccess';
        }
        $return['title'] = 'Update Status';
        return $return;
    }

    public function ChangeStatus(Request $request, $id)
    {
       
        $status = $request->input('status');
        \DB::beginTransaction();
        try {
            $input_all['news_gallery_status'] = $status;
            $input_all['updated_at'] = date('Y-m-d H:i:s');
            NewsGallery::where('news_gallery_id', $id)->update($input_all);
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

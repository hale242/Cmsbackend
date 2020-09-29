<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DataTables;
use App\Helper;
use App\MenuSystem;
use App\NewsTag;

class NewsTagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          $data['MainMenus'] = MenuSystem::where('menu_system_part','NewsTag')->with('MainMenu')->first();
          $data['Menus'] = MenuSystem::ActiveMenu()->get();
          if(Helper::CheckPermissionMenu('NewsTag' , '1')){
              return view('admin.NewsTag.news_tag', $data);
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
            'news_tag_name' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $NewsTag = new NewsTag;
                foreach($input_all as $key=>$val){
                    $NewsTag->{$key} = $val;
                }
                if(!isset($input_all['news_tag_status'])){
                    $NewsTag->news_tag_status = 0;
                }
                $NewsTag->save();
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
            if(isset($failedRules['news_tag_name']['required'])) {
                $return['status'] = 2;
                $return['title'] = "News Tag is required";
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
        $content = NewsTag::find($id);
        $return['status'] = 1;
        $return['title'] = 'Get NewsTag';
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
            'news_tag_name' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $NewsTag = NewsTag::find($id);
                foreach($input_all as $key=>$val){
                    $NewsTag->{$key} = $val;
                }
                if(!isset($input_all['news_tag_status'])){
                    $NewsTag->news_tag_status = 0;
                }
                $NewsTag->save();
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
            if(isset($failedRules['news_tag_name']['required'])) {
                $return['status'] = 2;
                $return['title'] = "News Tag is required";
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
      $result = NewsTag::select();
      $news_tag_name = $request->input('news_tag_name');
      $news_tag_detail = $request->input('news_tag_detail');
      if($news_tag_name){
          $result->where('news_tag_name', 'like', '%'.$news_tag_name.'%');
      };
      if($news_tag_detail){
          $result->where('news_tag_details', 'like', '%'.$news_tag_detail.'%');
      };
      return Datatables::of($result)
        ->addColumn('checkbox' , function($res){
            $str = '<div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input checkbox-table" id="checkbox-item-'.$res->news_tag_id.'">
                        <label class="custom-control-label" for="checkbox-item-'.$res->news_tag_id.'"></label>
                    </div>';
            return $str;
        })
        ->addColumn('action' , function($res){
            $view = Helper::CheckPermissionMenu('NewsTag' , '1');
            $insert = Helper::CheckPermissionMenu('NewsTag' , '2');
            $update = Helper::CheckPermissionMenu('NewsTag' , '3');
            $delete = Helper::CheckPermissionMenu('NewsTag' , '4');
            if($res->news_tag_status == 1){
                $checked = 'checked';
            }else{
                $checked = '';
            }
            $btnStatus = '<input type="checkbox" class="toggle change-status" '.$checked.' data-id="'.$res->news_tag_id.'" data-style="ios" data-on="On" data-off="Off">';
            $btnView = '<button type="button" class="btn btn-success btn-md btn-view" data-id="'.$res->news_tag_id.'">View</button>';
            $btnEdit = '<button type="button" class="btn btn-info btn-md btn-edit" data-id="'.$res->news_tag_id.'">Edit</button>';
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
        ->rawColumns(['checkbox', 'action'])
        ->make(true);
    }

    public function ChangeStatus(Request $request, $id)
    {
        $status = $request->input('status');
        \DB::beginTransaction();
        try {
            $input_all['news_tag_status'] = $status;
            $input_all['updated_at'] = date('Y-m-d H:i:s');
            NewsTag::where('news_tag_id', $id)->update($input_all);
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

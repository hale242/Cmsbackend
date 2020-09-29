<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DataTables;
use App\Helper;
use App\MenuSystem;
use App\Question;
use App\QuestionCategory;
use App\QuestionDetail;
use App\QuestionHasQuestionCategory;

use App\Language;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['MainMenus'] = MenuSystem::where('menu_system_part', 'Question')->with('MainMenu')->first();
        $data['Menus'] = MenuSystem::ActiveMenu()->get();
        $data['QuestionCategory'] = QuestionCategory::where('ques_category_status', '1')->get();
        $data['Language'] = Language::where('languages_status', '1')->get();
        // $data['SeoTypes'] = [
        //     "0" => "ใช้ SEO หลัก",
        //     "1" => "ใช้ SEO ตามภาษา"
        // ];
        if (Helper::CheckPermissionMenu('Question', '1')) {
            return view('admin.Question.question', $data);
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
        $ques_category_id = $request->input('ques_category_id');
        $ques_lang = $request->input('lang');
        $question = $request->input('question');

        $url_temp = public_path('uploads/QuestionImageTemp');
        $url_upload = public_path('uploads/QuestionImage');
        $file_name_all = $this->readDir($url_temp);

        $validator = Validator::make($request->all(), [
            // 'ques_seo_title' => 'required',
        ]);
        $array = array();

        // foreach ($ques_lang as $key => $val) {
        // }
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                if ($question) {
                    $Question = new Question;
                    $Language = Language::where('languages_type', '1')->first();
                    foreach ($question as $key => $val) {
                        $Question->{$key} = $val;
                    }
                    if (!isset($question['ques_status'])) {
                        $Question->ques_status = 0;
                    }
                    
                    $Question->save();
                    $ques_id = $Question->getKey();
                }
                if ($ques_lang) {
                    foreach ($ques_lang as $val1) {
                        $QuestionDetail = new QuestionDetail;
                        foreach ($val1 as $key => $val) {
                            // return $val1['ques_langs_image'];
                            $QuestionDetail->{$key} = $val;
                            if (isset($val1['ques_lang_image'])) {
                                $image_cut = str_replace("QuestionImageTemp/", "", $val1['ques_lang_image']);
                                $QuestionDetail->ques_lang_image = $image_cut;
                                copy($url_temp . '/' . $image_cut, $url_upload . '/' . $image_cut);
                            }

                            $QuestionDetail->ques_id = $Question->getKey();
                            $QuestionDetail->save();
                        }
                    }
                }

                if ($ques_category_id) {
                    foreach ($ques_category_id as $val) {
                        $QuestionHasQuestionCategory = new QuestionHasQuestionCategory;
                        $QuestionHasQuestionCategory->ques_category_id = $val;
                        // $QuestionHasQuestionCategory->ques_has_ques_category_status = '1';
                        $QuestionHasQuestionCategory->ques_id = $ques_id;
                        $QuestionHasQuestionCategory->save();
                    }
                }
                if ($file_name_all) {
                    foreach ($file_name_all as $val) {
                        $data_pic = explode('/', $val);
                        $cout_path = count($data_pic);
                        $pic_name =  $data_pic[$cout_path - 1];

                        // copy($url_temp . '/' . $pic_name, $url_upload . '/' . $pic_name);
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
            if (isset($failedRules['ques_seo_title']['required'])) {
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
        $content = Question::select()->with('QuestionHasQuestionCategory.QuestionCategory', 'QuestionDetail')->find($id);
        $content['QuestionCoverPath'] = asset('uploads/QuestionCover');
        $content['QuestionImagePath'] = asset('uploads/QuestionImage');
        $return['status'] = 1;
        $return['title'] = 'Get Question';
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

        $ques_category_id = $request->input('ques_category_id');
        $ques_lang = $request->input('lang');
        $question = $request->input('question');

        $url_temp = public_path('uploads/QuestionImageTemp');
        $url_upload = public_path('uploads/QuestionImage');
        $file_name_all = $this->readDir($url_temp);

        $pic_ques_cover_name = '';
        $pic_ques_image_name = '';
        $validator = Validator::make($request->all(), [
            // 'ques_seo_title' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                if ($question) {
                    $Question = Question::find($id);
                    foreach ($question as $key => $val) {
                        $Question->{$key} = $val;
                    }
                    if (!isset($question['ques_status'])) {
                        $Question->ques_status = 0;
                    }
                    if (isset($question['ques_image'])) {
                        $Question->ques_image = str_replace("QuestionCover/", "", $question['ques_image']);
                    }
                    $Question->save();
                    $ques_id = $Question->getKey();
                }
                if ($ques_lang) {
                    foreach ($ques_lang as $key1 => $val1) {

                        $QuestionDetail = QuestionDetail::where('ques_id', $ques_id)->where('languages_id', $key1)->first();
                        foreach ($val1 as $key => $val) {
                            $old_image = $QuestionDetail->ques_lang_image;
                            $QuestionDetail->{$key} = $val;
                            $QuestionDetail->ques_id = $ques_id;

                            if (isset($val1['ques_lang_image'])) {
                                // if($old_image){
                                //     unlink($url_upload . '/' . $old_image);
                                // }
                                $image_cut = str_replace("QuestionImageTemp/", "", $val1['ques_lang_image']);
                                $QuestionDetail->ques_lang_image = $image_cut;
                                copy($url_temp . '/' . $image_cut, $url_upload . '/' . $image_cut);
                            }

                            $QuestionDetail->save();
                        }
                    }
                }
                if ($ques_category_id) {
                    QuestionHasQuestionCategory::where('ques_id', $ques_id)->delete();
                    foreach ($ques_category_id as $key => $val) {
                        $QuestionHasQuestionCategory = new QuestionHasQuestionCategory;
                        $QuestionHasQuestionCategory->ques_category_id = $val;
                        // $QuestionHasQuestionCategory->ques_has_ques_category_status = '1';
                        $QuestionHasQuestionCategory->ques_id = $ques_id;
                        $QuestionHasQuestionCategory->save();
                    }
                }

                if ($file_name_all) {
                    foreach ($file_name_all as $val) {
                        $data_pic = explode('/', $val);
                        $cout_path = count($data_pic);
                        $pic_name =  $data_pic[$cout_path - 1];

                        // copy($url_temp . '/' . $pic_name, $url_upload . '/' . $pic_name);
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
            if (isset($failedRules['ques_seo_title']['required'])) {
                $return['status'] = 2;
                $return['title'] = "Question is required";
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
        $result = Question::select()->with('QuestionHasQuestionCategory.QuestionCategory');
        $ques_seo_title = $request->input('ques_seo_title');
        $ques_seo_description = $request->input('ques_seo_description');
        if ($ques_seo_title) {
            $result->where('ques_seo_title', 'like', '%' . $ques_seo_title . '%');
        };
        if ($ques_seo_description) {
            $result->where('ques_seo_description', 'like', '%' . $ques_seo_description . '%');
        };
        return Datatables::of($result)
            ->addColumn('checkbox', function ($res) {
                $str = '<div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input checkbox-table" id="checkbox-item-' . $res->ques_id . '">
                        <label class="custom-control-label" for="checkbox-item-' . $res->ques_id . '"></label>
                    </div>';
                return $str;
            })

            ->addColumn('ques_category', function ($res) {
                $html = '';
                foreach ($res->QuestionHasQuestionCategory as $val) {
                    if ($val->ques_category_id) {
                        $html .= '<span class="badge badge-pill badge-primary text-white">' . $val->QuestionCategory->ques_category_seo_title . '</span></br>';
                    }
                }
                return $html;
            })

            ->addColumn('action', function ($res) {
                $view = Helper::CheckPermissionMenu('Question', '1');
                $insert = Helper::CheckPermissionMenu('Question', '2');
                $update = Helper::CheckPermissionMenu('Question', '3');
                $delete = Helper::CheckPermissionMenu('Question', '4');
                if ($res->ques_status == 1) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }
                $btnStatus = '<input type="checkbox" class="toggle change-status" ' . $checked . ' data-id="' . $res->ques_id . '" data-style="ios" data-on="On" data-off="Off">';
                $btnView = '<button type="button" class="btn btn-success btn-md btn-view" data-id="' . $res->ques_id . '">View</button>';
                $btnEdit = '<button type="button" class="btn btn-info btn-md btn-edit" data-id="' . $res->ques_id . '">Edit</button>';
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
            ->rawColumns(['checkbox', 'ques_category', 'ques_tag', 'ques_date_set', 'ques_date_end', 'action'])
            ->make(true);
    }

    public function ChangeStatus(Request $request, $id)
    {
        $status = $request->input('status');
        \DB::beginTransaction();
        try {
            $input_all['ques_status'] = $status;
            $input_all['updated_at'] = date('Y-m-d H:i:s');
            Question::where('ques_id', $id)->update($input_all);
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

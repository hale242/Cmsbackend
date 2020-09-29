<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DataTables;
use App\Helper;
use App\MenuSystem;
use App\News;
use App\NewsCategory;
use App\NewsDetail;
use App\NewsHasNewsCategory;
use App\NewsTag;
use App\NewsHasNewsTag;
use App\Language;
use App\NewsGallery;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['MainMenus'] = MenuSystem::where('menu_system_part', 'News')->with('MainMenu')->first();
        $data['Menus'] = MenuSystem::ActiveMenu()->get();
        $data['NewsCategory'] = NewsCategory::where('news_category_status', '1')->get();
        $data['NewsTag'] = NewsTag::where('news_tag_status', '1')->get();
        $data['Language'] = Language::where('languages_status', '1')->get();
        $data['SeoTypes'] = [
            "0" => "ใช้ SEO หลัก",
            "1" => "ใช้ SEO ตามภาษา"
        ];
        $data['ImageTypes'] = [
            "0" => "ใช้รูปหลักเป็นปก",
            "1" => "ใช้รูปตามเนื้อกิจกรรมเป็นปก (แยกตามภาษา)"
        ];
        if (Helper::CheckPermissionMenu('News', '1')) {
            return view('admin.News.news', $data);
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
        $news_category_id = $request->input('news_category_id');
        $news_detail = $request->input('lang');
        $news_tag_id = $request->input('news_tag_id');
        $news_gallery_type = $request->input('news_gallery_type');
        $news = $request->input('news');

        // $url_news_cover_temp = public_path('uploads/EventCoverTemp');
        // $url_news_cover_upload = public_path('uploads/EventCover');
        $url_temp = public_path('uploads/NewsGalleryTemp');
        $url_upload = public_path('uploads/NewsGallery');
        $img_detail_url_temp = public_path('uploads/NewsImageTemp');
        $img_detail_url_upload = public_path('uploads/NewsImage');
        $img_cover_url_temp = public_path('uploads/NewsCoverTemp');
        $img_cover_url_upload = public_path('uploads/NewsCover');

        $file_name_all = $this->readDir($url_temp);
        $file_name_all_mg_detail_temp = $this->readDir($img_detail_url_temp);
        $file_cover_temp = $this->readDir($img_cover_url_temp);

        $file_name_all = $this->readDir($url_temp);

        $validator = Validator::make($request->all(), [
            // 'news_seo_title' => 'required',
        ]);
        $array = array();

        // foreach ($news_detail as $key => $val) {
        // }
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                if ($news) {

                    $News = new News;
                    $Language = Language::where('languages_type', '1')->first();
                    if ($news_detail) {
                        foreach ($news as $key => $val) {
                            $News->{$key} = $val;
                        }
                        if (!isset($news['news_status'])) {
                            $News->news_status = 0;
                        }
                        if (isset($news['news_image'])) {
                            // $data_pic = explode('/', $news['news_image']);
                            // $cout_path = count($data_pic);
                            // $pic_name =  $data_pic[$cout_path - 1];
                            // $News->news_image = $pic_name;
                            $image_cut = str_replace("NewsCoverTemp/", "", $news['news_image']);
                            $News->news_image = $image_cut;
                            copy($img_cover_url_temp . '/' . $image_cut, $img_cover_url_upload . '/' . $image_cut);
                        }
                        $News->save();
                        $news_id = $News->getKey();
                    }
                }
                if ($news_detail) {

                    foreach ($news_detail as $key => $val1) {
                        $NewsDetail = new NewsDetail;
                        foreach ($val1 as $key => $val) {
                            if (isset($val1['news_details_image'])) {
                                $image_cut2 = str_replace("NewsImageTemp/", "", $val1['news_details_image']);
                                $NewsDetail->news_details_image = $image_cut2;
                                copy($img_detail_url_temp . '/' . $image_cut2, $img_detail_url_upload . '/' . $image_cut2);
                            }
                            $NewsDetail->{$key} = $val;
                            $NewsDetail->news_id = $News->getKey();
                            $NewsDetail->save();
                        }
                    }
                }

                if ($news_category_id) {
                    foreach ($news_category_id as $val) {
                        $NewsHasNewsCategory = new NewsHasNewsCategory;
                        $NewsHasNewsCategory->news_category_id = $val;
                        $NewsHasNewsCategory->news_has_news_category_status = '1';
                        $NewsHasNewsCategory->news_id = $news_id;
                        $NewsHasNewsCategory->save();
                    }
                }
                if ($news_tag_id) {
                    foreach ($news_tag_id as $val) {
                        $NewsHasNewsTag = new NewsHasNewsTag;
                        $NewsHasNewsTag->news_tag_id = $val;
                        $NewsHasNewsTag->news_has_news_tag_status = '1';
                        $NewsHasNewsTag->news_id = $news_id;
                        $NewsHasNewsTag->save();
                    }
                }
                if ($file_name_all) {
                    foreach ($file_name_all as $val) {
                        $data_pic = explode('/', $val);
                        $cout_path = count($data_pic);
                        $pic_name =  $data_pic[$cout_path - 1];
                        $NewsGallery = new NewsGallery;
                        $NewsGallery->news_id = $News->getKey();
                        $NewsGallery->news_gallery_image_gall = $data_pic[$cout_path - 1];
                        $NewsGallery->news_gallery_type = $news_gallery_type;
                        $NewsGallery->news_gallery_status = 1;
                        $NewsGallery->save();
                        copy($url_temp . '/' . $pic_name, $url_upload . '/' . $pic_name);
                        unlink($url_temp . '/' . $pic_name);
                    }
                }
                if ($file_name_all_mg_detail_temp) {
                    foreach ($file_name_all_mg_detail_temp as $val) {
                        $data_pic = explode('/', $val);
                        $cout_path = count($data_pic);
                        $pic_name =  $data_pic[$cout_path - 1];
                        unlink($img_detail_url_temp . '/' . $pic_name);
                    }
                }
                if ($file_cover_temp) {
                    foreach ($file_cover_temp as $val) {
                        $data_pic = explode('/', $val);
                        $cout_path = count($data_pic);
                        $pic_name =  $data_pic[$cout_path - 1];
                        unlink($img_cover_url_temp . '/' . $pic_name);
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
            if (isset($failedRules['news_seo_title']['required'])) {
                $return['status'] = 2;
                $return['title'] = "News is required";
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
        $content = News::select()->with('NewsHasNewsCategory.NewsCategory', 'NewsHasNewsTag.NewsTag', 'NewsDetail', 'NewsGallery')->find($id);
        $content['format_news_date_set'] = $content->news_date_set ? date("Y-m-d", strtotime($content->news_date_set)) : '';
        $content['format_news_date_end'] = $content->news_date_end ? date("Y-m-d", strtotime($content->news_date_end)) : '';
        $content['url_path'] = asset('uploads/NewsGallery/');
        $content['NewsPath'] = asset('uploads/NewsImage');
        $content['NewsCoverPath'] = asset('uploads/NewsCover');

        $return['status'] = 1;
        $return['title'] = 'Get News';
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

        $news_category_id = $request->input('news_category_id');
        $news_detail = $request->input('lang');
        $news_tag_id = $request->input('news_tag_id');
        $news = $request->input('news');
        $news_gallery_type = $request->input('news_gallery_type');

        $url_temp = public_path('uploads/NewsGalleryTemp');
        $url_upload = public_path('uploads/NewsGallery');

        $img_detail_url_temp = public_path('uploads/NewsImageTemp');
        $img_detail_url_upload = public_path('uploads/NewsImage');

        $img_cover_url_temp = public_path('uploads/NewsCoverTemp');
        $img_cover_url_upload = public_path('uploads/NewsCover');

        $file_name_all = $this->readDir($url_temp);
        $file_name_all_mg_detail_temp = $this->readDir($img_detail_url_temp);
        $file_cover_temp = $this->readDir($img_cover_url_temp);

        $pic_news_cover_name = '';
        $pic_news_image_name = '';
        $validator = Validator::make($request->all(), [
            // 'news_seo_title' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                if ($news) {
                    $News = News::find($id);

                    if ($news_detail) {
                        foreach ($news as $key => $val) {
                            $old_image_cover = $News->news_image;
                            $News->{$key} = $val;
                            if (isset($news['news_image'])) {
                                // $data_pic = explode('/', $news['news_image']);
                                // $cout_path = count($data_pic);
                                // $pic_news_cover_name =  $data_pic[$cout_path - 1];
                                // $News->news_image = $pic_news_cover_name;

                                if ($old_image_cover) {
                                    unlink($img_cover_url_upload . '/' . $old_image_cover);
                                }
                                $image_cut = str_replace("NewsCoverTemp/", "", $news['news_image']);
                                $News->news_image = $image_cut;
                                copy($img_cover_url_temp . '/' . $image_cut, $img_cover_url_upload . '/' . $image_cut);
                            }
                            if (!isset($news['news_status'])) {
                                $News->news_status = 0;
                            }
                            $News->save();
                            $news_id = $News->getKey();
                        }
                    }
                }
                if ($news_detail) {
                    // $NewsDetail = NewsDetail::where('news_id', $news_id)->delete();
                    foreach ($news_detail as $key => $val1) {
                        $NewsDetail = NewsDetail::where('news_id', $news_id)->where('languages_id', $key)->first();
                        // $NewsDetail = new NewsDetail;
                        foreach ($val1 as $key => $val) {
                            $old_image = $NewsDetail->news_details_image;
                            $NewsDetail->{$key} = $val;
                            $NewsDetail->news_id = $news_id;

                            if (isset($val1['news_details_image'])) {
                                if ($old_image) {
                                    unlink($img_detail_url_upload . '/' . $old_image);
                                }
                                $image_cut2 = str_replace("NewsImageTemp/", "", $val1['news_details_image']);
                                $NewsDetail->news_details_image = $image_cut2;
                                copy($img_detail_url_temp . '/' . $image_cut2, $img_detail_url_upload . '/' . $image_cut2);
                            }
                            $NewsDetail->save();
                        }
                    }
                }
                if ($news_category_id) {
                    NewsHasNewsCategory::where('news_id', $news_id)->delete();
                    foreach ($news_category_id as $key => $val) {
                        $NewsHasNewsCategory = new NewsHasNewsCategory;
                        $NewsHasNewsCategory->news_category_id = $val;
                        $NewsHasNewsCategory->news_has_news_category_status = '1';
                        $NewsHasNewsCategory->news_id = $news_id;
                        $NewsHasNewsCategory->save();
                    }
                }
                if ($news_tag_id) {
                    NewsHasNewsTag::where('news_id', $news_id)->delete();
                    if ($news_tag_id) {
                        foreach ($news_tag_id as $val) {
                            $NewsHasNewsTag = new NewsHasNewsTag;
                            $NewsHasNewsTag->news_tag_id = $val;
                            $NewsHasNewsTag->news_has_news_tag_status = '1';
                            $NewsHasNewsTag->news_id = $news_id;
                            $NewsHasNewsTag->save();
                        }
                    }
                }
                if ($file_name_all) {
                    foreach ($file_name_all as $val) {
                        $data_pic = explode('/', $val);
                        $cout_path = count($data_pic);
                        $pic_name =  $data_pic[$cout_path - 1];
                        $NewsGallery = new NewsGallery;
                        $NewsGallery->news_id = $id;
                        $NewsGallery->news_gallery_image_gall = $data_pic[$cout_path - 1];
                        $NewsGallery->news_gallery_type = $news_gallery_type;
                        $NewsGallery->news_gallery_status = 1;
                        $NewsGallery->save();
                        copy($url_temp . '/' . $pic_name, $url_upload . '/' . $pic_name);
                        unlink($url_temp . '/' . $pic_name);
                    }
                }
                if ($file_name_all_mg_detail_temp) {
                    foreach ($file_name_all_mg_detail_temp as $val) {
                        $data_pic = explode('/', $val);
                        $cout_path = count($data_pic);
                        $pic_name =  $data_pic[$cout_path - 1];
                        unlink($img_detail_url_temp . '/' . $pic_name);
                    }
                }
                if ($file_cover_temp) {
                    foreach ($file_cover_temp as $val) {
                        $data_pic = explode('/', $val);
                        $cout_path = count($data_pic);
                        $pic_name =  $data_pic[$cout_path - 1];
                        unlink($img_cover_url_temp . '/' . $pic_name);
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
            if (isset($failedRules['news_seo_title']['required'])) {
                $return['status'] = 2;
                $return['title'] = "News is required";
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
        $result = News::select()->with('NewsHasNewsCategory.NewsCategory', 'NewsHasNewsTag.NewsTag');
        $news_seo_title = $request->input('news_seo_title');
        $news_seo_description = $request->input('news_seo_description');
        if ($news_seo_title) {
            $result->where('news_seo_title', 'like', '%' . $news_seo_title . '%');
        };
        if ($news_seo_description) {
            $result->where('news_seo_description', 'like', '%' . $news_seo_description . '%');
        };
        return Datatables::of($result)
            ->addColumn('checkbox', function ($res) {
                $str = '<div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input checkbox-table" id="checkbox-item-' . $res->news_id . '">
                        <label class="custom-control-label" for="checkbox-item-' . $res->news_id . '"></label>
                    </div>';
                return $str;
            })

            ->addColumn('news_category', function ($res) {
                $html = '';
                foreach ($res->NewsHasNewsCategory as $val) {
                    if ($val->news_category_id) {
                        $html .= '<span class="badge badge-pill badge-primary text-white">' . $val->NewsCategory->news_category_seo_title . '</span></br>';
                    }
                }
                return $html;
            })
            ->addColumn('news_tag', function ($res) {
                $html = '';
                foreach ($res->NewsHasNewsTag as $val) {
                    if ($val->news_tag_id) {
                        $html .= '<span class="badge badge-pill badge-info text-white">' . $val->NewsTag->news_tag_name . '</span></br>';
                    }
                }
                return $html;
            })
            ->addColumn('news_date_set', function ($res) {
                $str = $res->news_date_set ? date("Y-m-d", strtotime($res->news_date_set)) : '';
                return $str;
            })
            ->addColumn('news_date_end', function ($res) {
                $str = $res->news_date_end ? date("Y-m-d", strtotime($res->news_date_end)) : '';
                return $str;
            })

            ->addColumn('action', function ($res) {
                $view = Helper::CheckPermissionMenu('News', '1');
                $insert = Helper::CheckPermissionMenu('News', '2');
                $update = Helper::CheckPermissionMenu('News', '3');
                $delete = Helper::CheckPermissionMenu('News', '4');
                if ($res->news_status == 1) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }
                $btnStatus = '<input type="checkbox" class="toggle change-status" ' . $checked . ' data-id="' . $res->news_id . '" data-style="ios" data-on="On" data-off="Off">';
                $btnView = '<button type="button" class="btn btn-success btn-md btn-view" data-id="' . $res->news_id . '">View</button>';
                $btnEdit = '<button type="button" class="btn btn-info btn-md btn-edit" data-id="' . $res->news_id . '">Edit</button>';
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
            ->rawColumns(['checkbox', 'news_category', 'news_tag', 'news_date_set', 'news_date_end', 'action'])
            ->make(true);
    }

    public function ChangeStatus(Request $request, $id)
    {
        $status = $request->input('status');
        \DB::beginTransaction();
        try {
            $input_all['news_status'] = $status;
            $input_all['updated_at'] = date('Y-m-d H:i:s');
            News::where('news_id', $id)->update($input_all);
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

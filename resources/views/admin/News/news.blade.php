@extends('layouts.layout')@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Search</h4>
                <form id="FormSearch">
                    <div class="row pt-3">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">News</label>
                                <input type="text" id="search_news_seo_title" class="form-control search_table">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Keyword</label>
                                <input type="text" id="search_news_seo_keyword" class="form-control search_table">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Description</label>
                                <input type="text" id="search_news_seo_description" class="form-control search_table">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-search"><i class="ti-search"></i> Search</button>
                <button type="button" class="btn btn-secondary clear-search btn-clear-search">Clear</button>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="material-card card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{$MainMenus->menu_system_name}}</h4>
                    @if(App\Helper::CheckPermissionMenu('News' , '2'))
                    <button type="button" class="btn btn-primary btn-rounded m-t-10 mb-2 float-right newdata btn-add">Add New</button>
                    @endif
                </div>
                <div class="table-responsive">
                    <table id="tableNews" class="table">
                        <thead>
                            <tr>
                                <!-- <th scope="col"></th> -->
                                <th scope="col">No</th>
                                <th scope="col">News Title</th>
                                <th scope="col">News Category</th>
                                <th scope="col">News Tag</th>
                                <th scope="col">News Order</th>
                                <th scope="col">News Date Set</th>
                                <th scope="col">News Date End</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection @section('modal')
<div class="modal fade" id="ModalAdd" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="mdi mdi-close"></i></span></button>
            </div>
            <form id="FormAdd" class="needs-validation" novalidate>
                <div class="card">
                    <div class="container">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            @foreach($Language as $val)
                            <li class="nav-item">
                                <a class="nav-link {{ $val->languages_type == '1' ? 'active' : ''}}" id="{{ $val->languages_name }}" data-toggle="tab" href="#{{ $val->languages_name }}-add" role="tab" aria-controls="{{ $val->languages_name }}-edit" aria-selected="true"><i class="{{ $val->languages_icon }}"></i> {{ $val->languages_name }}</a>
                            </li>
                            @endforeach
                            <li class="nav-item">
                                <a class="nav-link" id="setting-tab-edit" data-toggle="tab" href="#setting-edit" role="tab" aria-controls="setting-edit" aria-selected="false"><i class="mdi mdi-settings"></i> Setting</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            @foreach($Language as $val)
                            <div class="tab-pane fade {{ $val->languages_type == '1' ? 'show active' : ''}}" id="{{ $val->languages_name }}-add" role="tabpanel" aria-labelledby="{{ $val->languages_name }}">
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="form-horizontal form-upload">
                                            <input type="hidden" id="add_languages_id" name="lang[{{$val->languages_id}}][languages_id]" value="{{ $val->languages_id }}">
                                            <div class="form-group row pb-3">
                                                <label for="add_news_details_subject" class="col-sm-3 text-right control-label col-form-label">News Subject</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_news_details_subject" name="lang[{{$val->languages_id}}][news_details_subject]" required>
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_news_details_title" class="col-sm-3 text-right control-label col-form-label">News Title</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_news_details_title" name="lang[{{$val->languages_id}}][news_details_title]" required>
                                                </div>
                                            </div>

                                            <!-- <div class="form-group row pb-3">
                                                <label for="add_news_details_image" class="col-sm-3 text-right control-label col-form-label">News Image</label>
                                                <div class="col-sm-9">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input upload-news-img" id="{{$val->languages_id}}">
                                                        <label class="custom-file-label" for="validatedCustomFile">Choose Image...</label>
                                                    </div>
                                                    <div class="card-body">
                                                        <img id="preview_img_add{{$val->languages_id}}" style="width:30%;">
                                                    </div>
                                                </div>
                                            </div> -->
                                            <div class="form-group row pb-3">
                                                <label for="add_news_details_image" class="col-sm-3 text-right control-label col-form-label">News Image</label>
                                                <div class="col-sm-9">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input upload-news-img form-control" id="{{$val->languages_id}}">
                                                        <label class="custom-file-label" for="validatedCustomFile">Choose Image...</label>
                                                    </div>
                                                    <div class="card-body">
                                                        <img class="img-thumbnail" id="preview_img_add{{$val->languages_id}}" style="width:30%;" src="{{asset('uploads/images/no-image.jpg')}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3 image_alt">
                                                <label for="add_news_details_image_alt" class="col-sm-3 text-right control-label col-form-label">News Image Alt</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_news_details_image_alt" name="lang[{{$val->languages_id}}][news_details_image_alt]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_news_details_description" class="col-sm-3 text-right control-label col-form-label">News Description</label>
                                                <div class="col-sm-9">
                                                    <textarea class="editor" cols="60" id="add_news_details_description_{{$val->languages_id}}" rows="6" data-sample="3" data-sample-short name="lang[{{$val->languages_id}}][news_details_description]"></textarea>

                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_news_details_seo_title" class="col-sm-3 text-right control-label col-form-label">News Seo Title</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_news_details_seo_title" name="lang[{{$val->languages_id}}][news_details_seo_title]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_news_details_seo_description" class="col-sm-3 text-right control-label col-form-label">News Seo Description</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_news_details_seo_description" name="lang[{{$val->languages_id}}][news_details_seo_description]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_news_seo_keyword" class="col-sm-3 text-right control-label col-form-label">News Seo Keyword</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_news_seo_keyword" name="lang[{{$val->languages_id}}][news_details_seo_keyword]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_news_details_seo_type" class="col-sm-3 text-right control-label col-form-label">News Seo Type</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control select2" id="add_news_details_seo_type{{$val->languages_name}}" name="lang[{{$val->languages_id}}][news_details_seo_type]">
                                                        <option>Select Type</option>
                                                        @foreach($SeoTypes as $key=>$SeoType)
                                                        <option value="{{ $key }}">{{ $SeoType }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_news_details_og_title" class="col-sm-3 text-right control-label col-form-label">News Og Title</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_news_details_og_title" name="lang[{{$val->languages_id}}][news_details_og_title]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_news_details_og_description" class="col-sm-3 text-right control-label col-form-label">News Og Description</label>
                                                <div class="col-sm-9">
                                                    <textarea rows="3" type="text" class="form-control" id="add_news_details_og_description" name="lang[{{$val->languages_id}}][news_details_og_description]"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_news_details_og_url" class="col-sm-3 text-right control-label col-form-label">News Og Url</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_news_details_og_url" name="lang[{{$val->languages_id}}][news_details_og_url]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_news_details_og_site_name" class="col-sm-3 text-right control-label col-form-label">News Og Site Name</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_news_details_og_site_name" name="lang[{{$val->languages_id}}][news_details_og_site_name]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_news_details_og_image" class="col-sm-3 text-right control-label col-form-label">News Og Image</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_news_details_og_image" name="lang[{{$val->languages_id}}][news_details_og_image]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_news_details_status" class="col-sm-3 text-right control-label col-form-label">Display Status</label>
                                                <div class="col-sm-9">
                                                    <div class="form-check form-check-inline">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input" value="1" id="add_news_details_status_{{$val->languages_id}}_1" name="lang[{{$val->languages_id}}][news_details_status]" checked>
                                                            <label class="custom-control-label" for="add_news_details_status_{{$val->languages_id}}_1">Active</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input" value="0" id="add_news_details_status_{{$val->languages_id}}_2" name="lang[{{$val->languages_id}}][news_details_status]">
                                                            <label class="custom-control-label" for="add_news_details_status_{{$val->languages_id}}_2">Inactive</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <div class="tab-pane fade" id="setting-edit" role="tabpanel" aria-labelledby="setting-tab-edit">
                                <div class="card-body">
                                    <div class="form-horizontal form-upload-add">
                                        <div class="form-group row pb-3">
                                            <label for="add_news_image" class="col-sm-3 text-right control-label col-form-label">News Cover Image</label>
                                            <div class="col-sm-9">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input upload-news-img-setting" id="{{$val->languages_id}}">
                                                    <label class="custom-file-label" for="validatedCustomFile">Choose Image...</label>
                                                </div>
                                                <div class="card-body">
                                                    <img id="preview_img_cover_add" style="width:30%;" src="{{asset('uploads/images/no-image.jpg')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="add_news_image_alt" class="col-sm-3 text-right control-label col-form-label">News Cover Image Alt</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="add_news_image_alt" name="lang[{{$val->languages_id}}][news_details_image_alt]" required>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="" class="col-sm-3 text-right control-label col-form-label">News Seo Title</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="add_news_seo_title" name="news[news_seo_title]">
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="" class="col-sm-3 text-right control-label col-form-label">News Seo Keyword</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="add_news_seo_keyword" name="news[news_seo_keyword]">
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="" class="col-sm-3 text-right control-label col-form-label">News Seo Description</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="add_news_seo_description" name="news[news_seo_description]">
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="" class="col-sm-3 text-right control-label col-form-label">News Url Slug</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="add_news_url_slug" name="news[news_url_slug]" placeholder="https://">
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="add_news_category_id" class="col-sm-3 text-right control-label col-form-label">News Category</label>
                                            <div class="col-sm-9">
                                                <select class="form-control select2" id="add_news_category_id" multiple="" name="news_category_id[]">
                                                    @foreach($NewsCategory as $val)
                                                    <option value="{{ $val->news_category_id }}">{{ $val->news_category_seo_title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="add_news_tag_id" class="col-sm-3 text-right control-label col-form-label">News Tag</label>
                                            <div class="col-sm-9">
                                                <select class="form-control select2" id="add_news_tag_id" multiple="" name="news_tag_id[]" required>
                                                    @foreach($NewsTag as $val)
                                                    <option value="{{ $val->news_tag_id }}">{{ $val->news_tag_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="add_news_gallery" class="col-sm-3 text-right control-label col-form-label">News gallery</label>
                                            <div class="col-sm-9">
                                                <div class="form-group">
                                                    <div id="dZUpload" class="dropzone">
                                                        <div class="dz-default dz-message">
                                                            Drop files here or click to upload.
                                                        </div>
                                                    </div>
                                                </div>
                                                <select class="form-control select2" id="add_news_gallery_type" name="news_gallery_type">
                                                    <option value="">select image type</option>
                                                    @foreach($ImageTypes as $key=>$val)
                                                    <option value="{{ $key }}">{{ $val }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="add_news_sort_order" class="col-sm-3 text-right control-label col-form-label">News Sort Order</label>
                                            <div class="col-sm-9">
                                                <input type="number" class="form-control" id="add_news_sort_order" name="news[news_sort_order]">
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="add_news_language_lock_type" class="col-sm-3 text-right control-label col-form-label">News Language Lock</label>
                                            <div class="col-sm-9">
                                                <div class="form-check form-check-inline">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input" value="0" id="add_news_language_lock_type_1" name="news[news_language_lock_type]">
                                                        <label class="custom-control-label" for="add_news_language_lock_type_1">ล็อกภาษาตามภาษาหลัก</label>
                                                    </div>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input" value="1" id="add_news_language_lock_type_2" name="news[news_language_lock_type]">
                                                        <label class="custom-control-label" for="add_news_language_lock_type_2">ล็อกตามภาษา</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="add_news_date_set" class="col-sm-3 text-right control-label col-form-label">News Date Set</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control" id="add_news_date_set" name="news[news_date_set]" required>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="add_news_date_end" class="col-sm-3 text-right control-label col-form-label">News Date End</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control" id="add_news_date_end" name="news[news_date_end]" required>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="Check-Box" class="col-sm-3 text-right control-label col-form-label">Status</label>
                                            <div class="col-sm-9">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="add_news_status" name="news[news_status]" value="1">
                                                    <label class="custom-control-label" for="add_news_status">Action</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-footer">
                        <button type="submit" class="btn btn-success"><i class="ti-save"></i> Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalEdit" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="mdi mdi-close"></i></span></button>
            </div>
            <form id="FormEdit" class="needs-validation" novalidate>
                <input type="hidden" id="edit_id">
                <div class="card">
                    <div class="container">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            @foreach($Language as $val)
                            <li class="nav-item">
                                <a class="nav-link {{ $val->languages_type == '1' ? 'active' : ''}}" id="{{ $val->languages_name }}" data-toggle="tab" href="#{{ $val->languages_name }}-edit" role="tab" aria-controls="{{ $val->languages_name }}" aria-selected="true"><i class="{{ $val->languages_icon }}"></i> {{ $val->languages_name }}</a>
                            </li>
                            @endforeach
                            <li class="nav-item">
                                <a class="nav-link" id="setting-tab" data-toggle="tab" href="#setting" role="tab" aria-controls="setting" aria-selected="false"><i class="mdi mdi-settings"></i> Setting</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            @foreach($Language as $val)
                            <div class="tab-pane fade {{ $val->languages_type == '1' ? 'show active' : ''}}" id="{{ $val->languages_name }}-edit" role="tabpanel" aria-labelledby="{{ $val->languages_name }}">
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="form-horizontal form-upload">
                                            <input type="hidden" id="add_languages_id" name="lang[{{$val->languages_id}}][languages_id]" value="{{ $val->languages_id }}">
                                            <div class="form-group row pb-3">
                                                <label for="edit_news_details_subject" class="col-sm-3 text-right control-label col-form-label">News Subject</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="edit_news_details_subject_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][news_details_subject]" required>
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="edit_news_details_title" class="col-sm-3 text-right control-label col-form-label">News Title</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="edit_news_details_title_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][news_details_title]" required>
                                                </div>
                                            </div>
                                            <!-- <div class="form-group row pb-3 ">
                                                <label for="edit_news_details_image" class="col-sm-3 text-right control-label col-form-label">News Image</label>
                                                <div class="col-sm-9">
                                                    <input type="file" class="form-control upload-news-img" id="{{$val->languages_id}}">
                                                    <div class="card-body">
                                                        <img class="img-thumbnail" id="preview_img_{{$val->languages_id}}" style="width:70%;">
                                                    </div>
                                                    <input type="hidden" id="edit_old_news_details_image_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][news_details_image]" value="">
                                                </div>
                                            </div> -->
                                            <div class="form-group row pb-3">
                                                <label for="edit_news_details_image" class="col-sm-3 text-right control-label col-form-label">News Image</label>
                                                <div class="col-sm-9">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input upload-news-img form-control" id="{{$val->languages_id}}">
                                                        <label class="custom-file-label" for="validatedCustomFile">Choose Image...</label>
                                                    </div>
                                                    <div class="card-body">
                                                        <img class="img-thumbnail" id="preview_img_{{$val->languages_id}}" style="width:30%;" src="{{asset('uploads/images/no-image.jpg')}}">
                                                    </div>
                                                    <!-- <input type="hidden" id="edit_old_news_details_image_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][news_details_image]" value=""> -->
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="edit_news_details_image_alt" class="col-sm-3 text-right control-label col-form-label">News Image Alt</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="edit_news_details_image_alt_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][news_details_image_alt]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="edit_news_details_description" class="col-sm-3 text-right control-label col-form-label">News Description</label>
                                                <div class="col-sm-9">
                                                    <textarea class="editor-edit" cols="60" id="edit_news_details_description_{{$val->languages_id}}" rows="6" data-sample="3" data-sample-short name="lang[{{$val->languages_id}}][news_details_description]"></textarea>

                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="edit_news_details_seo_title" class="col-sm-3 text-right control-label col-form-label">News Seo Title</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="edit_news_details_seo_title_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][news_details_seo_title]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="edit_news_details_seo_description" class="col-sm-3 text-right control-label col-form-label">News Seo Description</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="edit_news_details_seo_description_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][news_details_seo_description]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="edit_news_details_seo_keyword" class="col-sm-3 text-right control-label col-form-label">News Seo Keyword</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="edit_news_details_seo_keyword_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][news_details_seo_keyword]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="edit_news_details_seo_type" class="col-sm-3 text-right control-label col-form-label">News Seo Type</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control select2" id="edit_news_details_seo_type_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][news_details_seo_type]">
                                                        <option value="99">Select Type</option>
                                                        @foreach($SeoTypes as $key=>$SeoType)
                                                        <option value="{{ $key }}">{{ $SeoType }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="edit_news_details_og_title" class="col-sm-3 text-right control-label col-form-label">News Og Title</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="edit_news_details_og_title_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][news_details_og_title]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="edit_news_details_og_description" class="col-sm-3 text-right control-label col-form-label">News Og Description</label>
                                                <div class="col-sm-9">
                                                    <textarea rows="3" type="text" class="form-control" id="edit_news_details_og_description_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][news_details_og_description]"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="edit_news_details_og_url" class="col-sm-3 text-right control-label col-form-label">News Og Url</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="edit_news_details_og_url_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][news_details_og_url]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="edit_news_details_og_site_name" class="col-sm-3 text-right control-label col-form-label">News Og Site Name</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="edit_news_details_og_site_name_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][news_details_og_site_name]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="edit_news_details_og_image" class="col-sm-3 text-right control-label col-form-label">News Og Image</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="edit_news_details_og_image_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][news_details_og_image]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="edit_news_details_status" class="col-sm-3 text-right control-label col-form-label">Display Status</label>
                                                <div class="col-sm-9">
                                                    <div class="form-check form-check-inline">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input" value="1" id="edit_news_details_status_{{$val->languages_id}}_1" name="lang[{{$val->languages_id}}][news_details_status]">
                                                            <label class="custom-control-label" for="edit_news_details_status_{{$val->languages_id}}_1">Active</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input" value="0" id="edit_news_details_status_{{$val->languages_id}}_2" name="lang[{{$val->languages_id}}][news_details_status]">
                                                            <label class="custom-control-label" for="edit_news_details_status_{{$val->languages_id}}_2">Inactive</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <div class="tab-pane fade" id="setting" role="tabpanel" aria-labelledby="setting-tab">
                                <div class="card-body">
                                    <div class="form-horizontal form-upload-add">
                                        <div class="form-group row pb-3">
                                            <label for="edit_news_image" class="col-sm-3 text-right control-label col-form-label">News Cover Image</label>
                                            <div class="col-sm-9">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input upload-news-img-setting form-control" id="{{$val->languages_id}}">
                                                    <label class="custom-file-label" for="validatedCustomFile">Choose Image...</label>
                                                </div>
                                                <div class="card-body">
                                                    <img class="img-thumbnail" id="preview_img_cover_edit" style="width:70%;">
                                                </div>
                                                <!-- <input type="hidden" id="edit_old_news_cover_image" name="news[news_image]" value=""> -->
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="edit_news_image_alt" class="col-sm-3 text-right control-label col-form-label">News Cover Image Alt</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="edit_news_image_alt" name="news[news_image_alt]">
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="" class="col-sm-3 text-right control-label col-form-label">News Seo Title</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="edit_news_seo_title" name="news[news_seo_title]">
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="" class="col-sm-3 text-right control-label col-form-label">News Seo Keyword</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="edit_news_seo_keyword" name="news[news_seo_keyword]">
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="" class="col-sm-3 text-right control-label col-form-label">News Seo Description</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="edit_news_seo_description" name="news[news_seo_description]">
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="" class="col-sm-3 text-right control-label col-form-label">News Url Slug</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="edit_news_url_slug" name="news[news_url_slug]">
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="edit_news_category_id" class="col-sm-3 text-right control-label col-form-label">News Category</label>
                                            <div class="col-sm-9">
                                                <select class="form-control select2" id="edit_news_category_id" multiple="" name="news_category_id[]" required>
                                                    @foreach($NewsCategory as $val)
                                                    <option value="{{ $val->news_category_id }}">{{ $val->news_category_seo_title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="edit_news_tag_id" class="col-sm-3 text-right control-label col-form-label">News Tag</label>
                                            <div class="col-sm-9">
                                                <select class="form-control select2" id="edit_news_tag_id" multiple="" name="news_tag_id[]" required>
                                                    @foreach($NewsTag as $val)
                                                    <option value="{{ $val->news_tag_id }}">{{ $val->news_tag_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="edit_news_gallery" class="col-sm-3 text-right control-label col-form-label">News gallery</label>
                                            <div class="col-sm-9">
                                                <div class="form-group">
                                                    <div id="dZUploadEdit" class="dropzone">
                                                        <div class="dz-default dz-message">
                                                            Drop files here or click to upload.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" id="show_image">
                                                </div>

                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="edit_news_sort_order" class="col-sm-3 text-right control-label col-form-label">News Sort Order</label>
                                            <div class="col-sm-9">
                                                <input type="number" class="form-control" id="edit_news_sort_order" name="news[news_sort_order]">
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="edit_news_language_lock_type" class="col-sm-3 text-right control-label col-form-label">News Language Lock</label>
                                            <div class="col-sm-9">
                                                <div class="form-check form-check-inline">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input" value="0" id="edit_news_language_lock_type_1" name="news[news_language_lock_type]">
                                                        <label class="custom-control-label" for="edit_news_language_lock_type_1">ล็อกภาษาตามภาษาหลัก</label>
                                                    </div>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input" value="1" id="edit_news_language_lock_type_2" name="news[news_language_lock_type]">
                                                        <label class="custom-control-label" for="edit_news_language_lock_type_2">ล็อกตามภาษา</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="edit_news_date_set" class="col-sm-3 text-right control-label col-form-label">News Date Set</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control" id="edit_news_date_set" name="news[news_date_set]" required>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="edit_news_date_end" class="col-sm-3 text-right control-label col-form-label">News Date End</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control" id="edit_news_date_end" name="news[news_date_end]" required>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="Check-Box" class="col-sm-3 text-right control-label col-form-label">Status</label>
                                            <div class="col-sm-9">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="edit_news_status" name="news[news_status]" value="1">
                                                    <label class="custom-control-label" for="edit_news_status">Action</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-footer">
                        <button type="submit" class="btn btn-success"><i class="ti-save"></i> Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>
<div class="modal fade" id="ModalView" role="dialog" aria-labelledby="myModalLabelview">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">View</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="mdi mdi-close"></i></span></button>
            </div>
            <div class="card">
                <div class="container">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        @foreach($Language as $val)
                        <li class="nav-item">
                            <a class="nav-link {{ $val->languages_type == '1' ? 'active' : ''}}" id="{{ $val->languages_name }}" data-toggle="tab" href="#{{ $val->languages_name }}-view" role="tab" aria-controls="{{ $val->languages_name }}" aria-selected="true"><i class="{{ $val->languages_icon }}"></i> {{ $val->languages_name }}</a>
                        </li>
                        @endforeach
                    </ul>
                    <div class="tab-content" id="myTabContentView">
                        @foreach($Language as $val)
                        <div class="tab-pane fade {{ $val->languages_type == '1' ? 'show active' : ''}}" id="{{ $val->languages_name }}-view" role="tabpanel" aria-labelledby="{{ $val->languages_name }}">
                            <div class="form-body form-news-image">
                                <div class="card-body">
                                    <div class="row pb-3">
                                        <h3 class="col-sm-2 control-label col-form-label card-title">News Subject: </h3>
                                        <div class="col-sm-9">
                                            <div class="custom-control custom-checkbox">
                                                <h2 id="show_news_details_subject_{{ $val->languages_id }}"></h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row pb-3">
                                        <h3 class="col-sm-2 control-label col-form-label card-title">News Title: </h3>
                                        <div class="col-sm-9">
                                            <div class="custom-control custom-checkbox">
                                                <h2 id="show_news_details_title_{{ $val->languages_id }}"></h2>
                                            </div>
                                        </div>
                                    </div>
                                    <img class="form-horizontal pb-3" id="show_news_image_{{ $val->languages_id }}" style="width:100%;">
                                    <div class="form-horizontal pb-3">
                                        <label for="example-text-input" id="show_news_details_description_{{ $val->languages_id }}" class="col-form-label"></label>
                                    </div>
                                    <div class="row">
                                        <h3 class="col-sm-3 control-label col-form-label card-title">News Seo Title: </h3>
                                        <div class="col-sm-9">
                                            <div class="custom-control custom-checkbox">
                                                <label id="show_news_details_seo_title_{{ $val->languages_id }}"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <h3 class="col-sm-3 control-label col-form-label card-title">News Seo Description: </h3>
                                        <div class="col-sm-9">
                                            <div class="custom-control custom-checkbox">
                                                <label id="show_news_details_seo_description_{{ $val->languages_id }}"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <h3 class="col-sm-3 control-label col-form-label card-title">News Seo Keyword: </h3>
                                        <div class="col-sm-9">
                                            <div class="custom-control custom-checkbox">
                                                <label id="show_news_details_seo_keyword_{{ $val->languages_id }}"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <h3 class="col-sm-3 control-label col-form-label card-title">Display Status: </h3>
                                        <div class="col-sm-9">
                                            <div class="custom-control custom-checkbox">
                                                <label id="show_news_details_status_{{ $val->languages_id }}"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $('.image_alt').hide();
    $('#preview_img_cover').hide();
    Dropzone.autoDiscover = false;
    $(document).ready(function() {
        var tableNews = $('#tableNews').dataTable({
            "ajax": {
                "url": url_gb + "/admin/News/Lists",
                "type": "POST",
                "data": function(d) {
                    d.news_seo_title = $('#search_news_seo_title').val();
                    d.news_seo_keyword = $('#search_news_seo_keyword').val();
                    d.news_seo_description = $('#search_news_seo_description').val();
                    // etc
                }
            },
            "drawCallback": function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
                $(".change-status").bootstrapToggle();
            },
            "retrieve": true,
            "columns": [
                // {"data" : "checkbox" , "class":"text-center" , "searchable": false, "sortable": false,},
                {
                    "data": "DT_RowIndex",
                    "class": "text-center",
                    "searchable": false,
                    "sortable": false,
                },
                {
                    "data": "news_seo_title",
                    "class": "text-center"
                },
                {
                    "data": "news_category",
                    "class": "text-center"
                },
                {
                    "data": "news_tag",
                    "class": "text-center"
                },
                {
                    "data": "news_sort_order",
                    "class": "text-center"
                },
                {
                    "data": "news_date_set",
                    "class": "text-center"
                },
                {
                    "data": "news_date_end",
                    "class": "text-center"
                },

                {
                    "data": "action",
                    "name": "action",
                    "searchable": false,
                    "sortable": false,
                    "class": "text-center"
                },

            ],
            "select": true,
            "dom": 'Bfrtip',
            "lengthMenu": [
                [10, 25, 50, -1],
                ['10 rows', '25 rows', '50 rows', 'Show all']
            ],
            "columnDefs": [{
                className: 'noVis',
                visible: false
            }],
            "buttons": [
                'pageLength',
                'colvis',
                {
                    extend: 'copy',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: ':visible'
                    }
                }
            ],
            processing: true,
            serverSide: true,
        });

        $('body').on('click', '.btn-search', function() {
            tableNews.api().ajax.reload();
        });

        $('body').on('click', '.btn-clear-search', function() {
            $('#search_news_seo_title').val('');
            $('#search_news_seo_description').val('');
            $('#search_news_seo_keyword').val('');
            tableNews.api().ajax.reload();
        });

        $('body').on('click', '.btn-add', function(data) {
            $('#add_news_status').prop('checked', true);
            $('#ModalAdd').modal('show');
        });

        $('body').on('click', '.btn-edit', function(data) {
            var id = $(this).data('id');
            var btn = $(this);
            $('#edit_id').val(id);
            $('#show_image').empty();
            loadingButton(btn);
            $.ajax({
                method: "GET",
                url: url_gb + "/admin/News/" + id,
                data: {
                    id: id
                }
            }).done(function(res) {
                resetButton(btn);
                var data = res.content;
                var news_category_selected_array = [];
                var news_tag_selected_array = [];

                $.each(data.news_has_news_category, function(k, v) {
                    news_category_selected_array[k] = v.news_category_id;
                    $("#edit_news_category_id").val(news_category_selected_array);
                    $("#edit_news_category_id").trigger('change');
                });

                $.each(data.news_has_news_tag, function(k, v) {
                    news_tag_selected_array[k] = v.news_tag_id;
                    $("#edit_news_tag_id").val(news_tag_selected_array);
                    $("#edit_news_tag_id").trigger('change');
                });

                $.each(data.news_detail, function(k, v) {
                    url = data.NewsPath + '/' + v.news_details_image;
                    $('#edit_news_details_subject_' + v.languages_id).val(v.news_details_subject);
                    $('#edit_news_details_title_' + v.languages_id).val(v.news_details_title);
                    $('#preview_img_' + v.languages_id).attr('src', url);
                    $('#edit_news_details_image_alt_' + v.languages_id).val(v.news_details_image_alt);
                    // $('#edit_old_news_details_image_' + v.languages_id).val(v.news_details_image);
                    $('#edit_news_details_description_' + v.languages_id).val(v.news_details_description);
                    $('#edit_news_details_seo_title_' + v.languages_id).val(v.news_details_seo_title);
                    $('#edit_news_details_seo_description_' + v.languages_id).val(v.news_details_seo_description);
                    $('#edit_news_details_seo_keyword_' + v.languages_id).val(v.news_details_seo_keyword);
                    $('#edit_news_details_og_title_' + v.languages_id).val(v.news_details_og_title);
                    $('#edit_news_details_og_description_' + v.languages_id).val(v.news_details_og_description);
                    $('#edit_news_details_og_url_' + v.languages_id).val(v.news_details_og_url);
                    $('#edit_news_details_og_site_name_' + v.languages_id).val(v.news_details_og_site_name);
                    $('#edit_news_details_og_image_' + v.languages_id).val(v.news_details_og_image);
                    $('#edit_news_details_seo_type_' + v.languages_id).val(v.news_details_seo_type).change();
                    if (v.news_details_status == "1") {
                        $('#edit_news_details_status_' + v.languages_id + '_1').prop('checked', true);
                    } else if (v.news_details_status == "0") {
                        $('#edit_news_details_status_' + v.languages_id + '_2').prop('checked', true);
                    }
                    // new FroalaEditor('.editor-edit', {
                    //     key: "UBB7jD6C5E3A2J3B7aIVLEABVAYFKc1Ce1MYGD1c1NYVMiB3B9B6A5C2C4F4H3G3J3==",
                    //     // Set the image upload parameter.
                    //     height: 300
                    // });

                });
                url_cover = data.NewsCoverPath + '/' + data.news_image;
                $('#preview_img_cover_edit').attr('src', url_cover);
                $('#edit_old_news_cover_image').val(data.news_image);
                $("#edit_news_image_alt").val(data.news_image_alt);
                $("#edit_news_seo_title").val(data.news_seo_title);
                $("#edit_news_seo_keyword").val(data.news_seo_keyword);
                $("#edit_news_seo_description").val(data.news_seo_description);
                $("#edit_news_url_slug").val(data.news_url_slug);
                $("#edit_news_sort_order").val(data.news_sort_order);
                $("#edit_news_date_set").val(data.format_news_date_set);
                $("#edit_news_date_end").val(data.format_news_date_end);
                if (data.news_language_lock_type == "0") {
                    $('#edit_news_language_lock_type_1').prop('checked', true);
                } else if (data.news_language_lock_type == "1") {
                    $('#edit_news_language_lock_type_2').prop('checked', true);
                }
                if (data.news_status == 1) {
                    $('#edit_news_status').prop('checked', true);
                } else {
                    $('#edit_news_status').prop('checked', false);
                }
                $.each(data.news_gallery, function(k, v) {
                    url = data.url_path + '/' + v.news_gallery_image_gall;
                    val_image = '<div id="img_' + v.news_gallery_id + '" class="col-md-2" style="margin-bottom:16px;" align="center">';
                    val_image += "<img src='" + url + "' class='img-thumbnail' width='175' height='100'>";
                    val_image += "<button type='button' class='btn btn-link remove_image' id='" + v.news_gallery_id + "' data-id='" + v.news_gallery_image_gall + "'><i class='fas fa-trash-alt'></i> Remove</button>";
                    val_image += '</div>';

                    $('#show_image').append(val_image);
                })
                $('#ModalEdit').modal('show');
            }).fail(function(res) {
                resetButton(form.find('button[type=submit]'));
                swal("โอ๊ะโอ! เกิดข้อผิดพลาด", res.content, 'error');
            });
        });

        $('body').on('click', '.btn-view', function(data) {
            var id = $(this).data('id');
            var btn = $(this);
            loadingButton(btn);
            $.ajax({
                method: "GET",
                url: url_gb + "/admin/News/" + id,
                data: {
                    id: id
                }
            }).done(function(res) {
                resetButton(btn);
                var data = res.content;
                var status = '';
                // var news_category_seo_title = [];
                // var news_tag_name = [];
                // if (data.news_status == 1) {
                //     status = "Active";
                // } else {
                //     status = "No Active";
                // }
                $.each(data.news_detail, function(k, v) {
                    url = data.NewsPath + '/' + v.news_details_image;
                    $('#show_news_details_description_' + v.languages_id).html(v.news_details_description);
                    $('#show_news_details_subject_' + v.languages_id).text(v.news_details_subject);
                    $('#show_news_details_title_' + v.languages_id).text(v.news_details_title);
                    $('#show_news_details_seo_title_' + v.languages_id).text(v.news_details_seo_title);
                    $('#show_news_details_seo_keyword_' + v.languages_id).text(v.news_details_seo_keyword);
                    $('#show_news_details_seo_description_' + v.languages_id).text(v.news_details_seo_description);
                    $('#show_news_image_' + v.languages_id).attr('src', url);
                    if (v.news_details_status == 1) {
                        details_status = '<h3 class="card-title text-success">Active</h3>';
                    } else {
                        details_status = '<h3 class="card-title text-danger">Inctive</h3>';
                    }
                    $('#show_news_details_status_' + v.languages_id).html(details_status);
                });
                $('#ModalView').modal('show');
            }).fail(function(res) {
                resetButton(form.find('button[type=submit]'));
                swal("โอ๊ะโอ! เกิดข้อผิดพลาด", res.content, 'error');
            });
        });

        $('body').on('change', '.change-status', function(data) {
            var id = $(this).data('id');
            var status = $(this).is(':checked');
            $.ajax({
                method: "POST",
                url: url_gb + "/admin/News/ChangeStatus/" + id,
                data: {
                    id: id,
                    status: status ? 1 : 0,
                }
            }).done(function(res) {
                if (res.status == 1) {
                    // swal(res.title, res.content, 'success');
                    // tableNews.api().ajax.reload();
                } else {
                    swal(res.title, res.content, 'error');
                }
            }).fail(function(res) {
                swal("โอ๊ะโอ! เกิดข้อผิดพลาด", res.content, 'error');
            });
        });

        $('body').on('submit', '#FormAdd', function(e) {
            e.preventDefault();
            var form = $(this);
            loadingButton(form.find('button[type=submit]'));
            $.ajax({
                method: "POST",
                url: url_gb + "/admin/News",
                data: form.serialize()
            }).done(function(res) {
                resetButton(form.find('button[type=submit]'));
                if (res.status == 1) {
                    swal(res.title, res.content, 'success');
                    form[0].reset();
                    swal(res.title, "Update", "success")
                        .then((value) => {
                            location.reload();
                            // tableNews.api().ajax.reload();
                        });
                    $('#ModalAdd').modal('hide');
                } else {
                    swal(res.title, res.content, 'error');
                }
            }).fail(function(res) {
                resetButton(form.find('button[type=submit]'));
                swal("โอ๊ะโอ! เกิดข้อผิดพลาด", res.content, 'error');
            });
        });

        $('body').on('submit', '#FormEdit', function(e) {
            e.preventDefault();
            var form = $(this);
            var id = $('#edit_id').val();
            loadingButton(form.find('button[type=submit]'));
            $.ajax({
                method: "PUT",
                url: url_gb + "/admin/News/" + id,
                data: form.serialize()
            }).done(function(res) {
                resetButton(form.find('button[type=submit]'));
                if (res.status == 1) {
                    form[0].reset();
                    swal(res.title, "Update", "success")
                        .then((value) => {
                            location.reload();
                            // tableNews.api().ajax.reload();
                        });
                    $('#ModalEdit').modal('hide');
                } else {
                    swal(res.title, res.content, 'error');
                }
            }).fail(function(res) {
                resetButton(form.find('button[type=submit]'));
                swal("โอ๊ะโอ! เกิดข้อผิดพลาด", res.content, 'error');
            });
        });

        $("#dZUpload").dropzone({
            url: url_gb + "/admin/UploadFile/NewsGalleryTemp",
            addRemoveLinks: true,
            removedfile: function(file) {
                var name = file.name;
                $.ajax({
                    type: 'POST',
                    url: url_gb + "/admin/UploadFile/DeleteUploadFile/NewsGalleryTemp",
                    data: "file_name=" + name,
                    dataType: 'html'
                });
                var _ref;
                return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
            },
            sending: function(file, xhr, formData) {
                formData.append("_token", "{{ csrf_token() }}");
            },
        });

        $("#dZUploadEdit").dropzone({
            url: url_gb + "/admin/UploadFile/NewsGalleryTemp",
            addRemoveLinks: true,
            removedfile: function(file) {
                var name = file.name;
                $.ajax({
                    type: 'POST',
                    url: url_gb + "/admin/UploadFile/DeleteUploadFile/NewsGalleryTemp",
                    data: "file_name=" + name,
                    dataType: 'html'
                });
                var _ref;
                return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
            },
            sending: function(file, xhr, formData) {
                formData.append("_token", "{{ csrf_token() }}");
            },
        });

        $(document).on('click', '.remove_image', function() {
            var id = $(this).attr('id');
            var name = $(this).attr('data-id');
            $.ajax({
                type: 'POST',
                url: url_gb + "/admin/UploadFile/DeleteUploadFileEdit/NewsGallery",
                data: "file_name=" + id + '/' + name,
                success: function(data) {
                    $('#img_' + id).remove();
                }
            })
        });
        $('body').on('change', '.upload-news-img', function() {
            var ele = $(this);
            var index = ele.data('index');
            var formData = new FormData();
            var id = $(this).attr('id');
            $('#preview_img_add' + id).attr('src', URL.createObjectURL(event.target.files[0]));
            $('#edit_old_news_details_image_' + id).remove('');
            formData.append('file', ele[0].files[0]);
            $.ajax({
                url: url_gb + '/admin/UploadImage/NewsImageTemp',
                type: 'POST',
                data: formData,
                processData: false, // tell jQuery not to process the data
                contentType: false, // tell jQuery not to set contentType
                success: function(res) {
                    $('.image_alt').show();
                    ele.closest('.form-upload').find('.upload-news-img').append('<input type="hidden" id="edit_news_details_image_' + id + '" name="lang[' + id + '][news_details_image]" value="' + res.path + '">');
                    setTimeout(function() {

                    }, 100);
                }
            });
        });
        $('body').on('change', '.upload-news-img-setting', function() {
            var ele = $(this);
            var index = ele.data('index');
            var formData = new FormData();
            var id = $(this).attr('id');
            $('#preview_img_cover_add').attr('src', URL.createObjectURL(event.target.files[0]));
            $('#preview_img_cover_edit').attr('src', URL.createObjectURL(event.target.files[0]));
            // $('#edit_old_news_cover_image').remove();
            formData.append('file', ele[0].files[0]);
            $.ajax({
                url: url_gb + '/admin/UploadImage/NewsCoverTemp',
                type: 'POST',
                data: formData,
                processData: false, // tell jQuery not to process the data
                contentType: false, // tell jQuery not to set contentType
                success: function(res) {
                    ele.closest('.form-upload-add').find('.upload-news-img-setting').append('<input type="hidden" id="add_news_details_image_' + id + '" name="news[news_image]" value="' + res.path + '">');
                    setTimeout(function() {

                    }, 100);
                }
            });
        });
    });
</script>
@endsection
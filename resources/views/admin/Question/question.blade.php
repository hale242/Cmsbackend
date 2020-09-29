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
                                <label class="control-label">Question</label>
                                <input type="text" id="search_ques_seo_title" class="form-control search_table">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Keyword</label>
                                <input type="text" id="search_ques_seo_keyword" class="form-control search_table">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Description</label>
                                <input type="text" id="search_ques_seo_description" class="form-control search_table">
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
                    @if(App\Helper::CheckPermissionMenu('Question' , '2'))
                    <button type="button" class="btn btn-primary btn-rounded m-t-10 mb-2 float-right newdata btn-add">Add New</button>
                    @endif
                </div>
                <div class="table-responsive">
                    <table id="tableQuestion" class="table">
                        <thead>
                            <tr>
                                <!-- <th scope="col"></th> -->
                                <th scope="col">No</th>
                                <th scope="col">Question Title</th>
                                <th scope="col">Question Category</th>
                                <th scope="col">Question Order</th>
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
                                                <label for="add_ques_lang_question" class="col-sm-3 text-right control-label col-form-label">Question Title</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_ques_lang_question" name="lang[{{$val->languages_id}}][ques_lang_question]" required>
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_ques_lang_details" class="col-sm-3 text-right control-label col-form-label">Question Details</label>
                                                <div class="col-sm-9">
                                                    <textarea type="text" class="form-control" id="add_ques_lang_details" name="ques_category[ques_lang_details]"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_ques_lang_image" class="col-sm-3 text-right control-label col-form-label">Question Image</label>
                                                <div class="col-sm-9">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input upload-question-file" id="{{$val->languages_id}}">
                                                        <label class="custom-file-label" for="validatedCustomFile">Choose Image...</label>
                                                    </div>
                                                    <div class="card-body">
                                                        <img class="img-thumbnail" id="add_preview_img_{{$val->languages_id}}" style="width:40%;" src="{{asset('uploads/images/no-image.jpg')}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3 image_alt">
                                                <label for="add_ques_lang_image_alt" class="col-sm-3 text-right control-label col-form-label">Question Image Alt</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_ques_lang_image_alt" name="lang[{{$val->languages_id}}][ques_lang_image_alt]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_ques_lang_seo_title" class="col-sm-3 text-right control-label col-form-label">Question Seo Title</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_ques_lang_seo_title" name="lang[{{$val->languages_id}}][ques_lang_seo_title]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_ques_lang_seo_description" class="col-sm-3 text-right control-label col-form-label">Question Seo Description</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_ques_lang_seo_description" name="lang[{{$val->languages_id}}][ques_lang_seo_description]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_ques_seo_keyword" class="col-sm-3 text-right control-label col-form-label">Question Seo Keyword</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_ques_seo_keyword" name="lang[{{$val->languages_id}}][ques_lang_seo_keyword]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_ques_lang_url_slug" class="col-sm-3 text-right control-label col-form-label">Question Url Slug</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_ques_lang_url_slug_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][ques_lang_url_slug]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_ques_lang_sort_order" class="col-sm-3 text-right control-label col-form-label">Question Sort Order</label>
                                                <div class="col-sm-9">
                                                    <input type="number" class="form-control" id="add_ques_lang_sort_order_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][ques_lang_sort_order]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_ques_lang_status" class="col-sm-3 text-right control-label col-form-label">Display Status</label>
                                                <div class="col-sm-9">
                                                    <div class="form-check form-check-inline">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input" value="1" id="add_ques_lang_status_{{$val->languages_id}}_1" name="lang[{{$val->languages_id}}][ques_lang_status]" checked>
                                                            <label class="custom-control-label" for="add_ques_lang_status_{{$val->languages_id}}_1">Active</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input" value="0" id="add_ques_lang_status_{{$val->languages_id}}_2" name="lang[{{$val->languages_id}}][ques_lang_status]">
                                                            <label class="custom-control-label" for="add_ques_lang_status_{{$val->languages_id}}_2">Inactive</label>
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
                                    <div class="form-horizontal form-upload-imgCover">
                                        <div class="form-group row pb-3">
                                            <label for="" class="col-sm-3 text-right control-label col-form-label">Question Seo Title</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="add_ques_seo_title" name="question[ques_seo_title]">
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="add_ques_category_id" class="col-sm-3 text-right control-label col-form-label">Question Category</label>
                                            <div class="col-sm-9">
                                                <select class="form-control select2" id="add_ques_category_id" multiple="" name="ques_category_id[]">
                                                    @foreach($QuestionCategory as $val)
                                                    <option value="{{ $val->ques_category_id }}">{{ $val->ques_category_seo_title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="add_ques_sort_order" class="col-sm-3 text-right control-label col-form-label">Question Sort Order</label>
                                            <div class="col-sm-9">
                                                <input type="number" class="form-control" id="add_ques_sort_order" name="question[ques_sort_order]">
                                            </div>
                                        </div>

                                        <div class="form-group row pb-3">
                                            <label for="Check-Box" class="col-sm-3 text-right control-label col-form-label">Status</label>
                                            <div class="col-sm-9">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="add_ques_status" name="question[ques_status]" value="1">
                                                    <label class="custom-control-label" for="add_ques_status">Action</label>
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
                                                <label for="edit_ques_lang_question" class="col-sm-3 text-right control-label col-form-label">Question Title</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="edit_ques_lang_question_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][ques_lang_question]" required>
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="edit_ques_lang_details" class="col-sm-3 text-right control-label col-form-label">Question Details</label>
                                                <div class="col-sm-9">
                                                    <textarea type="text" class="form-control" id="edit_ques_lang_details_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][ques_lang_details]"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3 ">
                                                <label for="edit_ques_lang_image" class="col-sm-3 text-right control-label col-form-label">Question Image</label>
                                                <div class="col-sm-9">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input upload-question-file" id="{{$val->languages_id}}">
                                                        <label class="custom-file-label" for="validatedCustomFile">Choose Image...</label>
                                                    </div>
                                                    <div class="card-body">
                                                        <img class="img-thumbnail" id="preview_img_{{$val->languages_id}}" style="width:70%;">
                                                    </div>
                                                    <!-- <input type="hidden" id="edit_old_ques_lang_image_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][ques_lang_image]" value=""> -->
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="edit_ques_lang_image_alt" class="col-sm-3 text-right control-label col-form-label">Question Image Alt</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="edit_ques_lang_image_alt_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][ques_lang_image_alt]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="edit_ques_lang_seo_title" class="col-sm-3 text-right control-label col-form-label">Question Seo Title</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="edit_ques_lang_seo_title_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][ques_lang_seo_title]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="edit_ques_lang_seo_description" class="col-sm-3 text-right control-label col-form-label">Question Seo Description</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="edit_ques_lang_seo_description_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][ques_lang_seo_description]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="edit_ques_lang_seo_keyword" class="col-sm-3 text-right control-label col-form-label">Question Seo Keyword</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="edit_ques_lang_seo_keyword_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][ques_lang_seo_keyword]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="edit_ques_lang_url_slug" class="col-sm-3 text-right control-label col-form-label">Question Url Slug</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="edit_ques_lang_url_slug_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][ques_lang_url_slug]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="edit_ques_lang_sort_order" class="col-sm-3 text-right control-label col-form-label">Question Sort Order</label>
                                                <div class="col-sm-9">
                                                    <input type="number" class="form-control" id="edit_ques_lang_sort_order_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][ques_lang_sort_order]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="edit_ques_lang_status" class="col-sm-3 text-right control-label col-form-label">Display Status</label>
                                                <div class="col-sm-9">
                                                    <div class="form-check form-check-inline">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input" value="1" id="edit_ques_lang_status_{{$val->languages_id}}_1" name="lang[{{$val->languages_id}}][ques_lang_status]">
                                                            <label class="custom-control-label" for="edit_ques_lang_status_{{$val->languages_id}}_1">Active</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input" value="0" id="edit_ques_lang_status_{{$val->languages_id}}_2" name="lang[{{$val->languages_id}}][ques_lang_status]">
                                                            <label class="custom-control-label" for="edit_ques_lang_status_{{$val->languages_id}}_2">Inactive</label>
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
                                    <div class="form-horizontal form-upload-imgCover">
                                        <div class="form-group row pb-3">
                                            <label for="" class="col-sm-3 text-right control-label col-form-label">Question Seo Title</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="edit_ques_seo_title" name="question[ques_seo_title]">
                                            </div>
                                        </div>

                                        <div class="form-group row pb-3">
                                            <label for="edit_ques_category_id" class="col-sm-3 text-right control-label col-form-label">Question Category</label>
                                            <div class="col-sm-9">
                                                <select class="form-control select2" id="edit_ques_category_id" multiple="" name="ques_category_id[]" required>
                                                    @foreach($QuestionCategory as $val)
                                                    <option value="{{ $val->ques_category_id }}">{{ $val->ques_category_seo_title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="edit_ques_sort_order" class="col-sm-3 text-right control-label col-form-label">Question Sort Order</label>
                                            <div class="col-sm-9">
                                                <input type="number" class="form-control" id="edit_ques_sort_order" name="question[ques_sort_order]">
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="Check-Box" class="col-sm-3 text-right control-label col-form-label">Status</label>
                                            <div class="col-sm-9">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="edit_ques_status" name="question[ques_status]" value="1">
                                                    <label class="custom-control-label" for="edit_ques_status">Action</label>
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
                            <div class="form-body form-event-image">
                                <div class="card-body">

                                    <div class="row pb-3">
                                        <h3 class="col-sm-2 control-label col-form-label card-title">Question Title: </h3>
                                        <div class="col-sm-9">
                                            <div class="custom-control custom-checkbox">
                                                <h2 id="show_ques_lang_question_{{ $val->languages_id }}"></h2>
                                            </div>
                                        </div>
                                    </div>
                                    <img class="form-horizontal pb-3" id="show_ques_lang_image_{{ $val->languages_id }}" style="width:100%;">
                                    <div class="row">
                                        <h3 class="col-sm-3 control-label col-form-label card-title">Question Detail: </h3>
                                        <div class="col-sm-9">
                                            <div class="custom-control custom-checkbox">
                                                <label id="show_ques_lang_details_{{ $val->languages_id }}"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <h3 class="col-sm-3 control-label col-form-label card-title">Question Seo Title: </h3>
                                        <div class="col-sm-9">
                                            <div class="custom-control custom-checkbox">
                                                <label id="show_ques_lang_seo_title_{{ $val->languages_id }}"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <h3 class="col-sm-3 control-label col-form-label card-title">Question Seo Description: </h3>
                                        <div class="col-sm-9">
                                            <div class="custom-control custom-checkbox">
                                                <label id="show_ques_lang_seo_description_{{ $val->languages_id }}"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <h3 class="col-sm-3 control-label col-form-label card-title">Question Seo Keyword: </h3>
                                        <div class="col-sm-9">
                                            <div class="custom-control custom-checkbox">
                                                <label id="show_ques_lang_seo_keyword_{{ $val->languages_id }}"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <h3 class="col-sm-3 control-label col-form-label card-title">Display Status: </h3>
                                        <div class="col-sm-9">
                                            <div class="custom-control custom-checkbox">
                                                <label id="show_ques_lang_status_{{ $val->languages_id }}"></label>
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
    var tableQuestion = $('#tableQuestion').dataTable({
        "ajax": {
            "url": url_gb + "/admin/Question/Lists",
            "type": "POST",
            "data": function(d) {
                d.ques_seo_title = $('#search_ques_seo_title').val();
                d.ques_seo_keyword = $('#search_ques_seo_keyword').val();
                d.ques_seo_description = $('#search_ques_seo_description').val();
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
                "data": "ques_seo_title",
                "class": "text-center"
            },
            {
                "data": "ques_category",
                "class": "text-center"
            },
            {
                "data": "ques_sort_order",
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
        tableQuestion.api().ajax.reload();
    });

    $('body').on('click', '.btn-clear-search', function() {
        $('#search_ques_seo_title').val('');
        $('#search_ques_seo_description').val('');
        $('#search_ques_seo_keyword').val('');
        tableQuestion.api().ajax.reload();
    });

    $('body').on('click', '.btn-add', function(data) {
        $('#add_ques_status').prop('checked', true);
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
            url: url_gb + "/admin/Question/" + id,
            data: {
                id: id
            }
        }).done(function(res) {
            resetButton(btn);
            var data = res.content;
            var ques_category_selected_array = [];
            var ques_tag_selected_array = [];

            $.each(data.question_has_question_category, function(k, v) {
                ques_category_selected_array[k] = v.ques_category_id;
                $("#edit_ques_category_id").val(ques_category_selected_array);
                $("#edit_ques_category_id").trigger('change');
            });

            $.each(data.question_detail, function(k, v) {
                url = data.QuestionImagePath + '/' + v.ques_lang_image;
                $('#edit_ques_lang_question_' + v.languages_id).val(v.ques_lang_question);
                $('#preview_img_' + v.languages_id).attr('src', url);
                $('#edit_ques_lang_details_' + v.languages_id).val(v.ques_lang_details);
                $('#edit_ques_lang_image_alt_' + v.languages_id).val(v.ques_lang_image_alt);
                // $('#edit_old_ques_lang_image_' + v.languages_id).val(v.ques_lang_image);
                $('#edit_ques_lang_seo_title_' + v.languages_id).val(v.ques_lang_seo_title);
                $('#edit_ques_lang_seo_description_' + v.languages_id).val(v.ques_lang_seo_description);
                $('#edit_ques_lang_seo_keyword_' + v.languages_id).val(v.ques_lang_seo_keyword);
                $('#edit_ques_lang_url_slug_'+ v.languages_id).val(v.ques_lang_url_slug);
                $('#edit_ques_lang_sort_order_'+ v.languages_id).val(v.ques_lang_sort_order);
                if (v.ques_lang_status == "1") {
                    $('#edit_ques_lang_status_' + v.languages_id + '_1').prop('checked', true);
                } else if (v.ques_lang_status == "0") {
                    $('#edit_ques_lang_status_' + v.languages_id + '_2').prop('checked', true);
                }
                // new FroalaEditor('.editor-edit', {
                //     key: "UBB7jD6C5E3A2J3B7aIVLEABVAYFKc1Ce1MYGD1c1NYVMiB3B9B6A5C2C4F4H3G3J3==",
                //     height: 300
                //     // Set the image upload parameter.
                // })
                // // new FroalaEditor('.editor');
            });
            url_cover = data.QuestionCoverPath + '/' + data.ques_lang_image;
            $('#preview_img_cover').attr('src', url_cover);
            $('#edit_old_ques_cover_image').val(data.ques_lang_image);
            $("#edit_ques_lang_image_alt").val(data.ques_lang_image_alt);
            $("#edit_ques_seo_title").val(data.ques_seo_title);
            $("#edit_ques_seo_keyword").val(data.ques_seo_keyword);
            $("#edit_ques_seo_description").val(data.ques_seo_description);
            $("#edit_ques_url_slug").val(data.ques_url_slug);
            $("#edit_ques_sort_order").val(data.ques_sort_order);

            if (data.ques_language_lock_type == "0") {
                $('#edit_ques_language_lock_type_1').prop('checked', true);
            } else if (data.ques_language_lock_type == "1") {
                $('#edit_ques_language_lock_type_2').prop('checked', true);
            }
            if (data.ques_status == 1) {
                $('#edit_ques_status').prop('checked', true);
            } else {
                $('#edit_ques_status').prop('checked', false);
            }

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
            url: url_gb + "/admin/Question/" + id,
            data: {
                id: id
            }
        }).done(function(res) {
            resetButton(btn);
            var data = res.content;
            var status = '';
            // var ques_category_seo_title = [];
            // var ques_tag_name = [];
            // if (data.ques_status == 1) {
            //     status = "Active";
            // } else {
            //     status = "No Active";
            // }
            $.each(data.question_detail, function(k, v) {
                url = data.QuestionImagePath + '/' + v.ques_lang_image;
                $('#show_ques_lang_question_' + v.languages_id).text(v.ques_lang_question);
                $('#show_ques_lang_details_' + v.languages_id).text(v.ques_lang_details);
                $('#show_ques_lang_seo_title_' + v.languages_id).text(v.ques_lang_seo_title);
                $('#show_ques_lang_seo_keyword_' + v.languages_id).text(v.ques_lang_seo_keyword);
                $('#show_ques_lang_seo_description_' + v.languages_id).text(v.ques_lang_seo_description);
                $('#show_ques_lang_image_' + v.languages_id).attr('src', url);
                if (v.ques_lang_status == 1) {
                    lang_status = '<h3 class="card-title text-success">Active</h3>';
                } else {
                    lang_status = '<h3 class="card-title text-danger">Inctive</h3>';
                }
                $('#show_ques_lang_status_' + v.languages_id).html(lang_status);
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
            url: url_gb + "/admin/Question/ChangeStatus/" + id,
            data: {
                id: id,
                status: status ? 1 : 0,
            }
        }).done(function(res) {
            if (res.status == 1) {
                // swal(res.title, res.content, 'success');
                // tableQuestion.api().ajax.reload();
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
            url: url_gb + "/admin/Question",
            data: form.serialize()
        }).done(function(res) {
            resetButton(form.find('button[type=submit]'));
            if (res.status == 1) {
                swal(res.title, "Update", "success")
                    .then((value) => {
                        location.reload();
                    });                 form[0].reset();
                tableQuestion.api().ajax.reload();
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
            url: url_gb + "/admin/Question/" + id,
            data: form.serialize()
        }).done(function(res) {
            resetButton(form.find('button[type=submit]'));
            if (res.status == 1) {
                // swal(res.title, res.content, 'success');
                form[0].reset();
                swal(res.title, "Update", "success")
                    .then((value) => {
                        location.reload();
                    }); 
                tableQuestion.api().ajax.reload();
                $('#ModalEdit').modal('hide');
            } else {
                swal(res.title, res.content, 'error');
            }
        }).fail(function(res) {
            resetButton(form.find('button[type=submit]'));
            swal("โอ๊ะโอ! เกิดข้อผิดพลาด", res.content, 'error');
        });
    });

    Dropzone.autoDiscover = false;
    $("#dZUpload").dropzone({
        url: url_gb + "/admin/UploadFile/QuestionGalleryTemp",
        addRemoveLinks: true,
        removedfile: function(file) {
            var name = file.name;
            $.ajax({
                type: 'POST',
                url: url_gb + "/admin/UploadFile/DeleteUploadFile/QuestionGalleryTemp",
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
        url: url_gb + "/admin/UploadFile/QuestionGalleryTemp",
        addRemoveLinks: true,
        removedfile: function(file) {
            var name = file.name;
            $.ajax({
                type: 'POST',
                url: url_gb + "/admin/UploadFile/DeleteUploadFile/QuestionGalleryTemp",
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
            url: url_gb + "/admin/UploadFile/DeleteUploadFileEdit/QuestionGalleryTemp",
            data: "file_name=" + id + '/' + name,
            success: function(data) {
                $('#img_' + id).remove();
            }
        })
    });
    $('body').on('change', '.upload-question-file', function() {
        var ele = $(this);
        var index = ele.data('index');
        var formData = new FormData();
        var id = $(this).attr('id');

        $('#add_preview_img_' + id).attr('src', URL.createObjectURL(event.target.files[0]));
        $('#preview_img_'+ id).attr('src', URL.createObjectURL(event.target.files[0]));
        // $('#edit_old_ques_lang_image_' + id).remove('');
        formData.append('file', ele[0].files[0]);
        $.ajax({
            url: url_gb + '/admin/UploadImage/QuestionImageTemp',
            type: 'POST',
            data: formData,
            processData: false, // tell jQuery not to process the data
            contentType: false, // tell jQuery not to set contentType
            success: function(res) {
                $('.image_alt').show();
                ele.closest('.form-upload').find('.upload-question-file').append('<input type="hidden" id="edit_ques_lang_image_' + id + '" name="lang[' + id + '][ques_lang_image]" value="' + res.path + '">');
                setTimeout(function() {

                }, 100);
            }
        });
    });
   
</script>
@endsection
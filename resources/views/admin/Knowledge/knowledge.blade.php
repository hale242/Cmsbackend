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
                                <label class="control-label">Knowledge</label>
                                <input type="text" id="search_knowledge_seo_title" class="form-control search_table">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Keyword</label>
                                <input type="text" id="search_knowledge_seo_keyword" class="form-control search_table">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Description</label>
                                <input type="text" id="search_knowledge_seo_description" class="form-control search_table">
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
                    @if(App\Helper::CheckPermissionMenu('Knowledge' , '2'))
                    <button type="button" class="btn btn-primary btn-rounded m-t-10 mb-2 float-right newdata btn-add">Add New</button>
                    @endif
                </div>
                <div class="table-responsive">
                    <table id="tableKnowledge" class="table">
                        <thead>
                            <tr>
                                <!-- <th scope="col"></th> -->
                                <th scope="col">No</th>
                                <th scope="col">Knowledge Title</th>
                                <th scope="col">Knowledge Category</th>
                                <th scope="col">Knowledge Order</th>
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
                                                <label for="add_knowledge_details_title" class="col-sm-3 text-right control-label col-form-label">Knowledge Title</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_knowledge_details_title" name="lang[{{$val->languages_id}}][knowledge_details_title]" required>
                                                </div>
                                            </div>

                                            <div class="form-group row pb-3">
                                                <label for="add_knowledge_details_image" class="col-sm-3 text-right control-label col-form-label">Knowledge Image</label>
                                                <div class="col-sm-9">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input upload-knowledge-file" id="{{$val->languages_id}}">
                                                        <label class="custom-file-label" for="validatedCustomFile">Choose Image...</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3 image_alt">
                                                <label for="add_knowledge_details_image_alt" class="col-sm-3 text-right control-label col-form-label">Knowledge Image Alt</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_knowledge_details_image_alt" name="lang[{{$val->languages_id}}][knowledge_details_image_alt]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_knowledge_details_seo_title" class="col-sm-3 text-right control-label col-form-label">Knowledge Seo Title</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_knowledge_details_seo_title" name="lang[{{$val->languages_id}}][knowledge_details_seo_title]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_knowledge_details_seo_description" class="col-sm-3 text-right control-label col-form-label">Knowledge Seo Description</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_knowledge_details_seo_description" name="lang[{{$val->languages_id}}][knowledge_details_seo_description]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_knowledge_seo_keyword" class="col-sm-3 text-right control-label col-form-label">Knowledge Seo Keyword</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_knowledge_seo_keyword" name="lang[{{$val->languages_id}}][knowledge_details_seo_keyword]">
                                                </div>
                                            </div>

                                            <div class="form-group row pb-3">
                                                <label for="add_knowledge_details_og_title" class="col-sm-3 text-right control-label col-form-label">Knowledge Og Title</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_knowledge_details_og_title" name="lang[{{$val->languages_id}}][knowledge_details_og_title]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_knowledge_details_og_description" class="col-sm-3 text-right control-label col-form-label">Knowledge Og Description</label>
                                                <div class="col-sm-9">
                                                    <textarea rows="3" type="text" class="form-control" id="add_knowledge_details_og_description" name="lang[{{$val->languages_id}}][knowledge_details_og_description]"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_knowledge_details_og_url" class="col-sm-3 text-right control-label col-form-label">Knowledge Og Url</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_knowledge_details_og_url" name="lang[{{$val->languages_id}}][knowledge_details_og_url]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_knowledge_details_og_site_name" class="col-sm-3 text-right control-label col-form-label">Knowledge Og Site Name</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_knowledge_details_og_site_name" name="lang[{{$val->languages_id}}][knowledge_details_og_site_name]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_knowledge_details_og_image" class="col-sm-3 text-right control-label col-form-label">Knowledge Og Image</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_knowledge_details_og_image" name="lang[{{$val->languages_id}}][knowledge_details_og_image]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_knowledge_details_status" class="col-sm-3 text-right control-label col-form-label">Display Status</label>
                                                <div class="col-sm-9">
                                                    <div class="form-check form-check-inline">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input" value="1" id="add_knowledge_details_status_{{$val->languages_id}}_1" name="lang[{{$val->languages_id}}][knowledge_details_status]" checked>
                                                            <label class="custom-control-label" for="add_knowledge_details_status_{{$val->languages_id}}_1">Active</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input" value="0" id="add_knowledge_details_status_{{$val->languages_id}}_2" name="lang[{{$val->languages_id}}][knowledge_details_status]">
                                                            <label class="custom-control-label" for="add_knowledge_details_status_{{$val->languages_id}}_2">Inactive</label>
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
                                            <label for="add_knowledge_image" class="col-sm-3 text-right control-label col-form-label">Knowledge Cover Image</label>
                                            <div class="col-sm-9">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input upload-knowledge-imgCover" id="{{$val->languages_id}}">
                                                    <label class="custom-file-label" for="validatedCustomFile">Choose Image...</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="add_knowledge_image_alt" class="col-sm-3 text-right control-label col-form-label">Knowledge Cover Image Alt</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="add_knowledge_image_alt" name="lang[{{$val->languages_id}}][knowledge_details_image_alt]" required>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="" class="col-sm-3 text-right control-label col-form-label">Knowledge Seo Title</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="add_knowledge_seo_title" name="knowledge[knowledge_seo_title]">
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="" class="col-sm-3 text-right control-label col-form-label">Knowledge Seo Keyword</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="add_knowledge_seo_keyword" name="knowledge[knowledge_seo_keyword]">
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="" class="col-sm-3 text-right control-label col-form-label">Knowledge Seo Description</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="add_knowledge_seo_description" name="knowledge[knowledge_seo_description]">
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="" class="col-sm-3 text-right control-label col-form-label">Knowledge Url Slug</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="add_knowledge_url_slug" name="knowledge[knowledge_url_slug]" placeholder="https://">
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="add_knowledge_category_id" class="col-sm-3 text-right control-label col-form-label">Knowledge Category</label>
                                            <div class="col-sm-9">
                                                <select class="form-control select2" id="add_knowledge_category_id" multiple="" name="knowledge_category_id[]">
                                                    @foreach($KnowledgeCategory as $val)
                                                    <option value="{{ $val->knowledge_category_id }}">{{ $val->knowledge_category_seo_title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="add_knowledge_sort_order" class="col-sm-3 text-right control-label col-form-label">Knowledge Sort Order</label>
                                            <div class="col-sm-9">
                                                <input type="number" class="form-control" id="add_knowledge_sort_order" name="knowledge[knowledge_sort_order]">
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="add_knowledge_language_lock_type" class="col-sm-3 text-right control-label col-form-label">Knowledge Language Lock</label>
                                            <div class="col-sm-9">
                                                <div class="form-check form-check-inline">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input" value="0" id="add_knowledge_language_lock_type_1" name="knowledge[knowledge_language_lock_type]">
                                                        <label class="custom-control-label" for="add_knowledge_language_lock_type_1">ล็อกภาษาตามภาษาหลัก</label>
                                                    </div>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input" value="1" id="add_knowledge_language_lock_type_2" name="knowledge[knowledge_language_lock_type]">
                                                        <label class="custom-control-label" for="add_knowledge_language_lock_type_2">ล็อกตามภาษา</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row pb-3">
                                            <label for="Check-Box" class="col-sm-3 text-right control-label col-form-label">Status</label>
                                            <div class="col-sm-9">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="add_knowledge_status" name="knowledge[knowledge_status]" value="1">
                                                    <label class="custom-control-label" for="add_knowledge_status">Action</label>
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
                                                <label for="edit_knowledge_details_title" class="col-sm-3 text-right control-label col-form-label">Knowledge Title</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="edit_knowledge_details_title_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][knowledge_details_title]" required>
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3 ">
                                                <label for="edit_knowledge_details_image" class="col-sm-3 text-right control-label col-form-label">Knowledge Image</label>
                                                <div class="col-sm-9">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input upload-knowledge-file" id="{{$val->languages_id}}">
                                                        <label class="custom-file-label" for="validatedCustomFile">Choose Image...</label>
                                                    </div>
                                                    <div class="card-body">
                                                        <img class="img-thumbnail" id="preview_img_{{$val->languages_id}}" style="width:70%;">
                                                    </div>
                                                    <input type="hidden" id="edit_old_knowledge_details_image_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][knowledge_details_image]" value="">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="edit_knowledge_details_image_alt" class="col-sm-3 text-right control-label col-form-label">Knowledge Image Alt</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="edit_knowledge_details_image_alt_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][knowledge_details_image_alt]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="edit_knowledge_details_seo_title" class="col-sm-3 text-right control-label col-form-label">Knowledge Seo Title</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="edit_knowledge_details_seo_title_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][knowledge_details_seo_title]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="edit_knowledge_details_seo_description" class="col-sm-3 text-right control-label col-form-label">Knowledge Seo Description</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="edit_knowledge_details_seo_description_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][knowledge_details_seo_description]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="edit_knowledge_details_seo_keyword" class="col-sm-3 text-right control-label col-form-label">Knowledge Seo Keyword</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="edit_knowledge_details_seo_keyword_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][knowledge_details_seo_keyword]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="edit_knowledge_details_og_title" class="col-sm-3 text-right control-label col-form-label">Knowledge Og Title</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="edit_knowledge_details_og_title_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][knowledge_details_og_title]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="edit_knowledge_details_og_description" class="col-sm-3 text-right control-label col-form-label">Knowledge Og Description</label>
                                                <div class="col-sm-9">
                                                    <textarea rows="3" type="text" class="form-control" id="edit_knowledge_details_og_description_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][knowledge_details_og_description]"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="edit_knowledge_details_og_url" class="col-sm-3 text-right control-label col-form-label">Knowledge Og Url</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="edit_knowledge_details_og_url_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][knowledge_details_og_url]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="edit_knowledge_details_og_site_name" class="col-sm-3 text-right control-label col-form-label">Knowledge Og Site Name</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="edit_knowledge_details_og_site_name_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][knowledge_details_og_site_name]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="edit_knowledge_details_og_image" class="col-sm-3 text-right control-label col-form-label">Knowledge Og Image</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="edit_knowledge_details_og_image_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][knowledge_details_og_image]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="edit_knowledge_details_status" class="col-sm-3 text-right control-label col-form-label">Display Status</label>
                                                <div class="col-sm-9">
                                                    <div class="form-check form-check-inline">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input" value="1" id="edit_knowledge_details_status_{{$val->languages_id}}_1" name="lang[{{$val->languages_id}}][knowledge_details_status]">
                                                            <label class="custom-control-label" for="edit_knowledge_details_status_{{$val->languages_id}}_1">Active</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input" value="0" id="edit_knowledge_details_status_{{$val->languages_id}}_2" name="lang[{{$val->languages_id}}][knowledge_details_status]">
                                                            <label class="custom-control-label" for="edit_knowledge_details_status_{{$val->languages_id}}_2">Inactive</label>
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
                                            <label for="edit_knowledge_image" class="col-sm-3 text-right control-label col-form-label">Knowledge Cover Image</label>
                                            <div class="col-sm-9">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input upload-knowledge-imgCover" id="{{$val->languages_id}}">
                                                    <label class="custom-file-label" for="validatedCustomFile">Choose Image...</label>
                                                </div>
                                                <div class="card-body">
                                                    <img class="img-thumbnail" id="preview_img_cover" style="width:70%;">
                                                </div>
                                                <input type="hidden" id="edit_old_knowledge_cover_image" name="knowledge[knowledge_image]" value="">
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="edit_knowledge_image_alt" class="col-sm-3 text-right control-label col-form-label">Knowledge Cover Image Alt</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="edit_knowledge_image_alt" name="knowledge[knowledge_image_alt]">
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="" class="col-sm-3 text-right control-label col-form-label">Knowledge Seo Title</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="edit_knowledge_seo_title" name="knowledge[knowledge_seo_title]">
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="" class="col-sm-3 text-right control-label col-form-label">Knowledge Seo Keyword</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="edit_knowledge_seo_keyword" name="knowledge[knowledge_seo_keyword]">
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="" class="col-sm-3 text-right control-label col-form-label">Knowledge Seo Description</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="edit_knowledge_seo_description" name="knowledge[knowledge_seo_description]">
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="" class="col-sm-3 text-right control-label col-form-label">Knowledge Url Slug</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="edit_knowledge_url_slug" name="knowledge[knowledge_url_slug]">
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="edit_knowledge_category_id" class="col-sm-3 text-right control-label col-form-label">Knowledge Category</label>
                                            <div class="col-sm-9">
                                                <select class="form-control select2" id="edit_knowledge_category_id" multiple="" name="knowledge_category_id[]" required>
                                                    @foreach($KnowledgeCategory as $val)
                                                    <option value="{{ $val->knowledge_category_id }}">{{ $val->knowledge_category_seo_title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="edit_knowledge_sort_order" class="col-sm-3 text-right control-label col-form-label">Knowledge Sort Order</label>
                                            <div class="col-sm-9">
                                                <input type="number" class="form-control" id="edit_knowledge_sort_order" name="knowledge[knowledge_sort_order]">
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="edit_knowledge_language_lock_type" class="col-sm-3 text-right control-label col-form-label">Knowledge Language Lock</label>
                                            <div class="col-sm-9">
                                                <div class="form-check form-check-inline">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input" value="0" id="edit_knowledge_language_lock_type_1" name="knowledge[knowledge_language_lock_type]">
                                                        <label class="custom-control-label" for="edit_knowledge_language_lock_type_1">ล็อกภาษาตามภาษาหลัก</label>
                                                    </div>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input" value="1" id="edit_knowledge_language_lock_type_2" name="knowledge[knowledge_language_lock_type]">
                                                        <label class="custom-control-label" for="edit_knowledge_language_lock_type_2">ล็อกตามภาษา</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="Check-Box" class="col-sm-3 text-right control-label col-form-label">Status</label>
                                            <div class="col-sm-9">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="edit_knowledge_status" name="knowledge[knowledge_status]" value="1">
                                                    <label class="custom-control-label" for="edit_knowledge_status">Action</label>
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
                                        <h3 class="col-sm-2 control-label col-form-label card-title">Knowledge Title: </h3>
                                        <div class="col-sm-9">
                                            <div class="custom-control custom-checkbox">
                                                <h2 id="show_knowledge_details_title_{{ $val->languages_id }}"></h2>
                                            </div>
                                        </div>
                                    </div>
                                    <img class="form-horizontal pb-3" id="show_knowledge_image_{{ $val->languages_id }}" style="width:100%;">

                                    <div class="row">
                                        <h3 class="col-sm-3 control-label col-form-label card-title">Knowledge Seo Title: </h3>
                                        <div class="col-sm-9">
                                            <div class="custom-control custom-checkbox">
                                                <label id="show_knowledge_details_seo_title_{{ $val->languages_id }}"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <h3 class="col-sm-3 control-label col-form-label card-title">Knowledge Seo Description: </h3>
                                        <div class="col-sm-9">
                                            <div class="custom-control custom-checkbox">
                                                <label id="show_knowledge_details_seo_description_{{ $val->languages_id }}"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <h3 class="col-sm-3 control-label col-form-label card-title">Knowledge Seo Keyword: </h3>
                                        <div class="col-sm-9">
                                            <div class="custom-control custom-checkbox">
                                                <label id="show_knowledge_details_seo_keyword_{{ $val->languages_id }}"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <h3 class="col-sm-3 control-label col-form-label card-title">Display Status: </h3>
                                        <div class="col-sm-9">
                                            <div class="custom-control custom-checkbox">
                                                <label id="show_knowledge_details_status_{{ $val->languages_id }}"></label>
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
    var tableKnowledge = $('#tableKnowledge').dataTable({
        "ajax": {
            "url": url_gb + "/admin/Knowledge/Lists",
            "type": "POST",
            "data": function(d) {
                d.knowledge_seo_title = $('#search_knowledge_seo_title').val();
                d.knowledge_seo_keyword = $('#search_knowledge_seo_keyword').val();
                d.knowledge_seo_description = $('#search_knowledge_seo_description').val();
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
                "data": "knowledge_seo_title",
                "class": "text-center"
            },
            {
                "data": "knowledge_category",
                "class": "text-center"
            },
            {
                "data": "knowledge_sort_order",
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
        tableKnowledge.api().ajax.reload();
    });

    $('body').on('click', '.btn-clear-search', function() {
        $('#search_knowledge_seo_title').val('');
        $('#search_knowledge_seo_description').val('');
        $('#search_knowledge_seo_keyword').val('');
        tableKnowledge.api().ajax.reload();
    });

    $('body').on('click', '.btn-add', function(data) {
        $('#add_knowledge_status').prop('checked', true);
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
            url: url_gb + "/admin/Knowledge/" + id,
            data: {
                id: id
            }
        }).done(function(res) {
            resetButton(btn);
            var data = res.content;
            var knowledge_category_selected_array = [];
            var knowledge_tag_selected_array = [];

            $.each(data.knowledge_has_knowledge_category, function(k, v) {
                knowledge_category_selected_array[k] = v.knowledge_category_id;
                $("#edit_knowledge_category_id").val(knowledge_category_selected_array);
                $("#edit_knowledge_category_id").trigger('change');
            });

            $.each(data.knowledge_has_knowledge_tag, function(k, v) {
                knowledge_tag_selected_array[k] = v.knowledge_tag_id;
                $("#edit_knowledge_tag_id").val(knowledge_tag_selected_array);
                $("#edit_knowledge_tag_id").trigger('change');
            });

            $.each(data.knowledge_detail, function(k, v) {
                url = data.KnowledgeImagePath + '/' + v.knowledge_details_image;
                $('#edit_knowledge_details_title_' + v.languages_id).val(v.knowledge_details_title);
                $('#preview_img_' + v.languages_id).attr('src', url);
                $('#edit_knowledge_details_image_alt_' + v.languages_id).val(v.knowledge_details_image_alt);
                $('#edit_old_knowledge_details_image_' + v.languages_id).val(v.knowledge_details_image);
                $('#edit_knowledge_details_seo_title_' + v.languages_id).val(v.knowledge_details_seo_title);
                $('#edit_knowledge_details_seo_description_' + v.languages_id).val(v.knowledge_details_seo_description);
                $('#edit_knowledge_details_seo_keyword_' + v.languages_id).val(v.knowledge_details_seo_keyword);
                $('#edit_knowledge_details_og_title_' + v.languages_id).val(v.knowledge_details_og_title);
                $('#edit_knowledge_details_og_description_' + v.languages_id).val(v.knowledge_details_og_description);
                $('#edit_knowledge_details_og_url_' + v.languages_id).val(v.knowledge_details_og_url);
                $('#edit_knowledge_details_og_site_name_' + v.languages_id).val(v.knowledge_details_og_site_name);
                $('#edit_knowledge_details_og_image_' + v.languages_id).val(v.knowledge_details_og_image);
                $('#edit_knowledge_details_seo_type_' + v.languages_id).val(v.knowledge_details_seo_type).change();
                if (v.knowledge_details_status == "1") {
                    $('#edit_knowledge_details_status_' + v.languages_id + '_1').prop('checked', true);
                } else if (v.knowledge_details_status == "0") {
                    $('#edit_knowledge_details_status_' + v.languages_id + '_2').prop('checked', true);
                }
                // new FroalaEditor('.editor-edit', {
                //     key: "UBB7jD6C5E3A2J3B7aIVLEABVAYFKc1Ce1MYGD1c1NYVMiB3B9B6A5C2C4F4H3G3J3==",
                //     height: 300
                //     // Set the image upload parameter.
                // })
                // // new FroalaEditor('.editor');
            });
            url_cover = data.KnowledgeCoverPath + '/' + data.knowledge_image;
            $('#preview_img_cover').attr('src', url_cover);
            $('#edit_old_knowledge_cover_image').val(data.knowledge_image);
            $("#edit_knowledge_image_alt").val(data.knowledge_image_alt);
            $("#edit_knowledge_seo_title").val(data.knowledge_seo_title);
            $("#edit_knowledge_seo_keyword").val(data.knowledge_seo_keyword);
            $("#edit_knowledge_seo_description").val(data.knowledge_seo_description);
            $("#edit_knowledge_url_slug").val(data.knowledge_url_slug);
            $("#edit_knowledge_sort_order").val(data.knowledge_sort_order);

            if (data.knowledge_language_lock_type == "0") {
                $('#edit_knowledge_language_lock_type_1').prop('checked', true);
            } else if (data.knowledge_language_lock_type == "1") {
                $('#edit_knowledge_language_lock_type_2').prop('checked', true);
            }
            if (data.knowledge_status == 1) {
                $('#edit_knowledge_status').prop('checked', true);
            } else {
                $('#edit_knowledge_status').prop('checked', false);
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
            url: url_gb + "/admin/Knowledge/" + id,
            data: {
                id: id
            }
        }).done(function(res) {
            resetButton(btn);
            var data = res.content;
            var status = '';
            // var knowledge_category_seo_title = [];
            // var knowledge_tag_name = [];
            // if (data.knowledge_status == 1) {
            //     status = "Active";
            // } else {
            //     status = "No Active";
            // }
            $.each(data.knowledge_detail, function(k, v) {
                url = data.KnowledgeImagePath + '/' + v.knowledge_details_image;
                $('#show_knowledge_details_title_' + v.languages_id).text(v.knowledge_details_title);
                $('#show_knowledge_details_seo_title_' + v.languages_id).text(v.knowledge_details_seo_title);
                $('#show_knowledge_details_seo_keyword_' + v.languages_id).text(v.knowledge_details_seo_keyword);
                $('#show_knowledge_details_seo_description_' + v.languages_id).text(v.knowledge_details_seo_description);
                $('#show_knowledge_image_' + v.languages_id).attr('src', url);
                if (v.knowledge_details_status == 1) {
                    details_status = '<h3 class="card-title text-success">Active</h3>';
                } else {
                    details_status = '<h3 class="card-title text-danger">Inctive</h3>';
                }
                $('#show_knowledge_details_status_' + v.languages_id).html(details_status);
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
            url: url_gb + "/admin/Knowledge/ChangeStatus/" + id,
            data: {
                id: id,
                status: status ? 1 : 0,
            }
        }).done(function(res) {
            if (res.status == 1) {
                // swal(res.title, res.content, 'success');
                // tableKnowledge.api().ajax.reload();
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
            url: url_gb + "/admin/Knowledge",
            data: form.serialize()
        }).done(function(res) {
            resetButton(form.find('button[type=submit]'));
            if (res.status == 1) {
                swal(res.title, res.content, 'success');
                form[0].reset();
                tableKnowledge.api().ajax.reload();
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
            url: url_gb + "/admin/Knowledge/" + id,
            data: form.serialize()
        }).done(function(res) {
            resetButton(form.find('button[type=submit]'));
            if (res.status == 1) {
                swal(res.title, res.content, 'success');
                form[0].reset();
                tableKnowledge.api().ajax.reload();
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
        url: url_gb + "/admin/UploadFile/KnowledgeGalleryTemp",
        addRemoveLinks: true,
        removedfile: function(file) {
            var name = file.name;
            $.ajax({
                type: 'POST',
                url: url_gb + "/admin/UploadFile/DeleteUploadFile/KnowledgeGalleryTemp",
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
        url: url_gb + "/admin/UploadFile/KnowledgeGalleryTemp",
        addRemoveLinks: true,
        removedfile: function(file) {
            var name = file.name;
            $.ajax({
                type: 'POST',
                url: url_gb + "/admin/UploadFile/DeleteUploadFile/KnowledgeGalleryTemp",
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
            url: url_gb + "/admin/UploadFile/DeleteUploadFileEdit/KnowledgeGalleryTemp",
            data: "file_name=" + id + '/' + name,
            success: function(data) {
                $('#img_' + id).remove();
            }
        })
    });
    $('body').on('change', '.upload-knowledge-file', function() {
        var ele = $(this);
        var index = ele.data('index');
        var formData = new FormData();
        var id = $(this).attr('id');
        $('#edit_old_knowledge_details_image_' + id).remove('');
        formData.append('file', ele[0].files[0]);
        $.ajax({
            url: url_gb + '/admin/UploadImage/KnowledgeImage',
            type: 'POST',
            data: formData,
            processData: false, // tell jQuery not to process the data
            contentType: false, // tell jQuery not to set contentType
            success: function(res) {
                $('.image_alt').show();
                ele.closest('.form-upload').find('.upload-knowledge-file').append('<input type="hidden" id="edit_knowledge_details_image_' + id + '" name="lang[' + id + '][knowledge_details_image]" value="' + res.path + '">');
                setTimeout(function() {

                }, 100);
            }
        });
    });
    $('body').on('change', '.upload-knowledge-imgCover', function() {
        var ele = $(this);
        var index = ele.data('index');
        var formData = new FormData();
        var id = $(this).attr('id');
        $('#edit_old_knowledge_cover_image').remove();
        formData.append('file', ele[0].files[0]);
        $.ajax({
            url: url_gb + '/admin/UploadImage/KnowledgeCover',
            type: 'POST',
            data: formData,
            processData: false, // tell jQuery not to process the data
            contentType: false, // tell jQuery not to set contentType
            success: function(res) {
                ele.closest('.form-upload-imgCover').find('.upload-knowledge-imgCover').append('<input type="hidden" id="add_knowledge_details_image_' + id + '" name="knowledge[knowledge_image]" value="' + res.path + '">');
                setTimeout(function() {

                }, 100);
            }
        });
    });
</script>
@endsection
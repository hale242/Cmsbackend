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
                                <label class="control-label">Seo Title</label>
                                <input type="text" id="search_knowledge_category_seo_title" class="form-control search_table">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Seo Keyword</label>
                                <input type="text" id="search_knowledge_category_seo_keyword" class="form-control search_table">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Seo Description</label>
                                <input type="text" id="search_knowledge_category_seo_description" class="form-control search_table">
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
                    @if(App\Helper::CheckPermissionMenu('KnowledgeCategory' , '2'))
                    <button type="button" class="btn btn-primary btn-rounded m-t-10 mb-2 float-right newdata btn-add">Add New</button>
                    @endif
                </div>
                <div class="table-responsive">
                    <table id="tableKnowledgeCategory" class="table">
                        <thead>
                            <tr>
                                <!-- <th scope="col"></th> -->
                                <th scope="col">No</th>
                                <th scope="col">Knowledge Category</th>
                                <th scope="col">Description</th>
                                <th scope="col">Order</th>
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
                                <a class="nav-link {{ $val->languages_type == '1' ? 'active' : ''}}" id="{{ $val->languages_name }}-tab" data-toggle="tab" href="#{{ $val->languages_name }}" role="tab" aria-controls="{{ $val->languages_name }}" aria-selected="true"><i class="{{ $val->languages_icon }}"></i> {{ $val->languages_name }}</a>
                            </li>
                            @endforeach
                            <li class="nav-item">
                                <a class="nav-link" id="setting-tab" data-toggle="tab" href="#setting" role="tab" aria-controls="setting" aria-selected="false"><i class="mdi mdi-settings"></i> Setting</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            @foreach($Language as $val)
                            <div class="tab-pane fade {{ $val->languages_type == '1' ? 'show active' : ''}}" id="{{ $val->languages_name }}" role="tabpanel" aria-labelledby="{{ $val->languages_name }}-tab">
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="form-horizontal">
                                            <input type="hidden" id="add_languages_id" name="lang[{{$val->languages_id}}][languages_id]" value="{{ $val->languages_id }}">
                                            <div class="form-group row pb-3">
                                                <label for="add_knowledge_category_details_name" class="col-sm-3 text-right control-label col-form-label">Knowledge Category Name</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_knowledge_category_details_name" name="lang[{{$val->languages_id}}][knowledge_category_details_name]" required>
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_knowledge_category_details_details" class="col-sm-3 text-right control-label col-form-label">Knowledge Category Detail</label>
                                                <div class="col-sm-9">
                                                    <textarea cols="60" id="add_event_details_description_{{$val->languages_id}}" rows="6" data-sample="3" data-sample-short name="lang[{{$val->languages_id}}][knowledge_category_details_details]"></textarea>

                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_knowledge_category_details_status" class="col-sm-3 text-right control-label col-form-label">Display Status</label>
                                                <div class="col-sm-9">
                                                    <div class="form-check form-check-inline">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input" value="1" id="add_knowledge_category_details_status_{{$val->languages_id}}_1" name="lang[{{$val->languages_id}}][knowledge_category_details_status]" checked>
                                                            <label class="custom-control-label" for="add_knowledge_category_details_status_{{$val->languages_id}}_1">Active</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input" value="0" id="add_knowledge_category_details_status_{{$val->languages_id}}_2" name="lang[{{$val->languages_id}}][knowledge_category_details_status]">
                                                            <label class="custom-control-label" for="add_knowledge_category_details_status_{{$val->languages_id}}_2">Inactive</label>
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
                                    <div class="form-horizontal">
                                        <div class="form-group row pb-3">
                                            <label for="add_knowledge_category_main_id" class="col-sm-3 text-right control-label col-form-label">Knowledge Category Main</label>
                                            <div class="col-sm-9">
                                                <select class="form-control select2 select_main_add" id="add_knowledge_category_main_id" name="knowledge_category[knowledge_category_main_id]">
                                                    <option value="0">Main Menu</option>
                                                    <option value="99">Sub Menu</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3 add_knowledge_category_sub_id">
                                            <label for="add_knowledge_category_sub_id" class="col-sm-3 text-right control-label col-form-label">Knowledge Category Sub</label>
                                            <div class="col-sm-9">
                                                <select class="form-control select2" id="add_knowledge_category_sub_id" name="knowledge_category[knowledge_category_sub_id]">
                                                    @foreach($KnowledgeCategoryMain as $val)
                                                    <option value="{{$val->knowledge_category_id}}">{{ $val->knowledge_category_seo_title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="add_knowledge_category_seo_title" class="col-sm-3 text-right control-label col-form-label">Knowledge Category Seo Title</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="add_knowledge_category_seo_title" name="knowledge_category[knowledge_category_seo_title]">
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="add_knowledge_category_seo_keyword" class="col-sm-3 text-right control-label col-form-label">Knowledge Category Seo Keyword</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="add_knowledge_category_seo_keyword" name="knowledge_category[knowledge_category_seo_keyword]">
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="add_knowledge_category_seo_description" class="col-sm-3 text-right control-label col-form-label">Knowledge Category Seo Description</label>
                                            <div class="col-sm-9">
                                                <textarea type="text" class="form-control" id="add_knowledge_category_seo_description" name="knowledge_category[knowledge_category_seo_description]"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="" class="col-sm-3 text-right control-label col-form-label">Knowledge Category Order</label>
                                            <div class="col-sm-9">
                                                <input type="number" class="form-control" id="add_knowledge_category_sort_order" name="knowledge_category[knowledge_category_sort_order]">
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="Check-Box" class="col-sm-3 text-right control-label col-form-label">Status</label>
                                            <div class="col-sm-9">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="add_knowledge_category_status" name="knowledge_category[knowledge_category_status]" value="1">
                                                    <label class="custom-control-label" for="add_knowledge_category_status">Action</label>
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
                                <a class="nav-link {{ $val->languages_type == '1' ? 'active' : ''}}" id="{{ $val->languages_name }}-tab-edit" data-toggle="tab" href="#{{ $val->languages_name }}-edit" role="tab" aria-controls="{{ $val->languages_name }}-edit" aria-selected="true"><i class="{{ $val->languages_icon }}"></i> {{ $val->languages_name }}</a>
                            </li>
                            @endforeach
                            <li class="nav-item">
                                <a class="nav-link" id="setting-tab-edit" data-toggle="tab" href="#setting-edit" role="tab" aria-controls="setting-edit" aria-selected="false"><i class="mdi mdi-settings"></i> Setting</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            @foreach($Language as $val)
                            <div class="tab-pane fade {{ $val->languages_type == '1' ? 'show active' : ''}}" id="{{ $val->languages_name }}-edit" role="tabpanel" aria-labelledby="{{ $val->languages_name }}-tab-edit">
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="form-horizontal">
                                            <input type="hidden" id="edit_languages_id" name="lang[{{$val->languages_id}}][languages_id]" value="{{ $val->languages_id }}">
                                            <div class="form-group row pb-3">
                                                <label for="edit_knowledge_category_details_name" class="col-sm-3 text-right control-label col-form-label">Knowledge Category Name</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="edit_knowledge_category_details_name_{{ $val->languages_id }}" name="lang[{{$val->languages_id}}][knowledge_category_details_name]" required>
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="edit_knowledge_category_details_details" class="col-sm-3 text-right control-label col-form-label">Knowledge Category Detail</label>
                                                <div class="col-sm-9">
                                                    <textarea cols="60" id="edit_event_details_description_{{$val->languages_id}}" rows="6" data-sample="3" data-sample-short name="lang[{{$val->languages_id}}][knowledge_category_details_details]"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="edit_knowledge_category_details_status" class="col-sm-3 text-right control-label col-form-label">Display Status</label>
                                                <div class="col-sm-9">
                                                    <div class="form-check form-check-inline">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input" value="1" id="edit_knowledge_category_details_status_{{$val->languages_id}}_1" name="lang[{{$val->languages_id}}][knowledge_category_details_status]">
                                                            <label class="custom-control-label" for="edit_knowledge_category_details_status_{{$val->languages_id}}_1">Active</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input" value="0" id="edit_knowledge_category_details_status_{{$val->languages_id}}_2" name="lang[{{$val->languages_id}}][knowledge_category_details_status]">
                                                            <label class="custom-control-label" for="edit_knowledge_category_details_status_{{$val->languages_id}}_2">Inactive</label>
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
                                    <div class="form-horizontal">
                                        <div class="form-group row pb-3">
                                            <label for="edit_knowledge_category_main_id" class="col-sm-3 text-right control-label col-form-label">Knowledge Category Main</label>
                                            <div class="col-sm-9">
                                                <select class="form-control select2 select_main_edit" id="edit_knowledge_category_main_id" name="knowledge_category[knowledge_category_main_id]">
                                                    <option value="0">Main Menu</option>
                                                    <option value="99">Sub Menu</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3 edit_knowledge_category_sub_id">
                                            <label for="edit_knowledge_category_sub_id" class="col-sm-3 text-right control-label col-form-label">Knowledge Category Sub</label>
                                            <div class="col-sm-9">
                                                <select class="form-control select2" id="edit_knowledge_category_sub_id" name="knowledge_category[knowledge_category_sub_id]">
                                                    @foreach($KnowledgeCategoryMain as $val)
                                                    <option value="{{$val->knowledge_category_id}}">{{ $val->knowledge_category_seo_title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="edit_knowledge_category_seo_title" class="col-sm-3 text-right control-label col-form-label">Knowledge Category Seo Title</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="edit_knowledge_category_seo_title" name="knowledge_category[knowledge_category_seo_title]">
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="edit_knowledge_category_seo_keyword" class="col-sm-3 text-right control-label col-form-label">Knowledge Category Seo Keyword</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="edit_knowledge_category_seo_keyword" name="knowledge_category[knowledge_category_seo_keyword]">
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="edit_knowledge_category_seo_description" class="col-sm-3 text-right control-label col-form-label">Knowledge Category Seo Description</label>
                                            <div class="col-sm-9">
                                                <textarea type="text" class="form-control" id="edit_knowledge_category_seo_description" name="knowledge_category[knowledge_category_seo_description]"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="" class="col-sm-3 text-right control-label col-form-label">Knowledge Category Order</label>
                                            <div class="col-sm-9">
                                                <input type="number" class="form-control" id="edit_knowledge_category_sort_order" name="knowledge_category[knowledge_category_sort_order]">
                                            </div>
                                        </div>

                                        <div class="form-group row pb-3">
                                            <label for="Check-Box" class="col-sm-3 text-right control-label col-form-label">Status</label>
                                            <div class="col-sm-9">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="edit_knowledge_category_status" name="knowledge_category[knowledge_category_status]" value="1">
                                                    <label class="custom-control-label" for="edit_knowledge_category_status">Action</label>
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
                    <ul class="nav nav-tabs customtab" id="myTab" role="tablist">
                        @foreach($Language as $val)
                        <li class="nav-item">
                            <a class="nav-link {{ $val->languages_type == '1' ? 'active' : ''}}" id="{{ $val->languages_name }}" data-toggle="tab" href="#{{ $val->languages_name }}-view" role="tab" aria-controls="{{ $val->languages_name }}" aria-selected="true"><i class="{{ $val->languages_icon }}"></i> {{ $val->languages_name }}</a>
                        </li>
                        @endforeach
                        <li class="nav-item">
                            <a class="nav-link" id="setting-tab" data-toggle="tab" href="#setting-view" role="tab" aria-controls="setting" aria-selected="false"><i class="mdi mdi-settings"></i> Setting</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContentView">
                        @foreach($Language as $val)
                        <div class="tab-pane fade {{ $val->languages_type == '1' ? 'show active' : ''}}" id="{{ $val->languages_name }}-view" role="tabpanel" aria-labelledby="{{ $val->languages_name }}">
                            <div class="modal-body form-horizontal">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td width="300">
                                                        <label for="example-text-input" class="col-form-label">Knowledge Category Name</label>
                                                    </td>
                                                    <td>
                                                        <label for="example-text-input" id="show_knowledge_category_details_name_{{ $val->languages_id}}" class="col-form-label"></label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="300">
                                                        <label for="example-text-input" class="col-form-label">Knowledge Category Details</label>
                                                    </td>
                                                    <td>
                                                        <label for="example-text-input" id="show_knowledge_category_details_details_{{ $val->languages_id}}" class="col-form-label"></label>
                                                    </td>
                                                </tr>
                                                <td width="300">
                                                    <label for="example-text-input" class="col-form-label">Status</label>
                                                </td>
                                                <td>
                                                    <label for="example-text-input" id="show_knowledge_category_details_status_{{ $val->languages_id}}" class="col-form-label"></label>
                                                </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="tab-pane fade" id="setting-view" role="tabpanel" aria-labelledby="setting-tab-edit">
                            <div class="modal-body form-horizontal">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                <tr>
                                                    <td width="300">
                                                        <label for="example-text-input" class="col-form-label">Knowledge Category Tpye</label>
                                                    </td>
                                                    <td>
                                                        <label for="example-text-input" id="show_knowledge_category_type" class="col-form-label"></label>
                                                    </td>
                                                </tr>
                                                <td width="300">
                                                    <label for="example-text-input" class="col-form-label">Knowledge Category Seo Title</label>
                                                </td>
                                                <td>
                                                    <label for="example-text-input" id="show_knowledge_category_seo_title" class="col-form-label"></label>
                                                </td>
                                                </tr>
                                                <tr>
                                                    <td width="300">
                                                        <label for="example-text-input" class="col-form-label">Knowledge Category Seo Keyword</label>
                                                    </td>
                                                    <td>
                                                        <label for="example-text-input" id="show_knowledge_category_seo_keyword" class="col-form-label"></label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="300">
                                                        <label for="example-text-input" class="col-form-label">Knowledge Category Seo Description</label>
                                                    </td>
                                                    <td>
                                                        <label for="example-text-input" id="show_knowledge_category_seo_description" class="col-form-label"></label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="300">
                                                        <label for="example-text-input" class="col-form-label">Knowledge Category Status</label>
                                                    </td>
                                                    <td>
                                                        <label for="example-text-input" id="show_knowledge_category_status" class="col-form-label"></label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $(".add_knowledge_category_sub_id").hide();
        $(".edit_knowledge_category_sub_id").hide();

        var tableKnowledgeCategory = $('#tableKnowledgeCategory').dataTable({
            "ajax": {
                "url": url_gb + "/admin/KnowledgeCategory/Lists",
                "type": "POST",
                "data": function(d) {
                    d.knowledge_category_seo_title = $('#search_knowledge_category_seo_title').val();
                    d.knowledge_category_seo_keyword = $('#search_knowledge_category_seo_keyword').val();
                    d.knowledge_category_seo_description = $('#search_knowledge_category_seo_description').val();
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
                    "data": "knowledge_category_seo_title",
                    "class": "text-center"
                },
                {
                    "data": "knowledge_category_seo_description",
                    "class": "text-center",
                    "searchable": false,
                    "sortable": false,
                },
                {
                    "data": "knowledge_category_sort_order",
                    "class": "text-center",
                    "searchable": false,
                    "sortable": false,
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
            tableKnowledgeCategory.api().ajax.reload();
        });
        $('body').on('change', '.select_main_add', function(data) {
            if (this.value == 99) {
                $(".add_knowledge_category_sub_id").show();
            } else if (this.value == 0) {
                $(".add_knowledge_category_sub_id").hide();
            }
        });
        $('body').on('change', '.select_main_edit', function(data) {
            if (this.value == 99) {
                $(".edit_knowledge_category_sub_id").show();
            } else if (this.value == 0) {
                $(".edit_knowledge_category_sub_id").hide();
            }
        });

        $('body').on('click', '.btn-clear-search', function() {
            $('#search_knowledge_category_seo_title').val('');
            $('#search_knowledge_category_seo_keyword').val('');
            $('#search_knowledge_category_seo_description').val('');
            tableKnowledgeCategory.api().ajax.reload();
        });

        $('body').on('click', '.btn-add', function(data) {
            $('#add_knowledge_category_status').prop('checked', true);
            $('#ModalAdd').modal('show');
        });

        $('body').on('click', '.btn-edit', function(data) {
            var id = $(this).data('id');
            var btn = $(this);
            $('#edit_id').val(id);
            loadingButton(btn);
            $.ajax({
                method: "GET",
                url: url_gb + "/admin/KnowledgeCategory/" + id,
                data: {
                    id: id
                }
            }).done(function(res) {
                resetButton(btn);
                var data = res.content;
                $.each(data.knowledge_category_detail, function(k, v) {
                    $("#edit_knowledge_category_details_name_" + v.languages_id).val(v.knowledge_category_details_name);
                    CKEDITOR.instances['edit_event_details_description_' + v.languages_id].setData(v.knowledge_category_details_details)
                    $("#edit_knowledge_category_details_seo_title_" + v.languages_id).val(v.knowledge_category_details_seo_title);
                    if (v.knowledge_category_details_status == "1") {
                        $('#edit_knowledge_category_details_status_' + v.languages_id + '_1').prop('checked', true);
                    } else if (v.knowledge_category_details_status == "0") {
                        $('#edit_knowledge_category_details_status_' + v.languages_id + '_2').prop('checked', true);
                    }
                });
                $("#edit_knowledge_category_main_id").val(data.knowledge_category_main_id).change();
                $("#edit_knowledge_category_sub_id").val(data.knowledge_category_sub_id).change();
                $("#edit_knowledge_category_seo_title").val(data.knowledge_category_seo_title);
                $("#edit_knowledge_category_seo_keyword").val(data.knowledge_category_seo_keyword);
                $("#edit_knowledge_category_seo_description").val(data.knowledge_category_seo_description);
                $("#edit_knowledge_category_sort_order").val(data.knowledge_category_sort_order);
                if (data.knowledge_category_status == 1) {
                    $('#edit_knowledge_category_status').prop('checked', true);
                } else {
                    $('#edit_knowledge_category_status').prop('checked', false);
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
                url: url_gb + "/admin/KnowledgeCategory/" + id,
                data: {
                    id: id
                }
            }).done(function(res) {
                resetButton(btn);
                var data = res.content;
                var seo_type = '';
                var category_status = '';
                $.each(data.knowledge_category_detail, function(k, v) {
                    $("#show_knowledge_category_details_name_" + v.languages_id).text(v.knowledge_category_details_name);
                    $("#show_knowledge_category_details_details_" + v.languages_id).html(v.knowledge_category_details_details);

                    if (v.knowledge_category_details_seo_type == 1) {
                        seo_type = "ใช้ SEO หลัก";
                    } else {
                        seo_type = "ใช้ SEO ตามภาษา";
                    }
                    $("#show_knowledge_category_details_seo_type_" + v.languages_id).text(seo_type);
                    if (v.knowledge_category_details_status == 1) {
                        category_status = "Active";
                    } else {
                        category_status = "No Active";
                    }
                    $("#show_knowledge_category_details_status_" + v.languages_id).text(category_status);

                });
                var status = '';
                if (data.knowledge_category_status == 1) {
                    status = "Active";
                } else {
                    status = "No Active";
                }
                if (data.knowledge_category_main_id == 0) {
                    $('#show_knowledge_category_type').text('Main Category');
                }
                if (data.knowledge_category_main_id == 99) {
                    $('#show_knowledge_category_type').text('Sub Category');
                }
                $('#show_knowledge_category_seo_title').text(data.knowledge_category_seo_title);
                $('#show_knowledge_category_seo_keyword').text(data.knowledge_category_seo_keyword);
                $('#show_knowledge_category_seo_description').text(data.knowledge_category_seo_description);
                // $('#show_knowledge_category_url_slug').text(data.knowledge_category_url_slug);
                $('#show_knowledge_category_status').text(status);
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
                url: url_gb + "/admin/KnowledgeCategory/ChangeStatus/" + id,
                data: {
                    id: id,
                    status: status ? 1 : 0,
                }
            }).done(function(res) {
                if (res.status == 1) {
                    // swal(res.title, res.content, 'success');
                    // tableKnowledgeCategory.api().ajax.reload();
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
                url: url_gb + "/admin/KnowledgeCategory",
                data: form.serialize()
            }).done(function(res) {
                resetButton(form.find('button[type=submit]'));
                if (res.status == 1) {
                    swal(res.title, res.content, 'success');
                    form[0].reset();
                    tableKnowledgeCategory.api().ajax.reload();
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
                url: url_gb + "/admin/KnowledgeCategory/" + id,
                data: form.serialize()
            }).done(function(res) {
                resetButton(form.find('button[type=submit]'));
                if (res.status == 1) {
                    swal(res.title, res.content, 'success');
                    form[0].reset();
                    tableKnowledgeCategory.api().ajax.reload();
                    $('#ModalEdit').modal('hide');
                } else {
                    swal(res.title, res.content, 'error');
                }
            }).fail(function(res) {
                resetButton(form.find('button[type=submit]'));
                swal("โอ๊ะโอ! เกิดข้อผิดพลาด", res.content, 'error');
            });
        });
    });
</script>
@endsection
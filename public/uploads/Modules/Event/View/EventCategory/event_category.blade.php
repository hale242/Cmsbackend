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
                                <label class="control-label">Event Category</label>
                                <input type="text" id="search_event_category_seo_title" class="form-control search_table">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Keyword</label>
                                <input type="text" id="search_event_category_seo_keyword" class="form-control search_table">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Description</label>
                                <input type="text" id="search_event_category_seo_description" class="form-control search_table">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Url Slug</label>
                                <input type="text" id="search_event_category_url_slug" class="form-control search_table">
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
                    @if(App\Helper::CheckPermissionMenu('EventCategory' , '2'))
                    <button type="button" class="btn btn-primary btn-rounded m-t-10 mb-2 float-right newdata btn-add">Add New</button>
                    @endif
                </div>
                <div class="table-responsive">
                    <table id="tableEventCategory" class="table">
                        <thead>
                            <tr>
                                <!-- <th scope="col"></th> -->
                                <th scope="col">No</th>
                                <th scope="col">Event Category</th>
                                <th scope="col">Description</th>
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
                                                <label for="add_event_category_details_name" class="col-sm-3 text-right control-label col-form-label">Event Category Name</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_event_category_details_name" name="lang[{{$val->languages_id}}][event_category_details_name]" required>
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_event_category_details_details" class="col-sm-3 text-right control-label col-form-label">Event Category Detail</label>
                                                <div class="col-sm-9">
                                                    <textarea cols="60" id="add_event_details_description_{{$val->languages_id}}" rows="6" data-sample="3" data-sample-short name="lang[{{$val->languages_id}}][event_category_details_details]"></textarea>

                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_event_category_details_seo_title" class="col-sm-3 text-right control-label col-form-label">Event Category Seo Title</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_event_category_details_seo_title" name="lang[{{$val->languages_id}}][event_category_details_seo_title]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_event_category_details_seo_description" class="col-sm-3 text-right control-label col-form-label">Event Category Seo Description</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_event_category_details_seo_description" name="lang[{{$val->languages_id}}][event_category_details_seo_description]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_event_seo_keyword" class="col-sm-3 text-right control-label col-form-label">Event Category Seo Keyword</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_event_seo_keyword" name="lang[{{$val->languages_id}}][event_category_details_seo_keyword]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_event_category_details_seo_type" class="col-sm-3 text-right control-label col-form-label">Event Category Seo Type</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control select2" id="add_event_category_details_seo_type{{$val->languages_name}}" name="lang[{{$val->languages_id}}][event_category_details_seo_type]">
                                                        <option>Select Type</option>
                                                        @foreach($SeoTypes as $key=>$val)
                                                        <option value="{{ $key }}">{{ $val }}</option>
                                                        @endforeach
                                                    </select>
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
                                            <label for="" class="col-sm-3 text-right control-label col-form-label">Event Category Seo Title</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="add_event_category_seo_title" name="event_category[event_category_seo_title]">
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="" class="col-sm-3 text-right control-label col-form-label">Event Category Seo Keyword</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="add_event_category_seo_keyword" name="event_category[event_category_seo_keyword]">
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="" class="col-sm-3 text-right control-label col-form-label">Event Category Seo Description</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="add_event_category_seo_description" name="event_category[event_category_seo_description]">
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="" class="col-sm-3 text-right control-label col-form-label">Event Category Url Slug</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="add_event_category_url_slug" name="event_category[event_category_url_slug]" placeholder="https://">
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="Check-Box" class="col-sm-3 text-right control-label col-form-label">Status</label>
                                            <div class="col-sm-9">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="add_event_category_status" name="event_category[event_category_status]" value="1">
                                                    <label class="custom-control-label" for="add_event_category_status">Action</label>
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
                                                <label for="edit_event_category_details_name" class="col-sm-3 text-right control-label col-form-label">Event Category Name</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="edit_event_category_details_name_{{ $val->languages_id }}" name="lang[{{$val->languages_id}}][event_category_details_name]" required>
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="edit_event_category_details_details" class="col-sm-3 text-right control-label col-form-label">Event Category Detail</label>
                                                <div class="col-sm-9">
                                                    <textarea cols="60" id="edit_event_details_description_{{$val->languages_id}}" rows="6" data-sample="3" data-sample-short name="lang[{{$val->languages_id}}][event_category_details_details]"></textarea>

                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="edit_event_category_details_seo_title" class="col-sm-3 text-right control-label col-form-label">Event Category Seo Title</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="edit_event_category_details_seo_title_{{ $val->languages_id }}" name="lang[{{$val->languages_id}}][event_category_details_seo_title]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="edit_event_category_details_seo_description" class="col-sm-3 text-right control-label col-form-label">Event Category Seo Description</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="edit_event_category_details_seo_description_{{ $val->languages_id }}" name="lang[{{$val->languages_id}}][event_category_details_seo_description]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="edit_event_category_details_seo_keyword" class="col-sm-3 text-right control-label col-form-label">Event Category Seo Keyword</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="edit_event_category_details_seo_keyword_{{ $val->languages_id }}" name="lang[{{$val->languages_id}}][event_category_details_seo_keyword]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="edit_event_category_details_seo_type" class="col-sm-3 text-right control-label col-form-label">Event Category Seo Type</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control select2" id="edit_event_category_details_seo_type_{{ $val->languages_id }}" name="lang[{{$val->languages_id}}][event_category_details_seo_type]">
                                                        <option>Select Type</option>
                                                        @foreach($SeoTypes as $key=>$val)
                                                        <option value="{{ $key }}">{{ $val }}</option>
                                                        @endforeach
                                                    </select>
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
                                            <label for="" class="col-sm-3 text-right control-label col-form-label">Event Category Seo Title</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="edit_event_category_seo_title" name="event_category[event_category_seo_title]">
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="" class="col-sm-3 text-right control-label col-form-label">Event Category Seo Keyword</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="edit_event_category_seo_keyword" name="event_category[event_category_seo_keyword]">
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="" class="col-sm-3 text-right control-label col-form-label">Event Category Seo Description</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="edit_event_category_seo_description" name="event_category[event_category_seo_description]">
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="" class="col-sm-3 text-right control-label col-form-label">Event Category Url Slug</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="edit_event_category_url_slug" name="event_category[event_category_url_slug]">
                                            </div>
                                        </div>
                                        <div class="form-group row pb-3">
                                            <label for="Check-Box" class="col-sm-3 text-right control-label col-form-label">Status</label>
                                            <div class="col-sm-9">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="edit_event_category_status" name="event_category[event_category_status]" value="1">
                                                    <label class="custom-control-label" for="edit_event_category_status">Action</label>
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
                                                        <label for="example-text-input" class="col-form-label">Event Category Name</label>
                                                    </td>
                                                    <td>
                                                        <label for="example-text-input" id="show_event_category_details_name_{{ $val->languages_id}}" class="col-form-label"></label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="300">
                                                        <label for="example-text-input" class="col-form-label">Event Category Details</label>
                                                    </td>
                                                    <td>
                                                        <label for="example-text-input" id="show_event_category_details_details_{{ $val->languages_id}}" class="col-form-label"></label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="300">
                                                        <label for="example-text-input" class="col-form-label">Event Category Seo Title</label>
                                                    </td>
                                                    <td>
                                                        <label for="example-text-input" id="show_event_category_details_seo_title_{{ $val->languages_id}}" class="col-form-label"></label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="300">
                                                        <label for="example-text-input" class="col-form-label">Event Category Seo Keyword</label>
                                                    </td>
                                                    <td>
                                                        <label for="example-text-input" id="show_event_category_details_seo_keyword_{{ $val->languages_id}}" class="col-form-label"></label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="300">
                                                        <label for="example-text-input" class="col-form-label">Event Category Seo Description</label>
                                                    </td>
                                                    <td>
                                                        <label for="example-text-input" id="show_event_category_details_seo_description_{{ $val->languages_id}}" class="col-form-label"></label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="300">
                                                        <label for="example-text-input" class="col-form-label">Event Category Seo Type</label>
                                                    </td>
                                                    <td>
                                                        <label for="example-text-input" id="show_event_category_details_seo_type_{{ $val->languages_id}}" class="col-form-label"></label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="300">
                                                        <label for="example-text-input" class="col-form-label">Status</label>
                                                    </td>
                                                    <td>
                                                        <label for="example-text-input" id="show_event_category_details_status_{{ $val->languages_id}}" class="col-form-label"></label>
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
                                                    <td width="300">
                                                        <label for="example-text-input" class="col-form-label">Event Category Seo Title</label>
                                                    </td>
                                                    <td>
                                                        <label for="example-text-input" id="show_event_category_seo_title" class="col-form-label"></label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="300">
                                                        <label for="example-text-input" class="col-form-label">Event Category Seo Keyword</label>
                                                    </td>
                                                    <td>
                                                        <label for="example-text-input" id="show_event_category_seo_keyword" class="col-form-label"></label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="300">
                                                        <label for="example-text-input" class="col-form-label">Event Category Seo Description</label>
                                                    </td>
                                                    <td>
                                                        <label for="example-text-input" id="show_event_category_seo_description" class="col-form-label"></label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="300">
                                                        <label for="example-text-input" class="col-form-label">Event Category Seo Slug</label>
                                                    </td>
                                                    <td>
                                                        <label for="example-text-input" id="show_event_category_url_slug" class="col-form-label"></label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="300">
                                                        <label for="example-text-input" class="col-form-label">Event Category Status</label>
                                                    </td>
                                                    <td>
                                                        <label for="example-text-input" id="show_event_category_status" class="col-form-label"></label>
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
    var tableEventCategory = $('#tableEventCategory').dataTable({
        "ajax": {
            "url": url_gb + "/admin/EventCategory/Lists",
            "data": function(d) {
                d.event_category_seo_title = $('#search_event_category_seo_title').val();
                d.event_category_seo_keyword = $('#search_event_category_seo_keyword').val();
                d.event_category_seo_description = $('#search_event_category_seo_description').val();
                d.event_category_url_slug = $('#search_event_category_url_slug').val();

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
                "data": "event_category_seo_title",
                "class": "text-center"
            },
            {
                "data": "event_category_seo_description",
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
        tableEventCategory.api().ajax.reload();
    });

    $('body').on('click', '.btn-clear-search', function() {
        $('#search_event_category_seo_title').val('');
        $('#search_event_category_seo_keyword').val('');
        $('#search_event_category_seo_description').val('');
        $('#search_event_category_url_slug').val('');
        tableEventCategory.api().ajax.reload();
    });

    $('body').on('click', '.btn-add', function(data) {
        $('#add_event_category_status').prop('checked', true);
        $('#ModalAdd').modal('show');
    });

    $('body').on('click', '.btn-edit', function(data) {
        var id = $(this).data('id');
        var btn = $(this);
        $('#edit_id').val(id);
        loadingButton(btn);
        $.ajax({
            method: "GET",
            url: url_gb + "/admin/EventCategory/" + id,
            data: {
                id: id
            }
        }).done(function(res) {
            resetButton(btn);
            var data = res.content;
            $.each(data.event_category_detail, function(k, v) {
                $("#edit_event_category_details_name_" + v.languages_id).val(v.event_category_details_name);
                CKEDITOR.instances['edit_event_details_description_' + v.languages_id].setData(v.event_category_details_details)
                $("#edit_event_category_details_seo_title_" + v.languages_id).val(v.event_category_details_seo_title);
                $("#edit_event_category_details_seo_description_" + v.languages_id).val(v.event_category_details_seo_description);
                $("#edit_event_category_details_seo_keyword_" + v.languages_id).val(v.event_category_details_seo_keyword);
                $("#edit_event_category_details_seo_type_" + v.languages_id).val(v.event_category_details_seo_type).change();
            });
            $("#edit_event_category_seo_title").val(data.event_category_seo_title);
            $("#edit_event_category_seo_keyword").val(data.event_category_seo_keyword);
            $("#edit_event_category_seo_description").val(data.event_category_seo_description);
            $("#edit_event_category_url_slug").val(data.event_category_url_slug);
            if (data.event_category_status == 1) {
                $('#edit_event_category_status').prop('checked', true);
            } else {
                $('#edit_event_category_status').prop('checked', false);
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
            url: url_gb + "/admin/EventCategory/" + id,
            data: {
                id: id
            }
        }).done(function(res) {
            resetButton(btn);
            var data = res.content;
            var seo_type = '';
            var category_status = '';
            $.each(data.event_category_detail, function(k, v) {
                $("#show_event_category_details_name_" + v.languages_id).text(v.event_category_details_name);
                $("#show_event_category_details_details_" + v.languages_id).html(v.event_category_details_details);
                $("#show_event_category_details_seo_title_" + v.languages_id).text(v.event_category_details_seo_title);
                $("#show_event_category_details_seo_keyword_" + v.languages_id).text(v.event_category_details_seo_keyword);
                $("#show_event_category_details_seo_description_" + v.languages_id).text(v.event_category_details_seo_description);
                if (v.event_category_details_seo_type == 1) {
                    seo_type = "ใช้ SEO หลัก";
                } else {
                    seo_type = "ใช้ SEO ตามภาษา";
                }
                $("#show_event_category_details_seo_type_" + v.languages_id).text(seo_type);
                if (v.event_category_details_status == 1) {
                    category_status = "Active";
                } else {
                    category_status = "No Active";
                }
                $("#show_event_category_details_status_" + v.languages_id).text(category_status);

            });
            var status = '';
            if (data.event_category_status == 1) {
                status = "Active";
            } else {
                status = "No Active";
            }
            $('#show_event_category_seo_title').text(data.event_category_seo_title);
            $('#show_event_category_seo_keyword').text(data.event_category_seo_keyword);
            $('#show_event_category_seo_description').text(data.event_category_seo_description);
            $('#show_event_category_url_slug').text(data.event_category_url_slug);
            $('#show_event_category_status').text(status);
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
            url: url_gb + "/admin/EventCategory/ChangeStatus/" + id,
            data: {
                id: id,
                status: status ? 1 : 0,
            }
        }).done(function(res) {
            if (res.status == 1) {
                // swal(res.title, res.content, 'success');
                // tableEventCategory.api().ajax.reload();
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
            url: url_gb + "/admin/EventCategory",
            data: form.serialize()
        }).done(function(res) {
            resetButton(form.find('button[type=submit]'));
            if (res.status == 1) {
                swal(res.title, res.content, 'success');
                form[0].reset();
                tableEventCategory.api().ajax.reload();
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
            url: url_gb + "/admin/EventCategory/" + id,
            data: form.serialize()
        }).done(function(res) {
            resetButton(form.find('button[type=submit]'));
            if (res.status == 1) {
                swal(res.title, res.content, 'success');
                form[0].reset();
                tableEventCategory.api().ajax.reload();
                $('#ModalEdit').modal('hide');
            } else {
                swal(res.title, res.content, 'error');
            }
        }).fail(function(res) {
            resetButton(form.find('button[type=submit]'));
            swal("โอ๊ะโอ! เกิดข้อผิดพลาด", res.content, 'error');
        });
    });
</script>
@endsection
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
                                <input type="text" id="search_event_category_details_name" class="form-control search_table">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Keyword</label>
                                <input type="text" id="search_event_category_details_seo_keyword" class="form-control search_table">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Detail</label>
                                <input type="text" id="search_event_category_details_details" class="form-control search_table">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Description</label>
                                <input type="text" id="search_event_category_details_seo_description" class="form-control search_table">
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
                    @if(App\Helper::CheckPermissionMenu('EventCategoryDetail' , '2'))
                    <button type="button" class="btn btn-primary btn-rounded m-t-10 mb-2 float-right newdata btn-add">Add New</button>
                    @endif
                </div>
                <div class="table-responsive">
                    <table id="tableEventCategoryDetail" class="table">
                        <thead>
                            <tr>
                                <!-- <th scope="col"></th> -->
                                <th scope="col">No</th>
                                <th scope="col">Event Category</th>
                                <th scope="col">Event Category Language</th>
                                <th scope="col">Event Category Detail</th>
                                <th scope="col">Event Category Detail Description</th>
                                <th scope="col">Event Category Detail Type</th>
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
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="mdi mdi-close"></i></span></button>
            </div>
            <form id="FormAdd" class="needs-validation" novalidate>
                <div class="card">
                    <div class="form-body">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label for="add_event_category_id">Event Category</label>
                                    <select class="form-control select2" id="add_event_category_id" name="event_category_id">
                                        <option>Select Event Category</option>
                                        @foreach($EventCategory as $val)
                                        <option value="{{ $val->event_category_id }}">{{ $val->event_category_seo_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="add_languages_id">Language</label>
                                    <select class="form-control select2" id="add_languages_id" name="languages_id">
                                        <option>Select Language</option>
                                        @foreach($Languages as $val)
                                        <option value="{{ $val->languages_id }}">{{ $val->languages_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="add_event_category_details_name">Event Category Detail Name</label>
                                    <input type="text" class="form-control" id="add_event_category_details_name" name="event_category_details_name" placeholder="" value="" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="add_event_category_details_details">Event Category Detail</label>
                                    <input type="text" class="form-control" id="add_event_category_details_details" name="event_category_details_details" placeholder="" value="" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="add_event_category_details_seo_title">Event Category Detail Title</label>
                                    <input type="text" class="form-control" id="add_event_category_details_seo_title" name="event_category_details_seo_title" placeholder="" value="" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="add_event_category_details_seo_keyword">Event Category Detail Keyword</label>
                                    <input type="text" class="form-control" id="add_event_category_details_seo_keyword" name="event_category_details_seo_keyword"></input>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="add_event_category_details_seo_description">Event Category Detail Description</label>
                                    <textarea cols="80" class="form-control" id="add_event_category_details_seo_description" name="event_category_details_seo_description" rows="3"></textarea>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="add_event_category_details_seo_type">Event Category Detail Type</label>
                                    <select class="form-control select2" id="add_event_category_details_seo_type" name="event_category_details_seo_type">
                                        <option>Select Type</option>
                                        @foreach($SeoTypes as $key=>$val)
                                        <option value="{{ $key }}">{{ $val }}</option>
                                        @endforeach
                                    </select> </div>
                                <div class="col-md-12 mb-3">
                                    <label for="Check-Box">Status</label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="add_event_category_details_status" name="event_category_details_status" value="1">
                                        <label class="custom-control-label" for="add_event_category_details_status">Action</label>
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
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="mdi mdi-close"></i></span></button>
            </div>
            <form id="FormEdit" class="needs-validation" novalidate>
                <input type="hidden" id="edit_id">
                <div class="card">
                    <div class="form-body">
                        <div class="card-body">
                            <div class="form-row">
                            <div class="col-md-12 mb-3">
                                    <label for="edit_event_category_id">Event Category</label>
                                    <select class="form-control select2" id="edit_event_category_id" name="event_category_id">
                                        <option>Select Event Category</option>
                                        @foreach($EventCategory as $val)
                                        <option value="{{ $val->event_category_id }}">{{ $val->event_category_seo_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="edit_languages_id">Language</label>
                                    <select class="form-control select2" id="edit_languages_id" name="languages_id">
                                        <option>Select Language</option>
                                        @foreach($Languages as $val)
                                        <option value="{{ $val->languages_id }}">{{ $val->languages_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="edit_event_category_details_name">Event Category Detail Name</label>
                                    <input type="text" class="form-control" id="edit_event_category_details_name" name="event_category_details_name" placeholder="" value="" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="edit_event_category_details_details">Event Category Detail</label>
                                    <input type="text" class="form-control" id="edit_event_category_details_details" name="event_category_details_details" placeholder="" value="" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="edit_event_category_details_seo_title">Event Category Detail Title</label>
                                    <input type="text" class="form-control" id="edit_event_category_details_seo_title" name="event_category_details_seo_title" placeholder="" value="" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="edit_event_category_details_seo_keyword">Event Category Detail Keyword</label>
                                    <input type="text" class="form-control" id="edit_event_category_details_seo_keyword" name="event_category_details_seo_keyword"></input>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="edit_event_category_details_seo_description">Event Category Detail Description</label>
                                    <textarea cols="80" class="form-control" id="edit_event_category_details_seo_description" name="event_category_details_seo_description" rows="3"></textarea>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="edit_event_category_details_seo_type">Event Category Detail Type</label>
                                    <select class="form-control select2" id="edit_event_category_details_seo_type" name="event_category_details_seo_type">
                                        <option>Select Type</option>
                                        @foreach($SeoTypes as $key=>$val)
                                        <option value="{{ $key }}">{{ $val }}</option>
                                        @endforeach
                                    </select> </div>
                                <div class="col-md-12 mb-3">
                                    <label for="Check-Box">Status</label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="edit_event_category_details_status" name="event_category_details_status" value="1">
                                        <label class="custom-control-label" for="edit_event_category_details_status">Action</label>
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
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">View</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="mdi mdi-close"></i></span></button>
            </div>
            <div class="modal-body form-horizontal">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Event Category</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_event_category_id" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Language</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_languages_id" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Event Category Detail Name</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_event_category_details_name" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Event Category Detail</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_event_category_details_details" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Event Category Detail Title</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_event_category_details_seo_title" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Event Category Detail Keyword</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_event_category_details_seo_keyword" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Event Category Detail Description</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_event_category_details_seo_description" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Event Category Detail Type</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_event_category_details_seo_type" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Status</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_event_category_details_status" class="col-form-label"></label>
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
@endsection
@section('scripts')
<script>
    var tableEventCategoryDetail = $('#tableEventCategoryDetail').dataTable({
        "ajax": {
            "url": url_gb + "/admin/EventCategoryDetail/Lists",
            "data": function(d) {
                d.event_category_details_name = $('#search_event_category_details_name').val();
                d.event_category_details_seo_keyword = $('#search_event_category_details_seo_keyword').val();
                d.event_category_details_seo_description = $('#search_event_category_details_seo_description').val();
                d.event_category_details_details = $('#search_event_category_details_details').val();

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
                "data": "event_category_id",
                "class": "text-center"
            },
            {
                "data": "language.languages_name",
                "class": "text-center"
            },
            {
                "data": "event_category_details_name",
                "class": "text-center"
            },
            {
                "data": "event_category_details_seo_description",
                "class": "text-center",
                "searchable": false,
                "sortable": false,
            },
            {
                "data": "event_category_details_seo_type",
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
        tableEventCategoryDetail.api().ajax.reload();
    });

    $('body').on('click', '.btn-clear-search', function() {
        $('#search_event_category_details_name').val('');
        $('#search_event_category_details_seo_keyword').val('');
        $('#search_event_category_details_details').val('');
        $('#search_event_category_details_seo_description').val('');
        tableEventCategoryDetail.api().ajax.reload();
    });

    $('body').on('click', '.btn-add', function(data) {
        $('#add_event_category_details_status').prop('checked', true);
        $('#ModalAdd').modal('show');
    });

    $('body').on('click', '.btn-edit', function(data) {
        var id = $(this).data('id');
        var btn = $(this);
        $('#edit_id').val(id);
        loadingButton(btn);
        $.ajax({
            method: "GET",
            url: url_gb + "/admin/EventCategoryDetail/" + id,
            data: {
                id: id
            }
        }).done(function(res) {
            resetButton(btn);
            var data = res.content;
            $("#edit_event_category_id").val(data.event_category_id).change();
            $("#edit_languages_id").val(data.languages_id).change();
            $("#edit_event_category_details_name").val(data.event_category_details_name);
            $("#edit_event_category_details_details").val(data.event_category_details_details);
            $("#edit_event_category_details_seo_title").val(data.event_category_details_seo_title);
            $("#edit_event_category_details_seo_keyword").val(data.event_category_details_seo_keyword);
            $("#edit_event_category_details_seo_description").val(data.event_category_details_seo_description);
            $("#edit_event_category_details_seo_type").val(data.event_category_details_seo_type).change();
            if (data.event_category_details_status == 1) {
                $('#edit_event_category_details_status').prop('checked', true);
            } else {
                $('#edit_event_category_details_status').prop('checked', false);
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
            url: url_gb + "/admin/EventCategoryDetail/" + id,
            data: {
                id: id
            }
        }).done(function(res) {
            resetButton(btn);
            var data = res.content;
            var status = '';
            var type = '';
            if (data.event_category_details_status == 1) {
                status = "Active";
            } else {
                status = "No Active";
            }
            if (data.event_category_details_seo_type == 1) {
                type = "ใช้ SEO ตามภาษา";
            } else {
                type = "ใช้ SEO หลัก";
            }
            $("#show_event_category_id").text(data.event_category.event_category_seo_title);
            $("#show_languages_id").text(data.language.languages_name);
            $("#show_event_category_details_name").text(data.event_category_details_name);
            $("#show_event_category_details_details").text(data.event_category_details_details);
            $("#show_event_category_details_seo_title").text(data.event_category_details_seo_title);
            $("#show_event_category_details_seo_keyword").text(data.event_category_details_seo_keyword);
            $("#show_event_category_details_seo_description").text(data.event_category_details_seo_description);
            $("#show_event_category_details_seo_type").text(type);
            $('#show_event_category_details_status').text(status);
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
            url: url_gb + "/admin/EventCategoryDetail/ChangeStatus/" + id,
            data: {
                id: id,
                status: status ? 1 : 0,
            }
        }).done(function(res) {
            if (res.status == 1) {
                // swal(res.title, res.content, 'success');
                // tableEventCategoryDetail.api().ajax.reload();
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
            url: url_gb + "/admin/EventCategoryDetail",
            data: form.serialize()
        }).done(function(res) {
            resetButton(form.find('button[type=submit]'));
            if (res.status == 1) {
                swal(res.title, res.content, 'success');
                form[0].reset();
                tableEventCategoryDetail.api().ajax.reload();
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
            url: url_gb + "/admin/EventCategoryDetail/" + id,
            data: form.serialize()
        }).done(function(res) {
            resetButton(form.find('button[type=submit]'));
            if (res.status == 1) {
                swal(res.title, res.content, 'success');
                form[0].reset();
                tableEventCategoryDetail.api().ajax.reload();
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
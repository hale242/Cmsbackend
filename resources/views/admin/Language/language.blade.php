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
                                <label class="control-label">Language</label>
                                <input type="text" id="search_languages_name" class="form-control search_table">
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
                    @if(App\Helper::CheckPermissionMenu('Language' , '2'))
                    <button type="button" class="btn btn-primary btn-rounded m-t-10 mb-2 float-right newdata btn-add">Add New</button>
                    @endif
                </div>
                <div class="table-responsive">
                    <table id="tableLanguage" class="table">
                        <thead>
                            <tr>
                                <!-- <th scope="col"></th> -->
                                <th scope="col">No</th>
                                <th scope="col">Language</th>
                                <th scope="col">Language Icon</th>
                                <th scope="col">language Type</th>
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
                                    <label for="languages_name">Language</label>
                                    <input type="text" class="form-control" id="add_languages_name" name="languages_name" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="languages_code">Language Code</label>
                                    <input type="text" class="form-control" id="add_languages_code" name="languages_code">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="languages_icon">Language Icon</label>
                                    <!-- <select class="form-control select2" name="languages_icon">
                                        @foreach($languages_icons as $key=>$val)
                                        <option value="{{$key}}">{{$val}}</option>
                                        @endforeach
                                    </select> -->
                                    <!-- <input type="text" class="form-control" id="add_languages_icon" name="languages_icon" required> -->
                                    <select class="form-control select2 template-with-flag-icons" name="languages_icon">
                                        <option>Select Icon</option>
                                        @foreach($languages_icons as $key=>$val)
                                        <option data-flag="{{$key}}" value="{{$key}}"> {{$val}}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="languages_ordering">Language Ordering</label>
                                    <input type="number" class="form-control" id="add_languages_ordering" name="languages_ordering">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="languages_type">Language Type</label>
                                    <select class="form-control select2" id="add_languages_type" name="languages_type">
                                        <option value="">Select Type</option>
                                        @foreach($languages_types as $key=>$val)
                                        <option value="{{$key}}">{{$val}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="Check-Box">Status</label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="add_languages_status" name="languages_status" value="1">
                                        <label class="custom-control-label" for="add_languages_status">Action</label>
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
                                    <label for="languages_name">Language</label>
                                    <input type="text" class="form-control" id="edit_languages_name" name="languages_name" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="languages_code">Language Code</label>
                                    <input type="text" class="form-control" id="edit_languages_code" name="languages_code">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="languages_icon">Language Icon</label>
                                    <select class="form-control select2 template-with-flag-icons" id="edit_languages_icon" name="languages_icon">
                                        <option>Select Icon</option>
                                        @foreach($languages_icons as $key=>$val)
                                        <option data-flag="{{$key}}" value="{{$key}}"> {{$val}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="languages_ordering">Language Ordering</label>
                                    <input type="number" class="form-control" id="edit_languages_ordering" name="languages_ordering">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="languages_type">Language Type</label>
                                    <select class="form-control select2" id="edit_languages_type" name="languages_type">
                                        <option value="">Select Type</option>
                                        @foreach($languages_types as $key=>$val)
                                        <option value="{{$key}}">{{$val}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3 form_languages_status">
                                    <label for="Check-Box">Status</label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="edit_languages_status" name="languages_status" value="1">
                                        <label class="custom-control-label" for="edit_languages_status">Action</label>
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
                                        <label for="example-text-input" class="col-form-label">Language</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_languages_name" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Language Code</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_languages_code" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Language Icon</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_languages_icon" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Language Ordering</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_languages_ordering" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Language Type</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_languages_type" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Status</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_languages_status" class="col-form-label"></label>
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
    $(document).ready(function() {
        var tableLanguage = $('#tableLanguage').dataTable({
            "ajax": {
                "url": url_gb + "/admin/Language/Lists",
                "type": "POST",
                "data": function(d) {
                    d.languages_name = $('#search_languages_name').val();
                    d.languages_code = $('#search_languages_code').val();
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
                    "data": "languages_name",
                    "class": "text-center"
                },
                {
                    "data": "languages_icon",
                    "class": "text-center",
                    "searchable": false,
                    "sortable": false,
                },
                {
                    "data": "languages_type",
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
            tableLanguage.api().ajax.reload();
        });

        $('body').on('click', '.btn-clear-search', function() {
            $('#search_languages_name').val('');
            $('#search_languages_code').val('');
            tableLanguage.api().ajax.reload();
        });

        $('body').on('click', '.btn-add', function(data) {
            $('#add_languages_status').prop('checked', true);
            $('#ModalAdd').modal('show');
        });

        $('body').on('click', '.btn-edit', function(data) {
            var id = $(this).data('id');
            var btn = $(this);
            $('#edit_id').val(id);
            loadingButton(btn);
            $.ajax({
                method: "GET",
                url: url_gb + "/admin/Language/" + id,
                data: {
                    id: id
                }
            }).done(function(res) {
                resetButton(btn);
                var data = res.content;
                $("#edit_languages_name").val(data.languages_name);
                $("#edit_languages_code").val(data.languages_code);
                $("#edit_languages_icon").val(data.languages_icon).change();
                $("#edit_languages_ordering").val(data.languages_ordering);
                $("#edit_languages_type").val(data.languages_type).change();
                if (data.languages_status == 1) {
                    $('#edit_languages_status').prop('checked', true);
                } else {
                    $('#edit_languages_status').prop('checked', false);
                }
                if (data.languages_type == 1) {
                    $('.form_languages_status').hide();
                } else {
                    $('.form_languages_status').show();
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
                url: url_gb + "/admin/Language/" + id,
                data: {
                    id: id
                }
            }).done(function(res) {
                resetButton(btn);
                var data = res.content;
                var status = '';
                if (data.languages_status == 1) {
                    status = "Active";
                } else {
                    status = "No Active";
                }
                $("#show_languages_name").text(data.languages_name);
                $("#show_languages_code").text(data.languages_code);
                $("#show_languages_icon").text(data.languages_icon);
                $("#show_languages_ordering").text(data.languages_ordering);
                $("#show_languages_type").text(data.languages_type);
                $('#show_languages_status').text(status);
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
                url: url_gb + "/admin/Language/ChangeStatus/" + id,
                data: {
                    id: id,
                    status: status ? 1 : 0,
                }
            }).done(function(res) {
                if (res.status == 1) {
                    // swal(res.title, res.content, 'success');
                    // tableLanguage.api().ajax.reload();
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
                url: url_gb + "/admin/Language",
                data: form.serialize()
            }).done(function(res) {
                resetButton(form.find('button[type=submit]'));
                if (res.status == 1) {
                    swal(res.title, res.content, 'success');
                    form[0].reset();
                    tableLanguage.api().ajax.reload();
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
                url: url_gb + "/admin/Language/" + id,
                data: form.serialize()
            }).done(function(res) {
                resetButton(form.find('button[type=submit]'));
                if (res.status == 1) {
                    swal(res.title, res.content, 'success');
                    form[0].reset();
                    tableLanguage.api().ajax.reload();
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
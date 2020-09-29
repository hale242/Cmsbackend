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
                                <label class="control-label">Menu Name</label>
                                <input type="text" id="search_menu_system_name" class="form-control search_table">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Main Menu</label>
                                <select class="form-control select2" id="search_menu_system_main_menu" name="menu_system_main_menu">
                                    <option value="">Select Main Menu</option>
                                    @foreach( $MenuSystems as $val)
                                    <option value="{{ $val->menu_system_id }}">{{ $val->menu_system_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Sub Menu</label>
                                <select class="form-control select2" id="search_menu_system_sub_menu" name="menu_system_main_menu">
                                    <option value="">Select Sub Menu</option>
                                    @foreach( $MenuSystems as $val)
                                    <option value="{{ $val->menu_system_id }}">{{ $val->menu_system_name }}</option>
                                    @endforeach
                                </select>
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
                    @if(App\Helper::CheckPermissionMenu('MenuSetting' , '2'))
                    <button type="button" class="btn btn-primary btn-rounded m-t-10 mb-2 float-right newdata btn-add">Add New</button>
                    @endif
                </div>
                <div class="table-responsive">
                    <table id="tableMenuSetting" class="table">
                        <thead>
                            <tr>
                                <!-- <th scope="col"></th> -->
                                <th scope="col">No</th>
                                <th scope="col">Menu System</th>
                                <th scope="col">Menu Part</th>
                                <th scope="col">Menu Type</th>
                                <th scope="col">z-index</th>
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
    <div class="modal-dialog modal-ml" role="document">
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
                                    <label for="menu_system_name">Menu System</label>
                                    <input type="text" class="form-control" id="add_menu_system_name" name="menu_system_name" placeholder="" value="" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="add_menu_system_part">Part</label>
                                    <input cols="80" class="form-control" id="add_menu_system_part" name="menu_system_part">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="add_menu_system_icon">Icon</label>
                                    <input cols="80" class="form-control" id="add_menu_system_icon" name="menu_system_icon">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="menu_system_details">Main Menu</label>
                                    <select class="form-control select2" id="add_menu_system_main_menu" name="menu_system_main_menu" required>
                                        <option value="">Select Main Menu</option>
                                        <option value="">Main Menu</option>
                                        <optgroup label="Sub Menu">
                                            @foreach( $MenuSystems as $val)
                                            <option value="{{ $val->menu_system_id }}">{{ $val->menu_system_name }}</option>
                                            @endforeach
                                        <optgroup>
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="add_menu_system_z_index">Z-index</label>
                                    <input type="number" class="form-control" id="add_menu_system_z_index" name="menu_system_z_index">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="Check-Box">Status</label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="add_menu_system_status" name="menu_system_status" value="1">
                                        <label class="custom-control-label" for="add_menu_system_status">Action</label>
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
                                    <label for="edit_menu_system_name">Menu System</label>
                                    <input type="text" class="form-control" id="edit_menu_system_name" name="menu_system_name" placeholder="" value="" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="edit_menu_system_part">Part</label>
                                    <input cols="80" class="form-control" id="edit_menu_system_part" name="menu_system_part">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="edit_menu_system_icon">Icon</label>
                                    <input cols="80" class="form-control" id="edit_menu_system_icon" name="menu_system_icon">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="edit_menu_system_main_menu">Main Menu</label>
                                    <select class="form-control select2" id="edit_menu_system_main_menu" name="menu_system_main_menu" required="">
                                        <option>Select Main Menu</option>
                                        <option value="">Main Menu</option>
                                        <optgroup label="Sub Menu">
                                            @foreach( $MenuSystems as $val)
                                            <option value="{{ $val->menu_system_id }}">{{ $val->menu_system_name }}</option>
                                            @endforeach
                                        <optgroup>
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="edit_menu_system_z_index">Z-index</label>
                                    <input type="number" class="form-control" id="edit_menu_system_z_index" name="menu_system_z_index">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="Check-Box">Status</label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="edit_menu_system_status" name="menu_system_status" value="1">
                                        <label class="custom-control-label" for="edit_menu_system_status">Action</label>
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
                                        <label for="example-text-input" class="col-form-label">Menu System</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_menu_system_name" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Details</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_menu_system_details" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Status</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_menu_system_status" class="col-form-label"></label>
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
        var tableMenuSetting = $('#tableMenuSetting').dataTable({
            "ajax": {
                "url": url_gb + "/admin/MenuSetting/Lists",
                "type": "POST",
                "data": function(d) {
                    d.menu_system_name = $('#search_menu_system_name').val();
                    d.menu_system_main_menu = $('#search_menu_system_main_menu').val();
                    d.menu_system_sub_menu = $('#search_menu_system_sub_menu').val();
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
                    "class": "text-center"
                },
                {
                    "data": "menu_system_name",
                    "searchable": false,
                    "sortable": false
                },
                {
                    "data": "menu_system_part",
                    "searchable": false,
                    "sortable": false
                },
                {
                    "data": "menu_system_type",
                    "searchable": false,
                    "sortable": false
                },
                {
                    "data": "menu_system_z_index",
                    "searchable": false,
                    "sortable": false
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
                visible: false,
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
            tableMenuSetting.api().ajax.reload();
        });

        $('body').on('click', '.btn-clear-search', function() {
            $('#search_menu_system_name').val();
            $('#search_menu_system_main_menu').val('').change();
            $('#search_menu_system_sub_menu').val('').change();
            tableMenuSetting.api().ajax.reload();
        });

        $('body').on('click', '.btn-add', function(data) {
            $('#add_menu_system_status').prop('checked', true);
            $('#ModalAdd').modal('show');
        });

        $('body').on('click', '.btn-edit', function(data) {
            var id = $(this).data('id');
            var btn = $(this);
            $('#edit_id').val(id);
            loadingButton(btn);
            $.ajax({
                method: "GET",
                url: url_gb + "/admin/MenuSetting/" + id,
                data: {
                    id: id
                }
            }).done(function(res) {
                resetButton(btn);
                var data = res.content;
                $("#edit_menu_system_name").val(data.menu_system_name);
                $("#edit_menu_system_part").val(data.menu_system_part);
                $("#edit_menu_system_icon").val(data.menu_system_icon);
                $("#edit_menu_system_main_menu").val(data.menu_system_main_menu).change();
                $("#edit_menu_system_z_index").val(data.menu_system_z_index);

                if (data.menu_system_status == 1) {
                    $('#edit_menu_system_status').prop('checked', true);
                } else {
                    $('#edit_menu_system_status').prop('checked', false);
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
                url: url_gb + "/admin/MenuSetting/" + id,
                data: {
                    id: id
                }
            }).done(function(res) {
                resetButton(btn);
                var data = res.content;
                var status = '';
                if (data.menu_system_status == 1) {
                    status = "Active";
                } else {
                    status = "No Active";
                }
                $('#show_menu_system_name').text(data.menu_system_name);
                $('#show_menu_system_details').text(data.menu_system_details);
                $('#show_menu_system_status').text(status);
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
                url: url_gb + "/admin/MenuSetting/ChangeStatus/" + id,
                data: {
                    id: id,
                    status: status ? 1 : 0,
                }
            }).done(function(res) {
                if (res.status == 1) {
                    // swal(res.title, res.content, 'success');
                    // tableMenuSetting.api().ajax.reload();
                } else {
                    swal(res.title, res.content, 'error');
                }
            }).fail(function(res) {
                swal("โอ๊ะโอ! เกิดข้อผิดพลาด", res.content, 'error');
            });
        });
        $('body').on('click', '.btn-delete', function(data) {
            var id = $(this).data('id');
            swal({
                    title: "Are you sure ?",
                    icon: "warning",
                    buttons: true,
                })
                .then((ConfirmDelete) => {
                    if (ConfirmDelete) {
                        $.ajax({
                            method: "POST",
                            url: url_gb + "/admin/MenuSetting/Delete/" + id,
                            data: {
                                id: id,
                            }
                        }).done(function(res) {
                            if (res.status == 1) {
                                swal(res.title, res.content, 'success');
                                tableMenuSetting.api().ajax.reload();
                            } else {
                                swal(res.title, res.content, 'error');
                            }
                        }).fail(function(res) {
                            swal("โอ๊ะโอ! เกิดข้อผิดพลาด", res.content, 'error');
                        });
                    }
                });

        });

        $('body').on('submit', '#FormAdd', function(e) {
            e.preventDefault();
            var form = $(this);
            loadingButton(form.find('button[type=submit]'));
            $.ajax({
                method: "POST",
                url: url_gb + "/admin/MenuSetting",
                data: form.serialize()
            }).done(function(res) {
                resetButton(form.find('button[type=submit]'));
                if (res.status == 1) {
                    swal(res.title, res.content, 'success');
                    form[0].reset();
                    tableMenuSetting.api().ajax.reload();
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
                url: url_gb + "/admin/MenuSetting/" + id,
                data: form.serialize()
            }).done(function(res) {
                resetButton(form.find('button[type=submit]'));
                if (res.status == 1) {
                    swal(res.title, res.content, 'success');
                    form[0].reset();
                    tableMenuSetting.api().ajax.reload();
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
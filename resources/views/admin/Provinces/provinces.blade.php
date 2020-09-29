@extends('layouts.layout')@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Search</h4>
        <form id="FormSearch">
            <div class="row pt-3">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label">Geography</label>
                        <select class="form-control custom-select select2" name="geo_id" id="search_geo_id" data-placeholder="" tabindex="1">
                            <option value="">เลือกภาค</option>
                            @foreach ($Geography as $val)
                            <option value="{{ $val->geo_id }}">{{ $val->geo_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label">Provinces Code</label>
                        <input type="text" id="search_provinces_code" name="provinces_code" class="form-control search_table" placeholder="">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label">Provinces Name</label>
                        <input type="text" id="search_provinces_name" name="provinces_name" class="form-control search_table" placeholder="">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-success btn-search"><i class="ti-search"></i> Search</button>
        <button type="button" class="btn btn-secondary clear-search btn-clear-search">Clear</button>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="material-card card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{$MainMenus->menu_system_name}}</h4>
                    @if(App\Helper::CheckPermissionMenu('Provinces' , '2'))
                    <button type="button" class="btn btn-primary btn-rounded m-t-10 mb-2 float-right newdata btn-add">Add New</button>
                    @endif
                </div>
                <div class="table-responsive">
                    <table id="tableProvinces" class="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Provinces Name</th>
                                <th scope="col">Provinces Code</th>
                                <th scope="col">Geography</th>
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
            <form id="FormAdd">
                <div class="card">
                    <div class="form-body">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label for="geo_id">Geography</label>
                                    <br>
                                    <select class="form-control select2" id="geo_id" name="geo_id" required>
                                        <option value="">เลือกภาค</option>
                                        @foreach ($Geography as $val)
                                        <option value="{{ $val->geo_id }}">{{ $val->geo_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="provinces_code">Provinces Code</label>
                                    <input type="text" class="form-control" id="add_provinces_code" name="provinces_code" placeholder="" value="">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="provinces_name">Provinces Name</label>
                                    <input type="text" class="form-control" id="add_provinces_name" name="provinces_name" placeholder="" value="" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="Check-Box">Status</label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="add_provinces_status" name="provinces_status" value="1" checked>
                                        <label class="custom-control-label" for="add_provinces_status">Action</label>
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
            <form id="FormEdit">
                <input type="hidden" id="edit_id">
                <div class="card">
                    <div class="form-body">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label class="control-label" for="edit_geo_id">Geography</label><br>
                                    <select class="form-control select2" name="geo_id" id="edit_geo_id" data-placeholder="Select Geo">
                                        <option value="">----Select----</option>
                                        @foreach ($Geography as $val)
                                        <option value="{{ $val->geo_id }}">{{ $val->geo_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="provinces_code">Provinces Code</label>
                                    <input type="text" class="form-control" id="edit_provinces_code" name="provinces_code" placeholder="" value="" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="provinces_name">Provinces Name</label>
                                    <input type="text" class="form-control" id="edit_provinces_name" name="provinces_name" placeholder="" value="" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="Check-Box">Status</label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="edit_provinces_status" name="provinces_status" value="1">
                                        <label class="custom-control-label" for="edit_provinces_status">Action</label>
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
                                        <label for="example-text-input" class="col-form-label">Geography</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_geo_name" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Provinces Code</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_provinces_code" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Provinces Name</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_provinces_name" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Status</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_provinces_status" class="col-form-label"></label>
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

<div class="modal fade show" id="ModalAmphures" tabindex="-1" role="dialog" aria-labelledby="myModalLabelview" aria-modal="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Amphures</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="mdi mdi-close"></i></span></button>

            </div>
            <div class="modal-body form-horizontal">
                <div id="Table_Amphures">

                </div>


            </div>
        </div>
    </div>
</div>
<div class="modal fade show" id="ModalDistricts" tabindex="-1" role="dialog" aria-labelledby="myModalLabelview" aria-modal="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Districts</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="mdi mdi-close"></i></span></button>

            </div>
            <div class="modal-body form-horizontal">
                <div id="Table_Districts">

                </div>


            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        var tableProvinces = $('#tableProvinces').dataTable({
            "ajax": {
                "url": url_gb + "/admin/Provinces/Lists",
                "type": "POST",
                "data": function(d) {
                    d.geo_id = $('#search_geo_id').val(),
                        d.provinces_code = $('#search_provinces_code').val(),
                        d.provinces_name = $('#search_provinces_name').val()
                }
            },
            "drawCallback": function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
                $(".change-status").bootstrapToggle();
            },
            "retrieve": true,
            "columns": [{
                    "data": "DT_RowIndex",
                    "class": "text-center",
                    "searchable": false,
                    "sortable": false,
                },
                {
                    "data": "provinces_name",
                    "class": "text-center"
                },
                {
                    "data": "provinces_code",
                    "class": "text-center"
                },
                {
                    "data": "geo_name",
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

        $('body').on('click', '.btn-add', function(data) {
            $('#ModalAdd').modal('show');
        });

        $('body').on('click', '.btn-edit', function(data) {
            var id = $(this).data('id');
            var btn = $(this);
            $('#edit_id').val(id);
            loadingButton(btn);
            $.ajax({
                method: "GET",
                url: url_gb + "/admin/Provinces/" + id,
                data: {
                    id: id
                }
            }).done(function(res) {
                resetButton(btn);
                var data = res.content;
                $('#edit_geo_id').val(data.geo_id).change();
                $("#edit_provinces_name").val(data.provinces_name);
                $("#edit_provinces_code").val(data.provinces_code);
                if (data.provinces_status == 1) {
                    $('#edit_provinces_status').prop('checked', true);
                } else {
                    $('#edit_provinces_status').prop('checked', false);
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
                url: url_gb + "/admin/Provinces/" + id,
                data: {
                    id: id
                }
            }).done(function(res) {
                resetButton(btn);
                var data = res.content;
                var status = '';
                if (data.provinces_status == 1) {
                    status = "Active";
                } else {
                    status = "No Active";
                }
                console.log(data);
                $('#show_geo_name').text(data.geo_name);
                $('#show_provinces_name').text(data.provinces_name);
                $('#show_provinces_code').text(data.provinces_code);
                $('#show_provinces_status').text(status);
                $('#ModalView').modal('show');
            }).fail(function(res) {
                resetButton(form.find('button[type=submit]'));
                swal("โอ๊ะโอ! เกิดข้อผิดพลาด", res.content, 'error');
            });
        });

        $('body').on('click', '.btn-amphures', function(data) {
            var id = $(this).data('id');
            var btn = $(this);
            loadingButton(btn);
            $.ajax({
                method: "GET",
                url: url_gb + "/admin/Provinces/getAmphures_table/" + id,
                data: {
                    id: id
                }
            }).done(function(res) {
                resetButton(btn);
                $('#Table_Amphures').html('');
                $('#Table_Amphures').html(res);
                $('.modal-title').text('Amphures');
                $('#ModalAmphures').modal('show');

            }).fail(function(res) {
                resetButton(form.find('button[type=submit]'));
                swal("โอ๊ะโอ! เกิดข้อผิดพลาด", res.content, 'error');
            });
        });

        $('body').on('click', '.btn-districts', function(data) {
            var id = $(this).attr('id');
            var btn = $(this);
            loadingButton(btn);
            $.ajax({
                method: "GET",
                url: url_gb + "/admin/Provinces/getDistricts_table/" + id,
                data: {
                    id: id
                }
            }).done(function(res) {
                resetButton(btn);
                $('#Table_Districts').html('');
                $('#Table_Districts').html(res);
                $('.modal-title').text('Districts');
                $('#ModalDistricts').modal('show');

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
                url: url_gb + "/admin/Provinces/ChangeStatus/" + id,
                data: {
                    id: id,
                    status: status ? 1 : 0,
                }
            }).done(function(res) {
                if (res.status == 1) {
                    // swal(res.title, res.content, 'success');
                    // tableProvinces.api().ajax.reload();
                } else {
                    swal(res.title, res.content, 'error');
                }
            }).fail(function(res) {
                resetButton(form.find('button[type=submit]'));
                swal("โอ๊ะโอ! เกิดข้อผิดพลาด", res.content, 'error');
            });
        });

        $('body').on('submit', '#FormAdd', function(e) {
            e.preventDefault();
            var form = $(this);
            loadingButton(form.find('button[type=submit]'));
            $.ajax({
                method: "POST",
                url: url_gb + "/admin/Provinces",
                data: form.serialize()
            }).done(function(res) {
                resetButton(form.find('button[type=submit]'));
                if (res.status == 1) {
                    swal(res.title, res.content, 'success');
                    form[0].reset();
                    tableProvinces.api().ajax.reload();
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
                url: url_gb + "/admin/Provinces/" + id,
                data: form.serialize()
            }).done(function(res) {
                resetButton(form.find('button[type=submit]'));
                if (res.status == 1) {
                    swal(res.title, res.content, 'success');
                    form[0].reset();
                    tableProvinces.api().ajax.reload();
                    $('#ModalEdit').modal('hide');
                } else {
                    swal(res.title, res.content, 'error');
                }
            }).fail(function(res) {
                resetButton(form.find('button[type=submit]'));
                swal("โอ๊ะโอ! เกิดข้อผิดพลาด", res.content, 'error');
            });
        });

        $('body').on('click', '.btn-search', function(data) {

            tableProvinces.api().ajax.reload();
        });

        $('body').on('click', '.btn-clear-search', function(data) {
            $('#search_geo_id').val('');
            $('#search_provinces_code').val('');
            $('#search_provinces_name').val('');

            tableProvinces.api().ajax.reload();
        });
    });
</script>
@endsection
@extends('layouts.layout')@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Search</h4>
        <div class="row pt-3 address">
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Geography</label>
                    <select class="form-control custom-select select-geography select2" name="geo_id" id="search_geo_id" data-placeholder="" tabindex="1">
                        <option value="">เลือกภาค</option>
                        @foreach ($Geography as $val)
                        <option value="{{ $val->geo_id }}">{{ $val->geo_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Provinces</label>
                    <select class="form-control custom-select select-province select2" name="provinces_id" id="search_provinces_id" data-placeholder="" tabindex="1">
                        <option value="">เลือกจังหวัด</option>
                    </select>
                    <!-- <input type="hidden" id="provinces_selected" value="0"> -->
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Amphures</label>
                    <select class="form-control custom-select select-amphur select2" name="amphures_id" id="search_amphures_id" data-placeholder="" tabindex="1">
                        <option value="">เลือกอำเภอ</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Districts Code</label>
                    <input type="text" id="search_districts_code" name="districts_code" class="form-control search_table" placeholder="">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Districts Name</label>
                    <input type="text" id="search_districts_name" name="districts_name" class="form-control search_table" placeholder="">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Zipcode Name</label>
                    <input type="text" id="search_zipcode_name" name="zipcode_name" class="form-control search_table" placeholder="">
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-success btn-search"><i class="ti-search"></i> Search</button>
        <button type="button" class="btn btn-secondary btn-clear-search">Clear</button>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="material-card card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Districts</h4>
                    @if(App\Helper::CheckPermissionMenu('Districts' , '2'))
                    <button type="button" class="btn btn-primary btn-rounded m-t-10 mb-2 float-right newdata btn-add">Add New</button>
                    @endif
                </div>
                <div class="table-responsive">
                    <table id="tableDistricts" class="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Districts Name</th>
                                <th scope="col">Geography</th>
                                <th scope="col">Provinces</th>
                                <th scope="col">Amphures</th>
                                <th scope="col">Districts Code</th>
                                <th scope="col">Zipcode</th>
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
                            <div class="form-row address">
                                <div class="col-md-6 mb-3">
                                    <label for="geo_id">Geography</label>
                                    <br>
                                    <select class="form-control select-geography select2" id="geography_add" name="districts[geo_id]" required>
                                        <option value="">เลือกภาค</option>
                                        @foreach ($Geography as $val)
                                        <option value="{{ $val->geo_id }}">{{ $val->geo_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="geo_id">Provinces</label>
                                    <br>
                                    <select class="form-control select-province select2" id="provinces_add" name="districts[provinces_id]" required>
                                        <option value="">เลือกจังหวัด</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="geo_id">Amphures</label>
                                    <br>
                                    <select class="form-control select-amphur select2" id="amphures_add" name="districts[amphures_id]" required>
                                        <option value="">เลือกอำเภอ</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="districts_code">Districts Code</label>
                                    <input type="text" class="form-control" id="add_districts_code" name="districts[districts_code]" placeholder="" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="districts_name">Districts Name</label>
                                    <input type="text" class="form-control" id="add_districts_name" name="districts[districts_name]" placeholder="" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="zipcodes_name">Zipcode</label>
                                    <input type="text" class="form-control" id="add_zipcodes_name" name="zipcode[zipcodes_name]" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="Check-Box">Status</label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="add_districts_status" name="districts[districts_status]" value="1">
                                        <label class="custom-control-label" for="add_districts_status">Action</label>
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
                <input type="hidden" id="edit_zipcodes_id" name="zipcode[zipcodes_id]">
                <div class="card">

                    <div class="form-body">
                        <div class="card-body">
                            <div class="form-row address">
                                <div class="col-md-6 mb-3">
                                    <label class="control-label" for="edit_geo_id">Geography</label><br>
                                    <select class="form-control select-geography-edit select2" name="districts[geo_id]" id="geography_edit" data-placeholder="Select Geo">
                                        <option value="">เลือกภาค</option>
                                        @foreach ($Geography as $val)
                                        <option value="{{ $val->geo_id }}">{{ $val->geo_name }}</option>
                                        @endforeach
                                    </select>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="geo_id">Provinces</label><br>
                                    <select class="form-control select-province-edit select2" id="provinces_edit" name="districts[provinces_id]" required>
                                        <option value="">เลือกจังหวัด</option>
                                    </select>
                                    <input type="hidden" id="provinces_selected" value="0">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="amphures_id">Amphures</label><br>
                                    <select class="form-control select-amphur-edit select2" id="amphures_edit" name="districts[amphures_id]">
                                        <option value="0">เลือกอำเภอ</option>
                                    </select>
                                    <input type="hidden" id="amphures_selected" value="0">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="districts_code">Districts Code</label>
                                    <input type="text" class="form-control" id="edit_districts_code" name="districts[districts_code]" value="" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="districts_name">Districts Name</label>
                                    <input type="text" class="form-control" id="edit_districts_name" name="districts[districts_name]" value="" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="zipcodes_name">Zipcode</label>
                                    <input type="text" class="form-control" id="edit_zipcodes_name" name="zipcode[zipcodes_name]" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="Check-Box">Status</label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="edit_districts_status" name="districts[districts_status]" value="1">
                                        <label class="custom-control-label" for="edit_districts_status">Action</label>
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
    <div class="modal-dialog modal-lg" role="document">
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
                                    <td width="390">
                                        <label for="example-text-input" class="col-form-label">Geography</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_geo_name" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="390">
                                        <label for="example-text-input" class="col-form-label">Provinces</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_provinces_name" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="390">
                                        <label for="example-text-input" class="col-form-label">Amphures</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_amphures_name" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="390">
                                        <label for="example-text-input" class="col-form-label">Districts Code</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_districts_code" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="390">
                                        <label for="example-text-input" class="col-form-label">Districts Name</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_districts_name" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="390">
                                        <label for="example-text-input" class="col-form-label">Zipcode</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_zipcodes_code" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="390">
                                        <label for="example-text-input" class="col-form-label">Status</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_districts_status" class="col-form-label"></label>
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
        var tableDistricts = $('#tableDistricts').dataTable({
            "ajax": {
                "url": url_gb + "/admin/Districts/Lists",
                "type": "POST",
                "data": function(d) {
                    d.geo_id = $('#search_geo_id').val(),
                        d.provinces_id = $('#search_provinces_id').val(),
                        d.amphures_id = $('#search_amphures_id').val(),
                        d.districts_code = $('#search_districts_code').val(),
                        d.districts_name = $('#search_districts_name').val(),
                        d.zipcode_name = $('#search_zipcode_name').val()
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
                    "data": "districts_name",
                    "class": "text-center"
                },
                {
                    "data": "geo_name",
                    "class": "text-center"
                },
                {
                    "data": "provinces_name",
                    "class": "text-center"
                },
                {
                    "data": "amphures_name",
                    "class": "text-center"
                },
                {
                    "data": "districts_code",
                    "class": "text-center"
                },
                {
                    "data": "zipcodes_name",
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
            $('#add_districts_status').prop('checked', true);
            $('#ModalAdd').modal('show');
        });

        $('body').on('click', '.btn-edit', function(data) {
            var id = $(this).data('id');
            var btn = $(this);
            $('#edit_id').val(id);
            loadingButton(btn);
            $.ajax({
                method: "GET",
                url: url_gb + "/admin/Districts/" + id,
                data: {
                    id: id
                }
            }).done(function(res) {
                resetButton(btn);
                var data = res.content;
                console.log(data);
                $('#edit_zipcodes_id').val(data.zipcodes_id);
                $('#geography_edit').val(data.geo_id).change();
                $('#provinces_selected').val(data.provinces_id);
                $('#amphures_selected').val(data.amphures_id);
                $("#edit_districts_name").val(data.districts_name);
                $("#edit_districts_code").val(data.districts_code);
                $('#edit_zipcodes_name').val(data.zipcodes_name);

                if (data.districts_status == 1) {
                    $('#edit_districts_status').prop('checked', true);
                } else {
                    $('#edit_districts_status').prop('checked', false);
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
                url: url_gb + "/admin/Districts/" + id,
                data: {
                    id: id
                }
            }).done(function(res) {
                resetButton(btn);
                var data = res.content;
                var status = '';
                if (data.districts_status == 1) {
                    status = "Active";
                } else {
                    status = "No Active";
                }
                $('#show_geo_name').text(data.geo_name);
                $('#show_provinces_name').text(data.provinces_name);
                $('#show_districts_name').text(data.districts_name);
                $('#show_amphures_name').text(data.amphures_name);
                $('#show_districts_code').text(data.districts_code);
                $('#show_zipcodes_code').text(data.zipcodes_name);
                $('#show_districts_status').text(status);
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
                url: url_gb + "/admin/Districts/ChangeStatus/" + id,
                data: {
                    id: id,
                    status: status ? 1 : 0,
                }
            }).done(function(res) {
                if (res.status == 1) {
                    // swal(res.title, res.content, 'success');
                    // tableDistricts.api().ajax.reload();
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
                url: url_gb + "/admin/Districts",
                data: form.serialize()
            }).done(function(res) {
                resetButton(form.find('button[type=submit]'));
                if (res.status == 1) {
                    swal(res.title, res.content, 'success');
                    form[0].reset();
                    tableDistricts.api().ajax.reload();
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
                url: url_gb + "/admin/Districts/" + id,
                data: form.serialize()
            }).done(function(res) {
                resetButton(form.find('button[type=submit]'));
                if (res.status == 1) {
                    swal(res.title, res.content, 'success');
                    form[0].reset();
                    tableDistricts.api().ajax.reload();
                    $('#ModalEdit').modal('hide');
                } else {
                    swal(res.title, res.content, 'error');
                }
            }).fail(function(res) {
                resetButton(form.find('button[type=submit]'));
                swal("โอ๊ะโอ! เกิดข้อผิดพลาด", res.content, 'error');
            });
        });
        $('body').on('change', '.select-geography-edit', function() {
            var ele = $(this).closest('.address');
            var geo_id = $(this).val();
            ele.find('.select-province-edit').html('');
            ele.find('.select-amphur-edit').html('');
            ele.find('.select-district-edit').html('');
            if (geo_id) {
                $.ajax({
                    method: "GET",
                    url: url_gb + "/admin/GetProvinceByGeography/" + geo_id,
                    dataType: 'json',
                }).done(function(res) {
                    var html = '<option value="">เลือกจังหวัด</option>';
                    $.each(res, function(k, v) {
                        html += '<option value="' + v.provinces_id + '">' + v.provinces_name + '</option>';
                    });
                    ele.find('.select-province-edit').append(html);
                    ele.find('.select-province-edit').select2('destroy').select2();
                    var provinces_selected = $('#provinces_selected').val();
                    if (provinces_selected > 0) {
                        $('#provinces_edit').val(provinces_selected).change();
                    }
                }).fail(function() {
                    swal("system.system_alert", "system.system_error", "error");
                });
            }
        });
        $('body').on('change', '.select-province-edit', function() {
            var ele = $(this).closest('.address');
            var province_id = $(this).val();
            ele.find('.select-amphur-edit').html('');
            ele.find('.select-district-edit').html('');
            ele.find('.zipcode').val('');
            if (province_id) {
                $.ajax({
                    method: "GET",
                    url: url_gb + "/admin/GetAmphurByProvince/" + province_id,
                    dataType: 'json',
                }).done(function(res) {
                    var html = '<option value="">เลือกอำเภอ</option>';
                    $.each(res, function(k, v) {
                        html += '<option value="' + v.amphures_id + '">' + v.amphures_name + '</option>';
                    });
                    ele.find('.select-amphur-edit').append(html);
                    ele.find('.select-amphur-edit').select2('destroy').select2();
                    var amphures_selected = $('#amphures_selected').val();
                    if (amphures_selected > 0) {
                        $('#amphures_edit').val(amphures_selected).change();
                    }

                }).fail(function() {
                    swal("system.system_alert", "system.system_error", "error");
                });
            }
        });

        $('body').on('click', '.btn-search', function(data) {

            tableDistricts.api().ajax.reload();
        });

        $('body').on('click', '.btn-clear-search', function(data) {
            $('#search_geo_id').val('');
            $('#search_provinces_id').val('');
            $('#search_provinces_id').empty();
            $('#search_amphures_id').val('');
            $('#search_amphures_id').empty();
            $('#search_districts_code').val('');
            $('#search_districts_name').val('');
            $('#search_zipcode_name').val('');
            tableDistricts.api().ajax.reload();
        });
    });
</script>
@include('admin.Script.script_address')
@endsection
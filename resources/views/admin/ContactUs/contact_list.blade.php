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
                                <label class="control-label">Contact Title</label>
                                <input type="text" id="search_contact_list_title" class="form-control search_table">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Contact Company</label>
                                <input type="text" id="search_contact_list_company" class="form-control search_table">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Contact Email</label>
                                <input type="text" id="search_contact_list_email" class="form-control search_table">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Contact Telephone</label>
                                <input type="text" id="search_contact_list_telephone" class="form-control search_table">
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
                    @if(App\Helper::CheckPermissionMenu('ContactUs' , '2'))
                    <button type="button" class="btn btn-primary btn-rounded m-t-10 mb-2 float-right newdata btn-add">Add New</button>
                    @endif
                </div>
                <div class="table-responsive">
                    <table id="tableContactUs" class="table">
                        <thead>
                            <tr>
                                <!-- <th scope="col"></th> -->
                                <th scope="col">No</th>
                                <th scope="col">Contact Title</th>
                                <th scope="col">Contact Company</th>
                                <th scope="col">Contact Email</th>
                                <th scope="col">Contact Telephone</th>
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
    <div class="modal-dialog modal-lg" role="document">
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
                                <div class="col-md-6 mb-3">
                                    <label for="contact_list_title">Contact Title</label>
                                    <input type="text" class="form-control" id="add_contact_list_title" name="contact_list_title" placeholder="" value="" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="contact_list_message">Contact Message</label>
                                    <textarea cols="80" class="form-control" id="add_contact_list_message" name="contact_list_message" rows="3"></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="contact_list_company">Contact Company</label>
                                    <input type="text" class="form-control" id="add_contact_list_company" name="contact_list_company" placeholder="" value="" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="contact_list_ip_address">Contact Ip Address</label>
                                    <input type="text" class="form-control" id="add_contact_list_ip_address" name="contact_list_ip_address" placeholder="" value="" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="contact_list_name">Contact Name</label>
                                    <input type="text" class="form-control" id="add_contact_list_name" name="contact_list_name" placeholder="" value="" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="contact_list_email">Contact Email</label>
                                    <input type="text" class="form-control" id="add_contact_list_email" name="contact_list_email" placeholder="" value="" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="contact_list_telephone">Contact Telephone</label>
                                    <input type="number" class="form-control" id="add_contact_list_telephone" name="contact_list_telephone" placeholder="" value="" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="Check-Box">Status</label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="add_contact_list_status" name="contact_list_status" value="1">
                                        <label class="custom-control-label" for="add_contact_list_status">Action</label>
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
    <div class="modal-dialog modal-lg" role="document">
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
                                <div class="col-md-6 mb-3">
                                    <label for="contact_list_title">Contact Title</label>
                                    <input type="text" class="form-control" id="edit_contact_list_title" name="contact_list_title" placeholder="" value="" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="contact_list_message">Contact Message</label>
                                    <textarea cols="80" class="form-control" id="edit_contact_list_message" name="contact_list_message" rows="3"></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="contact_list_company">Contact Company</label>
                                    <input type="text" class="form-control" id="edit_contact_list_company" name="contact_list_company" placeholder="" value="" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="contact_list_ip_address">Contact Ip Address</label>
                                    <input type="text" class="form-control" id="edit_contact_list_ip_address" name="contact_list_ip_address" placeholder="" value="" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="contact_list_name">Contact Name</label>
                                    <input type="text" class="form-control" id="edit_contact_list_name" name="contact_list_name" placeholder="" value="" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="contact_list_email">Contact Email</label>
                                    <input type="text" class="form-control" id="edit_contact_list_email" name="contact_list_email" placeholder="" value="" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="contact_list_telephone">Contact Telephone</label>
                                    <input type="number" class="form-control" id="edit_contact_list_telephone" name="contact_list_telephone" placeholder="" value="" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="Check-Box">Status</label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="edit_contact_list_status" name="contact_list_status" value="1">
                                        <label class="custom-control-label" for="edit_contact_list_status">Action</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-success"><i class="ti-save"></i> Save</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
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
                                        <label for="example-text-input" class="col-form-label">Contact Title</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_contact_list_title" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Contact Massage</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_contact_list_message" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Contact Company</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_contact_list_company" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Contact Ip Address</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_contact_list_ip_address" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Contact Name</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_contact_list_name" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Contact Email</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_contact_list_email" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Contact Telephone</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_contact_list_telephone" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Status</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_contact_list_status" class="col-form-label"></label>
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
        var tableContactUs = $('#tableContactUs').dataTable({
            "ajax": {
                "url": url_gb + "/admin/ContactUs/Lists",
                "type": "POST",
                "data": function(d) {

                    d.contact_list_title = $('search_contact_list_title').val();
                    d.contact_list_company = $('search_contact_list_company').val();
                    d.contact_list_email = $('search_contact_list_email').val();
                    d.contact_list_telephone = $('search_contact_list_telephone').val();
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
                    "data": "contact_list_title",
                    "class": "text-center"
                },
                {
                    "data": "contact_list_company",
                    "class": "text-center",
                    "searchable": false,
                    "sortable": false,
                },
                {
                    "data": "contact_list_email",
                    "class": "text-center",
                    "searchable": false,
                    "sortable": false,
                },
                {
                    "data": "contact_list_telephone",
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
            tableContactUs.api().ajax.reload();
        });

        $('body').on('click', '.btn-clear-search', function() {
            $('search_contact_list_title').val('');
            $('search_contact_list_company').val('');
            $('search_contact_list_email').val('');
            $('search_contact_list_telephone').val('');
            tableContactUs.api().ajax.reload();
        });

        $('body').on('click', '.btn-add', function(data) {
            $('#add_contact_list_status').prop('checked', true);
            $('#ModalAdd').modal('show');
        });

        $('body').on('click', '.btn-edit', function(data) {
            var id = $(this).data('id');
            var btn = $(this);
            $('#edit_id').val(id);
            loadingButton(btn);
            $.ajax({
                method: "GET",
                url: url_gb + "/admin/ContactUs/" + id,
                data: {
                    id: id
                }
            }).done(function(res) {
                resetButton(btn);
                var data = res.content;
                // $("#edit_contact_list_title").val(data.contact_list_title);
                // $("#edit_contact_list_message").val(data.contact_list_message);
                $('#edit_contact_list_title').val(data.contact_list_title);
                $('#edit_contact_list_message').val(data.contact_list_message);
                $('#edit_contact_list_company').val(data.contact_list_company);
                $('#edit_contact_list_ip_address').val(data.contact_list_ip_address);
                $('#edit_contact_list_name').val(data.contact_list_name);
                $('#edit_contact_list_email').val(data.contact_list_email);
                $('#edit_contact_list_telephone').val(data.contact_list_telephone);
                $('#edit_contact_list_status').val(data.contact_list_status);
                $('#edit_contact_list_status').val(data.contact_list_status);
                if (data.contact_list_status == 1) {
                    $('#edit_contact_list_status').prop('checked', true);
                } else {
                    $('#edit_contact_list_status').prop('checked', false);
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
                url: url_gb + "/admin/ContactUs/" + id,
                data: {
                    id: id
                }
            }).done(function(res) {
                resetButton(btn);
                var data = res.content;
                var status = '';
                if (data.contact_list_status == 1) {
                    status = "Active";
                } else {
                    status = "No Active";
                }
                $('#show_contact_list_title').text(data.contact_list_title);
                $('#show_contact_list_message').text(data.contact_list_message);
                $('#show_contact_list_company').text(data.contact_list_company);
                $('#show_contact_list_ip_address').text(data.contact_list_ip_address);
                $('#show_contact_list_name').text(data.contact_list_name);
                $('#show_contact_list_email').text(data.contact_list_email);
                $('#show_contact_list_telephone').text(data.contact_list_telephone);
                $('#show_contact_list_status').text(data.contact_list_status);
                // $('#show_contact_list_status').text(data.contact_list_status);
                // $('#show_contact_list_title').text(data.contact_list_title);
                // $('#show_contact_list_message').text(data.contact_list_message);
                $('#show_contact_list_status').text(status);
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
                url: url_gb + "/admin/ContactUs/ChangeStatus/" + id,
                data: {
                    id: id,
                    status: status ? 1 : 0,
                }
            }).done(function(res) {
                if (res.status == 1) {
                    // swal(res.title, res.content, 'success');
                    // tableContactUs.api().ajax.reload();
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
                url: url_gb + "/admin/ContactUs",
                data: form.serialize()
            }).done(function(res) {
                resetButton(form.find('button[type=submit]'));
                if (res.status == 1) {
                    swal(res.title, res.content, 'success');
                    form[0].reset();
                    tableContactUs.api().ajax.reload();
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
                url: url_gb + "/admin/ContactUs/" + id,
                data: form.serialize()
            }).done(function(res) {
                resetButton(form.find('button[type=submit]'));
                if (res.status == 1) {
                    swal(res.title, res.content, 'success');
                    form[0].reset();
                    tableContactUs.api().ajax.reload();
                    $('#ModalEdit').modal('hide');
                } else {
                    swal(res.title, res.content, 'error');
                }
            }).fail(function(res) {
                resetButton(form.find('button[type=submit]'));
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
                            url: url_gb + "/admin/ContactUs/Delete/" + id,
                            data: {
                                id: id,
                            }
                        }).done(function(res) {
                            if (res.status == 1) {
                                swal(res.title, res.content, 'success');
                                tableContactUs.api().ajax.reload();
                            } else {
                                swal(res.title, res.content, 'error');
                            }
                        }).fail(function(res) {
                            swal("โอ๊ะโอ! เกิดข้อผิดพลาด", res.content, 'error');
                        });
                    }
                });

        });
    });
</script>
@endsection
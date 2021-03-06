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
                                <label class="control-label">Social Name</label>
                                <input type="text" id="search_social_name" class="form-control search_table">
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
                    @if(App\Helper::CheckPermissionMenu('Social' , '2'))
                    <button type="button" class="btn btn-primary btn-rounded m-t-10 mb-2 float-right newdata btn-add">Add New</button>
                    @endif
                </div>
                <div class="table-responsive">
                    <table id="tableSocial" class="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Image Icon</th>
                                <th scope="col">Social Name</th>
                                <th scope="col">Url</th>
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
                            <div class="form-row form-upload-img">
                                <div class="col-md-12 mb-3">
                                    <label for="add_languages_id">Languages</label>
                                    <select class="form-control select2" id="add_languages_id" name="languages_id">
                                        @foreach($Language as $val)
                                        <option value="{{ $val->languages_id }}">{{ $val->languages_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="add_social_social_name">Social Name</label>
                                    <input type="text" class="form-control" id="add_social_social_name" name="social_social_name" placeholder="" value="" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="add_social_details">Social Details</label>
                                    <textarea cols="80" class="form-control" id="add_social_details" name="social_details" rows="3"></textarea>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="add_social_icon">Social Image</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input upload-logo-add form-control" id="add_social_icon" name="social_icon" placeholder="" value="">
                                        <label class="custom-file-label" for="validatedCustomFile">Choose Image...</label>
                                    </div>
                                    <div class="card-body">
                                        <img class="img-thumbnail" id="add_preview_img" style="width:40%;" src="{{asset('uploads/images/no-image.jpg')}}">
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="add_social_url">Social Url</label>
                                    <input type="text" class="form-control" id="add_social_url" name="social_url" placeholder="" value="">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="add_social_target_link">Social Target Url</label>
                                    <div class="custom-control">
                                        <div class="form-check form-check-inline">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" value="_self" id="add_social_target_link_self" name="social_target_link">
                                                <label class="custom-control-label" for="add_social_target_link_self">เปิดในหน้าเดิม</label>
                                            </div>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" value="_blank" id="add_social_target_link_blank" name="social_target_link">
                                                <label class="custom-control-label" for="add_social_target_link_blank">เปิดในแท็บใหม่</label>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <input type="text" class="form-control" id="add_social_target_link" name="social_target_link" placeholder="" value=""> -->
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="add_social_sort_order">Social Order</label>
                                    <input type="number" class="form-control" id="add_social_sort_order" name="social_sort_order" placeholder="" value="">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="Check-Box">Status</label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="add_social_status" name="social_status" value="1">
                                        <label class="custom-control-label" for="add_social_status">Action</label>
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
                            <div class="form-row form-upload-img-edit">
                                <div class="col-md-12 mb-3">
                                    <label for="edit_languages_id">Languages</label>
                                    <select class="form-control select2" id="edit_languages_id" name="languages_id">
                                        @foreach($Language as $val)
                                        <option value="{{ $val->languages_id }}">{{ $val->languages_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="edit_social_social_name">Social Title</label>
                                    <input type="text" class="form-control" id="edit_social_social_name" name="social_social_name" placeholder="" value="">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="edit_social_details">Social Details</label>
                                    <textarea cols="80" class="form-control" id="edit_social_details" name="social_details" rows="3"></textarea>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="edit_social_icon">Social Image</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input upload-logo-edit form-control" id="edit_social_icon" name="social_icon" placeholder="" value="">
                                        <label class="custom-file-label" for="validatedCustomFile">Choose Image...</label>
                                    </div>
                                    <div class="card-body">
                                        <img class="img-thumbnail" id="preview_img_social" style="width:70%;">
                                    </div>
                                    <!-- <input type="hidden" id="old_social_icon" name="social_icon"> -->
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="edit_social_url">Social Url</label>
                                    <input type="text" class="form-control" id="edit_social_url" name="social_url" placeholder="" value="">

                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="edit_social_target_link">Social Target Url</label>
                                    <div class="custom-control">
                                        <div class="form-check form-check-inline">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" value="_self" id="edit_social_target_link_self" name="social_target_link">
                                                <label class="custom-control-label" for="edit_social_target_link_self">เปิดในหน้าเดิม</label>
                                            </div>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" value="_blank" id="edit_social_target_link_blank" name="social_target_link">
                                                <label class="custom-control-label" for="edit_social_target_link_blank">เปิดในแท็บใหม่</label>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <input type="text" class="form-control" id="edit_social_target_link" name="social_target_link" placeholder="" value=""> -->
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="edit_social_sort_order">Social Type</label>
                                    <input type="text" class="form-control" id="edit_social_sort_order" name="social_sort_order" placeholder="" value="">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="Check-Box">Status</label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="edit_social_status" name="social_status" value="1">
                                        <label class="custom-control-label" for="edit_social_status">Action</label>
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
                                        <label for="example-text-input" class="col-form-label">Languages</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_languages_id" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Social Title</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_social_social_name" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Social Details</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_social_details" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Social Image</label>
                                    </td>
                                    <td>
                                        <img id="show_social_icon" style="width:70%;">
                                        <!-- <label for="example-text-input" id="show_social_icon" class="col-form-label"></label> -->
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Social Url</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_social_url" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Social Target Url</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_social_target_link" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Social Order</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_social_sort_order" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Status</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_social_status" class="col-form-label"></label>
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
        var tableSocial = $('#tableSocial').dataTable({
            "ajax": {
                "url": url_gb + "/admin/Social/Lists",
                "type": "POST",
                "data": function(d) {
                    d.social_name = $('#search_social_name').val();
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
                    "data": "social_icon",
                    "class": "text-center",
                    "sortable": false,
                },
                {
                    "data": "social_social_name",
                    "class": "text-center"
                },
                {
                    "data": "social_url",
                    "class": "text-center",
                    "searchable": false,
                    "sortable": false,
                },
                {
                    "data": "social_sort_order",
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
            tableSocial.api().ajax.reload();
        });

        $('body').on('click', '.btn-clear-search', function() {
            $('#search_social_name').val('');
            tableSocial.api().ajax.reload();
        });

        $('body').on('click', '.btn-add', function(data) {
            $('#add_social_status').prop('checked', true);
            $('#ModalAdd').modal('show');
        });

        $('body').on('click', '.btn-edit', function(data) {
            var id = $(this).data('id');
            var btn = $(this);
            $('#edit_social_icon').val('');

            $('#edit_id').val(id);
            loadingButton(btn);
            $.ajax({
                method: "GET",
                url: url_gb + "/admin/Social/" + id,
                data: {
                    id: id
                }
            }).done(function(res) {
                resetButton(btn);
                var data = res.content;
                url_social = data.SocialImagePath + '/' + data.social_icon;
                $("#edit_languages_id").val(data.languages_id).select2();
                $("#edit_social_social_name").val(data.social_social_name);
                $("#edit_social_details").val(data.social_details);
                $('#preview_img_social').attr('src', url_social);
                $("#edit_social_icon_alt").val(data.social_icon_alt);
                $("#edit_social_url").val(data.social_url);
                $("#edit_social_sort_order").val(data.social_sort_order);

                $('#edit_social_target_link' + data.social_target_link).prop('checked', true);
                if (data.social_status == 1) {
                    $('#edit_social_status').prop('checked', true);
                } else {
                    $('#edit_social_status').prop('checked', false);
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
                url: url_gb + "/admin/Social/" + id,
                data: {
                    id: id
                }
            }).done(function(res) {
                resetButton(btn);
                var data = res.content;
                var status = '';
                var url_target = '';
                if (data.social_status == 1) {
                    status = "Active";
                } else {
                    status = "No Active";
                }
                if (data.social_target_link == "_self") {
                    url_target = "เปิดในหน้าเดิม";
                } else if (data.social_target_link == "_blank") {
                    url_target = "ปิดในแท็บใหม่";
                }
                url_social = data.SocialImagePath + '/' + data.social_icon;
                $('#show_languages_id').text(data.language.languages_name);
                $('#show_social_name').text(data.social_name);
                $('#show_social_details').text(data.social_details);
                $("#show_social_social_name").text(data.social_social_name);
                // $("#show_social_details").val(data.social_details);
                $('#show_social_icon').attr('src', url_social);
                $("#old_social_icon").text(data.social_icon);
                $("#show_social_icon_alt").text(data.social_icon_alt);
                $("#show_social_url").text(data.social_url);
                $("#show_social_sort_order").text(data.social_sort_order);
                $('#show_social_target_link').text(url_target);
                $('#show_social_status').text(status);
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
                url: url_gb + "/admin/Social/ChangeStatus/" + id,
                data: {
                    id: id,
                    status: status ? 1 : 0,
                }
            }).done(function(res) {
                if (res.status == 1) {
                    // swal(res.title, res.content, 'success');
                    // tableSocial.api().ajax.reload();
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
                url: url_gb + "/admin/Social",
                data: form.serialize()
            }).done(function(res) {
                resetButton(form.find('button[type=submit]'));
                if (res.status == 1) {
                    swal(res.title, res.content, 'success');
                    form[0].reset();
                    swal(res.title, "Update", "success")
                        .then((value) => {
                            location.reload();
                            tableSocial.api().ajax.reload();
                        }); // form[0].reset();
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
                url: url_gb + "/admin/Social/" + id,
                data: form.serialize()
            }).done(function(res) {
                resetButton(form.find('button[type=submit]'));
                if (res.status == 1) {
                    // swal(res.title, res.content, 'success');
                    form[0].reset();
                    swal(res.title, "Update", "success")
                        .then((value) => {
                            location.reload();
                            tableSocial.api().ajax.reload();
                        }); // form[0].reset();
                    $('#ModalEdit').modal('hide');
                } else {
                    swal(res.title, res.content, 'error');
                }
            }).fail(function(res) {
                resetButton(form.find('button[type=submit]'));
                swal("โอ๊ะโอ! เกิดข้อผิดพลาด", res.content, 'error');
            });
        });

        $('body').on('change', '.upload-logo-add', function() {
            var ele = $(this);
            var index = ele.data('index');
            var formData = new FormData();
            formData.append('file', ele[0].files[0]);
            $('#add_preview_img').attr('src', URL.createObjectURL(event.target.files[0]));
            $.ajax({
                url: url_gb + '/admin/UploadImage/SocialImageTemp',
                type: 'POST',
                data: formData,
                processData: false, // tell jQuery not to process the data
                contentType: false, // tell jQuery not to set contentType
                success: function(res) {
                    ele.closest('.form-upload-img').find('.upload-logo-add').append('<input type="hidden" id="add_social_icon"  name="social_icon" value="' + res.path + '">');
                    setTimeout(function() {

                    }, 100);
                }
            });
        });
        $('body').on('change', '.upload-logo-edit', function() {
            var ele = $(this);
            var index = ele.data('index');
            var formData = new FormData();
            formData.append('file', ele[0].files[0]);

            $('#preview_img_social').attr('src', URL.createObjectURL(event.target.files[0]));
            $.ajax({
                url: url_gb + '/admin/UploadImage/SocialImageTemp',
                type: 'POST',
                data: formData,
                processData: false, // tell jQuery not to process the data
                contentType: false, // tell jQuery not to set contentType
                success: function(res) {
                    ele.closest('.form-upload-img-edit').find('.upload-logo-edit').append('<input type="hidden" id="edit_social_icon"  name="social_icon" value="' + res.path + '">');
                    setTimeout(function() {

                    }, 100);
                }
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
                            url: url_gb + "/admin/Social/Delete/" + id,
                            data: {
                                id: id,
                            }
                        }).done(function(res) {
                            if (res.status == 1) {
                                swal(res.title, res.content, 'success');
                                tableSocial.api().ajax.reload();
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
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
                                <label for="add_news_gallery_type">News Gallery Type</label>
                                <select class="form-control select2" id="search_news_gallery_type" name="news_gallery_type">
                                    <option value="">Select Image Type</option>
                                    @foreach($GalleryType as $key=>$val)
                                    <option value="{{ $key }}">{{ $val }}</option>
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
                    @if(App\Helper::CheckPermissionMenu('NewsGallery' , '2'))
                    <!-- <button type="button" class="btn btn-primary btn-rounded m-t-10 mb-2 float-right newdata btn-add">Add New</button> -->
                    @endif
                </div>
                <div class="table-responsive">
                    <table id="tableNewsGallery" class="table">
                        <thead>
                            <tr>
                                <!-- <th scope="col"></th> -->
                                <th scope="col">No</th>
                                <th scope="col">News</th>
                                <th scope="col">Image</th>
                                <th scope="col">Type</th>
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
            <!-- <div class="modal-header">
                <h4 class="modal-title">Add New</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="mdi mdi-close"></i></span></button>
            </div> -->
            <form id="FormAdd" class="needs-validation" novalidate>
                <div class="card">
                    <div class="form-body">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label for="add_news_id">News</label>
                                    <select class="form-control select2" id="add_news_id" name="news_id">
                                        <option>Select News</option>
                                        @foreach($News as $val)
                                        <option value="{{ $val->news_id }}">{{ $val->news_seo_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="news_gallery_details">News Gallery Details</label>
                                    <textarea cols="80" class="form-control" id="add_news_gallery_details" name="news_gallery_details" rows="3"></textarea>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="add_news_gallery_type">News Gallery Type</label>
                                    <select class="form-control select2" id="add_news_gallery_type" name="news_gallery_type">
                                        <option>Select Image Type</option>
                                        @foreach($GalleryType as $key=>$val)
                                        <option value="{{ $key }}">{{ $val }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="Check-Box">Status</label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="add_news_gallery_status" name="news_gallery_status" value="1">
                                        <label class="custom-control-label" for="add_news_gallery_status">Action</label>
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
                            <div class="col-md-12 mb-3">
                                <label for="edit_news_id">News</label>
                                <select class="form-control select2" id="edit_news_id" name="news_id" disabled>
                                    <option>Select News</option>
                                    @foreach($News as $val)
                                    <option value="{{ $val->news_id }}">{{ $val->news_seo_title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="preview_img_news_gallery">Image</label>
                                <div class="card-body">
                                    <img class="img-thumbnail" id="preview_img_news_gallery" style="width:70%;">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="news_gallery_details">News Gallery Details</label>
                                <textarea cols="80" class="form-control" id="edit_news_gallery_details" name="news_gallery_details" rows="3"></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="edit_news_gallery_type">News Gallery Type</label>
                                <select class="form-control select2" id="edit_news_gallery_type" name="news_gallery_type">
                                    <option>Select Image Type</option>
                                    @foreach($GalleryType as $key=>$val)
                                    <option value="{{ $key }}">{{ $val }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="Check-Box">Status</label>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="edit_news_gallery_status" name="news_gallery_status" value="1">
                                    <label class="custom-control-label" for="edit_news_gallery_status">Action</label>
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
                                        <label for="example-text-input" class="col-form-label">News</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_news_id" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">News Image</label>
                                    </td>
                                    <td>
                                        <img id="show_news_gallery_image" style="width:70%;">
                                        <!-- <label for="example-text-input" id="show_social_icon" class="col-form-label"></label> -->
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">News Gallery Details</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_news_gallery_details" class="col-form-label"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">News Gallery Type</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_news_gallery_type" class="col-form-label">นางสาว</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="170">
                                        <label for="example-text-input" class="col-form-label">Status</label>
                                    </td>
                                    <td>
                                        <label for="example-text-input" id="show_news_gallery_status" class="col-form-label"></label>
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
        var tableNewsGallery = $('#tableNewsGallery').dataTable({
            "ajax": {
                "url": url_gb + "/admin/NewsGallery/Lists",
                "type": "POST",
                "data": function(d) {
                    d.news_gallery_type = $('#search_news_gallery_type').val();
                    // d.news_gallery_detail = $('#search_news_gallery_detail').val();
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
                    "data": "news",
                    "class": "text-center"
                },
                {
                    "data": "news_gallery_image_gall",
                    "class": "text-center",
                    "searchable": false,
                    "sortable": false,
                },
                {
                    "data": "news_gallery_type",
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
            tableNewsGallery.api().ajax.reload();
        });

        $('body').on('click', '.btn-clear-search', function() {
            $('#search_news_gallery_type').val('');
            $('#search_news_gallery_detail').val('');
            tableNewsGallery.api().ajax.reload();
        });

        $('body').on('click', '.btn-add', function(data) {
            $('#add_news_gallery_status').prop('checked', true);
            $('#ModalAdd').modal('show');
        });

        $('body').on('click', '.btn-edit', function(data) {
            var id = $(this).data('id');
            var btn = $(this);
            $('#edit_id').val(id);
            loadingButton(btn);
            $.ajax({
                method: "GET",
                url: url_gb + "/admin/NewsGallery/" + id,
                data: {
                    id: id
                }
            }).done(function(res) {
                resetButton(btn);
                var data = res.content;
                url_news_gallery = res.GalleryPath + '/' + data.news_gallery_image_gall;
                $("#edit_news_id").val(data.news_id).change();
                $('#preview_img_news_gallery').attr('src', url_news_gallery);
                $("#edit_news_gallery_details").val(data.news_gallery_details);
                $("#edit_news_gallery_type").val(data.news_gallery_type).change();
                if (data.news_gallery_status == 1) {
                    $('#edit_news_gallery_status').prop('checked', true);
                } else {
                    $('#edit_news_gallery_status').prop('checked', false);
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
                url: url_gb + "/admin/NewsGallery/" + id,
                data: {
                    id: id
                }
            }).done(function(res) {
                resetButton(btn);
                var data = res.content;
                var status = '';
                var gallery_type = '';
                if (data.news_gallery_status == 1) {
                    status = "Active";
                } else {
                    status = "No Active";
                }
                if (data.news_gallery_type == 1) {
                    gallery_type = "รูปภาพทั่วไป";
                } else {
                    gallery_type = "รูปภาพ cover";
                }
                url_news_gallery = res.GalleryPath + '/' + data.news_gallery_image_gall;
                $('#show_news_id').text(data.news.news_seo_title);
                $('#show_news_gallery_details').text(data.news_gallery_details);
                $('#show_news_gallery_type').text(gallery_type);
                $('#show_news_gallery_image').attr('src', url_news_gallery);
                $('#show_news_gallery_status').text(status);
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
                url: url_gb + "/admin/NewsGallery/ChangeStatus/" + id,
                data: {
                    id: id,
                    status: status ? 1 : 0,
                }
            }).done(function(res) {
                if (res.status == 1) {
                    // swal(res.title, res.content, 'success');
                    // tableNewsGallery.api().ajax.reload();
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
                url: url_gb + "/admin/NewsGallery",
                data: form.serialize()
            }).done(function(res) {
                resetButton(form.find('button[type=submit]'));
                if (res.status == 1) {
                    swal(res.title, res.content, 'success');
                    form[0].reset();
                    tableNewsGallery.api().ajax.reload();
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
                url: url_gb + "/admin/NewsGallery/" + id,
                data: form.serialize()
            }).done(function(res) {
                resetButton(form.find('button[type=submit]'));
                if (res.status == 1) {
                    swal(res.title, res.content, 'success');
                    form[0].reset();
                    tableNewsGallery.api().ajax.reload();
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
                            url: url_gb + "/admin/NewsGallery/Delete/" + id,
                            data: {
                                id: id,
                            }
                        }).done(function(res) {
                            if (res.status == 1) {
                                swal(res.title, res.content, 'success');
                                tableNewsGallery.api().ajax.reload();
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
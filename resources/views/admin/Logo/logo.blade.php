@extends('layouts.layout')@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Logo</h4>
                <form id="FormAdd" class="needs-validation" novalidate>
                    <div class="card">
                        <div class="form-horizontal form-upload-img">
                            <input type="hidden" id="edit_logo_id" name="logo_id">
                            <div class="form-group row pb-3">
                                <label for="edit_logo_title" class="col-sm-3 text-right control-label col-form-label">Logo Title</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="edit_logo_title" name="logo_title">
                                </div>
                            </div>
                            <div class="form-group row pb-3">
                                <label for="edit_logo_details" class="col-sm-3 text-right control-label col-form-label">Logo Details</label>
                                <div class="col-sm-9">
                                    <textarea type="text" class="form-control" id="edit_logo_details" name="logo_details"></textarea>
                                </div>
                            </div>
                            <div class="form-group row pb-3">
                                <label for="edit_setting_image" class="col-sm-3 text-right control-label col-form-label">Logo Image</label>
                                <div class="col-sm-9">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input upload-logo" accept="image/*" onchange="loadFile(event)">
                                        <label class="custom-file-label" for="validatedCustomFile">Choose Image...</label>
                                    </div>
                                    <div class="card-body">
                                        <img class="img-thumbnail" id="edit_preview_img" style="width:30%;">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row pb-3">
                                <label for="edit_logo_image_alt" class="col-sm-3 text-right control-label col-form-label">Logo Image Alt</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="edit_logo_image_alt" name="logo_image_alt">
                                </div>
                            </div>
                            <div class="form-group row pb-3">
                                <label for="edit_logo_url" class="col-sm-3 text-right control-label col-form-label">Logo Url</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="edit_logo_url" name="logo_url" placeholder="https://">
                                </div>
                            </div>
                            <!-- <div class="form-group row pb-3">
                                <label for="edit_logo_type" class="col-sm-3 text-right control-label col-form-label">Logo Type</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" id="edit_logo_type" name="logo_type">
                                </div>
                            </div> -->
                            <div class="form-group row pb-3">
                                <label for="edit_logo_target_url" class="col-sm-3 text-right control-label col-form-label">Logo Target Url</label>
                                <div class="custom-control">
                                    <div class="form-check form-check-inline">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" value="_self" id="edit_logo_target_url_self" name="logo_target_url">
                                            <label class="custom-control-label" for="edit_logo_target_url_self">เปิดในหน้าเดิม</label>
                                        </div>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" value="_blank" id="edit_logo_target_url_blank" name="logo_target_url">
                                            <label class="custom-control-label" for="edit_logo_target_url_blank">เปิดในแท็บใหม่</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row pb-3">
                                <label for="edit_setting_status" class="col-sm-3 text-right control-label col-form-label">Display Status</label>
                                <div class="custom-control">
                                    <div class="form-check form-check-inline">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" value="1" id="edit_setting_status_1" name="logo_status" checked>
                                            <label class="custom-control-label" for="edit_setting_status_1">Active</label>
                                        </div>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" value="0" id="edit_setting_status_0" name="logo_status">
                                            <label class="custom-control-label" for="edit_setting_status_0">Inactive</label>
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
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $.ajax({
            url: url_gb + "/admin/Logo/GetLogo",
        }).done(function(res) {
            var data = res.content;
            $.each(data, function(k, v) {
                $("#edit_logo_id").val(v.logo_id);
                url_logo = res.LogoImagePath + '/' + v.logo_image;
                $('#edit_preview_img').attr('src', url_logo);
                $('#edit_logo_title').val(v.logo_title);
                $('#edit_logo_details').val(v.logo_details);
                $('#edit_logo_image_alt').val(v.logo_image_alt);
                $('#edit_logo_url').val(v.logo_url);
                $('#edit_logo_target_url'+v.logo_target_url).prop('checked', true);
                $('#edit_setting_status_'+v.logo_status).prop('checked', true);

            });

        }).fail(function(res) {
            resetButton(form.find('button[type=submit]'));
            swal("โอ๊ะโอ! เกิดข้อผิดพลาด", res.content, 'error');
        });

        $('body').on('submit', '#FormAdd', function(e) {
            e.preventDefault();
            var form = $(this);
            loadingButton(form.find('button[type=submit]'));
            $.ajax({
                method: "POST",
                url: url_gb + "/admin/Logo",
                data: form.serialize()
            }).done(function(res) {
                resetButton(form.find('button[type=submit]'));
                if (res.status == 1) {
                    swal(res.title, "Update", "success")
                        .then((value) => {
                            location.reload();
                        });
                } else {
                    swal(res.title, res.content, 'error');
                }
            }).fail(function(res) {
                resetButton(form.find('button[type=submit]'));
                swal("โอ๊ะโอ! เกิดข้อผิดพลาด", res.content, 'error');
            });
        });

        $('body').on('change', '.upload-logo', function() {
            var ele = $(this);
            var index = ele.data('index');
            var formData = new FormData();
            formData.append('file', ele[0].files[0]);
            $('#edit_preview_img').attr('src', URL.createObjectURL(event.target.files[0]));
            $.ajax({
                url: url_gb + '/admin/UploadImage/LogoImageTemp',
                type: 'POST',
                data: formData,
                processData: false, // tell jQuery not to process the data
                contentType: false, // tell jQuery not to set contentType
                success: function(res) {
                    ele.closest('.form-upload-img').find('.upload-logo').append('<input type="hidden" id="edit_logo_image"  name="logo_image" value="' + res.path + '">');
                    setTimeout(function() {

                    }, 100);
                }
            });
        });
        // $('body').on('change', '.upload-logo-edit', function() {
        //     var ele = $(this);
        //     var index = ele.data('index');
        //     var formData = new FormData();
        //     formData.append('file', ele[0].files[0]);

        //     $('#preview_img_logo').attr('src', URL.createObjectURL(event.target.files[0]));
        //     $.ajax({
        //         url: url_gb + '/admin/UploadImage/LogoImageTemp',
        //         type: 'POST',
        //         data: formData,
        //         processData: false, // tell jQuery not to process the data
        //         contentType: false, // tell jQuery not to set contentType
        //         success: function(res) {
        //             ele.closest('.form-upload-img-edit').find('.upload-logo-edit').append('<input type="hidden" id="edit_logo_image"  name="logo_image" value="' + res.path + '">');
        //             setTimeout(function() {

        //             }, 100);
        //         }
        //     });
        // });


    });
</script>
@endsection
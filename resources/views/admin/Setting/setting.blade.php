@extends('layouts.layout')@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Setting</h4>
                <form id="FormAdd" class="needs-validation" novalidate>
                    <div class="card">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            @foreach($Language as $val)
                            <li class="nav-item">
                                <a class="nav-link {{ $val->languages_type == '1' ? 'active' : ''}}" id="{{ $val->languages_name }}" data-toggle="tab" href="#{{ $val->languages_name }}-add" role="tab" aria-controls="{{ $val->languages_name }}-edit" aria-selected="true"><i class="{{ $val->languages_icon }}"></i> {{ $val->languages_name }}</a>
                            </li>
                            @endforeach
                        </ul>
                        <div class="tab-content tabcontent-border" id="myTabContent">
                            @foreach($Language as $val)
                            <div class="tab-pane fade {{ $val->languages_type == '1' ? 'show active' : ''}}" id="{{ $val->languages_name }}-add" role="tabpanel" aria-labelledby="{{ $val->languages_name }}">
                                <div class="form-body">
                                    <div class="card-body">
                                        <div class="form-horizontal form-upload-img">
                                            <input type="hidden" id="add_languages_id" name="lang[{{$val->languages_id}}][languages_id]" value="{{ $val->languages_id }}">
                                            <input type="hidden" id="setting_id_{{ $val->languages_id }}" name="lang[{{$val->languages_id}}][setting_id]" >

                                            <div class="form-group row pb-3 image_alt">
                                                <label for="add_setting_image_alt" class="col-sm-3 text-right control-label col-form-label">Author</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_setting_author_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][setting_author]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3 image_alt">
                                                <label for="add_setting_image_alt" class="col-sm-3 text-right control-label col-form-label">Title</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_setting_title_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][setting_title]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_event_details_description" class="col-sm-3 text-right control-label col-form-label">Description</label>
                                                <div class="col-sm-9">
                                                    <textarea cols="60" id="add_event_details_description_{{$val->languages_id}}" rows="6" data-sample="3" data-sample-short name="lang[{{$val->languages_id}}][setting_description]"></textarea>

                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_setting_keyword" class="col-sm-3 text-right control-label col-form-label">Keyword</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_setting_keyword_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][setting_keyword]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_setting_shortcut_icon" class="col-sm-3 text-right control-label col-form-label">Shortcut Icon</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_setting_shortcut_icon_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][setting_shortcut_icon]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_setting_google_analytics" class="col-sm-3 text-right control-label col-form-label">Google Analytics</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_setting_google_analytics_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][setting_google_analytics]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_setting_google_ua_code" class="col-sm-3 text-right control-label col-form-label">Google UA Code</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_setting_google_ua_code_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][setting_google_ua_code]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_setting_google_user_analytics" class="col-sm-3 text-right control-label col-form-label">Google User Analytics</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_setting_google_user_analytics_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][setting_google_user_analytics]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_setting_google_user_password" class="col-sm-3 text-right control-label col-form-label">Google User Password</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_setting_google_user_password_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][setting_google_user_password]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_setting_facebook_event" class="col-sm-3 text-right control-label col-form-label">Facebook Event</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_setting_facebook_event_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][setting_facebook_event]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_setting_facebook_id" class="col-sm-3 text-right control-label col-form-label">Facebook Id</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_setting_facebook_id_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][setting_facebook_id]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_setting_og_url" class="col-sm-3 text-right control-label col-form-label">Og Url</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_setting_og_url_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][setting_og_url]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_setting_og_type" class="col-sm-3 text-right control-label col-form-label">Og Type</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_setting_og_type_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][setting_og_type]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_setting_og_title" class="col-sm-3 text-right control-label col-form-label">Og Title</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_setting_og_title_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][setting_og_title]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_setting_og_description" class="col-sm-3 text-right control-label col-form-label">Og Description</label>
                                                <div class="col-sm-9">
                                                    <textarea rows="4" type="text" class="form-control" id="add_setting_og_description_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][setting_og_description]"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3 ">
                                                <label for="add_setting_image" class="col-sm-3 text-right control-label col-form-label">Og Image</label>
                                                <div class="col-sm-9">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input upload-Setting" id="{{$val->languages_id}}" accept="image/*" onchange="loadFile(event)">
                                                        <label class="custom-file-label" for="validatedCustomFile">Choose Image...</label>
                                                    </div>
                                                    <div class="card-body">
                                                        <img class="img-thumbnail" id="preview_img_Setting_{{$val->languages_id}}" style="width:30%;">
                                                    </div>
                                                    <!-- <input type="hidden" id="old_Setting_image_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][setting_og_image]" value=""> -->
                                                </div>
                                            </div>

                                            <div class="form-group row pb-3">
                                                <label for="add_setting_status" class="col-sm-3 text-right control-label col-form-label">Display Status</label>
                                                <div class="col-sm-9">
                                                    <div class="form-check form-check-inline">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input" value="1" id="add_setting_status_{{$val->languages_id}}_1" name="lang[{{$val->languages_id}}][setting_status]" checked>
                                                            <label class="custom-control-label" for="add_setting_status_{{$val->languages_id}}_1">Active</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input" value="0" id="add_setting_status_{{$val->languages_id}}_2" name="lang[{{$val->languages_id}}][setting_status]">
                                                            <label class="custom-control-label" for="add_setting_status_{{$val->languages_id}}_2">Inactive</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
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
    $(document).ready(function(data) {
        // var id = $('#add_languages_id').val();
        // alert(id);
        $.ajax({
            url: url_gb + "/admin/Setting/GetSetting",
        }).done(function(res) {
            var data = res.content;
            var about_us_category_selected_array = [];
            $.each(data, function(k, v) {
                $("#setting_id_" + v.languages_id).val(v.setting_id);
                url_Setting = data.SettingImagePath + '/' + v.setting_og_image;
                $('#preview_img_Setting_' + v.languages_id).attr('src', url_Setting);
                // $('#old_Setting_image_' + v.languages_id).val(v.setting_og_image);

                $("#add_setting_author_" + v.languages_id).val(v.setting_author);
                $("#add_setting_title_" + v.languages_id).val(v.setting_title);
                $("#add_event_details_description_" + v.languages_id).val(v.setting_description);

                // CKEDITOR.instances['add_event_details_description_' + v.languages_id].setData(v.setting_description)
                $("#add_setting_keyword_" + v.languages_id).val(v.setting_keyword);
                $("#add_setting_shortcut_icon_" + v.languages_id).val(v.setting_shortcut_icon);
                $("#add_setting_google_analytics_" + v.languages_id).val(v.setting_google_analytics);
                $("#add_setting_google_ua_code_" + v.languages_id).val(v.setting_google_ua_code);
                $("#add_setting_google_user_analytics_" + v.languages_id).val(v.setting_google_user_analytics);
                $("#add_setting_google_user_password_" + v.languages_id).val(v.setting_google_user_password);
                $("#add_setting_facebook_event_" + v.languages_id).val(v.setting_facebook_event);
                $("#add_setting_facebook_id_" + v.languages_id).val(v.setting_facebook_id);
                $("#add_setting_og_url_" + v.languages_id).val(v.setting_og_url);
                $("#add_setting_og_type_" + v.languages_id).val(v.setting_og_type);
                $("#add_setting_og_title_" + v.languages_id).val(v.setting_og_title);
                $("#add_setting_og_description_" + v.languages_id).val(v.setting_og_description);
                $("#add_setting_og_image_" + v.languages_id).val(v.setting_og_image);
                if (v.setting_status == "1") {
                    $('#add_setting_status_' + v.languages_id + '_1').prop('checked', true);
                } else if (v.setting_status == "0") {
                    $('#add_setting_status_' + v.languages_id + '_2').prop('checked', true);
                }
            });



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
            url: url_gb + "/admin/Setting/" + id,
            data: {
                id: id
            }
        }).done(function(res) {
            resetButton(btn);
            var data = res.content;
            var status = '';
            if (data.setting_status == 1) {
                status = "Active";
            } else {
                status = "No Active";
            }
            $('#show_setting_name').text(data.setting_name);
            $('#show_setting_details').text(data.setting_details);
            $('#show_setting_status').text(status);
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
            url: url_gb + "/admin/Setting/ChangeStatus/" + id,
            data: {
                id: id,
                status: status ? 1 : 0,
            }
        }).done(function(res) {
            if (res.status == 1) {
                // swal(res.title, res.content, 'success');
                // tableSetting.api().ajax.reload();
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
            url: url_gb + "/admin/Setting",
            data: form.serialize()
        }).done(function(res) {
            resetButton(form.find('button[type=submit]'));
            if (res.status == 1) {
                swal(res.title, "Update", "success")
                    .then((value) => {
                        location.reload();
                    }); // form[0].reset();
                tableSetting.api().ajax.reload();
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
            url: url_gb + "/admin/Setting/" + id,
            data: form.serialize()
        }).done(function(res) {
            resetButton(form.find('button[type=submit]'));
            if (res.status == 1) {
                swal(res.title, res.content, 'success');
                form[0].reset();
                tableSetting.api().ajax.reload();
                $('#ModalEdit').modal('hide');
            } else {
                swal(res.title, res.content, 'error');
            }
        }).fail(function(res) {
            resetButton(form.find('button[type=submit]'));
            swal("โอ๊ะโอ! เกิดข้อผิดพลาด", res.content, 'error');
        });
    });
    $('body').on('change', '.upload-Setting', function() {
        var ele = $(this);
        var index = ele.data('index');
        var formData = new FormData();
        var id = $(this).attr('id');
        $('#preview_img_Setting_'+id).attr('src', URL.createObjectURL(event.target.files[0]));
        // $('#old_Setting_image_' + id).remove('');
        formData.append('file', ele[0].files[0]);
        $.ajax({
            url: url_gb + '/admin/UploadImage/SettingOgImageTemp',
            type: 'POST',
            data: formData,
            processData: false, // tell jQuery not to process the data
            contentType: false, // tell jQuery not to set contentType
            success: function(res) {
                ele.closest('.form-upload-img').find('.upload-Setting').append('<input type="hidden" id="add_setting_image_' + id + '" name="lang[' + id + '][setting_og_image]" value="' + res.path + '">');
                setTimeout(function() {

                }, 100);
            }
        });
    });
</script>
@endsection
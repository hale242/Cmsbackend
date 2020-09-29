@extends('layouts.layout')@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">About Us</h4>
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
                                            <input type="hidden" id="aboutus_list_id_{{ $val->languages_id }}" name="lang[{{$val->languages_id}}][aboutus_list_id]">
                                            <div class="form-group row pb-3">
                                                <label for="add_aboutus_list_image" class="col-sm-3 text-right control-label col-form-label">Image</label>
                                                <div class="col-sm-9">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input upload-aboutus" id="{{$val->languages_id}}">
                                                        <label class="custom-file-label" for="validatedCustomFile">Choose Image...</label>
                                                    </div>
                                                    <div class="card-body">
                                                        <img class="img-thumbnail" id="preview_img_aboutus_{{$val->languages_id}}" style="width:45%;">
                                                    </div>
                                                    <!-- <input type="hidden" id="old_aboutus_image" name="event[event_image]" value=""> -->
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3 image_alt">
                                                <label for="add_aboutus_list_image_alt" class="col-sm-3 text-right control-label col-form-label">Image Alt</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_aboutus_list_image_alt_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][aboutus_list_image_alt]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_event_details_description" class="col-sm-3 text-right control-label col-form-label">Description</label>
                                                <div class="col-sm-9">
                                                    <textarea class="editor-edit" cols="60" id="add_event_details_description_{{$val->languages_id}}" rows="6" data-sample="3" data-sample-short name="lang[{{$val->languages_id}}][aboutus_list_details]"></textarea>

                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_aboutus_list_seo_title" class="col-sm-3 text-right control-label col-form-label">Seo Title</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_aboutus_list_seo_title_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][aboutus_list_seo_title]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_aboutus_list_seo_description" class="col-sm-3 text-right control-label col-form-label">Seo Description</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_aboutus_list_seo_description_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][aboutus_list_seo_description]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_aboutus_list_seo_keyword" class="col-sm-3 text-right control-label col-form-label">Seo Keyword</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_aboutus_list_seo_keyword_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][aboutus_list_seo_keyword]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_aboutus_list_seo_keyword" class="col-sm-3 text-right control-label col-form-label">Url Slug</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_aboutus_list_url_slug_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][aboutus_list_url_slug]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_aboutus_list_category" class="col-sm-3 text-right control-label col-form-label">Category</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control select2" multiple id="add_aboutus_list_category_{{$val->languages_id}}" name="category_id[{{$val->languages_id}}][]">
                                                        <option>Select Category</option>
                                                        @foreach($AboutUsCategorys as $AboutUsCategory)
                                                        <option value="{{ $AboutUsCategory->aboutus_category_id }}">{{ $AboutUsCategory->aboutus_category_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_aboutus_list_status" class="col-sm-3 text-right control-label col-form-label">Display Status</label>
                                                <div class="col-sm-9">
                                                    <div class="form-check form-check-inline">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input" value="1" id="add_aboutus_list_status_{{$val->languages_id}}_1" name="lang[{{$val->languages_id}}][aboutus_list_status]" checked>
                                                            <label class="custom-control-label" for="add_aboutus_list_status_{{$val->languages_id}}_1">Active</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input" value="0" id="add_aboutus_list_status_{{$val->languages_id}}_2" name="lang[{{$val->languages_id}}][aboutus_list_status]">
                                                            <label class="custom-control-label" for="add_aboutus_list_status_{{$val->languages_id}}_2">Inactive</label>
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
            url: url_gb + "/admin/AboutUs/GetAboutUs",
        }).done(function(res) {
            var data = res.content;
            var about_us_category_selected_array = [];
            $.each(data, function(k, v) {
                url_aboutus = data.AboutImagePath + '/' + v.aboutus_list_image;
                $('#preview_img_aboutus_' + v.languages_id).attr('src', url_aboutus);
                // $('#old_aboutus_image_' + v.languages_id).val(v.aboutus_list_image);
                $("#aboutus_list_id_" + v.languages_id).val(v.aboutus_list_id);
                $("#add_aboutus_list_seo_keyword_" + v.languages_id).val(v.aboutus_list_seo_keyword);
                $("#add_aboutus_list_image_alt_" + v.languages_id).val(v.aboutus_list_image_alt);
                $('#add_event_details_description_' + v.languages_id).val(v.aboutus_list_details);
                $("#add_aboutus_list_url_slug_" + v.languages_id).val(v.aboutus_list_url_slug);
                $("#add_aboutus_list_seo_keyword_" + v.languages_id).val(v.aboutus_list_seo_keyword);
                $("#add_aboutus_list_seo_description_" + v.languages_id).val(v.aboutus_list_seo_description);
                $("#add_aboutus_list_seo_title_" + v.languages_id).val(v.aboutus_list_seo_title);
                if (v.aboutus_list_status == "1") {
                    $('#add_aboutus_list_status_' + v.languages_id + '_1').prop('checked', true);
                } else if (v.aboutus_list_status == "0") {
                    $('#add_aboutus_list_status_' + v.languages_id + '_2').prop('checked', true);
                }
                // new FroalaEditor('.editor-edit', {
                //     key: "UBB7jD6C5E3A2J3B7aIVLEABVAYFKc1Ce1MYGD1c1NYVMiB3B9B6A5C2C4F4H3G3J3==",
                //     height: 300
                //     // Set the image upload parameter.
                // })
                $.each(v.about_us_has_about_us_category, function(k2, v2) {
                    about_us_category_selected_array[k2] = v2.about_us_category.aboutus_category_id;
                    $("#add_aboutus_list_category_" + v.languages_id).val(about_us_category_selected_array);
                    $("#add_aboutus_list_category_" + v.languages_id).trigger('change');
                });
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
            url: url_gb + "/admin/AboutUs/" + id,
            data: {
                id: id
            }
        }).done(function(res) {
            resetButton(btn);
            var data = res.content;
            var status = '';
            if (data.aboutus_list_status == 1) {
                status = "Active";
            } else {
                status = "No Active";
            }
            $('#show_aboutus_list_name').text(data.aboutus_list_name);
            $('#show_aboutus_list_details').text(data.aboutus_list_details);
            $('#show_aboutus_list_status').text(status);
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
            url: url_gb + "/admin/AboutUs/ChangeStatus/" + id,
            data: {
                id: id,
                status: status ? 1 : 0,
            }
        }).done(function(res) {
            if (res.status == 1) {
                // swal(res.title, res.content, 'success');
                // tableAboutUs.api().ajax.reload();
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
            url: url_gb + "/admin/AboutUs",
            data: form.serialize()
        }).done(function(res) {
            resetButton(form.find('button[type=submit]'));
            if (res.status == 1) {
                swal(res.title, "Update", "success")
                    .then((value) => {
                        location.reload();
                    }); // form[0].reset();
                tableAboutUs.api().ajax.reload();
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
            url: url_gb + "/admin/AboutUs/" + id,
            data: form.serialize()
        }).done(function(res) {
            resetButton(form.find('button[type=submit]'));
            if (res.status == 1) {
                swal(res.title, res.content, 'success');
                form[0].reset();
                tableAboutUs.api().ajax.reload();
                $('#ModalEdit').modal('hide');
            } else {
                swal(res.title, res.content, 'error');
            }
        }).fail(function(res) {
            resetButton(form.find('button[type=submit]'));
            swal("โอ๊ะโอ! เกิดข้อผิดพลาด", res.content, 'error');
        });
    });
    $('body').on('change', '.upload-aboutus', function() {
        var ele = $(this);
        var index = ele.data('index');
        var formData = new FormData();
        var id = $(this).attr('id');
        // $('#old_aboutus_image_' + id).remove('');
        $('#preview_img_aboutus_' + id).attr('src', URL.createObjectURL(event.target.files[0]));
        formData.append('file', ele[0].files[0]);
        $.ajax({
            url: url_gb + '/admin/UploadImage/AboutusImageTemp',
            type: 'POST',
            data: formData,
            processData: false, // tell jQuery not to process the data
            contentType: false, // tell jQuery not to set contentType
            success: function(res) {
                ele.closest('.form-upload-img').find('.upload-aboutus').append('<input type="hidden" id="add_aboutus_list_image_' + id + '" name="lang[' + id + '][aboutus_list_image]" value="' + res.path + '">');
                setTimeout(function() {

                }, 100);
            }
        });
    });
</script>
@endsection
@extends('layouts.layout')@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">ContactInfo</h4>
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
                                            <input type="hidden" id="contact_info_id_{{ $val->languages_id }}" name="lang[{{$val->languages_id}}][contact_info_id]">

                                            <div class="form-group row pb-3 image_alt">
                                                <label for="add_contact_info_company" class="col-sm-3 text-right control-label col-form-label">Company</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_contact_info_company_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][contact_info_company]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3 image_alt">
                                                <label for="add_contact_info_address" class="col-sm-3 text-right control-label col-form-label">Address</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_contact_info_address_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][contact_info_address]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_contact_info_telephone" class="col-sm-3 text-right control-label col-form-label">Telephone</label>
                                                <div class="col-sm-9">
                                                    <input type="number" class="form-control" id="add_contact_info_telephone_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][contact_info_telephone]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_contact_info_fax" class="col-sm-3 text-right control-label col-form-label">Fax</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_contact_info_fax_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][contact_info_fax]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_contact_info_google_map" class="col-sm-3 text-right control-label col-form-label">Google Map</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_contact_info_google_map_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][contact_info_google_map]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3 ">
                                                <label for="add_contact_info_google_map" class="col-sm-3 text-right control-label col-form-label">Image Map</label>
                                                <div class="col-sm-9">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input upload-ContactInfo-map" id="{{$val->languages_id}}" accept="image/*" onchange="loadFile(event)">
                                                        <label class="custom-file-label" for="validatedCustomFile">Choose Image...</label>
                                                    </div>
                                                    <div class="card-body">
                                                        <img class="img-thumbnail" id="preview_img_contactInfo_map_{{$val->languages_id}}" style="width:30%;">
                                                    </div>
                                                    <!-- <input type="hidden" id="old_contact_info_image_map_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][contact_info_image_map]" value=""> -->
                                                </div>
                                            </div>
                                            <!-- <div class="form-group row pb-3">
                                                <label for="add_contact_info_image_map" class="col-sm-3 text-right control-label col-form-label">Image Map</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_contact_info_image_map_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][contact_info_image_map]">
                                                </div>
                                            </div> -->
                                            <div class="form-group row pb-3">
                                                <label for="add_contact_info_facebook" class="col-sm-3 text-right control-label col-form-label">Facebook</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_contact_info_facebook_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][contact_info_facebook]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_contact_info_tw" class="col-sm-3 text-right control-label col-form-label">Twitter</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_contact_info_tw_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][contact_info_tw]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_	contact_info_ig" class="col-sm-3 text-right control-label col-form-label">Instagram</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_contact_info_ig_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][contact_info_ig]">
                                                </div>
                                            </div>

                                            <div class="form-group row pb-3 ">
                                                <label for="add_contact_info_image" class="col-sm-3 text-right control-label col-form-label">Image</label>
                                                <div class="col-sm-9">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input upload-ContactInfo" id="{{$val->languages_id}}" accept="image/*" onchange="loadFile(event)">
                                                        <label class="custom-file-label" for="validatedCustomFile">Choose Image...</label>
                                                    </div>
                                                    <div class="card-body">
                                                        <img class="img-thumbnail" id="preview_img_contactInfo_{{$val->languages_id}}" style="width:30%;">
                                                    </div>
                                                    <!-- <input type="hidden" id="old_contact_info_image_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][contact_info_image]" value=""> -->
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_contact_info_image_alt" class="col-sm-3 text-right control-label col-form-label">Image Alt</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_contact_info_image_alt_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][contact_info_image_alt]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_contact_info_seo_title" class="col-sm-3 text-right control-label col-form-label">Seo Title</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_contact_info_seo_title_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][contact_info_seo_title]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_contact_info_seo_keyword" class="col-sm-3 text-right control-label col-form-label">Seo Keyword</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_contact_info_seo_keyword_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][contact_info_seo_keyword]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_contact_info_seo_description" class="col-sm-3 text-right control-label col-form-label">Seo Description</label>
                                                <div class="col-sm-9">
                                                    <textarea rows="4" type="text" class="form-control" id="add_contact_info_seo_description_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][contact_info_seo_description]"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3">
                                                <label for="add_contact_info_url_slug" class="col-sm-3 text-right control-label col-form-label">Url Slug</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="add_contact_info_url_slug_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][contact_info_url_slug]">
                                                </div>
                                            </div>

                                            <div class="form-group row pb-3">
                                                <label for="add_contact_info_status" class="col-sm-3 text-right control-label col-form-label">Display Status</label>
                                                <div class="col-sm-9">
                                                    <div class="form-check form-check-inline">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input" value="1" id="add_contact_info_status_{{$val->languages_id}}_1" name="lang[{{$val->languages_id}}][contact_info_status]" checked>
                                                            <label class="custom-control-label" for="add_contact_info_status_{{$val->languages_id}}_1">Active</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input" value="0" id="add_contact_info_status_{{$val->languages_id}}_2" name="lang[{{$val->languages_id}}][contact_info_status]">
                                                            <label class="custom-control-label" for="add_contact_info_status_{{$val->languages_id}}_2">Inactive</label>
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
            url: url_gb + "/admin/ContactInfo/GetContactInfo",
        }).done(function(res) {
            var data = res.content;
            var about_us_category_selected_array = [];

            $.each(data, function(k, v) {
                // console.log(v.contact_info_id);
                url_ContactInfo_map = data.ContactInfoImageMapPath + '/' + v.contact_info_image_map;
                $('#preview_img_contactInfo_map_' + v.languages_id).attr('src', url_ContactInfo_map);
                $('#old_contact_info_image_map_' + v.languages_id).val(v.contact_info_image_map);
                url_ContactInfo = data.ContactInfoImagePath + '/' + v.contact_info_image;
                $('#preview_img_contactInfo_' + v.languages_id).attr('src', url_ContactInfo);
                // $('#old_contact_info_image_' + v.languages_id).val(v.contact_info_image);
                $('#contact_info_id_' + v.languages_id).val(v.contact_info_id);
                $('#add_contact_info_company_' + v.languages_id).val(v.contact_info_company);
                $('#add_contact_info_address_' + v.languages_id).val(v.contact_info_address);
                $('#add_contact_info_telephone_' + v.languages_id).val(v.contact_info_telephone);
                $('#add_contact_info_fax_' + v.languages_id).val(v.contact_info_fax);
                $('#add_contact_info_google_map_' + v.languages_id).val(v.contact_info_google_map);
                $('#add_contact_info_image_map_' + v.languages_id).val(v.contact_info_image_map);
                $('#add_contact_info_facebook_' + v.languages_id).val(v.contact_info_facebook);
                $('#add_contact_info_tw_' + v.languages_id).val(v.contact_info_tw);
                $('#add_contact_info_ig_' + v.languages_id).val(v.contact_info_ig);
                $('#add_contact_info_image_' + v.languages_id).val(v.contact_info_image);
                $('#add_contact_info_image_alt_' + v.languages_id).val(v.contact_info_image_alt);
                $('#add_contact_info_seo_title_' + v.languages_id).val(v.contact_info_seo_title);
                $('#add_contact_info_seo_keyword_' + v.languages_id).val(v.contact_info_seo_keyword);
                $('#add_contact_info_seo_keyword_' + v.languages_id).val(v.contact_info_seo_keyword);
                $('#add_contact_info_url_slug_' + v.languages_id).val(v.contact_info_url_slug);
                $('#add_contact_info_status_' + v.languages_id).val(v.contact_info_status);

                if (v.contact_info_status == "1") {
                    $('#add_contact_info_status_' + v.languages_id + '_1').prop('checked', true);
                } else if (v.contact_info_status == "0") {
                    $('#add_contact_info_status_' + v.languages_id + '_2').prop('checked', true);
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
            url: url_gb + "/admin/ContactInfo/" + id,
            data: {
                id: id
            }
        }).done(function(res) {
            resetButton(btn);
            var data = res.content;
            var status = '';
            if (data.contact_info_status == 1) {
                status = "Active";
            } else {
                status = "No Active";
            }
            $('#show_contact_info_name').text(data.contact_info_name);
            $('#show_contact_info_details').text(data.contact_info_details);
            $('#show_contact_info_status').text(status);
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
            url: url_gb + "/admin/ContactInfo/ChangeStatus/" + id,
            data: {
                id: id,
                status: status ? 1 : 0,
            }
        }).done(function(res) {
            if (res.status == 1) {
                // swal(res.title, res.content, 'success');
                // tableContactInfo.api().ajax.reload();
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
            url: url_gb + "/admin/ContactInfo",
            data: form.serialize()
        }).done(function(res) {
            resetButton(form.find('button[type=submit]'));
            if (res.status == 1) {
                swal(res.title, "Update", "success")
                    .then((value) => {
                        location.reload();
                    }); // form[0].reset();
                tableContactInfo.api().ajax.reload();
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
            url: url_gb + "/admin/ContactInfo/" + id,
            data: form.serialize()
        }).done(function(res) {
            resetButton(form.find('button[type=submit]'));
            if (res.status == 1) {
                swal(res.title, res.content, 'success');
                form[0].reset();
                tableContactInfo.api().ajax.reload();
                $('#ModalEdit').modal('hide');
            } else {
                swal(res.title, res.content, 'error');
            }
        }).fail(function(res) {
            resetButton(form.find('button[type=submit]'));
            swal("โอ๊ะโอ! เกิดข้อผิดพลาด", res.content, 'error');
        });
    });
    $('body').on('change', '.upload-ContactInfo-map', function() {
        var ele = $(this);
        var index = ele.data('index');
        var formData = new FormData();
        var id = $(this).attr('id');
        $('#preview_img_contactInfo_map_' + id).attr('src', URL.createObjectURL(event.target.files[0]));
        // $('#old_contact_info_image_map_' + id).remove('');
        formData.append('file', ele[0].files[0]);
        $.ajax({
            url: url_gb + '/admin/UploadImage/ContactInfoMapImageTemp',
            type: 'POST',
            data: formData,
            processData: false, // tell jQuery not to process the data
            contentType: false, // tell jQuery not to set contentType
            success: function(res) {
                ele.closest('.form-upload-img').find('.upload-ContactInfo-map').append('<input type="hidden" id="add_contact_info_image_map_' + id + '" name="lang[' + id + '][contact_info_image_map]" value="' + res.path + '">');
                setTimeout(function() {

                }, 100);
            }
        });
    });

    $('body').on('change', '.upload-ContactInfo', function() {
        var ele = $(this);
        var index = ele.data('index');
        var formData = new FormData();
        var id = $(this).attr('id');
        $('#preview_img_contactInfo_' + id).attr('src', URL.createObjectURL(event.target.files[0]));
        // $('#old_contact_info_image_' + id).remove('');
        formData.append('file', ele[0].files[0]);
        $.ajax({
            url: url_gb + '/admin/UploadImage/ContactInfoImageTemp',
            type: 'POST',
            data: formData,
            processData: false, // tell jQuery not to process the data
            contentType: false, // tell jQuery not to set contentType
            success: function(res) {
                ele.closest('.form-upload-img').find('.upload-ContactInfo').append('<input type="hidden" id="add_contact_info_image_' + id + '" name="lang[' + id + '][contact_info_image]" value="' + res.path + '">');
                setTimeout(function() {

                }, 100);
            }
        });
    });
</script>
@endsection
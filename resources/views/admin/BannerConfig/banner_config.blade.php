@extends('layouts.layout')@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Banner Config</h4>
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
                                            <input type="hidden" id="banner_config_id_{{ $val->languages_id }}" name="lang[{{$val->languages_id}}][banner_config_id]">

                                            <div class="form-group row pb-3 image_alt">
                                                <label for="add_banner_config_time" class="col-sm-3 text-right control-label col-form-label">Time</label>
                                                <div class="col-sm-9">
                                                    <input type="number" class="form-control" id="add_banner_config_time_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][banner_config_time]">
                                                </div>
                                            </div>
                                            <div class="form-group row pb-3 image_alt">
                                                <label for="add_banner_config_page_change" class="col-sm-3 text-right control-label col-form-label">Page Change</label>
                                                <div class="col-sm-9">
                                                    <input type="number" class="form-control" id="add_banner_config_page_change_{{$val->languages_id}}" name="lang[{{$val->languages_id}}][banner_config_page_change]">
                                                </div>
                                            </div>

                                            <div class="form-group row pb-3">
                                                <label for="add_banner_config_status" class="col-sm-3 text-right control-label col-form-label">Display Status</label>
                                                <div class="col-sm-9">
                                                    <div class="form-check form-check-inline">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input" value="1" id="add_banner_config_status_{{$val->languages_id}}_1" name="lang[{{$val->languages_id}}][banner_config_status]" checked>
                                                            <label class="custom-control-label" for="add_banner_config_status_{{$val->languages_id}}_1">Active</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input" value="0" id="add_banner_config_status_{{$val->languages_id}}_2" name="lang[{{$val->languages_id}}][banner_config_status]">
                                                            <label class="custom-control-label" for="add_banner_config_status_{{$val->languages_id}}_2">Inactive</label>
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
            url: url_gb + "/admin/BannerConfig/GetBannerConfig",
        }).done(function(res) {
            var data = res.content;
            var about_us_category_selected_array = [];
            $.each(data, function(k, v) {
                $("#banner_config_id_" + v.languages_id).val(v.banner_config_id);
                $("#add_banner_config_time_" + v.languages_id).val(v.banner_config_time);
                $("#add_banner_config_page_change_" + v.languages_id).val(v.banner_config_page_change);
                
                if (v.banner_config_status == "1") {
                    $('#add_banner_config_status_' + v.languages_id + '_1').prop('checked', true);
                } else if (v.banner_config_status == "0") {
                    $('#add_banner_config_status_' + v.languages_id + '_2').prop('checked', true);
                }
            });



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
            url: url_gb + "/admin/BannerConfig/ChangeStatus/" + id,
            data: {
                id: id,
                status: status ? 1 : 0,
            }
        }).done(function(res) {
            if (res.status == 1) {
                // swal(res.title, res.content, 'success');
                // tableBannerConfig.api().ajax.reload();
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
            url: url_gb + "/admin/BannerConfig",
            data: form.serialize()
        }).done(function(res) {
            resetButton(form.find('button[type=submit]'));
            if (res.status == 1) {
                swal(res.title, "Update", "success")
                    .then((value) => {
                        location.reload();
                    }); // form[0].reset();
                tableBannerConfig.api().ajax.reload();
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
            url: url_gb + "/admin/BannerConfig/" + id,
            data: form.serialize()
        }).done(function(res) {
            resetButton(form.find('button[type=submit]'));
            if (res.status == 1) {
                swal(res.title, res.content, 'success');
                form[0].reset();
                tableBannerConfig.api().ajax.reload();
                $('#ModalEdit').modal('hide');
            } else {
                swal(res.title, res.content, 'error');
            }
        }).fail(function(res) {
            resetButton(form.find('button[type=submit]'));
            swal("โอ๊ะโอ! เกิดข้อผิดพลาด", res.content, 'error');
        });
    });
   
</script>
@endsection
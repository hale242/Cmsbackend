<script type="text/javascript">
    $('body').on('change', '.select-geography', function(){
        var ele = $(this).closest('.address');
        var geo_id = $(this).val();
        ele.find('.select-province').html('<option value="">เลือกจังหวัด</option>');
        ele.find('.select-amphur').html('<option value="">เลือกอำเภอ</option>');
        ele.find('.select-district').html('<option value="">เลือกตำบล</option>');
        ele.find('.zipcode').val('');
        if(geo_id){
            $.ajax({
                method : "GET",
                url : url_gb+"/admin/GetProvinceByGeography/"+geo_id,
                dataType : 'json',
            }).done(function(res){
                var html = '';
                $.each(res, function(k, v) {
                    html += '<option value="'+v.provinces_id+'">'+v.provinces_name+'</option>';
                });
                ele.find('.select-province').append(html);
                ele.find('.select-province').select2('destroy').select2();
                ele.find('.select-amphur').select2('destroy').select2();
                ele.find('.select-district').select2('destroy').select2();

            }).fail(function(){
                swal("system.system_alert","system.system_error","error");
            });
        }
    });


    $('body').on('change', '.select-province', function(){
        var ele = $(this).closest('.address');
        var province_id = $(this).val();
        ele.find('.select-amphur').html('<option value="">เลือกอำเภอ</option>');
        ele.find('.select-district').html('<option value="">เลือกตำบล</option>');
        ele.find('.zipcode').val('');
        if(province_id){
            $.ajax({
                method : "GET",
                url : url_gb+"/admin/GetAmphurByProvince/"+province_id,
                dataType : 'json',
            }).done(function(res){
                var html = '';
                $.each(res, function(k, v) {
                    html += '<option value="'+v.amphures_id+'">'+v.amphures_name+'</option>';
                });
                ele.find('.select-amphur').append(html);
                ele.find('.select-amphur').select2('destroy').select2();
                ele.find('.select-district').select2('destroy').select2();

            }).fail(function(){
                swal("system.system_alert","system.system_error","error");
            });
        }
    });

    $('body').on('change', '.select-amphur', function(){
        var ele = $(this).closest('.address');
        var amphur_id = $(this).val();
        ele.find('.select-district').html('<option value="">เลือกตำบล</option>');
        ele.find('.zipcode').val('');
        if(amphur_id){
            $.ajax({
                method : "GET",
                url : url_gb+"/admin/GetDistrictByAmphur/"+amphur_id,
                dataType : 'json',
            }).done(function(res){
                var html = '';
                $.each(res, function(k, v) {
                    html += '<option value="'+v.districts_id+'" data-district-code="'+v.districts_code+'">'+v.districts_name+'</option>';
                });
                ele.find('.select-district').append(html);
                ele.find('.select-district').select2('destroy').select2();
            }).fail(function(){
                swal("system.system_alert","system.system_error","error");
            });
        }
    });

    $('body').on('change', '.select-district', function(){
        var ele = $(this).closest('.address');
        var districts_code = $(this).find('option:selected').data('district-code');
        ele.find('.zipcode').val('');
        if(districts_code){
            $.ajax({
                method : "GET",
                url : url_gb+"/admin/GetZipcodeByDistrict/"+districts_code,
                dataType : 'json',
            }).done(function(res){
                ele.find('.zipcode').val(res.zipcodes_name);
            }).fail(function(){
                swal("system.system_alert","system.system_error","error");
            });
        }
    });
</script>

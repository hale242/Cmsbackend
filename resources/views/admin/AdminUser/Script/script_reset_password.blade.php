<script>
    $('body').on('click','.btn-reset-password',function(data){
        var id = $(this).data('id');
        $('#reset_password_admin_id').val(id);
        $('#ModalResetPassword').modal('show');
    });

    $('body').on('submit', '#FormResetPassword', function(e) {
        e.preventDefault();
        var form = $(this);
        var id = $('#reset_password_admin_id').val();
        loadingButton(form.find('button[type=submit]'));
        $.ajax({
            method: "POST",
            url: url_gb+"/admin/AdminUser/ResetPassword/"+id,
            data: form.serialize()
        }).done(function(res) {
            resetButton(form.find('button[type=submit]'));
            if (res.status == 1) {
                swal(res.title, res.content, 'success');
                form[0].reset();
                tableAdminUser.api().ajax.reload();
                $('#ModalResetPassword').modal('hide');
            } else {
                swal(res.title, res.content, 'error');
            }
        }).fail(function(res) {
            resetButton(form.find('button[type=submit]'));
            swal("โอ๊ะโอ! เกิดข้อผิดพลาด", res.content, 'error');
        });
    });

    $('body').on('change', '.check-all', function(){
        var id = $(this).val();
        var ele = $(this).closest('tr').find('.check-item');
        if($(this).is(':checked')){
            ele.prop('checked', true);
        }else{
            ele.prop('checked', false);
        }
    });
</script>

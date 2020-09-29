<script>
  $('body').on('click','.btn-permission',function(data){
      var id = $(this).data('id');
      var btn = $(this);
      $('#admin_id').val(id);
      $('.check-all').prop('checked', false)
      $('.check-item').prop('checked', false)
      loadingButton(btn);
      $.ajax({
          method: "GET",
          url: url_gb+"/admin/AdminUser/"+id,
          data: {
              id: id
          }
      }).done(function(res) {
          resetButton(btn);
          var permission = res.content ? res.content.permission_action : '';
          $.each(permission, function(k,v){
              if(v.permission_action_code_action == 1){
                  if(v.permission_action_status == 1){
                      $('#menu_view_'+v.menu_system_id).prop('checked', true);
                  }else{
                      $('#menu_view_'+v.menu_system_id).prop('checked', false);
                  }
              }else if(v.permission_action_code_action == 2){
                  if(v.permission_action_status == 1){
                      $('#menu_add_'+v.menu_system_id).prop('checked', true);
                  }else{
                      $('#menu_add_'+v.menu_system_id).prop('checked', false);
                  }
              }else if(v.permission_action_code_action == 3){
                  if(v.permission_action_status == 1){
                      $('#menu_edit_'+v.menu_system_id).prop('checked', true);
                  }else{
                      $('#menu_edit_'+v.menu_system_id).prop('checked', false);
                  }
              }else if(v.permission_action_code_action == 4){
                  if(v.permission_action_status == 1){
                      $('#menu_delete_'+v.menu_system_id).prop('checked', true);
                  }else{
                      $('#menu_delete_'+v.menu_system_id).prop('checked', false);
                  }
              }
          });
          $('#ModalPermission').modal('show');
      }).fail(function(res) {
          resetButton(form.find('button[type=submit]'));
          swal("โอ๊ะโอ! เกิดข้อผิดพลาด", res.content, 'error');
      });
  });

  $('body').on('submit', '#FormPremission', function(e) {
      e.preventDefault();
      var form = $(this);
      var id = $('#admin_id').val();
      loadingButton(form.find('button[type=submit]'));
      $.ajax({
          method: "POST",
          url: url_gb+"/admin/AdminUser/SetPremission/"+id,
          data: form.serialize()
      }).done(function(res) {
          resetButton(form.find('button[type=submit]'));
          if (res.status == 1) {
              tableAdminUser.api().ajax.reload();
              swal(res.title, res.content, 'success');
              $('#ModalPermission').modal('hide');
          } else {
              swal(res.title, res.content, 'error');
          }
      }).fail(function(res) {
          resetButton(form.find('button[type=submit]'));
          swal("โอ๊ะโอ! เกิดข้อผิดพลาด", res.content, 'error');
      });
  });
</script>

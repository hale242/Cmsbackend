<?php
namespace App;
use Auth;
use App\MenuSystem;
use App\Runnumber;
use App\RunCode;

class Helper
{
    public static function CheckPermissionMenu($url, $permission){
        $admin_id = Auth::guard('admin')->user()->admin_id;
        $check_permission_department = MenuSystem::join('permission_action_by_group', 'permission_action_by_group.menu_system_id', 'menu_system.menu_system_id')
                  ->join('admin_group', 'admin_group.admin_user_group_id', 'permission_action_by_group.admin_user_group_id')
                  ->where([
                      'menu_system.menu_system_status' => 1,
                      'menu_system.menu_system_part' => $url,
                      'admin_group.admin_id' => $admin_id,
                      'permission_action_by_group.permission_action_by_group_code_action' => $permission,
                      'permission_action_by_group.permission_action_by_group_status' => 1,
                  ])->first();
        $check_permission_admin_user = MenuSystem::join('permission_action', 'permission_action.menu_system_id', 'menu_system.menu_system_id')
                  ->where([
                      'menu_system.menu_system_status' => 1,
                      'menu_system.menu_system_part' => $url,
                      'permission_action.admin_id' => $admin_id,
                      'permission_action.permission_action_code_action' => $permission,
                      'permission_action.permission_action_status' => 1,
                  ])->first();
        if($check_permission_department || $check_permission_admin_user){
            return true;
        }else{
            return false;
        }
    }
}



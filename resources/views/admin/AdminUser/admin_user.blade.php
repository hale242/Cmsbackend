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
                                <label class="control-label">Username</label>
                                <input type="text" id="search_username" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Firstname</label>
                                <input type="text" id="search_name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Lastname</label>
                                <input type="text" id="search_last_name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">E-mail</label>
                                <input type="email" id="search_email" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Gender</label>
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input search_gender" value="all" id="search_gender_id_all" name="search_gender_id">
                                    <label class="custom-control-label" for="search_gender_id_all">All</label>
                                </div>
                                @foreach($Genders as $val)
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input search_gender" value="{{$val->gender_id}}" id="search_gender_id_{{$val->gender_id}}" name="search_gender_id">
                                    <label class="custom-control-label" for="search_gender_id_{{$val->gender_id}}">{{$val->gender_name}}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Department</label>
                                @foreach($AdminUserGroups as $val)
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input search_admin_user_group" value="{{$val->admin_user_group_id}}" id="search_admin_user_group_id_{{$val->admin_user_group_id}}">
                                    <label class="custom-control-label" for="search_admin_user_group_id_{{$val->admin_user_group_id}}">{{$val->admin_user_group_name}}</label>
                                </div>
                                @endforeach
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
                    <h4 class="card-title">{{ $MainMenus->menu_system_name }}</h4>
                    @if(App\Helper::CheckPermissionMenu('AdminUser' , '2'))
                    <button type="button" class="btn btn-primary btn-rounded m-t-10 mb-2 float-right newdata btn-add">Add New</button>
                    @endif
                </div>
                <div class="table-responsive">
                    <!-- <div class="action-tables">
                        <a href="javascript:void(0)" class="checkbox-checkall" data-checked="no">
                            <span class="badge badge-light mr-2"><i class="ti-check"></i></span> Check All
                        </a>
                        <a href="javascript:void(0)">
                            <span class="badge badge-info mr-2"><i class="ti-check"></i></span> Approve
                        </a>
                        <a href="javascript:void(0)">
                            <span class="badge badge-warning mr-2"><i class="ti-alert"></i></span> Waiting
                        </a>
                        <a href="javascript:void(0)">
                            <span class="badge badge-secondary mr-2"><i class="ti-back-right"></i></span> Reject
                        </a>
                        <a href="javascript:void(0)">
                            <span class="badge badge-danger mr-2"><i class="ti-trash"></i></span> Delete
                        </a>
                        <a href="javascript:void(0)">
                            <span class="badge badge-warning mr-2"><i class="ti-export"></i></span> Export
                        </a>
                    </div> -->
                    <table id="tableAdminUser" class="table">
                        <thead>
                            <tr>
                                <!-- <th scope="col">#</th> -->
                                <th scope="col">No</th>
                                <th scope="col">Username</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Department</th>
                                <th scope="col">Create Date</th>
                                <th scope="col">Last Login</th>
                                <th scope="col">Action</th>
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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="mdi mdi-close"></i></span></button>
            </div>
            <form id="FormAdd" class="needs-validation" novalidate>
                <div class="card">
                    <div class="form-body">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="gendedr">Gender</label>
                                    <br>
                                    @foreach($Genders as $val)
                                    <div class="form-check form-check-inline">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" value="{{$val->gender_id}}" id="add_gender_id_{{$val->gender_id}}" name="gender_id">
                                            <label class="custom-control-label" for="add_gender_id_{{$val->gender_id}}">{{$val->gender_name}}</label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="control-label" for="add_name_prefix_id">Name prefix</label><br>
                                    <select class="form-control select2" name="name_prefix_id" id="add_name_prefix_id" data-placeholder="Select Name Prefix">
                                        <option value="">Select Name Prefix</option>
                                        @foreach($NamePrefixs as $val)
                                        <option value="{{$val->name_prefix_id}}">{{$val->name_prefix_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="add_name">Firstname</label>
                                    <input type="text" class="form-control" id="add_name" name="name">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="add_last_name">Lastname</label>
                                    <input type="text" class="form-control" id="add_last_name" name="last_name">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="add_email">E-mail</label>
                                    <input type="email" class="form-control" id="add_email" name="email">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="add_phone">Phone number</label>
                                    <input type="text" class="form-control" id="add_phone" name="phone">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="add_username">Username</label>
                                    <input type="text" class="form-control" id="add_username" name="username" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="add_password">Password</label>
                                    <input type="password" class="form-control" id="add_password" name="password" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="add_pin">PIN</label>
                                    <input type="text" class="form-control" id="add_pin" name="pin">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="Check-Box">Department</label> <br />
                                    @foreach($AdminUserGroups as $val)
                                    <div class="form-check form-check-inline">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" value="{{$val->admin_user_group_id}}" id="add_admin_user_group_id_{{$val->admin_user_group_id}}" name="admin_user_group_id[]">
                                            <label class="custom-control-label" for="add_admin_user_group_id_{{$val->admin_user_group_id}}">{{$val->admin_user_group_name}}</label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <!-- <div class="col-md-6 mb-3 form-upload">
                                    <label for="add_image">Profile Picture</label>
                                    <input type="file" class="form-control-file upload-image" id="add_image" name="image">
                                    <img class="preview-img" style="width:100px;">
                                </div> -->
                                <div class="col-md-6 mb-3">
                                    <label for="active">Status</label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="add_status" name="status" value="1">
                                        <label class="custom-control-label" for="add_status">Active</label>
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
    <div class="modal-dialog modal-lg" role="document">
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
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="gendedr">Gender</label>
                                    <br>
                                    @foreach($Genders as $val)
                                    <div class="form-check form-check-inline">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" value="{{$val->gender_id}}" id="edit_gender_id_{{$val->gender_id}}" name="gender_id">
                                            <label class="custom-control-label" for="edit_gender_id_{{$val->gender_id}}">{{$val->gender_name}}</label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="control-label" for="edit_name_prefix_id">Name Prefix</label><br>
                                    <select class="form-control select2" name="name_prefix_id" id="edit_name_prefix_id" data-placeholder="Select Name Prefix">
                                        <option value="">Select Name Prefix</option>
                                        @foreach($NamePrefixs as $val)
                                        <option value="{{$val->name_prefix_id}}">{{$val->name_prefix_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="edit_name">Firstname</label>
                                    <input type="text" class="form-control" id="edit_name" name="name">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="edit_last_name">Lastname</label>
                                    <input type="text" class="form-control" id="edit_last_name" name="last_name">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="edit_email">E-mail</label>
                                    <input type="email" class="form-control" id="edit_email" name="email">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="edit_phone">Phone number</label>
                                    <input type="text" class="form-control" id="edit_phone" name="phone">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="edit_username">Username</label>
                                    <input type="text" class="form-control" id="edit_username" name="username" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="edit_password">Password</label>
                                    <input type="password" class="form-control" id="edit_password" name="" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="edit_pin">PIN</label>
                                    <input type="text" class="form-control" id="edit_pin" name="pin">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="Check-Box">Department</label> <br />
                                    @foreach($AdminUserGroups as $val)
                                    <div class="form-check form-check-inline">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input check-group" value="{{$val->admin_user_group_id}}" id="edit_admin_user_group_id_{{$val->admin_user_group_id}}" name="admin_user_group_id[]">
                                            <label class="custom-control-label" for="edit_admin_user_group_id_{{$val->admin_user_group_id}}">{{$val->admin_user_group_name}}</label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="edit_status">Status</label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input check-group" id="edit_status" name="status" value="1">
                                        <label class="custom-control-label" for="add_status">Active</label>
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

<div class="modal fade" id="ModalView" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">View</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="mdi mdi-close"></i></span></button>
            </div>
            <form id="FormView">
                <div class="card">
                    <div class="form-body">
                        <div class="modal-body form-horizontal">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td width="300">
                                                    <label for="show__gender_name" class="col-form-label">Gender</label>
                                                </td>
                                                <td>
                                                    <label id="show_gender_name" class="col-form-label"></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="300">
                                                    <label for="show_name_prefix_name" class="col-form-label">Name Prefix</label>
                                                </td>
                                                <td>
                                                    <label id="show_name_prefix_name" class="col-form-label"></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="300">
                                                    <label for="show_name" class="col-form-label">Firstname</label>
                                                </td>
                                                <td>
                                                    <label id="show_name" class="col-form-label"></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="300">
                                                    <label for="show_last_name" class="col-form-label">Lastname</label>
                                                </td>
                                                <td>
                                                    <label id="show_last_name" class="col-form-label"></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="300">
                                                    <label for="show_email" class="col-form-label">E-mail</label>
                                                </td>
                                                <td>
                                                    <label id="show_email" class="col-form-label"></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="300">
                                                    <label for="show_phone" class="col-form-label">Phone number</label>
                                                </td>
                                                <td>
                                                    <label id="show_phone" class="col-form-label"></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="300">
                                                    <label for="show_username" class="col-form-label">Username</label>
                                                </td>
                                                <td>
                                                    <label id="show_username" class="col-form-label"></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="300">
                                                    <label for="show_pin" class="col-form-label">PIN</label>
                                                </td>
                                                <td>
                                                    <label id="show_pin" class="col-form-label"></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="300">
                                                    <label for="show_status" class="col-form-label">Status</label>
                                                </td>
                                                <td>
                                                    <label id="show_status" class="col-form-label"></label>
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
                    <div class="form-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalPermission" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">View</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="mdi mdi-close"></i></span></button>
            </div>
            <form id="FormPremission">
                <input type="hidden" id="admin_id">
                <div class="card">
                    <div class="form-body">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <table class="table mb-0 dataTables_wrapper no-footer">
                                        <thead>
                                            <tr>
                                                <th scope="col">Menu</th>
                                                <th scope="col">All</th>
                                                <th scope="col">View</th>
                                                <th scope="col">Add</th>
                                                <th scope="col">Edit</th>
                                                <th scope="col">Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($PermisstionMenus as $main_val)
                                            <tr>
                                                <td>{{$main_val->menu_system_name}}</td>
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input checkbox-table check-all" data-id="{{$main_val->menu_system_id}}" id="main_all_{{$main_val->menu_system_id}}">
                                                        <label class="custom-control-label" for="main_all_{{$main_val->menu_system_id}}"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input checkbox-table check-item" name="menu[{{$main_val->menu_system_id}}][view]" id="menu_view_{{$main_val->menu_system_id}}" value="1">
                                                        <label class="custom-control-label" for="menu_view_{{$main_val->menu_system_id}}"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input checkbox-table check-item" name="menu[{{$main_val->menu_system_id}}][add]" id="menu_add_{{$main_val->menu_system_id}}" value="2">
                                                        <label class="custom-control-label" for="menu_add_{{$main_val->menu_system_id}}"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input checkbox-table check-item" name="menu[{{$main_val->menu_system_id}}][edit]" id="menu_edit_{{$main_val->menu_system_id}}" value="3">
                                                        <label class="custom-control-label" for="menu_edit_{{$main_val->menu_system_id}}"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input checkbox-table check-item" name="menu[{{$main_val->menu_system_id}}][delete]" id="menu_delete_{{$main_val->menu_system_id}}" value="4">
                                                        <label class="custom-control-label" for="menu_delete_{{$main_val->menu_system_id}}"></label>
                                                    </div>
                                                </td>
                                            </tr>
                                            @foreach($main_val->SubMenu as $sub_val)
                                            <tr>
                                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <i class="mdi mdi-checkbox-blank-circle" style="font-size: 8px;"></i> {{$sub_val->menu_system_name}}</td>
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input checkbox-table check-all" id="sub_all_{{$sub_val->menu_system_id}}">
                                                        <label class="custom-control-label" for="sub_all_{{$sub_val->menu_system_id}}"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input checkbox-table check-item" name="menu[{{$sub_val->menu_system_id}}][view]" id="menu_view_{{$sub_val->menu_system_id}}" value="1">
                                                        <label class="custom-control-label" for="menu_view_{{$sub_val->menu_system_id}}"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input checkbox-table check-item" name="menu[{{$sub_val->menu_system_id}}][add]" id="menu_add_{{$sub_val->menu_system_id}}" value="2">
                                                        <label class="custom-control-label" for="menu_add_{{$sub_val->menu_system_id}}"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input checkbox-table check-item" name="menu[{{$sub_val->menu_system_id}}][edit]" id="menu_edit_{{$sub_val->menu_system_id}}" value="3">
                                                        <label class="custom-control-label" for="menu_edit_{{$sub_val->menu_system_id}}"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input checkbox-table check-item" name="menu[{{$sub_val->menu_system_id}}][delete]" id="menu_delete_{{$sub_val->menu_system_id}}" value="4">
                                                        <label class="custom-control-label" for="menu_delete_{{$sub_val->menu_system_id}}"></label>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
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


<div class="modal fade" id="ModalResetPassword" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Reset Password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="mdi mdi-close"></i></span></button>
            </div>
            <form id="FormResetPassword" class="needs-validation" novalidate>
                <input type="hidden" id="reset_password_admin_id">
                <div class="card">
                    <div class="form-body">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <label class="control-label" for="reset_password">New Password</label>
                                    <input type="password" class="form-control" id="reset_password" name="password" required>
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
@endsection
@section('scripts')
<script>
    var admin_user_group_id = [];
    var department_id = [];
    var position_id = [];
    $(document).ready(function() {
        var tableAdminUser = $('#tableAdminUser').dataTable({
            "ajax": {
                "url": url_gb + "/admin/AdminUser/Lists",
                "type": "POST",
                "data": function(d) {
                    d.username = $('#search_username').val(),
                        d.name = $('#search_name').val(),
                        d.last_name = $('#search_last_name').val(),
                        d.email = $('#search_email').val(),
                        d.gender_id = $("input[name='search_gender_id']:checked").val()
                    d.admin_user_group_id = admin_user_group_id,
                        d.position_id = position_id
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
                    "data": "username",
                    "class": "text-center"
                },
                {
                    "data": "name"
                },
                {
                    "data": "email"
                },
                {
                    "data": "department",
                    "class": "text-center"
                },
                {
                    "data": "created_at",
                    "class": "text-center"
                },
                {
                    "data": "last_login",
                    "class": "text-center"
                },
                {
                    "data": "action"
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

        $('body').on('click', '.btn-search', function(data) {
            admin_user_group_id = [];
            department_id = [];
            position_id = [];
            $(".search_admin_user_group:checked").each(function() {
                admin_user_group_id.push(this.value);
            });
            $(".search_department:checked").each(function() {
                department_id.push(this.value);
            });
            $(".search_position:checked").each(function() {
                position_id.push(this.value);
            });
            tableAdminUser.api().ajax.reload();
        });

        $('body').on('click', '.btn-clear-search', function(data) {
            $('#search_username').val('');
            $('#search_name').val('');
            $('#search_last_name').val('');
            $('#search_email').val('');
            $('#search_gender_id_all').prop('checked', true);
            $('.search_admin_user_group').prop('checked', false);
            admin_user_group_id = [];
            department_id = [];
            tableAdminUser.api().ajax.reload();
        });

        $('body').on('click', '.btn-add', function(data) {
            $('#ModalAdd').modal('show');
        });

        $('body').on('click', '.btn-reset-password', function(data) {
            var id = $(this).data('id');
            $('#reset_password_admin_id').val(id);
            $('#ModalResetPassword').modal('show');
        });

        $('body').on('click', '.btn-edit', function(data) {
            var id = $(this).data('id');
            var btn = $(this);
            $('#edit_id').val(id);
            $('.check-group').prop('checked', false)
            loadingButton(btn);
            $.ajax({
                method: "GET",
                url: url_gb + "/admin/AdminUser/" + id,
                data: {
                    id: id
                }
            }).done(function(res) {
                resetButton(btn);
                var data = res.content;
                // $('#edit_admin_user_employee_code').val(data.admin_user_employee_code);
                // $('#edit_admin_user_code_sale').val(data.admin_user_code_sale);
                $('#edit_name').val(data.name);
                $('#edit_last_name').val(data.last_name);
                $('#edit_email').val(data.email);
                $('#edit_phone').val(data.phone);
                $('#edit_username').val(data.username);
                $('#edit_pin').val(data.pin);
                $('#edit_status').val(data.status);
                $('#edit_name_prefix_id').val(data.name_prefix_id).change();
                // $('#edit_position_id').val(data.position_id).change();
                // $('#edit_head_documents_id').val(data.head_documents_id).change();
                if (data.status == 1) {
                    $('#edit_status').prop('checked', true);
                } else {
                    $('#edit_status').prop('checked', false);
                }
                // $.each(data.admin_group, function(k,v) {
                //     $('#edit_admin_id_'+v.admin_user_group_id).prop('checked', true);
                // });
                $.each(data.admin_group, function(k, v) {
                    $('#edit_admin_user_group_id_' + v.admin_user_group_id).prop('checked', true);
                });
                $('#edit_gender_id_' + data.gender_id).prop('checked', true);
                // if(data.image){
                //     $('#edit_image').closest('.form-body').find('.preview-img').attr('src', data.image);
                // }else{
                //     $('#edit_image').closest('.form-body').find('.preview-img').attr('src', '');
                // }
                $('#ModalEdit').modal('show');
            }).fail(function(res) {
                resetButton(form.find('button[type=submit]'));
                swal("โอ๊ะโอ! เกิดข้อผิดพลาด", res.content, 'error');
            });
        });

        $('body').on('click', '.btn-view', function(data) {
            var id = $(this).data('id');
            var btn = $(this);
            $('#show_image').text('');
            loadingButton(btn);
            $.ajax({
                method: "GET",
                url: url_gb + "/admin/AdminUser/" + id,
                data: {
                    id: id
                }
            }).done(function(res) {
                resetButton(btn);
                var status = '';
                // var department_name = [];
                // var group_lavel_name = [];
                var data = res.content;
                var gender_name = data.gender ? data.gender.gender_name : '';
                var prefix_name = data.name_prefix ? data.name_prefix.name_prefix_name : '';
                // var departments = data.department_admin_user;
                // var group_lavels = data.admin_group;
                // var position_name = data.position ? data.position.position_name : '';
                if (data.status == 1) {
                    status = 'Active'
                } else {
                    status = 'No Active'
                }
                // $.each(departments, function(k,v) {
                //     var name = v.department ? v.department.department_name : '';
                //     department_name.push(name);
                // });
                // $.each(group_lavels, function(k,v) {
                //     var name = v.group_level ? v.group_level.admin_user_group_name : '';
                //     group_lavel_name.push(name);
                // });
                // $('#show_image').append('<img src="'+data.image+'" id="picture" width="200">');
                // $('#show_admin_user_employee_code').text(data.admin_user_employee_code);
                // $('#show_admin_user_code_sale').text(data.admin_user_employee_code);
                $('#show_gender_name').text(gender_name);
                $('#show_name_prefix_name').text(prefix_name);
                $('#show_name').text(data.name);
                $('#show_last_name').text(data.last_name);
                $('#show_email').text(data.email);
                $('#show_phone').text(data.phone);
                // $('#show_department_name').text(department_name.toString());
                // $('#show_admin_user_grop_name').text(group_lavel_name.toString());
                // $('#show_position_name').text(position_name);
                $('#show_username').text(data.username);
                $('#show_pin').text(data.pin);
                $('#show_status').text(status);
                $('#ModalView').modal('show');
            }).fail(function(res) {
                resetButton(form.find('button[type=submit]'));
                swal("โอ๊ะโอ! เกิดข้อผิดพลาด", res.content, 'error');
            });
        });

        $('body').on('click', '.btn-permission', function(data) {
            var id = $(this).data('id');
            var btn = $(this);
            $('#admin_id').val(id);
            $('.check-all').prop('checked', false)
            $('.check-item').prop('checked', false)
            loadingButton(btn);
            $.ajax({
                method: "GET",
                url: url_gb + "/admin/AdminUser/" + id,
                data: {
                    id: id
                }
            }).done(function(res) {
                resetButton(btn);
                var permission = res.content ? res.content.permission_action : '';
                $.each(permission, function(k, v) {
                    if (v.permission_action_code_action == 1) {
                        if (v.permission_action_status == 1) {
                            $('#menu_view_' + v.menu_system_id).prop('checked', true);
                        } else {
                            $('#menu_view_' + v.menu_system_id).prop('checked', false);
                        }
                    } else if (v.permission_action_code_action == 2) {
                        if (v.permission_action_status == 1) {
                            $('#menu_add_' + v.menu_system_id).prop('checked', true);
                        } else {
                            $('#menu_add_' + v.menu_system_id).prop('checked', false);
                        }
                    } else if (v.permission_action_code_action == 3) {
                        if (v.permission_action_status == 1) {
                            $('#menu_edit_' + v.menu_system_id).prop('checked', true);
                        } else {
                            $('#menu_edit_' + v.menu_system_id).prop('checked', false);
                        }
                    } else if (v.permission_action_code_action == 4) {
                        if (v.permission_action_status == 1) {
                            $('#menu_delete_' + v.menu_system_id).prop('checked', true);
                        } else {
                            $('#menu_delete_' + v.menu_system_id).prop('checked', false);
                        }
                    }
                });
                $('#ModalPermission').modal('show');
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
                url: url_gb + "/admin/AdminUser/ChangeStatus/" + id,
                data: {
                    id: id,
                    status: status ? 1 : 0,
                }
            }).done(function(res) {
                if (res.status == 1) {
                    // swal(res.title, res.content, 'success');
                    // tableAdminUser.api().ajax.reload();
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
                url: url_gb + "/admin/AdminUser",
                data: form.serialize(),
            }).done(function(res) {
                resetButton(form.find('button[type=submit]'));
                if (res.status == 1) {
                    swal(res.title, res.content, 'success');
                    form[0].reset();
                    $('#add_image').closest('.form-body').find('.preview-img').attr('src', '');
                    tableAdminUser.api().ajax.reload();
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
                url: url_gb + "/admin/AdminUser/" + id,
                data: form.serialize()
            }).done(function(res) {
                resetButton(form.find('button[type=submit]'));
                if (res.status == 1) {
                    swal(res.title, res.content, 'success');
                    form[0].reset();
                    tableAdminUser.api().ajax.reload();
                    $('#ModalEdit').modal('hide');
                } else {
                    swal(res.title, res.content, 'error');
                }
            }).fail(function(res) {
                resetButton(form.find('button[type=submit]'));
                swal("โอ๊ะโอ! เกิดข้อผิดพลาด", res.content, 'error');
            });
        });

        $('body').on('submit', '#FormResetPassword', function(e) {
            e.preventDefault();
            var form = $(this);
            var id = $('#reset_password_admin_id').val();
            loadingButton(form.find('button[type=submit]'));
            $.ajax({
                method: "POST",
                url: url_gb + "/admin/AdminUser/ResetPassword/" + id,
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

        $('body').on('submit', '#FormPremission', function(e) {
            e.preventDefault();
            var form = $(this);
            var id = $('#admin_id').val();
            loadingButton(form.find('button[type=submit]'));
            $.ajax({
                method: "POST",
                url: url_gb + "/admin/AdminUser/SetPremission/" + id,
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

        $('body').on('change', '.check-all', function() {
            var id = $(this).val();
            var ele = $(this).closest('tr').find('.check-item');
            if ($(this).is(':checked')) {
                ele.prop('checked', true);
            } else {
                ele.prop('checked', false);
            }
        });

        $('body').on('change', '.upload-image', function() {
            var ele = $(this);
            var formData = new FormData();
            formData.append('file', ele[0].files[0]);
            $.ajax({
                url: url_gb + '/admin/UploadFile/AdminUser',
                type: 'POST',
                data: formData,
                processData: false, // tell jQuery not to process the data
                contentType: false, // tell jQuery not to set contentType
                success: function(res) {
                    ele.closest('.form-upload').find('.preview-img').attr('src', res.link_preview);
                    ele.closest('.form-upload').find('.upload-image').append('<input type="hidden" name="image" value="' + res.path + '">');
                    setTimeout(function() {

                    }, 100);
                }
            });
        });
    });
</script>
@endsection
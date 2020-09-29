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

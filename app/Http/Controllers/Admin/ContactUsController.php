<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DataTables;
use App\Helper;
use App\MenuSystem;
use App\ContactUs;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['MainMenus'] = MenuSystem::where('menu_system_part', 'ContactUs')->with('MainMenu')->first();
        $data['Menus'] = MenuSystem::ActiveMenu()->get();
        if (Helper::CheckPermissionMenu('ContactUs', '1')) {
            return view('admin.ContactUs.contact_list', $data);
        } else {
            return redirect('admin/');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input_all = $request->all();
        $validator = Validator::make($request->all(), [
            'contact_list_title' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $ContactUs = new ContactUs;
                foreach ($input_all as $key => $val) {
                    $ContactUs->{$key} = $val;
                }
                if (!isset($input_all['contact_list_status'])) {
                    $ContactUs->contact_list_status = 0;
                }
                $ContactUs->save();
                \DB::commit();
                $return['status'] = 1;
                $return['content'] = 'Success';
            } catch (Exception $e) {
                \DB::rollBack();
                $return['status'] = 0;
                $return['content'] = 'Unsuccess';
            }
        } else {
            $failedRules = $validator->failed();
            $return['content'] = 'Unsuccess';
            if (isset($failedRules['contact_list_title']['required'])) {
                $return['status'] = 2;
                $return['title'] = "Contact Us is required";
            }
        }
        $return['title'] = 'Insert';
        return $return;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $content = ContactUs::find($id);
        $return['status'] = 1;
        $return['title'] = 'Get ContactUs';
        $return['content'] = $content;
        return $return;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input_all = $request->all();
        $validator = Validator::make($request->all(), [
            'contact_list_title' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $ContactUs = ContactUs::find($id);
                foreach ($input_all as $key => $val) {
                    $ContactUs->{$key} = $val;
                }
                if (!isset($input_all['contact_list_status'])) {
                    $ContactUs->contact_list_status = 0;
                }
                $ContactUs->save();
                \DB::commit();
                $return['status'] = 1;
                $return['content'] = 'Success';
            } catch (Exception $e) {
                \DB::rollBack();
                $return['status'] = 0;
                $return['content'] = 'Unsuccess';
            }
        } else {
            $failedRules = $validator->failed();
            $return['content'] = 'Unsuccess';
            if (isset($failedRules['contact_list_title']['required'])) {
                $return['status'] = 2;
                $return['title'] = "Contact Us is required";
            }
        }
        $return['title'] = 'Update';
        return $return;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function lists(Request  $request)
    {
        $result = ContactUs::select();

        $contact_list_title = $request->input('contact_list_title');
        $contact_list_company = $request->input('contact_list_company');
        $contact_list_email = $request->input('contact_list_email');
        $contact_list_telephone = $request->input('contact_list_telephone');
        if ($contact_list_title) {
            $result->where('contact_list_title', 'like', '%' . $contact_list_title . '%');
        };
        if ($contact_list_company) {
            $result->where('contact_list_company', 'like', '%' . $contact_list_company . '%');
        };
        if ($contact_list_email) {
            $result->where('contact_list_email', 'like', '%' . $contact_list_email . '%');
        };
        if ($contact_list_telephone) {
            $result->where('contact_list_telephone', 'like', '%' . $contact_list_telephone . '%');
        };
        return Datatables::of($result)
            ->addColumn('checkbox', function ($res) {
                $str = '<div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input checkbox-table" id="checkbox-item-' . $res->contact_list_id . '">
                        <label class="custom-control-label" for="checkbox-item-' . $res->contact_list_id . '"></label>
                    </div>';
                return $str;
            })
            ->addColumn('action', function ($res) {
                $view = Helper::CheckPermissionMenu('ContactUs', '1');
                $insert = Helper::CheckPermissionMenu('ContactUs', '2');
                $update = Helper::CheckPermissionMenu('ContactUs', '3');
                $delete = Helper::CheckPermissionMenu('ContactUs', '4');
                if ($res->contact_list_status == 1) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }
                $btnStatus = '<input type="checkbox" class="toggle change-status" ' . $checked . ' data-id="' . $res->contact_list_id . '" data-style="ios" data-on="On" data-off="Off">';
                $btnView = '<button type="button" class="btn btn-success btn-md btn-view" data-id="' . $res->contact_list_id . '">View</button>';
                $btnEdit = '<button type="button" class="btn btn-info btn-md btn-edit" data-id="' . $res->contact_list_id . '">Edit</button>';
                $btnDelete = '<button type="button" class="btn btn-danger btn-md btn-delete" data-id="' . $res->contact_list_id . '">Delete</button>';

                $str = '';
                if ($update) {
                    $str .= ' ' . $btnStatus;
                }
                if ($view) {
                    $str .= ' ' . $btnView;
                }
                if ($update) {
                    $str .= ' ' . $btnEdit;
                }
                if ($delete) {
                    $str .= ' ' . $btnDelete;
                }
                return $str;
            })
            ->addIndexColumn()
            ->rawColumns(['checkbox', 'action'])
            ->make(true);
    }

    public function ChangeStatus(Request $request, $id)
    {
        $status = $request->input('status');
        \DB::beginTransaction();
        try {
            $input_all['contact_list_status'] = $status;
            $input_all['updated_at'] = date('Y-m-d H:i:s');
            ContactUs::where('contact_list_id', $id)->update($input_all);
            \DB::commit();
            $return['status'] = 1;
            $return['content'] = 'Success';
        } catch (Exception $e) {
            \DB::rollBack();
            $return['status'] = 0;
            $return['content'] = 'Unsuccess';
        }
        $return['title'] = 'Update Status';
        return $return;
    }

    public function Delete(Request $request, $id)
    {
        $status = $request->input('status');
        \DB::beginTransaction();
        try {
            
            ContactUs::where('contact_list_id', $id)->delete();
            \DB::commit();
            $return['status'] = 1;
            $return['content'] = 'Success';
        } catch (Exception $e) {
            \DB::rollBack();
            $return['content'] = 'Unsuccess';
        }
        $return['title'] = 'Update Status';
        return $return;
    }
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DataTables;
use App\Helper;
use App\MenuSystem;
use App\Provinces;
use App\Amphures;
use App\Districts;
use App\Geography;
use DB;

class AmphuresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['MainMenus'] = MenuSystem::where('menu_system_part', 'Amphures')->with('MainMenu')->first();
        $data['Menus'] = MenuSystem::ActiveMenu()->get();
        $data['Geography'] = Geography::where('geo_status', '1')->get();
        $data['Provinces'] = Provinces::where('provinces_status', '1')->get();
        if (Helper::CheckPermissionMenu('Amphures', '1')) {
            return view('admin.Amphures.amphures', $data);
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
            'amphures_name' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $Amphures = new Amphures;
                foreach ($input_all as $key => $val) {
                    $Amphures->{$key} = $val;
                }
                if (!isset($input_all['amphures_status'])) {
                    $Amphures->amphures_status = 0;
                }
                $Amphures->save();
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
            if (isset($failedRules['amphures_name']['required'])) {
                $return['status'] = 2;
                $return['title'] = "Amphures is required";
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
        $content = Amphures::select(
            "amphures.amphures_id",
            "amphures.amphures_name",
            "amphures.amphures_code",
            "amphures.amphures_status",
            "geography.geo_id",
            "geography.geo_name",
            "provinces.provinces_id",
            "provinces.provinces_name"
        )
            ->join('geography', 'geography.geo_id', '=', 'amphures.geo_id')
            ->join('provinces', 'provinces.provinces_id', '=', 'amphures.provinces_id')
            ->find($id);

        $return['status'] = 1;
        $return['title'] = 'Get Amphures';
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
            'amphures_name' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $Amphures = Amphures::find($id);
                foreach ($input_all as $key => $val) {
                    $Amphures->{$key} = $val;
                }
                if (!isset($input_all['amphures_status'])) {
                    $Amphures->amphures_status = 0;
                }
                $Amphures->save();
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
            if (isset($failedRules['amphures_name']['required'])) {
                $return['status'] = 2;
                $return['title'] = "Amphures is required";
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
        // $result = Amphures::select();
        $geo_id = $request->input('geo_id');
        $provinces_id = $request->input('provinces_id');
        $amphures_name = $request->input('amphures_name');
        $amphures_code = $request->input('amphures_code');

        $result = Amphures::orderBy('amphures_id', 'DESC')
            ->select(
                "amphures.*",
                "geography.geo_name",
                "provinces.provinces_name"
            )
            ->join('geography', 'geography.geo_id', '=', 'amphures.geo_id')
            ->join('provinces', 'provinces.provinces_id', '=', 'amphures.provinces_id')
            ->where('amphures.geo_id', 'LIKE', "%{$geo_id}%")
            ->where('amphures.provinces_id', 'LIKE', "%{$provinces_id}%")
            ->where('amphures.amphures_name', 'LIKE', "%{$amphures_name}%")
            ->where('amphures.amphures_code', 'LIKE', "%{$amphures_code}%");
        return Datatables::of($result)
            ->addColumn('checkbox', function ($res) {
                $str = '<div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input checkbox-table" id="checkbox-item-' . $res->amphures_id . '">
                        <label class="custom-control-label" for="checkbox-item-' . $res->amphures_id . '"></label>
                    </div>';
                return $str;
            })
            ->addColumn('action', function ($res) {
                $view = Helper::CheckPermissionMenu('Amphures', '1');
                $insert = Helper::CheckPermissionMenu('Amphures', '2');
                $update = Helper::CheckPermissionMenu('Amphures', '3');
                $delete = Helper::CheckPermissionMenu('Amphures', '4');

                if ($res->amphures_status == 1) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }
                $btnStatus = '<input type="checkbox" class="toggle change-status" ' . $checked . ' data-id="' . $res->amphures_id . '" data-style="ios" data-on="On" data-off="Off">';
                $btnDistricts = '<button type="button" class="btn btn-info btn-md btn-districts" data-id="' . $res->amphures_id . '">Districts</button>';
                $btnView = '<button type="button" class="btn btn-success btn-md btn-view" data-id="' . $res->amphures_id . '">View</button>';
                $btnEdit = '<button type="button" class="btn btn-info btn-md btn-edit" data-id="' . $res->amphures_id . '">Edit</button>';
                $str = '';
                if ($update) {
                    $str .= ' ' . $btnStatus;
                }
                $str .= ' ' . $btnDistricts;
                if ($view) {
                    $str .= ' ' . $btnView;
                }
                if ($update) {
                    $str .= ' ' . $btnEdit;
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
            $input_all['amphures_status'] = $status;
            $input_all['updated_at'] = date('Y-m-d H:i:s');
            Amphures::where('amphures_id', $id)->update($input_all);
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

    public function getDistricts_table($id)
    {
        $where = array('amphures_id' => $id);

        $districts['districts'] = Districts::where($where)
            ->select(
                "districts.*",
                "zipcodes.zipcodes_name"
            )
            ->where('districts_status', '1')
            ->join('zipcodes', 'zipcodes.districts_code', '=', 'districts.districts_code')
            ->paginate(100);

        return view('admin.Districts.districts_table', $districts);
    }
}

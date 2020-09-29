<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DataTables;
use App\Zipcode;
use App\Helper;
use App\MenuSystem;
use App\Districts;
use App\Provinces;
use App\Geography;
use App\Amphures;

class DistrictsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['MainMenus'] = MenuSystem::where('menu_system_part', 'Districts')->with('MainMenu')->first();
        $data['Menus'] = MenuSystem::ActiveMenu()->get();
        $data['Geography'] = Geography::where('geo_status', '1')->get();
        $data['Provinces'] = Provinces::where('provinces_status', '1')->get();
        if (Helper::CheckPermissionMenu('Districts', '1')) {
            return view('admin.Districts.districts', $data);
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
        // $input_all = $request->all();
        $districts = $request->input('districts');
        $zipcode = $request->input('zipcode');
        $validator = Validator::make($request->all(), [
            // 'districts_name' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                if ($districts) {
                    $Districts = new Districts;
                    foreach ($districts as $key => $val) {
                        $Districts->{$key} = $val;
                    }
                    if (!isset($districts['districts_status'])) {
                        $Districts->districts_status = 0;
                    }
                    $Districts->save();
                }
                if ($zipcode) {
                    $Zipcode = new Zipcode();
                    foreach ($zipcode as $key => $val) {
                        $Zipcode->{$key} = $val;
                    }
                    $Zipcode->districts_code = $Districts->districts_code;
                    $Zipcode->zipcodes_status = 1;
                    $Zipcode->save();
                }
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
            if (isset($failedRules['districts_name']['required'])) {
                $return['status'] = 2;
                $return['title'] = "Districts is required";
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
        $content = Districts::select(
            "districts.*",
            "geography.geo_id",
            "geography.geo_name",
            "provinces.provinces_id",
            "provinces.provinces_name",
            "amphures.amphures_id",
            "amphures.amphures_name",
            "zipcodes.zipcodes_id",
            "zipcodes.zipcodes_name"
        )
            ->join('geography', 'geography.geo_id', '=', 'districts.geo_id')
            ->join('provinces', 'provinces.provinces_id', '=', 'districts.provinces_id')
            ->join('amphures', 'amphures.amphures_id', '=', 'districts.amphures_id')
            ->join('zipcodes', 'zipcodes.districts_code', '=', 'districts.districts_code')
            ->find($id);

        $return['status'] = 1;
        $return['title'] = 'Get Districts';
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
        // $input_all = $request->all();
        $districts = $request->input('districts');
        $zipcode = $request->input('zipcode');
        $validator = Validator::make($request->all(), [
            // 'districts_name' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                if ($districts) {
                    $Districts = Districts::find($id);
                    foreach ($districts as $key => $val) {
                        $Districts->{$key} = $val;
                    }
                    if (!isset($districts['districts_status'])) {
                        $Districts->districts_status = 0;
                    }
                    $Districts->save();
                }
                if ($zipcode) {
                    if (isset($zipcode['zipcodes_id'])) {
                        $Zipcode = Zipcode::find($zipcode['zipcodes_id']);
                    } else {
                        $Zipcode = new Zipcode();
                    }
                    foreach ($zipcode as $key => $val) {
                        $Zipcode->{$key} = $val;
                    }
                    $Zipcode->districts_code = $Districts->districts_code;
                    $Zipcode->zipcodes_status = 1;
                    $Zipcode->save();
                }
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
            if (isset($failedRules['districts_name']['required'])) {
                $return['status'] = 2;
                $return['title'] = "Districts is required";
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
        // $result = Districts::select();
        $geo_id = $request->input('geo_id');
        $provinces_id = $request->input('provinces_id');
        $amphures_id = $request->input('amphures_id');
        $districts_code = $request->input('districts_code');
        $districts_name = $request->input('districts_name');
        $zipcode_name = $request->input('zipcode_name');

        $result = Districts::orderBy('districts_id', 'DESC')
            ->select(
                "districts.*",
                "geography.geo_name",
                "provinces.provinces_name",
                "amphures.amphures_name",
                "zipcodes.zipcodes_name"
            )
            ->join('geography', 'geography.geo_id', '=', 'districts.geo_id')
            ->join('provinces', 'provinces.provinces_id', '=', 'districts.provinces_id')
            ->join('amphures', 'amphures.amphures_id', '=', 'districts.amphures_id')
            ->join('zipcodes', 'zipcodes.districts_code', '=', 'districts.districts_code');

        if ($geo_id) {
            $result->where('districts.geo_id', $geo_id);
        }
        if ($provinces_id) {
            $result->where('districts.provinces_id', 'LIKE', $provinces_id);
        }
        if ($amphures_id) {
            $result->where('districts.amphures_id', 'LIKE', $amphures_id);
        }
        if ($districts_code) {
            $result->where('districts.districts_code', 'LIKE', "%{$districts_code}%");
        }
        if ($districts_name) {
            $result->where('districts.districts_name', 'LIKE', "%{$districts_name}%");
        }
        if ($zipcode_name) {
            $result->where('zipcodes.zipcodes_name', 'LIKE', "%{$zipcode_name}%");
        }
        return Datatables::of($result)
            ->addColumn('checkbox', function ($res) {
                $str = '<div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input checkbox-table" id="checkbox-item-' . $res->districts_id . '">
                        <label class="custom-control-label" for="checkbox-item-' . $res->districts_id . '"></label>
                    </div>';
                return $str;
            })
            ->addColumn('action', function ($res) {
                $view = Helper::CheckPermissionMenu('Districts', '1');
                $insert = Helper::CheckPermissionMenu('Districts', '2');
                $update = Helper::CheckPermissionMenu('Districts', '3');
                $delete = Helper::CheckPermissionMenu('Districts', '4');
                if ($res->districts_status == 1) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }
                $btnStatus = '<input type="checkbox" class="toggle change-status" ' . $checked . ' data-id="' . $res->districts_id . '" data-style="ios" data-on="On" data-off="Off">';
                $btnView = '<button type="button" class="btn btn-success btn-md btn-view" data-id="' . $res->districts_id . '">View</button>';
                $btnEdit = '<button type="button" class="btn btn-info btn-md btn-edit" data-id="' . $res->districts_id . '">Edit</button>';
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
            $input_all['districts_status'] = $status;
            $input_all['updated_at'] = date('Y-m-d H:i:s');
            Districts::where('districts_id', $id)->update($input_all);
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
}

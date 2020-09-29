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
use App\Zipcode;
use App\Geography;


class ProvincesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['MainMenus'] = MenuSystem::where('menu_system_part', 'Provinces')->with('MainMenu')->first();
        $data['Menus'] = MenuSystem::ActiveMenu()->get();
        $data['Geography'] = Geography::where('geo_status', '1')->get();
        if (Helper::CheckPermissionMenu('Provinces', '1')) {
            return view('admin.Provinces.provinces', $data);
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
            'provinces_name' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $Provinces = new Provinces;
                foreach ($input_all as $key => $val) {
                    $Provinces->{$key} = $val;
                }
                if (!isset($input_all['provinces_status'])) {
                    $Provinces->provinces_status = 0;
                }
                $Provinces->save();
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
            if (isset($failedRules['provinces_name']['required'])) {
                $return['status'] = 2;
                $return['title'] = "Provinces is required";
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
        $content = Provinces::select(
            "provinces.provinces_id",
            "provinces.geo_id",
            "provinces.provinces_name",
            "provinces.provinces_code",
            "provinces.provinces_status",
            "geography.geo_name"

        )
            ->join('geography', 'geography.geo_id', '=', 'provinces.geo_id')
            ->find($id);

        $return['status'] = 1;
        $return['title'] = 'Get Provinces';
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
            'provinces_name' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $Provinces = Provinces::find($id);
                foreach ($input_all as $key => $val) {
                    $Provinces->{$key} = $val;
                }
                if (!isset($input_all['provinces_status'])) {
                    $Provinces->provinces_status = 0;
                }
                $Provinces->save();
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
            if (isset($failedRules['provinces_name']['required'])) {
                $return['status'] = 2;
                $return['title'] = "Provinces is required";
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


        $geo_id = $request->input('geo_id');
        $provinces_name = $request->input('provinces_name');
        $provinces_code = $request->input('provinces_code');

        $result = Provinces::orderBy('provinces_id', 'DESC')
            ->select(
                "provinces.provinces_id",
                "provinces.provinces_name",
                "provinces.provinces_code",
                "provinces.provinces_status",
                "geography.geo_name"
            )
            ->join('geography', 'geography.geo_id', '=', 'provinces.geo_id')
            ->where('provinces.geo_id', 'LIKE', '%' . $geo_id . '%')
            ->where('provinces.provinces_name', 'LIKE', "%{$provinces_name}%")
            ->where('provinces.provinces_code', 'LIKE', "%{$provinces_code}%");

        return Datatables::of($result)
            ->addColumn('checkbox', function ($res) {
                $str = '<div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input checkbox-table" id="checkbox-item-' . $res->provinces_id . '">
                        <label class="custom-control-label" for="checkbox-item-' . $res->provinces_id . '"></label>
                    </div>';
                return $str;
            })
            ->addColumn('action', function ($res) {
                $view = Helper::CheckPermissionMenu('Provinces', '1');
                $insert = Helper::CheckPermissionMenu('Provinces', '2');
                $update = Helper::CheckPermissionMenu('Provinces', '3');
                $delete = Helper::CheckPermissionMenu('Provinces', '4');
                if ($res->provinces_status == 1) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }
                $btnStatus = '<input type="checkbox" class="toggle change-status" ' . $checked . ' data-id="' . $res->provinces_id . '" data-style="ios" data-on="On" data-off="Off">';
                $btnAmphures = '<button type="button" class="btn btn-info btn-md btn-amphures" data-id="' . $res->provinces_id . '">Amphures</button>';
                $btnView = '<button type="button" class="btn btn-success btn-md btn-view" data-id="' . $res->provinces_id . '">View</button>';
                $btnEdit = '<button type="button" class="btn btn-info btn-md btn-edit" data-id="' . $res->provinces_id . '">Edit</button>';
                $str = '';
                if ($update) {
                    $str .= ' ' . $btnStatus;
                }
                $str .= ' ' . $btnAmphures;
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
            $input_all['provinces_status'] = $status;
            $input_all['updated_at'] = date('Y-m-d H:i:s');
            Provinces::where('provinces_id', $id)->update($input_all);
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

    public function getAmphures_table($id)
    {
        if (request()->ajax()) {
            $where = array('provinces_id' => $id);
            // $data  = Districts::where($where)->first();

            $amphures['amphures'] = Amphures::where($where)
                ->where('amphures_status', '1')
                ->paginate(100);

            return view('admin.Amphures.amphures_table', $amphures);
        }
    }

    public function getDistricts_table($id)
    {
        if (request()->ajax()) {
            $where = array('amphures_id' => $id);
            // $data  = Districts::where($where)->first();

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
}

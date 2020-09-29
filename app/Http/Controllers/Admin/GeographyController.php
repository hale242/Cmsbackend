<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DataTables;
use App\Helper;
use App\MenuSystem;
use App\Geography;
use App\Provinces;
use App\Amphures;
use App\Districts;

class GeographyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['MainMenus'] = MenuSystem::where('menu_system_part', 'Geography')->with('MainMenu')->first();
        $data['Menus'] = MenuSystem::ActiveMenu()->get();
        if (Helper::CheckPermissionMenu('Geography', '1')) {
            return view('admin.Geography.geography', $data);
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
            'geo_name' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $Geography = new Geography;
                foreach ($input_all as $key => $val) {
                    $Geography->{$key} = $val;
                }
                if (!isset($input_all['geo_status'])) {
                    $Geography->geo_status = 0;
                }
                $Geography->save();
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
            if (isset($failedRules['geo_name']['required'])) {
                $return['status'] = 2;
                $return['title'] = "Geography is required";
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
        $content = Geography::find($id);
        $return['status'] = 1;
        $return['title'] = 'Get Geography';
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
            'geo_name' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $Geography = Geography::find($id);
                foreach ($input_all as $key => $val) {
                    $Geography->{$key} = $val;
                }
                if (!isset($input_all['geo_status'])) {
                    $Geography->geo_status = 0;
                }
                $Geography->save();
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
            if (isset($failedRules['geo_name']['required'])) {
                $return['status'] = 2;
                $return['title'] = "Geography is required";
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
        $result = Geography::select();
        $geo_name = $request->input('geo_name');
        if ($geo_name) {
            $result->where('geo_name', 'like', '%' . $geo_name . '%');
        }
        return Datatables::of($result)

            ->addColumn('checkbox', function ($res) {
                $str = '<div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input checkbox-table" id="checkbox-item-' . $res->geo_id . '">
                        <label class="custom-control-label" for="checkbox-item-' . $res->geo_id . '"></label>
                    </div>';
                return $str;
            })
            ->addColumn('action', function ($res) {
                $view = Helper::CheckPermissionMenu('Geography', '1');
                $insert = Helper::CheckPermissionMenu('Geography', '2');
                $update = Helper::CheckPermissionMenu('Geography', '3');
                $delete = Helper::CheckPermissionMenu('Geography', '4');
                if ($res->geo_status == 1) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }
                $btnStatus = '<input type="checkbox" class="toggle change-status" ' . $checked . ' data-id="' . $res->geo_id . '" data-style="ios" data-on="On" data-off="Off">';
                $btnProvinces = '<button type="button" class="btn btn-info btn-md btn-provinces" data-id="' . $res->geo_id . '">Provinces</button>';
                $btnView = '<button type="button" class="btn btn-success btn-md btn-view" data-id="' . $res->geo_id . '">View</button>';
                $btnEdit = '<button type="button" class="btn btn-info btn-md btn-edit" data-id="' . $res->geo_id . '">Edit</button>';
                $str = '';
                if ($update) {
                    $str .= ' ' . $btnStatus;
                }
                $str .= ' ' . $btnProvinces;
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
            $input_all['geo_status'] = $status;
            $input_all['updated_at'] = date('Y-m-d H:i:s');
            Geography::where('geo_id', $id)->update($input_all);
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

    public function getProvinces_table($id)
    {
        if (request()->ajax()) {
            $where = array('geo_id' => $id);

            $provinces['provinces'] = Provinces::where($where)
                ->where('provinces_status', '1')
                ->paginate(100);

            return view('admin.Provinces.provinces_table', $provinces);
        }
    }

    public function getAmphures_table($id)
    {
        if (request()->ajax()) {
            $where = array('provinces_id' => $id);

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

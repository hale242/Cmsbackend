<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DataTables;
use App\Helper;
use App\MenuSystem;
use App\Language;
use App\AboutUs;
use App\Setting;
use App\Social;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['MainMenus'] = MenuSystem::where('menu_system_part', 'Language')->with('MainMenu')->first();
        $data['Menus'] = MenuSystem::ActiveMenu()->get();
        $data['languages_icons'] = [
            "flag-icon flag-icon-ad" => "AD",
            "flag-icon flag-icon-ae" => "AE",
            "flag-icon flag-icon-af" => "AF",
            "flag-icon flag-icon-ag" => "AG",
            "flag-icon flag-icon-ai" => "AU",
            "flag-icon flag-icon-al" => "AL",
            "flag-icon flag-icon-am" => "AM",
            "flag-icon flag-icon-ao" => "AO",
            "flag-icon flag-icon-aq" => "AQ",
            "flag-icon flag-icon-ar" => "AR",
            "flag-icon flag-icon-as" => "AS",
            "flag-icon flag-icon-at" => "AT",
            "flag-icon flag-icon-au" => "AU",
            "flag-icon flag-icon-aw" => "AW",
            "flag-icon flag-icon-ax" => "AX",
            "flag-icon flag-icon-az" => "AZ",
            "flag-icon flag-icon-ba" => "BA",
            "flag-icon flag-icon-bb" => "BB",
            "flag-icon flag-icon-bd" => "BD",
            "flag-icon flag-icon-be" => "BE",
            "flag-icon flag-icon-bf" => "BF",
            "flag-icon flag-icon-bg" => "BG",
            "flag-icon flag-icon-bh" => "BH",
            "flag-icon flag-icon-bi" => "BI",
            "flag-icon flag-icon-bj" => "BJ",
            "flag-icon flag-icon-bl" => "BL",
            "flag-icon flag-icon-bm" => "BM",
            "flag-icon flag-icon-bn" => "BN",
            "flag-icon flag-icon-bo" => "BO",
            "flag-icon flag-icon-bq" => "BQ",
            "flag-icon flag-icon-br" => "BR",
            "flag-icon flag-icon-bs" => "BS",
            "flag-icon flag-icon-bt" => "BT",
            "flag-icon flag-icon-bv" => "BV",
            "flag-icon flag-icon-bw" => "BW",
            "flag-icon flag-icon-by" => "BY",
            "flag-icon flag-icon-bz" => "BZ",
            "flag-icon flag-icon-ca" => "CA",
            "flag-icon flag-icon-cc" => "CC",
            "flag-icon flag-icon-cd" => "CD",
            "flag-icon flag-icon-cf" => "CF",
            "flag-icon flag-icon-cg" => "CG",
            "flag-icon flag-icon-ch" => "CH",
            "flag-icon flag-icon-ci" => "CI",
            "flag-icon flag-icon-ck" => "CK",
            "flag-icon flag-icon-cl" => "CL",
            "flag-icon flag-icon-cm" => "CM",
            "flag-icon flag-icon-cn" => "CN",
            "flag-icon flag-icon-co" => "CO",
            "flag-icon flag-icon-cr" => "CR",
            "flag-icon flag-icon-cu" => "CU",
            "flag-icon flag-icon-cv" => "CV",
            "flag-icon flag-icon-cw" => "CW",
            "flag-icon flag-icon-cx" => "CX",
            "flag-icon flag-icon-cy" => "CY",
            "flag-icon flag-icon-cz" => "CZ",
            "flag-icon flag-icon-de" => "DE",
            "flag-icon flag-icon-dj" => "DJ",
            "flag-icon flag-icon-dk" => "DK",
            "flag-icon flag-icon-dm" => "DM",
            "flag-icon flag-icon-do" => "DO",
            "flag-icon flag-icon-dz" => "DZ",
            "flag-icon flag-icon-ec" => "EC",
            "flag-icon flag-icon-ee" => "EE",
            "flag-icon flag-icon-eg" => "EG",
            "flag-icon flag-icon-eh" => "EH",
            "flag-icon flag-icon-er" => "ER",
            "flag-icon flag-icon-es" => "ES",
            "flag-icon flag-icon-et" => "ET",
            "flag-icon flag-icon-fi" => "FI",
            "flag-icon flag-icon-fj" => "FJ",
            "flag-icon flag-icon-fk" => "FK",
            "flag-icon flag-icon-fm" => "FM",
            "flag-icon flag-icon-fo" => "FO",
            "flag-icon flag-icon-fr" => "FR",
            "flag-icon flag-icon-ga" => "GA",
            "flag-icon flag-icon-gb" => "GB",
            "flag-icon flag-icon-gd" => "GD",
            "flag-icon flag-icon-ge" => "GE",
            "flag-icon flag-icon-gf" => "GF",
            "flag-icon flag-icon-gg" => "GG",
            "flag-icon flag-icon-gh" => "GH",
            "flag-icon flag-icon-gi" => "GI",
            "flag-icon flag-icon-gl" => "GL",
            "flag-icon flag-icon-gm" => "GM",
            "flag-icon flag-icon-gn" => "GN",
            "flag-icon flag-icon-gp" => "GP",
            "flag-icon flag-icon-gq" => "GQ",
            "flag-icon flag-icon-gr" => "GR",
            "flag-icon flag-icon-gs" => "GS",
            "flag-icon flag-icon-gt" => "GT",
            "flag-icon flag-icon-gu" => "GU",
            "flag-icon flag-icon-gw" => "GW",
            "flag-icon flag-icon-gy" => "GY",
            "flag-icon flag-icon-hk" => "HK",
            "flag-icon flag-icon-hm" => "HM",
            "flag-icon flag-icon-hn" => "HN",
            "flag-icon flag-icon-hr" => "HR",
            "flag-icon flag-icon-ht" => "HT",
            "flag-icon flag-icon-hu" => "HU",
            "flag-icon flag-icon-id" => "ID",
            "flag-icon flag-icon-ie" => "IE",
            "flag-icon flag-icon-il" => "IL",
            "flag-icon flag-icon-im" => "IM",
            "flag-icon flag-icon-in" => "IN",
            "flag-icon flag-icon-io" => "IO",
            "flag-icon flag-icon-iq" => "IQ",
            "flag-icon flag-icon-ir" => "IR",
            "flag-icon flag-icon-is" => "IS",
            "flag-icon flag-icon-it" => "IT",
            "flag-icon flag-icon-je" => "JE",
            "flag-icon flag-icon-jm" => "JM",
            "flag-icon flag-icon-jo" => "JO",
            "flag-icon flag-icon-jp" => "JP",
            "flag-icon flag-icon-ke" => "KE",
            "flag-icon flag-icon-kg" => "KG",
            "flag-icon flag-icon-kh" => "KH",
            "flag-icon flag-icon-ki" => "KI",
            "flag-icon flag-icon-km" => "KM",
            "flag-icon flag-icon-kn" => "KN",
            "flag-icon flag-icon-kp" => "KP",
            "flag-icon flag-icon-kr" => "KR",
            "flag-icon flag-icon-kw" => "KW",
            "flag-icon flag-icon-ky" => "KY",
            "flag-icon flag-icon-kz" => "KZ",
            "flag-icon flag-icon-la" => "LA",
            "flag-icon flag-icon-lb" => "LB",
            "flag-icon flag-icon-lc" => "LC",
            "flag-icon flag-icon-li" => "LI",
            "flag-icon flag-icon-lk" => "LK",
            "flag-icon flag-icon-lr" => "LR",
            "flag-icon flag-icon-ls" => "LS",
            "flag-icon flag-icon-lt" => "LT",
            "flag-icon flag-icon-lu" => "LU",
            "flag-icon flag-icon-lv" => "LV",
            "flag-icon flag-icon-ly" => "LY",
            "flag-icon flag-icon-ma" => "MA",
            "flag-icon flag-icon-mc" => "MC",
            "flag-icon flag-icon-md" => "MD",
            "flag-icon flag-icon-me" => "ME",
            "flag-icon flag-icon-mf" => "MF",
            "flag-icon flag-icon-mg" => "MG",
            "flag-icon flag-icon-mh" => "MH",
            "flag-icon flag-icon-mk" => "MK",
            "flag-icon flag-icon-ml" => "ML",
            "flag-icon flag-icon-mm" => "MM",
            "flag-icon flag-icon-mn" => "MN",
            "flag-icon flag-icon-mo" => "MO",
            "flag-icon flag-icon-mp" => "MP",
            "flag-icon flag-icon-mq" => "MQ",
            "flag-icon flag-icon-mr" => "MR",
            "flag-icon flag-icon-ms" => "MS",
            "flag-icon flag-icon-mt" => "MT",
            "flag-icon flag-icon-mu" => "MU",
            "flag-icon flag-icon-mv" => "MV",
            "flag-icon flag-icon-mw" => "MW",
            "flag-icon flag-icon-mx" => "MX",
            "flag-icon flag-icon-my" => "MY",
            "flag-icon flag-icon-mz" => "MZ",
            "flag-icon flag-icon-na" => "NA",
            "flag-icon flag-icon-nc" => "NC",
            "flag-icon flag-icon-ne" => "NE",
            "flag-icon flag-icon-nf" => "NF",
            "flag-icon flag-icon-ng" => "NG",
            "flag-icon flag-icon-ni" => "NI",
            "flag-icon flag-icon-nl" => "NL",
            "flag-icon flag-icon-no" => "NO",
            "flag-icon flag-icon-np" => "NP",
            "flag-icon flag-icon-nr" => "NR",
            "flag-icon flag-icon-nu" => "NU",
            "flag-icon flag-icon-nz" => "NZ",
            "flag-icon flag-icon-om" => "OM",
            "flag-icon flag-icon-pa" => "PA",
            "flag-icon flag-icon-pe" => "PE",
            "flag-icon flag-icon-pf" => "PF",
            "flag-icon flag-icon-pg" => "PG",
            "flag-icon flag-icon-ph" => "PH",
            "flag-icon flag-icon-pk" => "PK",
            "flag-icon flag-icon-pl" => "PL",
            "flag-icon flag-icon-pm" => "PM",
            "flag-icon flag-icon-pn" => "PN",
            "flag-icon flag-icon-pr" => "PR",
            "flag-icon flag-icon-ps" => "PS",
            "flag-icon flag-icon-pt" => "PT",
            "flag-icon flag-icon-pw" => "PW",
            "flag-icon flag-icon-py" => "PY",
            "flag-icon flag-icon-qa" => "QA",
            "flag-icon flag-icon-re" => "RE",
            "flag-icon flag-icon-ro" => "RO",
            "flag-icon flag-icon-rs" => "RS",
            "flag-icon flag-icon-ru" => "RU",
            "flag-icon flag-icon-rw" => "RW",
            "flag-icon flag-icon-sa" => "SA",
            "flag-icon flag-icon-sb" => "SB",
            "flag-icon flag-icon-sc" => "SC",
            "flag-icon flag-icon-sd" => "SD",
            "flag-icon flag-icon-se" => "SE",
            "flag-icon flag-icon-sg" => "SG",
            "flag-icon flag-icon-sh" => "SH",
            "flag-icon flag-icon-si" => "SI",
            "flag-icon flag-icon-sj" => "SJ",
            "flag-icon flag-icon-sk" => "SK",
            "flag-icon flag-icon-sl" => "SL",
            "flag-icon flag-icon-sm" => "SM",
            "flag-icon flag-icon-sn" => "SN",
            "flag-icon flag-icon-so" => "SO",
            "flag-icon flag-icon-sr" => "SR",
            "flag-icon flag-icon-ss" => "SS",
            "flag-icon flag-icon-st" => "ST",
            "flag-icon flag-icon-sv" => "SV",
            "flag-icon flag-icon-sx" => "SX",
            "flag-icon flag-icon-sy" => "SY",
            "flag-icon flag-icon-sz" => "SZ",
            "flag-icon flag-icon-tc" => "TC",
            "flag-icon flag-icon-td" => "TD",
            "flag-icon flag-icon-tf" => "TF",
            "flag-icon flag-icon-tg" => "TG",
            "flag-icon flag-icon-th" => "TH",
            "flag-icon flag-icon-tj" => "TJ",
            "flag-icon flag-icon-tk" => "TK",
            "flag-icon flag-icon-tl" => "TL",
            "flag-icon flag-icon-tm" => "TM",
            "flag-icon flag-icon-tn" => "TN",
            "flag-icon flag-icon-to" => "TO",
            "flag-icon flag-icon-tr" => "TR",
            "flag-icon flag-icon-tt" => "TT",
            "flag-icon flag-icon-tv" => "TV",
            "flag-icon flag-icon-tw" => "TW",
            "flag-icon flag-icon-tz" => "TZ",
            "flag-icon flag-icon-ua" => "UA",
            "flag-icon flag-icon-ug" => "UG",
            "flag-icon flag-icon-um" => "UM",
            "flag-icon flag-icon-us" => "US",
            "flag-icon flag-icon-uy" => "UY",
            "flag-icon flag-icon-uz" => "UZ",
            "flag-icon flag-icon-va" => "VA",
            "flag-icon flag-icon-vc" => "VC",
            "flag-icon flag-icon-ve" => "VE",
            "flag-icon flag-icon-vg" => "VG",
            "flag-icon flag-icon-vi" => "VI",
            "flag-icon flag-icon-vn" => "VN",
            "flag-icon flag-icon-vu" => "VU",
            "flag-icon flag-icon-wf" => "WF",
            "flag-icon flag-icon-ws" => "WS",
            "flag-icon flag-icon-ye" => "YE",
            "flag-icon flag-icon-yt" => "YT",
            "flag-icon flag-icon-za" => "ZA",
            "flag-icon flag-icon-zm" => "ZM",
            "flag-icon flag-icon-zw" => "ZW",
        ];
        $data['languages_types'] = [
            "0" => 'ไม่ใช่ภษาหลัก',
            "1" => 'ภาษาหลัก'
        ];
        if (Helper::CheckPermissionMenu('Language', '1')) {
            return view('admin.Language.language', $data);
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
            'languages_name' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $Language = new Language;
                foreach ($input_all as $key => $val) {
                    $Language->{$key} = $val;
                }
                if (!isset($input_all['languages_status'])) {
                    $Language->languages_status = 0;
                }
                $Language->save();
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
            if (isset($failedRules['languages_name']['required'])) {
                $return['status'] = 2;
                $return['title'] = "Language is required";
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
        $content = Language::find($id);
        $return['status'] = 1;
        $return['title'] = 'Get Language';
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
            'languages_name' => 'required',
        ]);
        if (!$validator->fails()) {
            \DB::beginTransaction();
            try {
                $Language = Language::find($id);
                foreach ($input_all as $key => $val) {
                    $Language->{$key} = $val;
                }
                if (!isset($input_all['languages_status'])) {
                    $Language->languages_status = 0;
                }
                if (!isset($input_all['languages_type'])) {
                    if ($Language->languages_type == 1) {
                        $Language->languages_type = 1;
                        $Language->languages_status = 1;
                    } else{
                    $Language->languages_type = 0;
                    }
                } 
                else {
                    Language::where('languages_type', 1)->update(['languages_type' => 0]);
                }
                $Language->save();
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
            if (isset($failedRules['languages_name']['required'])) {
                $return['status'] = 2;
                $return['title'] = "Language is required";
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
        $result = Language::select();
        $languages_name = $request->input('languages_name');
        if ($languages_name) {
            $result->where('languages_name', 'like', '%' . $languages_name . '%');
        };
        
        return Datatables::of($result)
            ->addColumn('checkbox', function ($res) {
                $str = '<div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input checkbox-table" id="checkbox-item-' . $res->languages_id . '">
                        <label class="custom-control-label" for="checkbox-item-' . $res->languages_id . '"></label>
                    </div>';
                return $str;
            })
            ->addColumn('languages_icon', function ($res) {
                $str = '<i class="'.$res->languages_icon.'"></i>';
                return $str;
            })
            ->addColumn('languages_type', function ($res) {
                $str="";
                if($res->languages_type == '1'){
                    $str = 'ภาษาหลัก';
                }
                if($res->languages_type == '0'){
                    $str = 'ไม่ใช่ภาษาหลัก';
                }
                return $str;
            })
            ->addColumn('action', function ($res) {
                $view = Helper::CheckPermissionMenu('Language', '1');
                $insert = Helper::CheckPermissionMenu('Language', '2');
                $update = Helper::CheckPermissionMenu('Language', '3');
                $delete = Helper::CheckPermissionMenu('Language', '4');
                if ($res->languages_status == 1) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }
                if($res->languages_type == 1){
                    $disabled = 'disabled';
                }
                else{
                    $disabled = '';
                }
                $btnStatus = '<input type="checkbox" class="toggle change-status" ' . $checked . ' ' . $disabled . ' data-id="' . $res->languages_id . '" data-style="ios" data-on="On" data-off="Off">';
                $btnView = '<button type="button" class="btn btn-success btn-md btn-view" data-id="' . $res->languages_id . '">View</button>';
                $btnEdit = '<button type="button" class="btn btn-info btn-md btn-edit" data-id="' . $res->languages_id . '">Edit</button>';
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
            ->rawColumns(['checkbox','languages_icon','languages_type','action'])
            ->make(true);
    }

    public function ChangeStatus(Request $request, $id)
    {
        $status = $request->input('status');
        \DB::beginTransaction();
        try {
            if($status==1){
                $AboutUs = New AboutUs;
                $AboutUs->languages_id = $id;
                $AboutUs->aboutus_list_status = 1;
                $AboutUs->save();
                $Social = New Social;
                $Social->languages_id = $id;
                $Social->social_status = 1;
                $Social->save();
                $Setting = New Setting;
                $Setting->languages_id = $id;
                $Setting->setting_status = 1;
                $Setting->save();
                
            }
            else if($status==0){
                AboutUs::where('languages_id',$id)->delete();
                Social::where('languages_id',$id)->delete();
                Setting::where('languages_id',$id)->delete();
            }
            $input_all['languages_status'] = $status;
            $input_all['updated_at'] = date('Y-m-d H:i:s');
            Language::where('languages_id', $id)->update($input_all);
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

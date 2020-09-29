<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MenuSystem;
use App\Provinces;
use App\Amphures;
use App\Districts;
use App\Zipcode;
use App\Driver;
use App\PriceStructureApprove;
use App\PickupEquipment;
use App\DriverInterview;
use App\DriverLeaveApprove;
use App\HolidayCalendar;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['MainMenus'] = MenuSystem::where('menu_system_part', 'Dashboard')->with('MainMenu')->first();
        $data['Menus'] = MenuSystem::ActiveMenu()->get();
        return view('admin.dashboard', $data);

        // $data['Number_Drivers'] = Driver::whereIn('driver_status', ['1', '2', '3', '99'])->count();
        // $data['Number_Drivers_Standbys'] = Driver::where('driver_status', 1)->count();
        // $data['Number_Drivers_Replacements'] = Driver::where('driver_status', 2)->count();

        // $data['Number_RecruitAndOperationApp'] = Driver::leftjoin('driver_interview', 'driver_interview.driver_id', 'driver.driver_id')
        //     ->where('driver.driver_status_job_app', 4) //4 = ผ่านการทดสอบขับรถ
        //     ->where('driver_interview.driver_interview_criminal_status', 1)
        //     ->where(function ($q) {
        //         $q->whereNull('driver.driver_status');
        //         $q->orWhere('driver.driver_status', 0);
        //     })
        //     ->where(function ($q) {
        //         $q->where(function ($sq) {
        //             $sq->where(function ($query) {
        //                 $query->whereNull('driver_interview.driver_interview_recrult_status');
        //                 $query->whereNull('driver_interview.driver_interview_operation_status');
        //             });
        //             $sq->orWhere(function ($query) {
        //                 $query->where('driver_interview.driver_interview_recrult_status', 0);
        //                 $query->where('driver_interview.driver_interview_operation_status', 0);
        //             });
        //         });
        //         $q->orWhere(function ($sq) {
        //             $sq->where('driver_interview.driver_interview_recrult_status', 1);
        //             $sq->whereNull('driver_interview.driver_interview_operation_status');
        //         });
        //         $q->orWhere(function ($sq) {
        //             $sq->where('driver_interview.driver_interview_operation_status', 1);
        //             $sq->whereNull('driver_interview.driver_interview_recrult_status');
        //         });
        //         $q->orWhere(function ($sq) {
        //             $sq->where('driver_interview.driver_interview_recrult_status', 1);
        //             $sq->where('driver_interview.driver_interview_operation_status', 0);
        //         });
        //         $q->orWhere(function ($sq) {
        //             $sq->where('driver_interview.driver_interview_operation_status', 1);
        //             $sq->where('driver_interview.driver_interview_recrult_status', 0);
        //         });
        //     })
        //     ->count();
        // $data['Number_ApproveNewDriver'] = Driver::leftjoin('driver_interview', 'driver_interview.driver_id', 'driver.driver_id')
        //     ->where('driver.driver_status_job_app', 4) //4 = ผ่านการทดสอบขับรถ
        //     ->whereNull('driver.driver_status')
        //     ->where('driver_interview.driver_interview_recrult_status', 1)
        //     ->where('driver_interview.driver_interview_operation_status', 1)
        //     ->count();
        // $data['Number_DriverLeaveApproves'] = DriverLeaveApprove::where('driver_leave_approve_status', 1)->count();
        // $data['Number_PriceStructureApproves'] = PriceStructureApprove::where('price_structure_approve_status', 1)->count();
        // $data['Number_Equipments'] = PickupEquipment::where('pickup_equipment_status', 1)->count();
        // $data['Number_Driver_Wait_Interviews'] = Driver::where('driver_status_job_app', 0)->count();
        // $data['Number_DriverInterviews'] = DriverInterview::where('driver_interview_status', 1)->count();

        // $data['HolidayCalendars'] = HolidayCalendar::whereNotNull('holiday_calendar_date')->where('holiday_calendar_date', 'like', '%' . '-' . date('m') . '-' . '%')->get();
        // $data['Months'] = [
        //     "01" => 'January',
        //     "02" => 'February',
        //     "03" => 'March',
        //     "04" => 'April',
        //     "05" => 'May',
        //     "06" => 'June',
        //     "07" => 'July',
        //     "08" => 'August',
        //     "09" => 'September',
        //     "10" => 'October',
        //     "11" => 'November',
        //     "12" => 'December',
        // ];

    }

    public function GetProvinceByGeography($geo_id)
    {
        $result = Provinces::where('geo_id', $geo_id)->where('provinces_status', 1)->get();
        return $result;
    }

    public function GetAmphurByProvince($provinces_id)
    {
        $result = Amphures::where('provinces_id', $provinces_id)->where('amphures_status', 1)->get();
        return $result;
    }

    public function GetDistrictByAmphur($amphur_id)
    {
        $result = Districts::where('amphures_id', $amphur_id)->where('districts_status', 1)->get();
        return $result;
    }

    public function GetZipcodeByDistrict($districts_code)
    {
        $result = Zipcode::where('districts_code', $districts_code)->first();
        return $result;
    }
    public function GetHoliday($mouth)
    {
        $result = HolidayCalendar::whereNotNull('holiday_calendar_date')->where('holiday_calendar_date', 'like', '%' . $mouth . '-' . '%')->get();
        // $result['format_holiday_calendar_date'] = $result->holiday_calendar_date ? date("Y-m-d", strtotime($result->holiday_calendar_date)) : '';
        return $result;
    }
}

<?php

namespace App\Http\Controllers\Calendar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendar\Form\CalendarFormView;
use App\Models\Calendar\ExtraHoliday;

/**
 * 臨時休業設定のコントローラー
 */
class ExtraHolidaySettingController extends Controller
{
    public function form(){

        $calendar = new CalendarFormView(time());
        return view('calendar.extra_holiday_setting_form', compact(
            'calendar'
        ));
    }

    public function update(Request $request){

        $input = $request->get("extra_holiday");

        ExtraHoliday::updateExtraHolidayWithMonth(date("Ym"), $input);
        return redirect()
            ->action([ExtraHolidaySettingController::class, 'form'])
            ->withStatus("保存しました");
    }
}

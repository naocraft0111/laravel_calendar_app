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
    public function form(Request $request){

        // クエリーのdateを受け取る
		$date = $request->input("date");

		// dateがYYYY-MMの形式かどうか判定する
		if($date && preg_match("/^[0-9]{4}-[0-9]{2}$/", $date)){
			$date = strtotime($date . '+1 month');
		}else{
			$date = null;
		}

		// 取得出来ない時は現在(=今月)を指定する
		if(!$date)$date = time();

        $calendar = new CalendarFormView($date);
        return view('calendar.extra_holiday_setting_form', compact(
            'calendar'
        ));
    }

    public function update(Request $request){

        $input = $request->get("extra_holiday");
        $ym = $request->input("ym");
        $date = $request->input("date");
        ExtraHoliday::updateExtraHolidayWithMonth($ym, $input);
        return redirect()
            ->action([ExtraHolidaySettingController::class, 'form'], compact('date'))
            ->withStatus("保存しました");
    }
}

<?php

namespace App\Calendar\Form;

use Carbon\Carbon;
use App\Calendar\CalendarView;
use App\Models\Calendar\ExtraHoliday;

/**
 * 表示用 （臨時営業日用のカレンダー）
 */
class CalendarFormView extends CalendarView {
    /**
     * @return CalendarWeekForm
     */
    protected function getWeek(Carbon $date, $index = 0){
        $week = new CalendarWeekForm($date, $index);

        // 臨時営業日を設定する
        $start = $date->copy()->startOfWeek()->format("Ymd");
        $end = $date->copy()->endOfWeek()->format("Ymd");

        $week->holidays = $this->holidays->filter(function($value, $key) use($start, $end){
			return $key >= $start && $key <= $end;
		})->keyBy("date_key");

        return $week;
    }

    /**
     * 前後の月の部分を取得
     */
    function render(){
        // parent::render()で元々のカレンダー部分を取得する
        return parent::render() .
            "<input type='hidden' name='ym' value='".$this->carbon->format("Ym")."' />" .
            "<input type='hidden' name='date' value='".$this->carbon->format("Y-m")."' />";
    }
}

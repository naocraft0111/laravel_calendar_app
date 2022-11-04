<?php

namespace App\Calendar\Form;

use Carbon\Carbon;
use App\Calendar\CalendarView;

/**
 * 表示用
 */
class CalendarFormView extends CalendarView {
    /**
     * @return CalendarWeekForm
     */
    protected function getWeek(Carbon $date, $index = 0){
        $week = new CalendarWeekForm($date, $index);
        return $week;
    }
}

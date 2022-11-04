<?php

namespace App\Calendar\Form;

use Carbon\Carbon;
use App\Calendar\CalendarWeek;
use App\Models\Calendar\HolidaySetting;


class CalendarWeekForm extends CalendarWeek {
    /**
     * @return CalendarWeekDayForm
     */
    function getDay(Carbon $date, HolidaySetting $setting){
        $day = new CalendarWeekDayForm($date);
        $day->checkHoliday($setting);
        return $day;
    }
}

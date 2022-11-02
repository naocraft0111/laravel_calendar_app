<?php
namespace App\Calendar;

use Carbon\Carbon;

/**
 * その日のカレンダーを出力する
 */
class CalendarWeekDay {
    protected $carbon;

    function __construct($date)
    {
        $this->carbon = new Carbon($date);
    }

    /**
     * HTMLを表示する時に後からCSSを当てることが出来るようにクラス名を出力する
     */
    function getClassName(){
        // format()関数に「D」を指定すると「Sun」「Mon」などの曜日を省略形式で取得 小文字に変換をしているので、日曜日はday-sun、月曜日はday-monというクラス名を出力
        return "day-" . strtolower($this->carbon->format("D"));
    }

    /**
     * カレンダーの日の内部を出力する
     * @return
     */
    function render(){
        return '<p class="day">' . $this->carbon->format("j"). '</p>';
    }
}

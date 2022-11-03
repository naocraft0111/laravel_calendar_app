<?php
namespace App\Calendar;

use Carbon\Carbon;
use App\Models\Calendar\HolidaySetting;
/**
 * その日のカレンダーを出力する
 */
class CalendarWeekDay {
    protected $carbon;
    protected $isHoliday = false;

    function __construct($date)
    {
        $this->carbon = new Carbon($date);
    }

    /**
     * HTMLを表示する時に後からCSSを当てることが出来るようにクラス名を出力する
     */
    function getClassName(){
        // format()関数に「D」を指定すると「Sun」「Mon」などの曜日を省略形式で取得 小文字に変換をしているので、日曜日はday-sun、月曜日はday-monというクラス名を出力
        $classNames = [ "day-" . strtolower($this->carbon->format("D")) ];

        // 祝日フラグを出す
        if($this->isHoliday){
            $classNames[] = "day-close";
        }

        return implode(" ", $classNames);
    }

    /**
     * カレンダーの日の内部を出力する
     * @return
     */
    function render(){
        return '<p class="day">' . $this->carbon->format("j"). '</p>';
    }

    /**
     * 休みかどうか判定する
     */
    function checkHoliday(HolidaySetting $setting){

        if($this->carbon->isMonday() && $setting->isCloseMonday()){
            $this->isHoliday = true;
        }
        else if($this->carbon->isTuesday() && $setting->isCloseTuesday()){
			$this->isHoliday = true;
		}
		else if($this->carbon->isWednesday() && $setting->isCloseWednesday()){
			$this->isHoliday = true;
		}
		else if($this->carbon->isThursday() && $setting->isCloseThursday()){
			$this->isHoliday = true;
		}
		else if($this->carbon->isFriday() && $setting->isCloseFriday()){
			$this->isHoliday = true;
		}
		else if($this->carbon->isSaturday() && $setting->isCloseSaturday()){
			$this->isHoliday = true;
		}
		else if($this->carbon->isSunday() && $setting->isCloseSunday()){
			$this->isHoliday = true;
		}

        // 祝日は曜日とは別に判定する
        if($setting->isCloseHoliday() && $setting->isHoliday($this->carbon)){
            $this->isHoliday = true;
        }
    }
}

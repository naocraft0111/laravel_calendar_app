<?php
namespace App\Calendar;

use App\Models\Calendar\HolidaySetting;
use App\Models\Calendar\ExtraHoliday;
use Carbon\Carbon;

/**
 * カレンダーを出力する
 */
class CalendarView {

    protected $carbon;
    protected $holidays = [];

    function __construct($date)
    {
        $this->carbon = new Carbon($date);
    }
    /**
     * タイトル
     */
    public function getTitle(){
        return $this->carbon->format('Y年n月');
    }

    /**
     * カレンダーを出力する
     */
    function render(){
        // HolidaySetting
        $setting = HolidaySetting::firstOrCreate();
        $setting->loadHoliday($this->carbon->format("Y"));

        // 臨時営業日の読み込み
        $this->holidays = ExtraHoliday::getExtraHolidayWithMonth($this->carbon->format("Ym"));

        $html = [];
        $html[] = '<div class="calendar">';
        $html[] = '<table class="table">';
        $html[] = '<thead>';
        $html[] = '<tr>';
        $html[] = '<th>月</th>';
        $html[] = '<th>火</th>';
        $html[] = '<th>水</th>';
        $html[] = '<th>木</th>';
        $html[] = '<th>金</th>';
        $html[] = '<th>土</th>';
        $html[] = '<th>日</th>';
        $html[] = '</tr>';
        $html[] = '</thead>';

        $html[] = '<tbody>';

        // 週カレンダーオブジェクトの配列を取得
        $weeks = $this->getWeeks();
        // 週カレンダーオブジェクトの一週ずつ処理
        foreach($weeks as $week){
            // 週カレンダーオブジェクトを使ってHTMLのクラス名を出力します。
            $html[] = '<tr class="'.$week->getClassName().'">';
            // 週カレンダーオブジェクトから、日カレンダーオブジェクトの配列を取得します。
            $days = $week->getDays($setting);
            // 日カレンダーオブジェクトをループさせながら、クラス名を出力し、<td>の中に日カレンダーを出力していきます。
            foreach($days as $day){
                $html[] = '<td class="'.$day->getClassName().'">';
                $html[] = $day->render();
                $html[] = '</td>';
            }
            $html[] = '</tr>';
        }

        $html[] = '</tbody>';

        $html[] = '</table>';
        $html[] = '</div>';
        return implode("", $html);
    }
    
    // 週の情報を取得
    protected function getWeeks(){
        $weeks = [];

        // 初日
        // copy()を間に挟むことで日付操作をしても影響が出ないようにしている
        $firstDay = $this->carbon->copy()->firstOfMonth();

        // 月末まで
        $lastDay = $this->carbon->copy()->lastOfMonth();

        // 1週目
        $weeks[] = $this->getWeek($firstDay->copy());

        // 作業用の日(翌週の月曜日が欲しいので、+7日した後、週の開始日に移動する)
        $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();

        // 月末までループさせる
        while($tmpDay->lte($lastDay)){
            // 週カレンダーViewを作成する。count()は何週目かを週カレンダーオブジェクトに伝えるために設置
            $weeks[] = $this->getWeek($tmpDay, count($weeks));
            // 次の週=+7日する
            $tmpDay->addDay(7);
        }

        return $weeks;
    }

    /**
     * @return CalendarWeek
     */
    protected function getWeek(Carbon $date, $index = 0){
        return new CalendarWeek($date, $index);
    }

}

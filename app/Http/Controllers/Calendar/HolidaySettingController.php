<?php

namespace App\Http\Controllers\Calendar;

use App\Http\Controllers\Controller;
use App\Models\Calendar\HolidaySetting;
use Illuminate\Http\Request;

class HolidaySettingController extends Controller
{
    /**
     * フォームを表示
     */
    function form(){

        // モデルから1件目を取得
        $setting = HolidaySetting::firstOrCreate();
        return view("calendar.holiday_setting_form", [
            "setting" => $setting,
            "FLAG_OPEN" => HolidaySetting::OPEN,
            "FLAG_CLOSE" => HolidaySetting::CLOSE
        ]);
    }

    /**
     * フォームを更新
     */
    function update(Request $request){
        // モデルから1件目を取得
        $setting = HolidaySetting::firstOrCreate();
        // 更新
        $setting->update($request->all());
        return redirect()
            ->action([HolidaySettingController::class, "form"])
            ->withStatus("保存しました");
    }
}

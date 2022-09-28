<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Settings\GeneralSettings;
class SettingController extends Controller
{
    public function __invoke(GeneralSettings $settings, GeneralSettingsRequest $request){
        $settings->site_name = $request->input('site_name');
        $settings->site_active = $request->boolean('site_active');
        
        $settings->save();
        
        return redirect()->back();
    }

    function getName(): string{
        return app(GeneralSettings::class)->site_name
    }
}

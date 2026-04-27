<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return response()->json([
            'settings' => Setting::pluck('value', 'key'),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'settings' => ['required', 'array'],
            'settings.*' => ['nullable', 'string'],
        ]);

        foreach ($data['settings'] as $key => $value) {
            Setting::set($key, (string) $value);
        }

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo')->store('settings', 'public');
            Setting::set('logo', $logo);
        }

        ActionLog::log('settings.update', null, ['keys' => array_keys($data['settings'])]);

        return response()->json(['settings' => Setting::pluck('value', 'key')]);
    }
}

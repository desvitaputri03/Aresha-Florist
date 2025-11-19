<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class StoreSettingController extends Controller
{
    public function index()
    {
        $bankAccount = Setting::getSetting('bank_account_number', 'Belum diatur');
        $bankName = Setting::getSetting('bank_name', 'Belum diatur');
        $costPerKm = Setting::getSetting('cost_per_km_outside_padang', 2000);
        $defaultDistance = Setting::getSetting('default_distance_outside_padang_km', 50);
        $googleMapsApiKey = Setting::getSetting('google_maps_api_key', '');
        return view('admin.settings.store', compact('bankAccount', 'bankName', 'costPerKm', 'defaultDistance', 'googleMapsApiKey'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'bank_account_number' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
        ]);

        Setting::setSetting('bank_account_number', $request->input('bank_account_number'));
        Setting::setSetting('bank_name', $request->input('bank_name'));

        return redirect()->route('admin.settings.store.index')->with('success', 'Pengaturan toko berhasil diperbarui.');
    }
}

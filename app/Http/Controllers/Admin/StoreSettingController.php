<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\StoreSetting; // Tambahkan ini

class StoreSettingController extends Controller
{
    public function index()
    {
        $bankAccount = Setting::getSetting('bank_account_number', 'Belum diatur');
        $bankName = Setting::getSetting('bank_name', 'Belum diatur');

        return view('admin.settings.store', compact('bankAccount', 'bankName'));
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'bank_account_number' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
        ]);

        Setting::setSetting('bank_account_number', $request->input('bank_account_number'));
        Setting::setSetting('bank_name', $request->input('bank_name'));

        return redirect()->route('admin.settings.store.index')->with('success', 'Pengaturan toko berhasil diperbarui.');
    }
}

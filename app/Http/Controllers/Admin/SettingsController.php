<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Show settings page
     */
    public function index()
    {
        $shippingFee = Setting::getShippingFee();
        return view('admin.settings.index', compact('shippingFee'));
    }

    /**
     * Update settings
     */
    public function update(Request $request)
    {
        $request->validate([
            'shipping_fee' => 'required|numeric|min:0|max:10000',
        ]);

        Setting::set('shipping_fee', $request->shipping_fee);

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }
}

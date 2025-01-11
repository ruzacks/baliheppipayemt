<?php

namespace App\Http\Controllers;

use App\Models\FeeSetting;
use Illuminate\Http\Request;

class FeeSettingController extends Controller
{

    public function index()
    {
        $feeSettings = FeeSetting::all(); // Fetch all fee settings
        return view('fee-settings.index', compact('feeSettings')); // Pass them to the view
    }

    // Show the form for creating a new resource
    public function create()
    {
        return view('fee-settings.create'); // Return the create form view
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        $request->validate([
            'method_name' => 'required|string|max:255',
            'transaction_fee_percentage' => 'required|numeric|between:0,100',
            'tax_percentage' => 'required|numeric|between:0,100',
            'rajagestun_fee' => 'required|numeric|between:0,100',
        ]);

        FeeSetting::create($request->all());

        return redirect()->route('fee-settings.index')->with('success', 'Fee setting created successfully.');
    }

    // Show the form for editing the specified resource
    public function edit(FeeSetting $feeSetting)
    {
        return view('fee-settings.edit', compact('feeSetting')); // Pass the specific fee setting to the edit view
    }

    // Update the specified resource in storage
    public function update(Request $request, FeeSetting $feeSetting)
    {
        $request->validate([
            'method_name' => 'required|string|max:255',
            'transaction_fee_percentage' => 'required|numeric|between:0,100',
            'tax_percentage' => 'required|numeric|between:0,100',
            'rajagestun_fee' => 'required|numeric|between:0,100',
        ]);

        $feeSetting->update($request->all());

        return redirect()->route('fee-settings.index')->with('success', 'Fee setting updated successfully.');
    }

    // Remove the specified resource from storage
    public function destroy(FeeSetting $feeSetting)
    {
        $feeSetting->delete();

        return redirect()->route('fee-settings.index')->with('success', 'Fee setting deleted successfully.');
    }

    public function getTransMethod()
    {
        $feeSettings = FeeSetting::all();
        return $feeSettings;
    }
}

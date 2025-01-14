<?php

namespace App\Http\Controllers;

use App\Models\ApiService;
use Illuminate\Http\Request;

class ApiServiceController extends Controller
{
    public function index()
    {
        $apiServices = ApiService::all();
        return view('api_services.index', compact('apiServices'));
    }

    public function create()
    {
        return view('api_services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'attribute' => 'required|array',
        ]);

        ApiService::create($validated);

        return redirect()->route('api_services.index')->with('success', 'API Service created successfully.');
    }

    public function edit(ApiService $apiService)
    {
        return view('api_services.edit', compact('apiService'));
    }

    public function update(Request $request, ApiService $apiService)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'attribute' => 'required|array',
        ]);

        $apiService->update($validated);

        return redirect()->route('api_services.index')->with('success', 'API Service updated successfully.');
    }
}

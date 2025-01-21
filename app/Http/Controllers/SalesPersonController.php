<?php

namespace App\Http\Controllers;

use App\Models\SalesPerson;
use Illuminate\Http\Request;

class SalesPersonController extends Controller
{
    public function index()
    {
        $salesPersons = SalesPerson::all();
        return view('sales_persons.index', compact('salesPersons'));
    }

    public function indexAjax(Request $request)
    {
        $query = $request->input('query', '');  // Get the query parameter
    
        // If the query is not empty, filter the sales persons based on the name
        if ($query) {
            $salesPersons = SalesPerson::where('name', 'like', '%' . $query . '%')->get();
        } else {
            // If no query, return all sales persons
            $salesPersons = SalesPerson::all();
        }
    
        return response()->json($salesPersons);
    }

    // Show the form for creating a new resource
    public function create()
    {
        return view('sales_persons.create'); // Return the create form view
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|digits_between:7,15',
            'commission' => 'required|numeric|between:0,100',
        ]);
    
        try {
            SalesPerson::create($request->all());
            return redirect()->route('sales_persons.index')->with('success', 'Salesperson created successfully.');
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Failed to create Salesperson: ' . $e->getMessage());
    
            // Redirect back with an error message
            return redirect()->back()->withInput()->with('error', 'Failed to create Salesperson. Please try again.');
        }
    }

    // Show the form for editing the specified resource
    public function edit(SalesPerson $salesPerson)
    {
        return view('sales_persons.edit', compact('salesPerons')); // Pass the specific fee setting to the edit view
    }

    // Update the specified resource in storage
    public function update(Request $request, SalesPerson $salesPerson)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|numeric|between:0,100',
            'commission' => 'required|numeric|between:0,100',
        ]);

        $salesPerson->update($request->all());

        return redirect()->route('sales_persons.index')->with('success', 'Fee setting updated successfully.');
    }

    // Remove the specified resource from storage
    public function destroy(SalesPerson $salesPerson)
    {
        $salesPerson->delete();

        return redirect()->route('sales_persons.index')->with('success', 'Fee setting deleted successfully.');
    }
}

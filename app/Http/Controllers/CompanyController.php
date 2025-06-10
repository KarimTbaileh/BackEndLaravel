<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    // عشان جيب كل الشركات
    public function index()
    {
        return Company::all();
    }

    // هون عشان يخزن شركه جديده
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|string',
            'type' => 'nullable|string',
            'size' => 'nullable|string',
            'sector' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'country' => 'nullable|string',
        ]);

        $company = Company::create($validated);
        return response()->json($company, 201);
    }

    // بدو يعرض شركه معينه
    public function show($id)
    {
        return Company::findOrFail($id);
    }

    // اذا بدو يعدل الشركه
    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);
        $company->update($request->all());
        return response()->json($company);
    }

    // اذا بدو يحذف الشركه
    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}

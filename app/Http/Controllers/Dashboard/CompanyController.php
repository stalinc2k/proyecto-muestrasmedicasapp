<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::orderBy('code', 'asc')->paginate(7);
        return view('dashboard.companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->all();

        $request->validate(
            [
             'code' => 'required|min:11|max:14|unique:companies',
             'ruc' => 'required|min:10|max:13',
             'name' => 'required|min:5|max:150',
            ]
        );

        Company::create(
            [
                'code' => strtoupper($request->code),
                'ruc' => $request->ruc,
                'name' => strtoupper($request->name),
                'address' => strtoupper($request->address),
                'phone' => $request->phone,
                'user_id' => Auth::id(),
            ]
        );

        return redirect()->route('company.index')->with('success', 'Empresa creada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $page = $request->input('page', 1);

        $validator = Validator::make($request->all(), [
            'ruc' => 'required|min:10|max:13',
            'name' => 'required|min:5|max:150',
        ]);
    
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()
                ->with('editing_company_id', $company->id);
        }
        
        $company->update([
            'ruc' => $request->ruc,
            'name' => strtoupper($request->name),
            'address' => strtoupper($request->address),
            'phone' => $request->phone,
            'type' => $request->type
        ]);
        return redirect()
            ->route('company.index', ['page' => $page])
            ->with('success', 'Empresa actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Company $company)
    {
        $page = $request->input('page', 1);

        $company->delete();
       
        return redirect()
            ->route('company.index', ['page' => $page])
            ->with('success', 'Empresa actualizada correctamente.');
    }
}

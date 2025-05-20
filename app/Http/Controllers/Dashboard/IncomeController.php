<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Income;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $incomes = Income::orderBy('id','asc')->paginate(10);

        return view('incomes.index',compact('incomes'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::has('product')->get();
        return view('incomes.create', compact('companies'));
    }

    public function getProducts($company_id){
        $products = Product::where('company_id',$company_id)->get();
        return response()->json($products);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'entrydate' => 'required|date',
            'productos' => 'required|array|min:1',
            'productos.*.company_id' => 'required|exists:companies,id',
            'productos.*.product_id' => 'required|exists:products,id',
            'productos.*.cantinventory' => 'required|integer|min:1',
        ]);
    
        DB::beginTransaction();
    
        try {
            // Usamos el primer proveedor de los productos (se asume que todos son del mismo proveedor)
            $companyId = $request->productos[0]['company_id'];
            $totalUnits = collect($request->productos)->sum('cantinventory');
    
            // Creamos la cabecera (Income)
            $income = Income::create([
                'user_id' => Auth::id(),
                'company_id' => $companyId,
                'entrydate' => $request->entrydate,
                'totalunits' => $totalUnits,
                'observations' => $request->observations,
            ]);
    
            // Guardamos el detalle (Inventories)
            foreach ($request->productos as $item) {
                Inventory::create([
                    'user_id' => Auth::id(),
                    'product_id' => $item['product_id'],
                    'income_id' => $income->id,
                    'dateinventory' => $request->entrydate,
                    'cantinventory' => $item['cantinventory'],
                ]);
            }
    
            DB::commit();
    
            return redirect()->route('incomes.index')->with('success', 'Entrada registrada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un error al guardar: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Income $income)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Income $income)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Income $income)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Income $income)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $visitors = Visitor::orderBy('code', 'asc')->get();
        $products = Product::orderBy('code', 'asc')->get();
        $expenses = Expense::orderBy('id', 'asc')->get();
        return view('expenses.index', compact('expenses','visitors','products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $visitors = Visitor::orderBy('code', 'asc')->get();
        $products = Product::orderBy('code', 'asc')->get();
        
        //BUSCAR STOCKS
        $stocks = Inventory::with(['product', 'batch'])
        ->select(
            'product_id',
            'batch_id',
            DB::raw("SUM(CASE WHEN income_id IS NOT NULL THEN cantinventory ELSE 0 END) as entradas"),
            DB::raw("SUM(CASE WHEN expense_id IS NOT NULL THEN cantinventory ELSE 0 END) as salidas"),
            DB::raw("SUM(CASE WHEN income_id IS NOT NULL THEN cantinventory ELSE 0 END) - 
                     SUM(CASE WHEN expense_id IS NOT NULL THEN cantinventory ELSE 0 END) as stock")
        )
        ->groupBy('product_id', 'batch_id')
        ->havingRaw('stock > 0')
        ->get();

        return view('expenses.create',compact('visitors','products', 'stocks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'visitor_id' => 'required|exists:visitors,id',
            'deliverydate' => 'required|date',
            'productos' => 'required|array|min:1',
            'productos.*.product_id' => 'required|exists:products,id',
            'productos.*.cantinventory' => 'required|integer|min:1',
        ]);
    
        DB::beginTransaction();
    
        try {
            $total = collect($request->productos)->sum('cantinventory');
    
            $expense = Expense::create([
                'user_id' => Auth::id(),
                'visitor_id' => $request->visitor_id,
                'deliverydate' => $request->deliverydate,
                'totalunits' => $total,
                'observations' => $request->observations,
            ]);
    
            foreach ($request->productos as $item) {
                $stock = Inventory::where('product_id', $item['product_id'])->whereNotNull('income_id')->sum('cantinventory') -
                         Inventory::where('product_id', $item['product_id'])->whereNotNull('expense_id')->sum('cantinventory');
    
                if ($item['cantinventory'] > $stock) {
                    throw new \Exception("Stock insuficiente para el producto ID {$item['product_id']}");
                }
    
                Inventory::create([
                    'user_id' => Auth::id(),
                    'product_id' => $item['product_id'],
                    'expense_id' => $expense->id,
                    'dateinventory' => $request->deliverydate,
                    'cantinventory' => $item['cantinventory'],
                ]);
            }
    
            DB::commit();
            return redirect()->route('expenses.index')->with('success', 'Salida registrada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        //
    }
}

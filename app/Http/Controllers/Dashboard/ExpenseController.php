<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Visitor;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use AuthorizesRequests;

    public function index()
    {
        $visitors = Visitor::orderBy('code', 'asc')->get();
        $products = Product::orderBy('code', 'asc')->get();
        $expenses = Expense::orderBy('id', 'asc')->get();
        return view('expenses.index', compact('expenses', 'visitors', 'products'));
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

        return view('expenses.create', compact('visitors', 'products', 'stocks'));
    }


    public function store(Request $request)
    {
        $this->authorize('create', Expense::class);
        $idvis = $request->productos[0]['id_vis'];
        $date = $request->productos[0]['date'];
        $obs = $request->productos[0]['obs'];

        $total = 0;
        foreach ($request->productos as $item) {
            $total = $total + intval($item['cant']);
        }
        $request->validate([
            'productos' => 'required|array|min:1',
            'productos.*.id_vis' => 'required|exists:visitors,id',
            'productos.*.id_pro' => 'required|exists:products,id',
            'productos.*.id_lot' => 'required|exists:batches,id',
            'productos.*.cant' => 'required|integer|min:1',
            'productos.*.date' => 'required|date',

        ]);

        DB::beginTransaction();

        try {

            $expense = Expense::create([
                'user_id' => Auth::id(),
                'visitor_id' => intval($idvis),
                'deliverydate' => $date,
                'totalunits' => intval($total),
                'observations' => strtoupper($obs),
            ]);

            foreach ($request->productos as $item) {
                Inventory::create([
                    'user_id' => Auth::id(),
                    'product_id' => intval($item['id_pro']),
                    'expense_id' => $expense->id,
                    'batch_id' => $item['id_lot'],
                    'dateinventory' => $item['date'],
                    'cantinventory' => intval($item['cant']),
                ]);
            }

            DB::commit();
            return redirect()->route('expense.index')->with('success', 'Salida registrada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }


    public function expensePdf($id)
    {

        $id = intval($id);
        $expense = Expense::where('id', $id)->first();
        $pdf = Pdf::loadView('expenses.listpdf', compact('expense'));
        return $pdf->stream('expense.pdf');
    }

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
    public function destroy(Expense $expense, Request $request)
    {
        $this->authorize('delete', $expense);
        $page = $request->input('page', 1);

        $expense->delete();

        return redirect()
            ->route('expense.index', ['page' => $page])
            ->with('success', 'Salida Eliminada.');
    }
}

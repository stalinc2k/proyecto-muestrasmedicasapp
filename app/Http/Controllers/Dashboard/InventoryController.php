<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use SoftDeletes;
    use AuthorizesRequests;
    public function index(Request $request)
    {
        $query = Inventory::with(['user', 'product']);

        if ($request->filled('buscar')){
            $buscar = $request->buscar;
            $query->where('dateinventory', 'like', "%{$buscar}%")
            ->orWhereHas('product', function ($q) use ($buscar) {
                $q->where('description', 'like', "%{$buscar}%")
                    ->orWhere('code', 'like', "%{$buscar}%");
            });
        }

        $inventories = $query->paginate(7);
        return view('inventories.index', compact('inventories'));
    }

     public function inventoryPdf(){

        $inventories = Inventory::orderBy('id', 'asc')->get();
        $pdf = Pdf::loadView('inventories.listpdf', compact('inventories'));
        return $pdf->stream('list_inventory.pdf');

    }

    public function getStock(Product $product)
    {
        $entradas = Inventory::where('product_id', $product->id)->whereNotNull('income_id')->sum('cantinventory');
        $salidas = Inventory::where('product_id', $product->id)->whereNotNull('expense_id')->sum('cantinventory');

        return response()->json(['stock' => $entradas - $salidas]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function stockgeneral()
    {
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

        return view('inventories.stock', compact('stocks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventory $inventory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory)
    {
        //
    }
}

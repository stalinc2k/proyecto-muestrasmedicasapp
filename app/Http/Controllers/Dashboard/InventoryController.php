<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use SoftDeletes;
    use AuthorizesRequests;
    public function index()
    {
        $inventories = Inventory::groupBy('id')->paginate(7);
        return view('inventories.index', compact('inventories'));
    }

     public function inventoryPdf(){

        $inventories = Inventory::orderBy('dateinventory', 'asc')->get();
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
    public function create()
    {
        //
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

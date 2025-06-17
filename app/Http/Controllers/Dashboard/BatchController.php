<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use AuthorizesRequests;

    public function index()
    {
        $products = Product::orderBy('code','asc')->get();
        $batches = Batch::orderBy('code', 'asc')->paginate(7);
        return view('dashboard.batches.index', compact('batches', 'products'));
    }

    public function stockLotes(){
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
            dd($stocks);
        return view('dashboard.batches.index', compact('stocks'));
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
        $this->authorize('create', Batch::class);
        $page = $request->input('page', 1);

        $validator = Validator::make($request->all(), [
            'code' => 'required|min:5',
            'initlot' => 'required|date',
            'finishlot' => 'date|required|after:today',
            'product_id' => 'required|integer'
        ]);
    
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()
                ->with('create_batch_id', true);
        }

            Batch::create([
            'code' => strtoupper($request->code),
            'initlot' => $request->initlot,
            'finishlot' => $request->finishlot,
            'product_id' => intval($request->product_id),
            'user_id' => Auth::id(),
            ]);
    
        return redirect()
            ->route('batch.index', ['page' => $page])
            ->with('success', 'Lote creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Batch $batch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Batch $batch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Batch $batch)
    {
        $this->authorize('update', $batch);
        $page = $request->input('page', 1);

        $validator = Validator::make($request->all(), [
            'code' => 'required|min:5',
            'initlot' => 'required|date',
            'finishlot' => 'date|required|after:today',
            'product_id' => 'required|integer'
        ]);
    
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()
                ->with('editing_batch_id', $batch->id);
        }

            $batch->update([
            'code' => strtoupper($request->code),
            'initlot' => $request->initlot,
            'finishlot' => $request->finishlot,
            'product_id' => intval($request->product_id),
            ]);
    
        return redirect()
            ->route('batch.index', ['page' => $page])
            ->with('success', 'Lote actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Batch $batch)
    {
        $this->authorize('delete', $batch);
        $page = $request->input('page', 1);

        $batch->delete();

        return redirect()
            ->route('batch.index', ['page' => $page])
            ->with('success', 'Lote Eliminada.');
    }
}

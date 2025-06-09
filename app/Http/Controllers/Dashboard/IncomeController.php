<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Company;
use App\Models\Income;
use App\Models\Inventory;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use AuthorizesRequests;

    public function index()
    {
        $incomes = Income::orderBy('id','asc')->paginate(10);
        $companies = Company::has('product')->get();
        return view('incomes.index',compact('incomes','companies'));
        
    }


    public function entryPdf($id){

        $id = intval($id);
        $entry = Income::where('id',$id)->first();
        $pdf = Pdf::loadView('incomes.listpdf', compact('entry'));
        return $pdf->stream('entry.pdf');

    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $proveedores = Company::orderBy('code', 'asc')->get();
        return view('incomes.create', compact('proveedores'));
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
        $this->authorize('create', Income::class);

        $request->validate([
            'entrydate' => 'required|date',
            'productos' => 'required|array|min:1',
            'productos.*.company_id' => 'required|exists:companies,id',
            'productos.*.product_id' => 'required|exists:products,id',
            'productos.*.cantinventory' => 'required|integer|min:1',
            'productos.*.codelot' => 'required|string|min:5',
            'productos.*.initlot' => 'required|date',
            'productos.*.finishlot' => 'required|date|after:today',
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
                //VERIFUCAR SI EXITE PRODUCTO Y LOTE
                $datos = DB::table('inventories')
                ->join('products', 'products.id', '=', 'inventories.product_id')
                ->join('batches', 'batches.id', '=', 'inventories.batch_id')
                ->where('inventories.product_id', $item['product_id'])
                ->where('batches.code', $item['codelot'])
                ->exists();
                if(!$datos){
                    $batch = Batch::create([
                        'code' => strtoupper($item['codelot']),
                        'initlot' => $item['initlot'],
                        'finishlot' => $item['finishlot'],
                        'user_id' => Auth::id(),
                    ]);
                    Inventory::create([
                        'user_id' => Auth::id(),
                        'product_id' => $item['product_id'],
                        'income_id' => $income->id,
                        'batch_id' => $batch->id,
                        'dateinventory' => $request->entrydate,
                        'cantinventory' => $item['cantinventory'],
                    ]);
                }
            }
    
            DB::commit();
    
            return redirect()->route('income.index')->with('success', 'Entrada registrada correctamente.');
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
    public function destroy(Request $request, Income $income)
    {
        $this->authorize('delete', $income);
        $page = $request->input('page', 1);

        $income->delete();
       
        return redirect()
            ->route('income.index', ['page' => $page])
            ->with('success', 'Entrada Eliminada.');
    }
}

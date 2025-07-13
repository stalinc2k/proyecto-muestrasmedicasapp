<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Company;
use App\Models\Income;
use App\Models\Inventory;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = Income::with(['user','company']);

        if ($request->filled('buscar')){
            $buscar = $request->buscar;
            $query->where('id', 'like', "%{$buscar}%")
            ->orWhereDate('entrydate', 'like', "%{$buscar}%")
            ->orWhereHas('company', function ($q) use ($buscar) {
                $q->where('name', 'like', "%{$buscar}%")
                    ->orWhere('code', 'like', "%{$buscar}%")
                    ->orWhere('observations', 'like', "%{$buscar}%");

            });
           
        }


        $incomes = $query->paginate(10);
        $companies = Company::orderBy('code', 'asc')->get();
        return view('incomes.index', compact('incomes', 'companies'));
    }


    public function entryPdf($id)
    {

        $id = intval($id);
        $entry = Income::where('id', $id)->first();
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

    public function getProducts($company_id)
    {
        $products = Product::where('company_id', $company_id)->get();
        return response()->json($products);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Income::class);

        $validator = Validator::make($request->all(),[
            'productos' => 'required|array|min:1',
            'productos.*.date' => 'required|date',
            'productos.*.id_com' => 'required|exists:companies,id',
            'productos.*.id_pro' => 'required|exists:products,id',
            'productos.*.cant' => 'required|integer|min:1',
            'productos.*.co_lot' => 'required|string|min:5',
            'productos.*.fela' => 'required|date',
            'productos.*.fven' => 'required|date|after:today',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()
                ->with('create_income_id', true);
        }

        $idcom = $request->productos[0]['id_com'];
        $date = $request->productos[0]['date'];
        $obs = $request->productos[0]['obs'];

        $total = 0;
        foreach ($request->productos as $item) {
            $total = $total + intval($item['cant']);
        }

        DB::beginTransaction();

        try {

            // Creamos la cabecera (Income)
            $income = Income::create([
                'user_id' => Auth::id(),
                'company_id' => intval($idcom),
                'entrydate' => $date,
                'totalunits' => $total,
                'observations' => strtoupper($obs),
            ]);
            // Guardamos el detalle (Inventories)
            foreach ($request->productos as $item) {
                //VERIFUCAR SI EXITE PRODUCTO Y LOTE
                $datos = Batch::firstOrCreate(
                    ['code' => strtoupper($item['co_lot']), 'product_id' => intval($item['id_pro'])],
                    [
                        'initlot' => $item['fela'],
                        'finishlot' => $item['fven'],
                        'user_id' => Auth::id(),
                        'product_id' => intval($item['id_pro'])
                    ]
                );
                Inventory::create([
                    'user_id' => Auth::id(),
                    'product_id' => intval($item['id_pro']),
                    'income_id' => $income->id,
                    'batch_id' => $datos->id,
                    'dateinventory' => $date,
                    'cantinventory' => intval($item['cant']),
                ]);
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
        $entradas = Inventory::with('income')->where('income_id', $income->id)->get();
        
        foreach($entradas as $entrada){
            $cont = Inventory::whereNotNull('expense_id')
                    ->where('expense_id', '!=', '')
                    ->where('product_id', $entrada->product_id)
                    ->where('batch_id', $entrada->batch_id)
                    ->get();
                    
            if($cont->count() > 0){
                return redirect()
                ->route('income.index',['page' => $page])
                ->with('warning', 'La Entrada no se puede eliminar, existen transacciones con este Entrada.');
            }
        }
       
        if($cont->count() == 0){
            $income->delete();
             return redirect()
            ->route('income.index',['page' => $page])
            ->with('success', 'Entrada eliminada correctamente.');
        }
        
    }
}

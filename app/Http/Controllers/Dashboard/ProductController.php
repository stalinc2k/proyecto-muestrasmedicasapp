<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Inventory;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = Product::with(['user','company']);

        if ($request->filled('buscar')){
            $buscar = $request->buscar;
            $query->where('code', 'like', "%{$buscar}%")
            ->orWhere('description', 'like', "%{$buscar}%")
            ->orWhere('barcode', 'like', "%{$buscar}%")
            ->orWhereHas('user', function ($q) use ($buscar) {
                $q->where('name', 'like', "%{$buscar}%")
                    ->orWhere('lastname', 'like', "%{$buscar}%");
            })
            ->orWhereHas('company', function ($q) use ($buscar) {
                $q->where('name', 'like', "%{$buscar}%")
                    ->orWhere('ruc', 'like', "%{$buscar}%")
                    ->orWhere('code', 'like', "%{$buscar}%");
            });
        }

        $companies = Company::orderBy('code', 'asc')->get();
        $products = $query->paginate(7);
        return view('dashboard.products.index', compact('products', 'companies'));
    }

    public function productPdf(){

        $products = Product::with('company')->orderBy('code', 'asc')->get();
        $pdf = Pdf::loadView('dashboard.products.listpdf', compact('products'));
        return $pdf->stream('list_products.pdf');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $companies = Company::orderBy('code', 'asc')->get();
        return view('dashboard.products.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Product::class);
        
        $validator = Validator::make($request->all(),[
            'code' => 'required|min:5|max:5|unique:products',
            'description' => 'required|min:5|max:150',
            'company_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()
                ->with('create_product_id', true);
        }

        // Guardar la imagen
        if($request->image){
            $imagePath = $request->file('image')->store('img', 'public');
            Product::create([
            'code' => strtoupper($request->code),
            'description' => strtoupper($request->description),
            'barcode' => $request->barcode,
            'image' => 'storage/' . $imagePath,
            'company_id' => intval($request->company_id),
            'user_id' => Auth::id(),
            ]);
        }
        else{
        Product::create([
            'code' => strtoupper($request->code),
            'description' => strtoupper($request->description),
            'barcode' => $request->barcode,
            'company_id' => intval($request->company_id),
            'user_id' => Auth::id(),
            ]);
        }

        return redirect()->back()->with('success', 'Producto guardado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);
        $page = $request->input('page', 1);

        $validator = Validator::make($request->all(), [
            'code' => 'required|min:5|max:5',
            'description' => 'required|min:5|max:150',
            'company_id' => 'integer|required',
        ]);
    
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()
                ->with('editing_product_id', $product->id);
        }

         if($request->image){
            $imagePath = $request->file('image')->store('img', 'public');
            $product->update([
            'code' => strtoupper($request->code),
            'description' => strtoupper($request->description),
            'barcode' => $request->barcode,
            'image' => 'storage/' . $imagePath,
            'company_id' => intval($request->company_id),
            ]); 

         }else{
            $product->update([
            'code' => strtoupper($request->code),
            'description' => strtoupper($request->description),
            'barcode' => $request->barcode,
            'company_id' => intval($request->company_id),
            ]);
         }
    
        return redirect()
            ->route('product.index', ['page' => $page])
            ->with('success', 'Producto actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Product $product)
    {
        $this->authorize('delete', $product);
        $page = $request->input('page',1);
        try{
            $product->delete();
             return redirect()
            ->route('product.index',['page' => $page])
            ->with('success', 'Producto eliminada correctamente.');
        }
        catch(QueryException $e){
            return redirect()
            ->route('product.index',['page' => $page])
            ->with('warning', 'El producto no se puede eliminar, existen transacciones con este producto.');
        }
    }
}

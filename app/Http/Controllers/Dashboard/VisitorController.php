<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VisitorController extends Controller
{

    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = Visitor::with(['user','zone']);

        if ($request->filled('buscar')){
            $buscar = $request->buscar;
            $query->where('code', 'like', "%{$buscar}%")
            ->orWhere('name', 'like', "%{$buscar}%")
            ->orWhereHas('user', function ($q) use ($buscar) {
                $q->where('name', 'like', "%{$buscar}%")
                    ->orWhere('lastname', 'like', "%{$buscar}%");
            })
            ->orWhereHas('zone', function ($q) use ($buscar) {
                $q->where('code', 'like', "%{$buscar}%")
                    ->orWhere('name', 'like', "%{$buscar}%");
            });
        }

        $visitors = $query->paginate(7);
        return view('dashboard.visitors.index', compact('visitors'));
    }

    public function visitorPdf(){

        $visitors = visitor::with('zone')->orderBy('code', 'asc')->get();
        $pdf = Pdf::loadView('dashboard.visitors.listpdf', compact('visitors'));
        return $pdf->stream('list_visitors.pdf');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.visitors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Visitor::class);

        $validator = Validator::make($request->all(),
            [
             'code' => 'required|min:5|max:5|unique:visitors',
             'name' => 'required|min:5|max:150',
            ]
        );

        
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()
                ->with('create_visitor_id', true);
        }

        Visitor::create(
            [
                'code' => strtoupper($request->code),
                'name' => strtoupper($request->name),
                'email' => $request->email,
                'phone' => $request->phone,
                'user_id' => Auth::id(),
            ]
        );

        return redirect()->route('visitor.index')->with('success', 'Representante creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Visitor $visitor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Visitor $visitor)
    {
        return view('dashboard.visitors.edit', compact('visitor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Visitor $visitor)
    {
        $this->authorize('update', $visitor);
        $page = $request->input('page', 1);

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:5|max:150',
            'active' => 'integer',
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()
                ->with('editing_visitor_id', $visitor->id);
        }

        $visitador = Visitor::find($visitor->id);
        $visitador->name = strtoupper($request->name);
        $visitador->email = $request->email;
        $visitador->phone = $request->phone;
        $visitador->active = intval($request->active);
        $visitador->save();

        return redirect()
            ->route('visitor.index', ['page' => $page])
            ->with('success', 'Representante actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Visitor $visitor)
    {
        $this->authorize('delete', $visitor);
        $page = $request->input('page', 1);
       
        try{
           $visitor->delete();
            return redirect()
            ->route('visitor.index', ['page' => $page])
            ->with('success', 'Representante eliminado correctamente.');
        }
        catch(QueryException $e){
            return redirect()
            ->route('visitor.index',['page' => $page])
            ->with('warning', 'El Representante no se puede eliminar, existen transacciones con este Representante.');
        }
    }
}

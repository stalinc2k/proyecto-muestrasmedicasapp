<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use App\Models\Zone;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use AuthorizesRequests;

    public function index(Request $request)
    {
        /* $zones = Zone::orderBy('code', 'asc')->paginate(7);
        $visitors = Visitor::where('active', true)->orderBy('code', 'asc')->get();
        return view('dashboard.zones.index',compact('zones','visitors'));*/

        $query = Zone::with(['visitor', 'user']);

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;

            $query->where('code', 'like', "%{$buscar}%")
                ->orWhere('name', 'like', "%{$buscar}%")
                ->orWhereHas('visitor', function ($q) use ($buscar) {
                    $q->where('name', 'like', "%{$buscar}%")
                    ->orWhere('code', 'like', "%{$buscar}%");
                })
                ->orWhereHas('user', function ($q) use ($buscar) {
                    $q->where('name', 'like', "%{$buscar}%")
                        ->orWhere('lastname', 'like', "%{$buscar}%");
                });
        }

        $zones = $query->paginate(7); 
        $visitors = Visitor::all(); 

        return view('dashboard.zones.index', compact('zones', 'visitors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $visitors = Visitor::where('active', true)->orderBy('code', 'asc');
        $this->authorize('create', Zone::class);
        return view('dashboard.zones.create', compact('visitors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Zone::class);

        $validator = Validator::make($request->all(), [
            'code' => 'required|integer|min:1|max:9999|unique:zones',
            'name' => 'required|min:5|max:150',
            'visitor_id' => 'integer',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()
                ->with('create_zone_id', true);
        }


        Zone::create([
            'code' => strtoupper($request->code),
            'name' => strtoupper($request->name),
            'visitor_id' => intval($request->visitor_id),
            'user_id' => Auth::id(),
        ]);

        return to_route('zone.index');
    }

    public function zonePdf()
    {

        $zones = Zone::orderBy('code', 'asc')->get();
        $pdf = Pdf::loadView('dashboard.zones.listpdf', compact('zones'));
        return $pdf->stream('list_zones.pdf');
    }


    public function show(Zone $zone)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Zone $zone)
    {
        $this->authorize('update', $zone);
        $visitors = Visitor::all();
        return view('dashboard.zones.edit', compact('zone', 'visitors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Zone $zone)
    {
        $this->authorize('update', $zone);
        $page = $request->input('page', 1);

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:4|max:150',
            'visitor_id' => 'integer',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()
                ->with('editing_zone_id', $zone->id);
        }

        $zone->update([
            'name' => strtoupper($request->name),
            'visitor_id' => intval($request->visitor_id),
        ]);

        return redirect()
            ->route('zone.index', ['page' => $page])
            ->with('success', 'Zona actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Zone $zone)
    {
        $this->authorize('delete', $zone);
        $page = $request->input('page', 1);
        
        try{
           $zone->delete();
            return redirect()
            ->route('zone.index', ['page' => $page])
            ->with('success', 'Zona eliminada correctamente.');
        }
        catch(QueryException $e){
            return redirect()
            ->route('zone.index',['page' => $page])
            ->with('warning', 'La zona no se puede eliminar, existen transacciones con este zona.');
        }
       
    }
}

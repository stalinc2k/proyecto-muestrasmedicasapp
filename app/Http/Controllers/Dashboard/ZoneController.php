<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $zones = Zone::orderBy('code', 'asc')->paginate(7);
        $visitors = Visitor::orderBy('code', 'asc')->get();
        return view('dashboard.zones.index',compact('zones','visitors'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $visitors = Visitor::all();
        return view('dashboard.zones.create',compact('visitors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->all();
        $request->validate([
            'code' => 'required|min:4|max:4|unique:zones',
            'name' => 'required|min:4|max:150',
            'visitor_id' => 'integer',
        ]);
        Zone::create([
            'code' => strtoupper($request->code),
            'name' => strtoupper($request->name),
            'visitor_id' => intval($request->visitor_id),
            'user_id' => Auth::id(),
        ]);

        return to_route('zone.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Zone $zone)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Zone $zone)
    {
        $visitors = Visitor::all();
        return view('dashboard.zones.edit', compact('zone','visitors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Zone $zone)
    {
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
        $page = $request->input('page',1);
        $zone->delete();
        return redirect()
        ->route('zone.index',['page' => $page])
        ->with('success', 'Zona eliminada correctamente.');
    }
}

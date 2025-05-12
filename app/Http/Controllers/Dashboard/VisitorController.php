<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use Illuminate\Http\Request;

class VisitorController extends Controller
{

    public function index()
    {
        //$visitors = Visitor::whereNull('deleted_at')->paginate(7);
        $visitors = Visitor::paginate(7);
        $visitorsDeleted = Visitor::onlyTrashed()->get();
        return view('dashboard.visitors.index', compact('visitors','visitorsDeleted'));
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
        $request->all();

        $request->validate(
            [
             'code' => 'required|min:5|max:5|unique:visitors',
             'name' => 'required|max:150',
            ]
        );

        Visitor::create(
            [
                'code' => strtoupper($request->code),
                'name' => strtoupper($request->name),
                'email' => $request->email,
                'phone' => $request->phone,
                'user_id' => 1,
            ]
        );

        return redirect()->route('visitor.index')->with('success', 'Visitador creado correctamente');
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
        $request->validate([
            'name' => 'required|min:10|max:150',
        ]);
        $visitador = Visitor::find($visitor->id);
        $visitador->name = strtoupper($request->name);
        $visitador->email = $request->email;
        $visitador->phone = $request->phone;
        $visitador->active = $request->active;
        $visitador->save();

        return redirect()->route('visitor.index')->with('success', 'Visitador actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Visitor $visitor)
    {
        $visitador = Visitor::find($visitor->id);
        $visitador->delete();
        return redirect()->route('visitor.index')->with('success', 'Visitador eliminado');
    }
}

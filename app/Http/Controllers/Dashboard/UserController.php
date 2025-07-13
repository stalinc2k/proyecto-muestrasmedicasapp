<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    use AuthorizesRequests;
    
    public function index(Request $request)
    {
        $query = User::orderBy('name','asc');

        if ($request->filled('buscar')){
            $buscar = $request->buscar;
            $query->where('name', 'like', "%{$buscar}%")
            ->orWhere('lastname', 'like', "%{$buscar}%")
            ->orWhere('email', 'like', "%{$buscar}%")
            ->orWhere('role', 'like', "%{$buscar}%");
        }
        $users = $query->paginate(7);
        return view('dashboard.users.index',compact('users'));
    }

    public function userPdf(){

        $users = user::orderBy('name', 'asc')->get();
        $pdf = Pdf::loadView('dashboard.users.listpdf', compact('users'));
        return $pdf->stream('list_user.pdf');

    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $this->authorize('create', User::class);
        
        $validator = Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'regex:/^[^@]+@(outlook\.com|admin\.com|user\.com|hotmail\.com|yahoo\.com|gmail\.com)$/i', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()
                ->with('create_user_id', true);
        }

        User::create([
            'name' => strtoupper($request->name),
            'lastname' => strtoupper($request->lastname),
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return redirect()
            ->route('user.index')
            ->with('success', 'Usuario Creado.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);
        $page = $request->input('page', 1);

        $validator = Validator::make($request->all(),[
            'name' => ['required', 'string','min:3', 'max:255'],
            'lastname' => ['required', 'string','min:3', 'max:255'],
            'email' => ['required', 'email', 'regex:/^[^@]+@(outlook\.com|admin\.com|user\.com|hotmail\.com|yahoo\.com|gmail\.com)$/i', 'lowercase', 'email', 'max:255'],
            'role' => ['required', 'string', 'lowercase', 'max:255'],
        ]);
        
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()
                ->with('editing_user_id', $user->id);
        }

        $user->update([
            'name' => strtoupper($request->name),
            'lastname' => strtoupper($request->lastname),
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()
        ->route('user.index')
        ->with('success', 'Usuario Actualizado.');
    }

    public function updatePassword(Request $request, User $user)
    {
        $this->authorize('update', $user);
        $page = $request->input('page', 1);

        $validator = Validator::make($request->all(),[
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()
                ->with('editing_pass_id', $user->id);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()
        ->route('user.index')
        ->with('success', 'Constraseña Actualizada.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
       
        
        try{
            $user->delete();
            return redirect()
            ->with('success', 'Usuario Eliminado.');
        }
        catch(QueryException $e){
            return redirect()
            ->with('warning', 'El Usuario no se puede eliminar, existen transacciones con este Usuario.');
        }

    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Responsable;
use App\Models\User;
use Illuminate\Support\Str;

class ResponsableController extends Controller
{
    public function index()
    {
        $responsables = Responsable::orderBy('apellido')->orderBy('nombre')->get();
        return view('responsables.index', compact('responsables'));
    }

    public function create()
    {
        return view('responsables.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni' => 'required|string|max:20|unique:responsables',
            'telefono' => 'nullable|string|max:20',
            'crear_usuario' => 'nullable|boolean',
            'email_usuario' => 'required_if:crear_usuario,1|email|unique:users,email',
            'password' => 'required_if:crear_usuario,1|string|min:6',
            'role' => 'required_if:crear_usuario,1|in:admin,responsable',
        ]);

        // Crear responsable
        $responsable = Responsable::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'dni' => $request->dni,
            'telefono' => $request->telefono,
            'activo' => $request->boolean('activo', true)
        ]);

        // Crear usuario si se solicita
        if ($request->boolean('crear_usuario')) {
            $user = User::create([
                'name' => $responsable->nombre_completo,
                'email' => $request->email_usuario,
                'email_verified_at' => now(),
                'password' => bcrypt($request->password),
                'role' => $request->role,
                'remember_token' => Str::random(10),
            ]);
            
            // Asociar usuario con responsable
            $responsable->update(['user_id' => $user->id]);
        }

        return redirect()->route('responsables.index')->with('success', 'Responsable creado exitosamente.');
    }

    public function show(Responsable $responsable)
    {
        $responsable->load(['designaciones' => function($query) {
            $query->activas();
        }, 'novedades' => function($query) {
            $query->latest()->limit(10);
        }]);
        
        return view('responsables.show', compact('responsable'));
    }

    public function edit(Responsable $responsable)
    {
        return view('responsables.edit', compact('responsable'));
    }

    public function update(Request $request, Responsable $responsable)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni' => 'required|string|max:20|unique:responsables,dni,' . $responsable->id,
            'telefono' => 'nullable|string|max:20',
            'crear_usuario' => 'nullable|boolean',
            'email_usuario' => 'required_if:crear_usuario,1|email|unique:users,email,' . ($responsable->user_id ?? 'NULL'),
            'password' => 'required_if:crear_usuario,1|string|min:6',
            'role' => 'required_if:crear_usuario,1|in:admin,responsable',
        ]);

        // Actualizar responsable
        $responsable->update([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'dni' => $request->dni,
            'telefono' => $request->telefono,
            'activo' => $request->boolean('activo', true)
        ]);

        // Manejar usuario
        if ($request->boolean('crear_usuario')) {
            if ($responsable->user) {
                // Actualizar usuario existente
                $responsable->user->update([
                    'name' => $responsable->nombre_completo,
                    'email' => $request->email_usuario,
                    'password' => bcrypt($request->password),
                    'role' => $request->role,
                ]);
            } else {
                // Crear nuevo usuario
                $user = User::create([
                    'name' => $responsable->nombre_completo,
                    'email' => $request->email_usuario,
                    'email_verified_at' => now(),
                    'password' => bcrypt($request->password),
                    'role' => $request->role,
                    'remember_token' => Str::random(10),
                ]);
                
                // Asociar usuario con responsable
                $responsable->update(['user_id' => $user->id]);
            }
        } elseif ($request->boolean('eliminar_usuario') && $responsable->user) {
            // Eliminar usuario
            $responsable->user->delete();
            $responsable->update(['user_id' => null]);
        }

        return redirect()->route('responsables.index')->with('success', 'Responsable actualizado exitosamente.');
    }

    public function destroy(Responsable $responsable)
    {
        $responsable->delete();
        return redirect()->route('responsables.index')->with('success', 'Responsable eliminado exitosamente.');
    }
}

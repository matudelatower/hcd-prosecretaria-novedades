<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Novedad;
use App\Models\Area;
use App\Models\Responsable;
use Illuminate\Support\Facades\Auth;

class NovedadController extends Controller
{
    public function index()
    {
        $novedades = Novedad::with(['area', 'responsable'])->latest()->get();
        return view('novedades.index', compact('novedades'));
    }

    public function create()
    {
        $areas = Area::orderBy('nombre')->pluck('nombre', 'id');
        
        // Solo administradores pueden seleccionar responsables
        if (auth()->user()->isAdmin()) {
            $responsables = Responsable::activos()
                ->orderBy('apellido')
                ->orderBy('nombre')
                ->get()
                ->mapWithKeys(function ($responsable) {
                    return [$responsable->id => $responsable->nombre_completo];
                });
        } else {
            $responsables = collect();
        }
        
        return view('novedades.create', compact('areas', 'responsables'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string',
            'tipo' => 'required|in:incidencia,mantenimiento,evento,otro',
            'fecha' => 'required|date',
            'hora' => 'nullable|date_format:H:i',
            'area_id' => 'required|exists:areas,id',
            'responsable_id' => 'nullable|exists:responsables,id',
            'estado' => 'required|in:pendiente,en_progreso,resuelto',
            'observaciones' => 'nullable|string'
        ]);

        // Determinar el responsable según el rol del usuario
        $responsableId = null;
        if (auth()->user()->isAdmin()) {
            // Admin puede asignar cualquier responsable
            $responsableId = $request->responsable_id;
        } else {
            // Responsable se asigna a sí mismo
            $responsable = auth()->user()->responsable;
            if ($responsable) {
                $responsableId = $responsable->id;
            }
        }

        Novedad::create([
            'descripcion' => $request->descripcion,
            'tipo' => $request->tipo,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'area_id' => $request->area_id,
            'responsable_id' => $responsableId,
            'estado' => $request->estado,
            'observaciones' => $request->observaciones,
            'user_id' => auth()->id()
        ]);
        
        return redirect()->route('novedades.index')->with('success', 'Novedad creada exitosamente.');
    }

    public function show(Novedad $novedad)
    {
        $novedad->load(['area', 'responsable']);
        return view('novedades.show', compact('novedad'));
    }

    public function edit(Novedad $novedad)
    {
        $areas = Area::orderBy('nombre')->pluck('nombre', 'id');
        
        // Solo administradores pueden seleccionar responsables
        if (auth()->user()->isAdmin()) {
            $responsables = Responsable::activos()
                ->orderBy('apellido')
                ->orderBy('nombre')
                ->get()
                ->mapWithKeys(function ($responsable) {
                    return [$responsable->id => $responsable->nombre_completo];
                });
        } else {
            $responsables = collect();
        }
        
        return view('novedades.edit', compact('novedad', 'areas', 'responsables'));
    }

    public function update(Request $request, Novedad $novedad)
    {
        $request->validate([
            'descripcion' => 'required|string',
            'tipo' => 'required|in:incidencia,mantenimiento,evento,otro',
            'fecha' => 'required|date',
            'hora' => 'nullable|date_format:H:i',
            'area_id' => 'required|exists:areas,id',
            'responsable_id' => 'nullable|exists:responsables,id',
            'estado' => 'required|in:pendiente,en_progreso,resuelto',
            'observaciones' => 'nullable|string'
        ]);

        $novedad->update($request->all());
        return redirect()->route('novedades.index')->with('success', 'Novedad actualizada exitosamente.');
    }

    public function destroy(Novedad $novedad)
    {
        $novedad->delete();
        return redirect()->route('novedades.index')->with('success', 'Novedad eliminada exitosamente.');
    }
}

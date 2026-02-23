<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Designacion;
use App\Models\Area;
use App\Models\Responsable;

class DesignacionController extends Controller
{
    public function index()
    {
        $designaciones = Designacion::with(['area', 'responsable'])->latest()->get();
        return view('designaciones.index', compact('designaciones'));
    }

    public function create()
    {
        $areas = Area::orderBy('nombre')->pluck('nombre', 'id');
        $responsables = Responsable::activos()
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->get()
            ->mapWithKeys(function ($responsable) {
                return [$responsable->id => $responsable->nombre_completo];
            });
        return view('designaciones.create', compact('areas', 'responsables'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'area_id' => 'required|exists:areas,id',
            'responsable_id' => 'required|exists:responsables,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'periodicidad' => 'required|in:diaria,semanal,mensual,unica',
            'observaciones' => 'nullable|string'
        ]);

        Designacion::create($request->all());
        return redirect()->route('designaciones.index')->with('success', 'Designación creada exitosamente.');
    }

    public function show(Designacion $designacion)
    {
        $designacion->load(['area', 'responsable']);
        return view('designaciones.show', compact('designacion'));
    }

    public function edit(Designacion $designacion)
    {
        $areas = Area::orderBy('nombre')->pluck('nombre', 'id');
        $responsables = Responsable::activos()
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->get()
            ->mapWithKeys(function ($responsable) {
                return [$responsable->id => $responsable->nombre_completo];
            });
        return view('designaciones.edit', compact('designacion', 'areas', 'responsables'));
    }

    public function update(Request $request, Designacion $designacion)
    {
        $request->validate([
            'area_id' => 'required|exists:areas,id',
            'responsable_id' => 'required|exists:responsables,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'periodicidad' => 'required|in:diaria,semanal,mensual,unica',
            'observaciones' => 'nullable|string'
        ]);

        $designacion->update($request->all());
        return redirect()->route('designaciones.index')->with('success', 'Designación actualizada exitosamente.');
    }

    public function destroy(Designacion $designacion)
    {
        $designacion->delete();
        return redirect()->route('designaciones.index')->with('success', 'Designación eliminada exitosamente.');
    }
}

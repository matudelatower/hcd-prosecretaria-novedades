<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;

class AreaController extends Controller
{
    public function index()
    {
        $areas = Area::with('padre')->orderBy('nombre')->get();
        return view('areas.index', compact('areas'));
    }

    public function create()
    {
        $areasPadre = Area::where('tipo', 'edificio')->orWhere('tipo', 'area')->orderBy('nombre')->pluck('nombre', 'id');
        return view('areas.create', compact('areasPadre'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:50|unique:areas',
            'tipo' => 'required|in:edificio,oficina,area',
            'padre_id' => 'nullable|exists:areas,id',
            'descripcion' => 'nullable|string'
        ]);

        Area::create($request->all());
        return redirect()->route('areas.index')->with('success', 'Área creada exitosamente.');
    }

    public function show(Area $area)
    {
        $area->load(['padre', 'hijos', 'novedades' => function($query) {
            $query->latest()->limit(10);
        }, 'designaciones' => function($query) {
            $query->activas();
        }]);
        
        return view('areas.show', compact('area'));
    }

    public function edit(Area $area)
    {
        $areasPadre = Area::where('id', '!=', $area->id)
                          ->where(function($query) use ($area) {
                              $query->where('tipo', 'edificio')
                                    ->orWhere('tipo', 'area');
                          })
                          ->orderBy('nombre')
                          ->pluck('nombre', 'id');
        
        return view('areas.edit', compact('area', 'areasPadre'));
    }

    public function update(Request $request, Area $area)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:50|unique:areas,codigo,' . $area->id,
            'tipo' => 'required|in:edificio,oficina,area',
            'padre_id' => 'nullable|exists:areas,id',
            'descripcion' => 'nullable|string'
        ]);

        $area->update($request->all());
        return redirect()->route('areas.index')->with('success', 'Área actualizada exitosamente.');
    }

    public function destroy(Area $area)
    {
        if ($area->hijos()->count() > 0) {
            return redirect()->route('areas.index')->with('error', 'No se puede eliminar el área porque tiene áreas hijas.');
        }
        
        $area->delete();
        return redirect()->route('areas.index')->with('success', 'Área eliminada exitosamente.');
    }
}

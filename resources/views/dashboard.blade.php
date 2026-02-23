@extends('layouts.app')

@section('title', 'Dashboard del Sistema')

@section('page-title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="row">
    <!-- Estadísticas principales -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ App\Models\Area::count() }}</h3>
                <p>Total de Áreas</p>
            </div>
            <div class="icon">
                <i class="fas fa-building"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ App\Models\Responsable::activos()->count() }}</h3>
                <p>Responsables Activos</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ App\Models\Designacion::activas()->count() }}</h3>
                <p>Designaciones Activas</p>
            </div>
            <div class="icon">
                <i class="fas fa-clipboard-list"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ App\Models\Novedad::porEstado('pendiente')->count() }}</h3>
                <p>Novedades Pendientes</p>
            </div>
            <div class="icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Dashboard por Edificios -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-building mr-2"></i>
                    Responsables por Edificio
                </h3>
            </div>
            <div class="card-body p-0">
                @php
                    $edificios = App\Models\Area::where('tipo', 'edificio')->with(['hijos', 'hijos.designaciones' => function($query) {
                        $query->activas()->with('responsable');
                    }])->get();
                @endphp
                
                @foreach($edificios as $edificio)
                <div class="d-flex border-bottom">
                    <div class="p-3" style="width: 200px;">
                        <strong>{{ $edificio->nombre }}</strong>
                        <br>
                        <small class="text-muted">{{ $edificio->codigo }}</small>
                    </div>
                    <div class="p-3 flex-grow-1">
                        @if($edificio->hijos->count() > 0)
                            <div class="row">
                                @foreach($edificio->hijos as $oficina)
                                    <div class="col-md-6 mb-2">
                                        <div class="bg-light p-2 rounded">
                                            <small class="text-muted d-block">{{ $oficina->nombre }}</small>
                                            @if($oficina->designaciones->count() > 0)
                                                @foreach($oficina->designaciones as $designacion)
                                                    <span class="badge badge-info">
                                                        {{ $designacion->responsable->nombre_completo }}
                                                    </span>
                                                    <small class="text-muted d-block">{{ ucfirst($designacion->periodicidad) }}</small>
                                                @endforeach
                                            @else
                                                <span class="badge badge-secondary">Sin responsable</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <span class="text-muted">Sin oficinas asignadas</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Últimas novedades -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Últimas Novedades
                </h3>
            </div>
            <div class="card-body">
                @php
                    $ultimasNovedades = App\Models\Novedad::with(['area', 'responsable'])->latest()->limit(5)->get();
                @endphp
                @forelse($ultimasNovedades as $novedad)
                    <div class="post clearfix">
                        <div class="user-block">
                            <i class="fas fa-exclamation-circle bg-{{ $novedad->tipo == 'incidencia' ? 'danger' : ($novedad->tipo == 'mantenimiento' ? 'warning' : 'info') }}"></i>
                            <span class="username">
                                <a href="#">{{ $novedad->area->nombre }}</a>
                            </span>
                            <span class="description">{{ $novedad->fecha->format('d/m/Y H:i') }}</span>
                        </div>
                        <p>{{ Str::limit($novedad->descripcion, 80) }}</p>
                        <span class="badge badge-{{ $novedad->estado == 'pendiente' ? 'warning' : ($novedad->estado == 'en_progreso' ? 'info' : 'success') }}">
                            {{ ucfirst($novedad->estado) }}
                        </span>
                    </div>
                @empty
                    <p class="text-muted">No hay novedades recientes</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Designaciones de Hoy -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-calendar-day mr-2"></i>
                    Designaciones de Hoy ({{ now()->format('d/m/Y') }})
                </h3>
            </div>
            <div class="card-body">
                @php
                    $designacionesHoy = App\Models\Designacion::paraFecha(now())
                        ->with(['area', 'responsable'])
                        ->get()
                        ->groupBy(function($item) {
                            return $item->area->padre ? $item->area->padre->nombre : 'Sin Edificio';
                        });
                @endphp
                
                @forelse($designacionesHoy as $edificio => $designaciones)
                    <div class="col-md-4">
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h5 class="card-title">{{ $edificio }}</h5>
                            </div>
                            <div class="card-body">
                                @foreach($designaciones as $designacion)
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div>
                                            <strong>{{ $designacion->responsable->nombre_completo }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $designacion->area->nombre }}</small>
                                        </div>
                                        <span class="badge badge-info">{{ ucfirst($designacion->periodicidad) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> No hay designaciones programadas para hoy.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

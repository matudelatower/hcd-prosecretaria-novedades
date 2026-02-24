@extends('layouts.app')

@section('title', 'Ver Novedad')
@section('page-title', 'Ver Novedad')
@section('breadcrumb', 'Ver Novedad')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Detalles de la Novedad</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><strong>Descripción:</strong></label>
                            <p>{{ $novedad->descripcion }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>Tipo:</strong></label>
                            <p>
                                <span class="badge 
                                    {{ $novedad->tipo == 'incidencia' ? 'bg-danger' : '' }}
                                    {{ $novedad->tipo == 'mantenimiento' ? 'bg-warning' : '' }}
                                    {{ $novedad->tipo == 'evento' ? 'bg-info' : '' }}
                                    {{ $novedad->tipo == 'otro' ? 'bg-secondary' : '' }}">
                                    {{ ucfirst($novedad->tipo) }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>Estado:</strong></label>
                            <p>
                                <span class="badge 
                                    {{ $novedad->estado == 'pendiente' ? 'bg-warning' : '' }}
                                    {{ $novedad->estado == 'en_progreso' ? 'bg-info' : '' }}
                                    {{ $novedad->estado == 'resuelto' ? 'bg-success' : '' }}">
                                    {{ ucfirst($novedad->estado) }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>Fecha:</strong></label>
                            <p>{{ $novedad->fecha ? $novedad->fecha->format('d/m/Y') : 'No especificada' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>Hora:</strong></label>
                            <p>{{ $novedad->hora ? $novedad->hora->format('H:i') : 'No especificada' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>Área:</strong></label>
                            <p>{{ $novedad->area ? $novedad->area->nombre : 'No especificada' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>Responsable:</strong></label>
                            <p>{{ $novedad->responsable ? $novedad->responsable->nombre_completo : 'No asignado' }}</p>
                        </div>
                    </div>
                </div>

                @if($novedad->observaciones)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><strong>Observaciones:</strong></label>
                                <p>{{ $novedad->observaciones }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if($novedad->imagenes && $novedad->imagenes->count() > 0)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><strong>Imágenes:</strong></label>
                                <div class="row">
                                    @foreach($novedad->imagenes as $imagen)
                                        <div class="col-md-4 mb-3">
                                            <a href="{{ asset('storage/novedades/' . $imagen->imagen) }}" target="_blank">
                                                <img src="{{ asset('storage/novedades/' . $imagen->imagen) }}" 
                                                     alt="Imagen" class="img-thumbnail" style="width: 100%; height: 150px; object-fit: cover;">
                                            </a>
                                            <small class="d-block text-center text-muted mt-1">{{ basename($imagen->imagen) }}</small>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="card-footer">
                <a href="{{ route('novedades.edit', $novedad->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit mr-2"></i>Editar
                </a>
                <a href="{{ route('novedades.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i>Volver
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Información Adicional</h3>
            </div>
            <div class="card-body">
                <p><strong>Creado por:</strong> {{ $novedad->user ? $novedad->user->name : 'Sistema' }}</p>
                <p><strong>Fecha de creación:</strong> {{ $novedad->created_at ? $novedad->created_at->format('d/m/Y H:i') : 'No disponible' }}</p>
                @if($novedad->updated_at && $novedad->created_at && $novedad->updated_at->ne($novedad->created_at))
                    <p><strong>Última actualización:</strong> {{ $novedad->updated_at->format('d/m/Y H:i') }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

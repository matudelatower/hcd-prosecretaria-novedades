@extends('layouts.app')

@section('title', 'Editar Designación')
@section('page-title', 'Editar Designación')
@section('breadcrumb', 'Editar Designación')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Editar Datos de la Designación</h3>
            </div>
            <form action="{{ route('designaciones.update', $designacion) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="area_id">Área <span class="text-danger">*</span></label>
                        <select class="form-control @error('area_id') is-invalid @enderror" id="area_id" name="area_id" required>
                            <option value="">Seleccionar área...</option>
                            @foreach($areas as $id => $nombre)
                                <option value="{{ $id }}" {{ old('area_id', $designacion->area_id) == $id ? 'selected' : '' }}>
                                    {{ $nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('area_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="responsable_id">Responsable <span class="text-danger">*</span></label>
                        <select class="form-control @error('responsable_id') is-invalid @enderror" id="responsable_id" name="responsable_id" required>
                            <option value="">Seleccionar responsable...</option>
                            @foreach($responsables as $id => $nombre)
                                <option value="{{ $id }}" {{ old('responsable_id', $designacion->responsable_id) == $id ? 'selected' : '' }}>
                                    {{ $nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('responsable_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fecha_inicio">Fecha Inicio <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('fecha_inicio') is-invalid @enderror" 
                                       id="fecha_inicio" name="fecha_inicio" value="{{ old('fecha_inicio', $designacion->fecha_inicio->format('Y-m-d')) }}" required>
                                @error('fecha_inicio')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fecha_fin">Fecha Fin</label>
                                <input type="date" class="form-control @error('fecha_fin') is-invalid @enderror" 
                                       id="fecha_fin" name="fecha_fin" value="{{ old('fecha_fin', $designacion->fecha_fin ? $designacion->fecha_fin->format('Y-m-d') : '') }}">
                                <small class="form-text text-muted">Dejar en blanco para designación indefinida</small>
                                @error('fecha_fin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="periodicidad">Periodicidad <span class="text-danger">*</span></label>
                        <select class="form-control @error('periodicidad') is-invalid @enderror" id="periodicidad" name="periodicidad" required>
                            <option value="">Seleccionar periodicidad...</option>
                            <option value="diaria" {{ old('periodicidad', $designacion->periodicidad) == 'diaria' ? 'selected' : '' }}>Diaria</option>
                            <option value="semanal" {{ old('periodicidad', $designacion->periodicidad) == 'semanal' ? 'selected' : '' }}>Semanal</option>
                            <option value="mensual" {{ old('periodicidad', $designacion->periodicidad) == 'mensual' ? 'selected' : '' }}>Mensual</option>
                            <option value="unica" {{ old('periodicidad', $designacion->periodicidad) == 'unica' ? 'selected' : '' }}>Única</option>
                        </select>
                        @error('periodicidad')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="observaciones">Observaciones</label>
                        <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                                  id="observaciones" name="observaciones" rows="3">{{ old('observaciones', $designacion->observaciones) }}</textarea>
                        @error('observaciones')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="activo" name="activo" value="1" {{ $designacion->activo ? 'checked' : '' }}>
                            <label class="custom-control-label" for="activo">Activa</label>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save mr-2"></i>Actualizar Designación
                    </button>
                    <a href="{{ route('designaciones.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times mr-2"></i>Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Información</h3>
            </div>
            <div class="card-body">
                <p class="text-muted">
                    Modifique los datos de la designación. Los campos marcados con <span class="text-danger">*</span> son obligatorios.
                </p>
                <hr>
                <h6>Notas:</h6>
                <ul class="mb-0">
                    <li>El área y responsable son obligatorios</li>
                    <li>La fecha de fin debe ser posterior o igual a la de inicio</li>
                    <li>Si no especifica fecha fin, la designación es indefinida</li>
                    <li>Las designaciones inactivas no se consideran en el dashboard</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

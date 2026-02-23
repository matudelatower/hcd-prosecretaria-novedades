@extends('layouts.app')

@section('title', 'Crear Novedad')
@section('page-title', 'Nueva Novedad')
@section('breadcrumb', 'Nueva Novedad')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Datos de la Novedad</h3>
            </div>
            <form action="{{ route('novedades.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="descripcion">Descripción <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                  id="descripcion" name="descripcion" rows="4" required>{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tipo">Tipo <span class="text-danger">*</span></label>
                                <select class="form-control @error('tipo') is-invalid @enderror" id="tipo" name="tipo" required>
                                    <option value="">Seleccionar tipo...</option>
                                    <option value="incidencia" {{ old('tipo') == 'incidencia' ? 'selected' : '' }}>Incidencia</option>
                                    <option value="mantenimiento" {{ old('tipo') == 'mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                                    <option value="evento" {{ old('tipo') == 'evento' ? 'selected' : '' }}>Evento</option>
                                    <option value="otro" {{ old('tipo') == 'otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                                @error('tipo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="estado">Estado <span class="text-danger">*</span></label>
                                <select class="form-control @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                                    <option value="">Seleccionar estado...</option>
                                    <option value="pendiente" {{ old('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="en_progreso" {{ old('estado') == 'en_progreso' ? 'selected' : '' }}>En Progreso</option>
                                    <option value="resuelto" {{ old('estado') == 'resuelto' ? 'selected' : '' }}>Resuelto</option>
                                </select>
                                @error('estado')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fecha">Fecha <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('fecha') is-invalid @enderror" 
                                       id="fecha" name="fecha" value="{{ old('fecha', now()->format('Y-m-d')) }}" required>
                                @error('fecha')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="hora">Hora</label>
                                <input type="time" class="form-control @error('hora') is-invalid @enderror" 
                                       id="hora" name="hora" value="{{ old('hora', now()->format('H:i')) }}">
                                @error('hora')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="area_id">Área <span class="text-danger">*</span></label>
                                <select class="form-control @error('area_id') is-invalid @enderror" id="area_id" name="area_id" required>
                                    <option value="">Seleccionar área...</option>
                                    @foreach($areas as $id => $nombre)
                                        <option value="{{ $id }}" {{ old('area_id') == $id ? 'selected' : '' }}>
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
                        </div>
                        @if(Auth::user()->isAdmin())
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="responsable_id">Responsable</label>
                                    <select class="form-control @error('responsable_id') is-invalid @enderror" id="responsable_id" name="responsable_id">
                                        <option value="">Seleccionar responsable...</option>
                                        @foreach($responsables as $id => $nombre)
                                            <option value="{{ $id }}" {{ old('responsable_id') == $id ? 'selected' : '' }}>
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
                            </div>
                        @else
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Responsable</label>
                                    <p class="form-control-plaintext">{{ Auth::user()->responsable->nombre_completo ?? 'No asignado' }}</p>
                                    <small class="form-text text-muted">Se asignará automáticamente a ti como responsable</small>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="observaciones">Observaciones</label>
                        <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                                  id="observaciones" name="observaciones" rows="3">{{ old('observaciones') }}</textarea>
                        @error('observaciones')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="imagenes">Imágenes</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('imagenes') is-invalid @enderror" 
                                       id="imagenes" name="imagenes[]" multiple accept="image/*">
                                <label class="custom-file-label" for="imagenes">Elegir imágenes...</label>
                            </div>
                        </div>
                        <small class="form-text text-muted">Puede seleccionar múltiples imágenes (JPG, PNG, GIF)</small>
                        @error('imagenes')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i>Guardar Novedad
                    </button>
                    <a href="{{ route('novedades.index') }}" class="btn btn-secondary">
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
                    Complete los datos de la novedad. Los campos marcados con <span class="text-danger">*</span> son obligatorios.
                </p>
                <hr>
                <h6>Tipos de Novedad:</h6>
                <ul class="mb-3">
                    <li><span class="badge badge-danger">Incidencia</span> - Problemas o emergencias</li>
                    <li><span class="badge badge-warning">Mantenimiento</span> - Tareas de mantenimiento</li>
                    <li><span class="badge badge-info">Evento</span> - Eventos programados</li>
                    <li><span class="badge badge-secondary">Otro</span> - Otros tipos</li>
                </ul>
                <h6>Estados:</h6>
                <ul class="mb-0">
                    <li><span class="badge badge-warning">Pendiente</span> - Esperando atención</li>
                    <li><span class="badge badge-info">En Progreso</span> - Siendo atendida</li>
                    <li><span class="badge badge-success">Resuelto</span> - Finalizada</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelector('.custom-file-input').addEventListener('change',function(e){
    var fileName = document.getElementById("imagenes").files.length + ' archivos seleccionados';
    var nextSibling = e.target.nextElementSibling;
    nextSibling.innerText = fileName
});
</script>
@endsection

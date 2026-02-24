@extends('layouts.app')

@section('title', 'Editar Área')
@section('page-title', 'Editar Área')
@section('breadcrumb', 'Editar Área')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Datos del Área</h3>
            </div>
            <form action="{{ route('areas.update', $area) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="nombre">Nombre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                               id="nombre" name="nombre" value="{{ old('nombre', $area->nombre) }}" required>
                        @error('nombre')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="codigo">Código <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('codigo') is-invalid @enderror" 
                               id="codigo" name="codigo" value="{{ old('codigo', $area->codigo) }}" required>
                        @error('codigo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tipo">Tipo <span class="text-danger">*</span></label>
                        <select id="tipo" name="tipo" class="form-control @error('tipo') is-invalid @enderror" required>
                            <option value="">Seleccione un tipo</option>
                            <option value="edificio" {{ old('tipo', $area->tipo) == 'edificio' ? 'selected' : '' }}>Edificio</option>
                            <option value="area" {{ old('tipo', $area->tipo) == 'area' ? 'selected' : '' }}>Área</option>
                            <option value="oficina" {{ old('tipo', $area->tipo) == 'oficina' ? 'selected' : '' }}>Oficina</option>
                        </select>
                        @error('tipo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="padre_id">Área Padre</label>
                        <select id="padre_id" name="padre_id" class="form-control @error('padre_id') is-invalid @enderror">
                            <option value="">Sin área padre (es raíz)</option>
                            @foreach($areasPadre as $id => $nombre)
                                <option value="{{ $id }}" {{ old('padre_id', $area->padre_id) == $id ? 'selected' : '' }}>{{ $nombre }}</option>
                            @endforeach
                        </select>
                        @error('padre_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea id="descripcion" name="descripcion" rows="3" 
                                  class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion', $area->descripcion) }}</textarea>
                        @error('descripcion')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('areas.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i>Actualizar Área
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

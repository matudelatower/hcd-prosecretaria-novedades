@extends('layouts.app')

@section('title', 'Ver Responsable')
@section('page-title', 'Detalles del Responsable')
@section('breadcrumb', 'Detalles')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-body box-profile">
                <div class="text-center">
                    <i class="fas fa-user-circle img-circle elevation-2" style="font-size: 5rem; color: #007bff;"></i>
                </div>
                <h3 class="profile-username text-center">{{ $responsable->nombre_completo }}</h3>
                <p class="text-muted text-center">DNI: {{ $responsable->dni }}</p>
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Estado:</b> 
                        <span class="float-right badge {{ $responsable->activo ? 'bg-success' : 'bg-danger' }}">
                            {{ $responsable->activo ? 'Activo' : 'Inactivo' }}
                        </span>
                    </li>
                    <li class="list-group-item">
                        <b>Teléfono:</b> <span class="float-right">{{ $responsable->telefono ?: 'No especificado' }}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Email:</b> <span class="float-right">{{ $responsable->email ?: 'No especificado' }}</span>
                    </li>
                </ul>
                <div class="btn-group w-100">
                    <a href="{{ route('responsables.edit', $responsable) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit mr-1"></i> Editar
                    </a>
                    <a href="{{ route('responsables.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Volver
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Información Detallada</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3">
                        <strong>Nombre:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $responsable->nombre }}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <strong>Apellido:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $responsable->apellido }}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <strong>DNI:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $responsable->dni }}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <strong>Teléfono:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $responsable->telefono ?: 'No especificado' }}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <strong>Email:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $responsable->email ?: 'No especificado' }}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <strong>Estado:</strong>
                    </div>
                    <div class="col-sm-9">
                        <span class="badge {{ $responsable->activo ? 'bg-success' : 'bg-danger' }}">
                            {{ $responsable->activo ? 'Activo' : 'Inactivo' }}
                        </span>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <strong>Fecha de creación:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $responsable->created_at->format('d/m/Y H:i') }}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <strong>Última actualización:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $responsable->updated_at->format('d/m/Y H:i') }}
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-info mt-3">
            <div class="card-header">
                <h3 class="card-title">Designaciones Activas</h3>
            </div>
            <div class="card-body">
                @php
                    $designaciones = $responsable->designaciones()->activas()->with('area')->get();
                @endphp
                @forelse($designaciones as $designacion)
                    <div class="d-flex justify-content-between align-items-center mb-2 p-2 bg-light rounded">
                        <div>
                            <strong>{{ $designacion->area->nombre }}</strong>
                            <br>
                            <small class="text-muted">{{ ucfirst($designacion->periodicidad) }}</small>
                        </div>
                        <span class="badge badge-info">
                            {{ $designacion->fecha_inicio->format('d/m/Y') }}
                            @if($designacion->fecha_fin)
                                al {{ $designacion->fecha_fin->format('d/m/Y') }}
                            @endif
                        </span>
                    </div>
                @empty
                    <p class="text-muted">No tiene designaciones activas</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

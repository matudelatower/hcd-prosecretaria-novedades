@extends('layouts.app')

@section('title', 'Listado de Novedades')
@section('page-title', 'Novedades')
@section('breadcrumb', 'Novedades')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Listado de Novedades</h3>
                <div class="card-tools">
                    <a href="{{ route('novedades.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Nueva Novedad
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Descripción</th>
                            <th>Tipo</th>
                            <th>Fecha</th>
                            <th>Área</th>
                            <th>Responsable</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($novedades as $novedad)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-start">
                                        @if($novedad->imagenes && $novedad->imagenes->count() > 0)
                                            <div class="mr-3">
                                                <img src="{{ asset('storage/novedades/' . $novedad->imagenes->first()->imagen) }}" 
                                                     alt="Imagen" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                            </div>
                                        @endif
                                        <div>
                                            <strong>{{ Str::limit($novedad->descripcion, 80) }}</strong>
                                            @if($novedad->imagenes && $novedad->imagenes->count() > 0)
                                                <br><small class="text-muted"><i class="fas fa-images"></i> {{ $novedad->imagenes->count() }} imagen(es)</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge 
                                        {{ $novedad->tipo == 'incidencia' ? 'bg-danger' : '' }}
                                        {{ $novedad->tipo == 'mantenimiento' ? 'bg-warning' : '' }}
                                        {{ $novedad->tipo == 'evento' ? 'bg-info' : '' }}
                                        {{ $novedad->tipo == 'otro' ? 'bg-secondary' : '' }}">
                                        {{ ucfirst($novedad->tipo) }}
                                    </span>
                                </td>
                                <td>{{ $novedad->fecha->format('d/m/Y') }}</td>
                                <td>{{ $novedad->area->nombre }}</td>
                                <td>{{ $novedad->responsable ? $novedad->responsable->nombre_completo : '-' }}</td>
                                <td>
                                    <span class="badge 
                                        {{ $novedad->estado == 'pendiente' ? 'bg-warning' : '' }}
                                        {{ $novedad->estado == 'en_progreso' ? 'bg-info' : '' }}
                                        {{ $novedad->estado == 'resuelto' ? 'bg-success' : '' }}">
                                        {{ ucfirst($novedad->estado) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('novedades.show', $novedad) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('novedades.edit', $novedad) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('novedades.destroy', $novedad) }}" method="POST" style="display: inline;" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    <i class="fas fa-exclamation-triangle fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No hay novedades registradas</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle delete form submissions
    const deleteForms = document.querySelectorAll('.delete-form');
    
    deleteForms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (confirm('¿Está seguro que desea eliminar esta novedad?')) {
                const formData = new FormData(this);
                const submitButton = this.querySelector('button[type="submit"]');
                const originalText = submitButton.innerHTML;
                
                // Show loading state
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the row from the table
                        const row = this.closest('tr');
                        row.style.transition = 'opacity 0.3s';
                        row.style.opacity = '0';
                        
                        setTimeout(() => {
                            row.remove();
                            
                            // Check if there are no more rows
                            const tbody = document.querySelector('tbody');
                            if (tbody.children.length === 0) {
                                tbody.innerHTML = `
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <i class="fas fa-exclamation-triangle fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">No hay novedades registradas</p>
                                        </td>
                                    </tr>
                                `;
                            }
                        }, 300);
                        
                        // Show success message
                        showAlert(data.message || 'Novedad eliminada exitosamente.', 'success');
                    } else {
                        throw new Error(data.message || 'Error al eliminar la novedad');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    
                    // If there's an error, fallback to normal form submission
                    if (error.message.includes('Error al eliminar')) {
                        showAlert('Error al eliminar la novedad. Recargando la página...', 'error');
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        showAlert('Error de conexión. Recargando la página...', 'error');
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    }
                    
                    // Restore button state
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalText;
                });
            }
        });
    });
    
    // Function to show alert messages
    function showAlert(message, type) {
        // Remove existing alerts
        const existingAlert = document.querySelector('.alert-message');
        if (existingAlert) {
            existingAlert.remove();
        }
        
        // Create new alert
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show alert-message`;
        alertDiv.style.position = 'fixed';
        alertDiv.style.top = '20px';
        alertDiv.style.right = '20px';
        alertDiv.style.zIndex = '9999';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        `;
        
        document.body.appendChild(alertDiv);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 5000);
    }
});
</script>
@endsection

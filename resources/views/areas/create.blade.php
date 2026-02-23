@extends('layouts.app')

@section('title', 'Crear Nueva Área')

@section('content')
<div class="px-4 py-6 sm:px-0">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Crear Nueva Área</h1>
        <p class="text-gray-600">Complete los datos para registrar una nueva área en el sistema</p>
    </div>

    <div class="bg-white shadow rounded-lg">
        <div class="p-6">
            <form action="{{ route('areas.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre *</label>
                        <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('nombre')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="codigo" class="block text-sm font-medium text-gray-700">Código *</label>
                        <input type="text" id="codigo" name="codigo" value="{{ old('codigo') }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('codigo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo *</label>
                        <select id="tipo" name="tipo" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Seleccione un tipo</option>
                            <option value="edificio" {{ old('tipo') == 'edificio' ? 'selected' : '' }}>Edificio</option>
                            <option value="area" {{ old('tipo') == 'area' ? 'selected' : '' }}>Área</option>
                            <option value="oficina" {{ old('tipo') == 'oficina' ? 'selected' : '' }}>Oficina</option>
                        </select>
                        @error('tipo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="padre_id" class="block text-sm font-medium text-gray-700">Área Padre</label>
                        <select id="padre_id" name="padre_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Sin área padre (es raíz)</option>
                            @foreach($areasPadre as $id => $nombre)
                                <option value="{{ $id }}" {{ old('padre_id') == $id ? 'selected' : '' }}>{{ $nombre }}</option>
                            @endforeach
                        </select>
                        @error('padre_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                        <textarea id="descripcion" name="descripcion" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('areas.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                        Cancelar
                    </a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        <i class="fas fa-save mr-2"></i>Guardar Área
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

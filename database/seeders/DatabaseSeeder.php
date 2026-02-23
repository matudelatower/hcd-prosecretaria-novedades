<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Responsable;
use App\Models\Designacion;
use App\Models\Novedad;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Crear edificios principales
        $concejo = Area::create([
            'nombre' => 'Concejo Deliberante',
            'codigo' => 'CD-001',
            'tipo' => 'edificio',
            'descripcion' => 'Edificio principal del Concejo Deliberante'
        ]);

        $anexo1 = Area::create([
            'nombre' => 'Anexo I',
            'codigo' => 'AX-001',
            'tipo' => 'edificio',
            'descripcion' => 'Primer anexo del Concejo'
        ]);

        $anexo2 = Area::create([
            'nombre' => 'Anexo II',
            'codigo' => 'AX-002',
            'tipo' => 'edificio',
            'descripcion' => 'Segundo anexo del Concejo'
        ]);

        // Crear oficinas dentro del Concejo
        $oficinasConcejo = [
            ['Presidencia', 'OF-001', 'Oficina del Presidente del Concejo'],
            ['Secretaría Administrativa', 'OF-002', 'Secretaría de administración general'],
            ['Sala de Sesiones', 'OF-003', 'Sala principal para sesiones'],
            ['Archivo General', 'OF-004', 'Archivo documental del HCD'],
            ['Mesa de Entrada', 'OF-005', 'Recepción y despacho de documentos']
        ];

        foreach ($oficinasConcejo as [$nombre, $codigo, $descripcion]) {
            Area::create([
                'nombre' => $nombre,
                'codigo' => $codigo,
                'tipo' => 'oficina',
                'padre_id' => $concejo->id,
                'descripcion' => $descripcion
            ]);
        }

        // Crear oficinas en Anexo I
        $oficinasAnexo1 = [
            ['Departamento Legal', 'DL-001', 'Asesoría legal'],
            ['Recursos Humanos', 'RR-001', 'Gestión de personal'],
            ['Contabilidad', 'CT-001', 'Área contable']
        ];

        foreach ($oficinasAnexo1 as [$nombre, $codigo, $descripcion]) {
            Area::create([
                'nombre' => $nombre,
                'codigo' => $codigo,
                'tipo' => 'oficina',
                'padre_id' => $anexo1->id,
                'descripcion' => $descripcion
            ]);
        }

        // Crear responsables
        $responsables = [
            ['Juan', 'Pérez', '12345678', '11-1234-5678', 'juan.perez@hcd.gov'],
            ['María', 'González', '23456789', '11-2345-6789', 'maria.gonzalez@hcd.gov'],
            ['Carlos', 'Rodríguez', '34567890', '11-3456-7890', 'carlos.rodriguez@hcd.gov'],
            ['Ana', 'Martínez', '45678901', '11-4567-8901', 'ana.martinez@hcd.gov'],
            ['Luis', 'Sánchez', '56789012', '11-5678-9012', 'luis.sanchez@hcd.gov']
        ];

        foreach ($responsables as [$nombre, $apellido, $dni, $telefono, $email]) {
            Responsable::create([
                'nombre' => $nombre,
                'apellido' => $apellido,
                'dni' => $dni,
                'telefono' => $telefono,
                'email' => $email
            ]);
        }

        // Crear algunas designaciones
        $responsables = Responsable::all();
        $areas = Area::where('tipo', 'oficina')->get();

        foreach ($areas->take(3) as $index => $area) {
            Designacion::create([
                'area_id' => $area->id,
                'responsable_id' => $responsables[$index]->id,
                'fecha_inicio' => now()->subDays($index * 7),
                'periodicidad' => 'semanal',
                'observaciones' => 'Designación semanal para ' . $area->nombre
            ]);
        }

        // Crear algunas novedades de ejemplo
        $tiposNovedad = ['incidencia', 'mantenimiento', 'evento', 'otro'];
        $estados = ['pendiente', 'en_progreso', 'resuelto'];
        $descripciones = [
            'Falla en el sistema de aire acondicionado',
            'Reparación de cerradura en puerta principal',
            'Reunión de mantenimiento programada',
            'Actualización de inventario de mobiliario',
            'Problema con conexión a internet'
        ];

        foreach ($descripciones as $index => $descripcion) {
            Novedad::create([
                'descripcion' => $descripcion,
                'tipo' => $tiposNovedad[$index % count($tiposNovedad)],
                'fecha' => now()->subDays($index),
                'hora' => now()->subHours($index * 2)->format('H:i'),
                'area_id' => $areas->random()->id,
                'responsable_id' => $responsables->random()->id,
                'estado' => $estados[$index % count($estados)],
                'observaciones' => 'Observaciones adicionales de la novedad ' . ($index + 1)
            ]);
        }
        
        // Crear usuarios para los responsables
        $this->call(UserResponsableSeeder::class);
    }
}

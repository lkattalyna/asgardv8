<?php

use App\DevState;
use App\DevTask;
use App\RegConsumedService;
use App\RegCustomerLevel;
use App\RegQuarter;
use App\RegServiceSegment;
use Illuminate\Database\Seeder;

class RegDocReqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DevTask::create([
            'name' => 'Creación de vistas',
            'max_time' => 560,
            'min_time' => 180,
            'description' => 'N/A',
        ]);
        DevState::create([
            'name' => 'En espera',
            'description' => 'Pendiente de ser asignado a un desarrollador'
        ]);
        DevState::create([
            'name' => 'Asignado',
            'description' => 'El requerimiento ha sido asignado a un desarrollador'
        ]);
        DevState::create([
            'name' => 'En proceso',
            'description' => 'El requerimiento ha sido asignado y se ha comenzado a trabajar en él'
        ]);
        DevState::create([
            'name' => 'Pendiente pruebas',
            'description' => 'El requerimiento ha sido desarrollado y se necesita realizar pruebas con el solicitante'
        ]);
        DevState::create([
            'name' => 'Pendiente documentación',
            'description' => 'El requerimiento se encuentra pendiente por documentar y aun no se puede finalizar'
        ]);
        DevState::create([
            'name' => 'Cancelado',
            'description' => 'El requerimiento ha sido cancelado'
        ]);
        DevState::create([
            'name' => 'Finalizado',
            'description' => 'El requerimiento ha sido finalizado y aceptado por el cliente'
        ]);
        RegConsumedService::create([
            'name' => 'No Aplica',
        ]);
        RegConsumedService::create([
            'name' => 'Ansible',
        ]);
        RegConsumedService::create([
            'name' => 'Power BI',
        ]);
        RegCustomerLevel::create([
            'name' => 'N1',
        ]);
        RegCustomerLevel::create([
            'name' => 'N2',
        ]);
        RegCustomerLevel::create([
            'name' => 'N3',
        ]);
        RegCustomerLevel::create([
            'name' => 'Tarea Programada',
        ]);
        RegQuarter::create([
            'name' => '2020 Q1',
            'start_date' => '2020-01-01',
            'end_date' =>  '2020-03-31'
        ]);
        RegQuarter::create([
            'name' => '2020 Q2',
            'start_date' => '2020-04-01',
            'end_date' =>  '2020-06-30'
        ]);
        RegQuarter::create([
            'name' => '2020 Q3',
            'start_date' => '2020-07-01',
            'end_date' =>  '2020-09-30'
        ]);
        RegQuarter::create([
            'name' => '2020 Q4',
            'start_date' => '2020-10-01',
            'end_date' =>  '2020-12-31'
        ]);
        RegServiceSegment::create([
            'name' => 'Personas & Hogar',
            'coordinator_id' => 0,
        ]);
        RegServiceSegment::create([
            'name' => 'Transversal',
            'coordinator_id' => 0,
        ]);
        RegServiceSegment::create([
            'name' => 'Empresas & Negocios',
            'coordinator_id' => 0,
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class PruebasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $empresas = factory(App\Empresa::class, 5)->create();
        $empresas->each(function (App\Empresa $empresa) {
            $users = factory(App\User::class)->create([
                'id_empresa' => $empresa->id,
            ]);
            $users->each(function (App\User $user) use ( $empresa) {
                $rol = Role::findById(2);
                $user->assignRole($rol);
                factory(App\Blog::class, 10)->create([
                    'id_empresa' => $empresa->id,
                    'id_usuario' => $user->id,
                ]);
            });
            $users->empresas()->attach($empresa);
            $departamentos = factory(App\Departamento::class)
                ->times(3)
                ->create([
                    'id_empresa' => $empresa->id,
                ]);
            $departamentos->each(function (App\Departamento $departamento) use ($empresa) {
                $empleados = factory(App\Empleado::class)
                    ->times(2)
                    ->create([
                        'id_departamento' => $departamento->id,
                        'id_empresa' => $empresa->id,
                    ]);
                /* $empleados->each(function (App\Empleado $empleado) use ($empleados, $empresa) {
                    factory(App\Acumulado::class)
                        ->times(9)
                        ->create([
                            'id_empleado' => $empleado->id,
                        ]);
                    factory(App\Novedade::class)
                        ->times(1)
                        ->create([
                            'id_empleado' => $empleado->id,
                            'id_empresa' => $empresa->id,
                        ]);
                }); */
            });
        });
    }
}

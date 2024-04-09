<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()['cache']->forget('spatie.permission.cache');
        // create permissions
        $permissions = [
            'rol-create',
            'rol-delete',
            'rol-edit',
            'rol-list',
            'rol-admin',
            'rol-show',
            'user-create',
            'user-delete',
            'user-edit',
            'user-list',
            'user-admin',
            'user-show',
            'backup-menu',
            'backup-user',
            'backup-run',
            'unixEN-menu',
            'unixEN-user',
            'unixEN-run',
            'unixEN-create',
            'unixEN-delete',
            'unixEN-edit',
            'unixPH-menu',
            'unixPH-user',
            'unixPH-run',
            'unixPH-create',
            'unixPH-delete',
            'unixPH-edit',
            'windowsEN-menu',
            'windowsEN-user',
            'windowsEN-run',
            'windowsEN-create',
            'windowsEN-delete',
            'windowsEN-edit',
            'windowsPH-menu',
            'windowsPH-user',
            'windowsPH-run',
            'windowsPH-create',
            'windowsPH-delete',
            'windowsPH-edit',
            'virtualization-menu',
            'virtualization-user',
            'virtualization-run',
            'virtualization-list',
            'executionLog-list',
            'executionLog-admin',
            'executionLog-user',
            'executionLog-menu',
            'executionLog-show',
            'OsGroup-create',
            'OsGroup-delete',
            'OsGroup-edit',
            'OsGroup-list',
            'OsGroup-admin',
            'OsGroup-menu',
            'OsGroup-user',
            'inventory-list',
            'inventory-admin',
            'inventory-user',
            'inventory-menu',
            'inventory-show',
            'inventory-edit',
            'amt-menu',
            'amt-user',
            'amt-run',
            'balancer-menu',
            'balancer-user',
            'balancer-run',
            'awxTemplate-create',
            'awxTemplate-delete',
            'awxTemplate-edit',
            'awxTemplate-list',
            'awxTemplate-admin',
            'awxTemplate-show',
            'awxTemplate-menu',
            'awxTemplate-user',
            'loginLog-menu',
            'loginLog-user',
            'loginLog-list',
            'loginLog-admin',
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        // create roles and assign created permissions
        Role::create(['name' => 'GRP-ASG-DES','comment' => 'Grupo Desarrolladores Portal Automatización ASGARD']);
        Role::create(['name' => 'GRP-ASG-Admin-UNIXEN','comment' => 'Grupo Unix Asgard Administradores Empresas y Negocios']);
        Role::create(['name' => 'GRP-ASG-Admin-UNIXPH','comment' => 'Grupo Unix Asgard Administradores Personas y Hogares']);
        Role::create(['name' => 'GRP-ASG-Admin-WINPH','comment' => 'Grupo Windows Asgard Administradores Personas y Hogares']);
        Role::create(['name' => 'GRP-ASG-Admin-WINEN','comment' => 'Grupo Windows Asgard Administradores Empresas y Negocios']);
        Role::create(['name' => 'GRP-ASG-Admin-VIRTUALIZACION','comment' => 'Grupo Virtualización Asgard Administradores']);
        Role::create(['name' => 'GRP-ASG-Admin-BACKUP','comment' => 'Grupo Backup Asgard Administradores']);
        Role::create(['name' => 'GRP-ASG-Admin-RTECNOLOGICOS','comment' => 'Grupo Recursos Tecnológicos Asgard Administradores']);
        Role::create(['name' => 'GRP-ASG-Admin-ALMACENAMIENTO','comment' => 'Grupo Almacenamiento Asgard Administradores']);
        Role::create(['name' => 'GRP-ASG-OPE-WINEN','comment' => 'Grupo Operación Ejecutores Asgard - Windows Empresas y Negocios']);
        Role::create(['name' => 'GRP-ASG-OPE-WINPH','comment' => 'Grupo Operación Ejecutores Asgard - Windows Personas y Hogares']);
        Role::create(['name' => 'GRP-ASG-OPE-UNIXEN','comment' => 'Grupo Operación Ejecutores Asgard - Unix Empresas y Negocios']);
        Role::create(['name' => 'GRP-ASG-OPE-UNIXPH','comment' => 'Grupo Operación Ejecutores Asgard - Unix Personas y Hogares']);
        Role::create(['name' => 'GRP-ASG-OPE-VIRTUALIZACION','comment' => 'Grupo Operación Ejecutores Asgard - Virtualización']);
        Role::create(['name' => 'GRP-ASG-OPE-BACKUP','comment' => 'Grupo Operación Ejecutores Asgard - Backup']);
        Role::create(['name' => 'GRP-ASG-OPE-RTECNOLOGICOS','comment' => 'Grupo Operación Ejecutores Asgard - Recursos Tecnológicos']);
        Role::create(['name' => 'GRP-ASG-OPE-ALMACENAMIENTO ','comment' => 'Grupo Operación Ejecutores Asgard - Almacenamiento']);
        Role::create(['name' => 'GRP-ASG-OPE-IRE','comment' => 'Grupo Operación Ejecutores Asgard - IRE']);
        Role::create(['name' => 'GRP-ASG-Admin-SQL','comment' => 'Grupo  Asgard Administradores - SQL']);
        Role::create(['name' => 'GRP-ASG-OPE-SQL','comment' => 'Grupo Operación Ejecutores Asgard - SQL']);
        Role::create(['name' => 'GRP-ASG-Admin-Oracle','comment' => 'Grupo  Asgard Administradores - Oracle']);
        Role::create(['name' => 'GRP-ASG-OPE-Oracle','comment' => 'Grupo Operación Ejecutores Asgard - Oracle']);
        Role::create(['name' => 'GRP-ASG-Admin-AMT','comment' => 'Grupo  Asgard Administradores - Capa Media']);
        Role::create(['name' => 'GRP-ASG-OPE-AMT','comment' => 'Grupo Operación Ejecutores Asgard - Capa Media']);
        Role::create(['name' => 'GRP-ASG-Admin-REDCorporativa','comment' => 'Grupo  Asgard Administradores - Red Corporativa Datacenter']);
        Role::create(['name' => 'GRP-ASG-OPE-RedCorporativa','comment' => 'Grupo Operación Ejecutores Asgard - Red Corporativa Datacenter']);
        Role::create(['name' => 'GRP-ASG-OPE-UNIX','comment' => 'Grupo Operación Ejecutores Asgard - Unix Transversal']);
        Role::create(['name' => 'GRP-ASG-OPE-WIN','comment' => 'Grupo Operación Ejecutores Asgard - Windows Transversal']);
        Role::create(['name' => 'GRP-ASG-Admin-IAAS','comment' => 'Grupo IAAS Asgard Administradores']);
        Role::create(['name' => 'GRP-ASG-OPE-IAAS','comment' => 'Grupo Operación Ejecutores Asgard - IAAS']);
        Role::create(['name' => 'GRP-ASG-Admin-PAAS','comment' => 'Grupo PAAS Asgard Administradores']);
        Role::create(['name' => 'GRP-ASG-OPE-PAAS','comment' => 'Grupo Operación Ejecutores Asgard - PAAS']);
        $role = Role::create(['name' => 'GRP-ASG-Admin-Master','comment' => 'Grupo de Administradores Portal Automatización ASGARD']);
        $role->givePermissionTo(Permission::all());
        $user = User::find(1);
        $user->assignRole($role->name);
        // fin seeder manejo de roles

    }
}

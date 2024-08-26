<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rol;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_admin = Role::create(['name' => 'admin']);
        $role_oficina = Role::create(['name' => 'oficina']);
        $role_planta = Role::create(['name' => 'planta']);
        $role_almacen = Role::create(['name' => 'almacen']);

        $permission_read_sistemas = Permission::create(['name' => 'read sistemas']);
        $permission_read_cargas = Permission::create(['name' => 'read cargas']);
        $permission_read_inventario = Permission::create(['name' => 'read inventario']);
        $permission_read_solicitudcarga = Permission::create(['name' => 'read solicitudcarga']);
        $permission_read_conocimiento = Permission::create(['name' => 'read conocimiento']);

        $permission_create_solicitud = Permission::create(['name' => 'create solicitud']);
        $permission_approved_solicitud = Permission::create(['name' => 'approved solicitud']);
        $permission_read_solicitud = Permission::create(['name' => 'read solicitud']);
        $permission_update_solicitud = Permission::create(['name' => 'update solicitud']);
        $permission_delete_solicitud = Permission::create(['name' => 'delete solicitud']);

        $permission_create_conocimiento = Permission::create(['name' => 'create conocimiento']);
        $permission_read_conocimiento = Permission::create(['name' => 'read conocimiento']);
        $permission_update_conocimiento = Permission::create(['name' => 'update conocimiento']);
        $permission_pdf_conocimiento = Permission::create(['name' => 'pdf conocimiento']);

        $permission_create_ingreso = Permission::create(['name' => 'create ingreso']);
        $permission_read_ingreso = Permission::create(['name' => 'read ingreso']);
        $permission_update_ingreso = Permission::create(['name' => 'update ingreso']);
        $permission_delete_ingreso = Permission::create(['name' => 'delete ingreso']);

        $permissions_admin = [$permission_read_sistemas];

        $permissions_oficina = [$permission_read_cargas, $permission_create_solicitud, $permission_read_solicitud,
                                $permission_delete_solicitud, $permission_approved_solicitud,$permission_read_conocimiento];

        $permissions_planta = [$permission_read_cargas, $permission_update_solicitud,$permission_read_solicitud,
        $permission_create_conocimiento, $permission_pdf_conocimiento, $permission_read_conocimiento,
        $permission_update_conocimiento];

        $permissions_almacen = [$permission_read_inventario, $permission_read_conocimiento, $permission_read_cargas,
                                $permission_create_ingreso, $permission_read_ingreso];

        //$permissions_editor = [$permission_create_lesson, $permission_read_lesson , $permission_update_lesson, $permission_delete_lesson,
        //$permission_create_category, $permission_read_category, $permission_update_category, $permission_delete_category];

        $role_admin->syncPermissions($permissions_admin);
        $role_oficina->syncPermissions($permissions_oficina);
        $role_planta->syncPermissions($permissions_planta);
        $role_almacen->syncPermissions($permissions_almacen);
        //$role_editor->syncPermissions($permissions_editor);
    }
}

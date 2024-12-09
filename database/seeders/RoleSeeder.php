<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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

        //producto terminado
        $permission_producto_terminado = Permission::create(['name' => 'layout productoterminado']);
        //cargas
        $permission_layout_sistemas = Permission::create(['name' => 'layout sistemas']);
        $permission_layout_cargas = Permission::create(['name' => 'layout cargas']);
        $permission_layout_inventarios = Permission::create(['name' => 'layout inventarios']);

        $permission_sub_layout_solicitudcarga = Permission::create(['name' => 'layout solicitudcarga']);
        $permission_sub_layout_conocimientos = Permission::create(['name' => 'layout conocimientos']);
        $permission_sub_layout_ingreso = Permission::create(['name' => 'layout ingreso']);
        $permission_sub_layout_salida = Permission::create(['name' => 'layout salida']);
        $permission_sub_layout_kardex = Permission::create(['name' => 'layout kardex']);

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

        $permissions_admin = [$permission_layout_sistemas];

        $permissions_oficina = [$permission_layout_cargas, $permission_sub_layout_solicitudcarga, $permission_sub_layout_conocimientos,
        $permission_sub_layout_kardex, $permission_create_solicitud, $permission_approved_solicitud, $permission_read_solicitud,
        $permission_delete_solicitud, $permission_read_conocimiento];

        $permissions_planta = [$permission_layout_cargas, $permission_sub_layout_solicitudcarga, $permission_sub_layout_conocimientos,
        $permission_layout_inventarios, $permission_sub_layout_ingreso, $permission_update_solicitud, $permission_create_conocimiento, $permission_read_conocimiento,
        $permission_update_conocimiento, $permission_pdf_conocimiento, $permission_read_ingreso];

        $permissions_almacen = [$permission_layout_cargas, $permission_layout_inventarios, $permission_sub_layout_conocimientos,
        $permission_sub_layout_ingreso, $permission_sub_layout_salida, $permission_sub_layout_kardex, $permission_read_conocimiento,
        $permission_create_ingreso, $permission_read_ingreso, $permission_update_ingreso, $permission_delete_ingreso];

        $role_admin->syncPermissions($permissions_admin);
        $role_oficina->syncPermissions($permissions_oficina);
        $role_planta->syncPermissions($permissions_planta);
        $role_almacen->syncPermissions($permissions_almacen);
    }
}

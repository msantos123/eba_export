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
        $role_financiera = Role::create(['name' => 'financiera']);

        //modulos
        $permiso_modulo_plantas = Permission::create(['name' => 'Modulo Plantas']);
        $permiso_modulo_sistemas = Permission::create(['name' => 'Modulo Sistemas']);
        $permiso_modulo_cargas = Permission::create(['name' => 'Modulo Cargas']);
        $permiso_modulo_almacenes = Permission::create(['name' => 'Modulo Almacenes']);
        $permiso_modulo_etiquetas = Permission::create(['name' => 'Modulo Etiquetas']);
        $permiso_modulo_tracking = Permission::create(['name' => 'Modulo Tracking']);
        $permiso_modulo_contratos = Permission::create(['name' => 'Modulo Contratos']);
        $permiso_modulo_costos = Permission::create(['name' => 'Modulo Costos']);
        $permiso_modulo_planificacion = Permission::create(['name' => 'Modulo Planificacion']);
        $permiso_modulo_poa = Permission::create(['name' => 'Modulo Poa']);
        $permiso_modulo_liberacion = Permission::create(['name' => 'Modulo Liberacion']);
        $permiso_modulo_prefactura = Permission::create(['name' => 'Modulo Pre Factura']);
        $permiso_modulo_estadistica = Permission::create(['name' => 'Modulo Estadistica']);
        //sub modulos
        $permiso_submodulo_solicitudcarga = Permission::create(['name' => 'Sub Modulo Cargas Solicitud Planta']);
        $permiso_submodulo_conocimiento = Permission::create(['name' => 'Sub Modulo Cargas Conocimiento']);
        $permiso_submodulo_solicitudalmacen = Permission::create(['name' => 'Sub Modulo Almacen Solicitud Almacen']);
        $permiso_submodulo_ingresoalmacen = Permission::create(['name' => 'Sub Modulo Almacen Ingreso Almacen']);
        $permiso_submodulo_kardex = Permission::create(['name' => 'Sub Modulo Almacen Kardex']);
        $permiso_submodulo_salidaalmacen = Permission::create(['name' => 'Sub Modulo Almacen Salida Almacen']);
        //Solicitud Carga
        $permiso_crear_solicitudcarga = Permission::create(['name' => 'Crear Solicitud Planta']);
        $permiso_modificar_solicitudcarga = Permission::create(['name' => 'Modificar Solicitud Planta']);
        $permiso_eliminar_solicitudcarga = Permission::create(['name' => 'Eliminar Solicitud Eliminar']);
        //Conocimiento carga
        $permiso_crear_conocimiento = Permission::create(['name' => 'Crear Conocimiento Carga']);
        $permiso_modificar_conocimiento = Permission::create(['name' => 'Modificar Conocimiento Carga']);
        $permiso_pdf_conocimiento = Permission::create(['name' => 'PDF Conocimiento Carga']);
        //Comprobante Ingreso
        $permiso_crear_comprobanteingreso = Permission::create(['name' => 'Crear Comprobante Ingreso']);
        $permiso_pdf_comprobanteingreso = Permission::create(['name' => 'PDF Comprobante Ingreso']);
        //Kardex
        $permiso_ingresar_kardex = Permission::create(['name' => 'Ingresar Carga Kardex']);
        //Solicitud Almacen
        $permiso_crear_solicitudalmacen = Permission::create(['name' => 'Crear Solicitud Almacen']);
        $permiso_modificar_solicitudalmacen = Permission::create(['name' => 'Modificar Solicitud Almacen']);
        $permiso_eliminar_solicitudalmacen = Permission::create(['name' => 'Eliminar Solicitud Almacen']);
        //Comprobante Salida
        $permiso_crear_comprobantesalida = Permission::create(['name' => 'Crear Comprobante Salida']);
        $permiso_ver_fechas_elaboracion = Permission::create(['name' => 'Ver Fechas de Elaboracion']);
        $permiso_pdf_comprobantesalida = Permission::create(['name' => 'PDF Comprobante Salida']);
        //costos
        $permiso_agregar_costo = Permission::create(['name' => 'Agregar Costo Lote']);
        //liberacion
        $permiso_revisar_liberacion = Permission::create(['name' => 'Revisar Liberacion']);
        $permiso_aprobar_liberacion = Permission::create(['name' => 'Aporbacion Liberacion']);
        $permiso_generarcarta_liberacion = Permission::create(['name' => 'Generar Carta Liberacion']);
        //prefactura
        $permiso_crear_prefactura = Permission::create(['name' => 'Crear Prefactura']);

        $permissions_admin = [
            //modulos
            $permiso_modulo_plantas,
            $permiso_modulo_sistemas,
            //$permiso_modulo_cargas,
            $permiso_modulo_almacenes,
            //$permiso_modulo_etiquetas,
            $permiso_modulo_tracking,
            $permiso_modulo_contratos,
            $permiso_modulo_costos,
            $permiso_modulo_planificacion,
            $permiso_modulo_poa,
            $permiso_modulo_liberacion,
            $permiso_modulo_prefactura,
            $permiso_modulo_estadistica,
            //submodulos
            //$permiso_submodulo_solicitudcarga,
            //$permiso_submodulo_conocimiento,
            //$permiso_submodulo_solicitudalmacen,
            //$permiso_submodulo_ingresoalmacen,
            //$permiso_submodulo_kardex,
            //$permiso_submodulo_salidaalmacen,
            //Solicitud Carga
            //$permiso_crear_solicitudcarga,
            //$permiso_modificar_solicitudcarga,
            //$permiso_eliminar_solicitudcarga,
            //Conocimiento carga
            //$permiso_crear_conocimiento,
            //$permiso_modificar_conocimiento,
            //$permiso_pdf_conocimiento,
            //Comprobante Ingreso
            //$permiso_crear_comprobanteingreso,
            //$permiso_pdf_comprobanteingreso,
            //Kardex
            //$permiso_ingresar_kardex,
            //Solicitud Almacen
            //$permiso_crear_solicitudalmacen,
            //$permiso_modificar_solicitudalmacen,
            //$permiso_eliminar_solicitudalmacen,
            //Comprobante Salida
            //$permiso_crear_comprobantesalida,
            //$permiso_ver_fechas_elaboracion,
            //$permiso_pdf_comprobantesalida,
            //costos
            //$permiso_agregar_costo,
            //liberacion
            //$permiso_revisar_liberacion,
            $permiso_aprobar_liberacion,
            //$permiso_generarcarta_liberacion,

        ];

        $permissions_oficina = [
            //modulos
            $permiso_modulo_plantas,
            //$permiso_modulo_sistemas,
            $permiso_modulo_cargas,
            $permiso_modulo_almacenes,
            $permiso_modulo_etiquetas,
            $permiso_modulo_tracking,
            $permiso_modulo_contratos,
            $permiso_modulo_costos,
            //$permiso_modulo_planificacion,
            $permiso_modulo_poa,
            $permiso_modulo_liberacion,
            $permiso_modulo_prefactura,
            $permiso_modulo_estadistica,
            //submodulos
            $permiso_submodulo_solicitudcarga,
            $permiso_submodulo_conocimiento,
            $permiso_submodulo_solicitudalmacen,
            //$permiso_submodulo_ingresoalmacen,
            $permiso_submodulo_kardex,
            //$permiso_submodulo_salidaalmacen,
            //Solicitud Carga
            $permiso_crear_solicitudcarga,
            $permiso_modificar_solicitudcarga,
            $permiso_eliminar_solicitudcarga,
            //Conocimiento carga
            //$permiso_crear_conocimiento,
            //$permiso_modificar_conocimiento,
            //$permiso_pdf_conocimiento,
            //Comprobante Ingreso
            //$permiso_crear_comprobanteingreso,
            //$permiso_pdf_comprobanteingreso,
            //Kardex
            //$permiso_ingresar_kardex,
            //Solicitud Almacen
            $permiso_crear_solicitudalmacen,
            $permiso_modificar_solicitudalmacen,
            $permiso_eliminar_solicitudalmacen,
            //Comprobante Salida
            //$permiso_crear_comprobantesalida,
            //$permiso_ver_fechas_elaboracion,
            //$permiso_pdf_comprobantesalida,
            //costos
            //$permiso_agregar_costo,
            //liberacion
            //$permiso_revisar_liberacion,
            //$permiso_aprobar_liberacion,
            $permiso_generarcarta_liberacion,
            $permiso_crear_prefactura
        ];

        $permissions_planta = [
            //modulos
            $permiso_modulo_plantas,
            //$permiso_modulo_sistemas,
            $permiso_modulo_cargas,
            //$permiso_modulo_almacenes,
            //$permiso_modulo_etiquetas,
            //$permiso_modulo_tracking,
            //$permiso_modulo_contratos,
            //$permiso_modulo_costos,
            //$permiso_modulo_planificacion,
            //$permiso_modulo_poa,
            //$permiso_modulo_liberacion,
            //$permiso_modulo_prefactura,
            //$permiso_modulo_estadistica,
            //submodulos
            $permiso_submodulo_solicitudcarga,
            $permiso_submodulo_conocimiento,
            //$permiso_submodulo_solicitudalmacen,
            //$permiso_submodulo_ingresoalmacen,
            //$permiso_submodulo_kardex,
            //$permiso_submodulo_salidaalmacen,
            //Solicitud Carga
            //$permiso_crear_solicitudcarga,
            $permiso_modificar_solicitudcarga,
            //$permiso_eliminar_solicitudcarga,
            //Conocimiento carga
            $permiso_crear_conocimiento,
            $permiso_modificar_conocimiento,
            $permiso_pdf_conocimiento,
            //Comprobante Ingreso
            //$permiso_crear_comprobanteingreso,
            //$permiso_pdf_comprobanteingreso,
            //Kardex
            //$permiso_ingresar_kardex,
            //Solicitud Almacen
            //$permiso_crear_solicitudalmacen,
            //$permiso_modificar_solicitudalmacen,
            //$permiso_eliminar_solicitudalmacen,
            //Comprobante Salida
            //$permiso_crear_comprobantesalida,
            //$permiso_ver_fechas_elaboracion,
            //$permiso_pdf_comprobantesalida,
            //costos
            $permiso_agregar_costo,
            //liberacion
            //$permiso_revisar_liberacion,
            //$permiso_aprobar_liberacion,
            //$permiso_generarcarta_liberacion,
        ];

        $permissions_almacen = [
            //modulos
            //$permiso_modulo_plantas,
            //$permiso_modulo_sistemas,
            $permiso_modulo_cargas,
            $permiso_modulo_almacenes,
            //$permiso_modulo_etiquetas,
            //$permiso_modulo_tracking,
            //$permiso_modulo_contratos,
            //$permiso_modulo_costos,
            //$permiso_modulo_planificacion,
            //$permiso_modulo_poa,
            //$permiso_modulo_liberacion,
            //$permiso_modulo_prefactura,
            //$permiso_modulo_estadistica,
            //submodulos
            $permiso_submodulo_solicitudcarga,
            $permiso_submodulo_conocimiento,
            //$permiso_submodulo_solicitudalmacen,
            $permiso_submodulo_ingresoalmacen,
            $permiso_submodulo_kardex,
            $permiso_submodulo_salidaalmacen,
            //Solicitud Carga
            //$permiso_crear_solicitudcarga,
            //$permiso_modificar_solicitudcarga,
            //$permiso_eliminar_solicitudcarga,
            //Conocimiento carga
            //$permiso_crear_conocimiento,
            //$permiso_modificar_conocimiento,
            //$permiso_pdf_conocimiento,
            //Comprobante Ingreso
            $permiso_crear_comprobanteingreso,
            $permiso_pdf_comprobanteingreso,
            //Kardex
            $permiso_ingresar_kardex,
            //Solicitud Almacen
            //$permiso_crear_solicitudalmacen,
            //$permiso_modificar_solicitudalmacen,
            //$permiso_eliminar_solicitudalmacen,
            //Comprobante Salida
            $permiso_crear_comprobantesalida,
            $permiso_ver_fechas_elaboracion,
            $permiso_pdf_comprobantesalida,
            //costos
            //$permiso_agregar_costo,
            //liberacion
            //$permiso_revisar_liberacion,
            //$permiso_aprobar_liberacion,
            //$permiso_generarcarta_liberacion,
        ];

        $permissions_financiera = [
            //modulos
            //$permiso_modulo_plantas,
            //$permiso_modulo_sistemas,
            //$permiso_modulo_cargas,
            //$permiso_modulo_almacenes,
            //$permiso_modulo_etiquetas,
            //$permiso_modulo_tracking,
            //$permiso_modulo_contratos,
            //$permiso_modulo_costos,
            //$permiso_modulo_planificacion,
            //$permiso_modulo_poa,
            $permiso_modulo_liberacion,
            //$permiso_modulo_prefactura,
            //$permiso_modulo_estadistica,
            //submodulos
            //$permiso_submodulo_solicitudcarga,
            //$permiso_submodulo_conocimiento,
            //$permiso_submodulo_solicitudalmacen,
            //$permiso_submodulo_ingresoalmacen,
            //$permiso_submodulo_kardex,
            //$permiso_submodulo_salidaalmacen,
            //Solicitud Carga
            //$permiso_crear_solicitudcarga,
            //$permiso_modificar_solicitudcarga,
            //$permiso_eliminar_solicitudcarga,
            //Conocimiento carga
            //$permiso_crear_conocimiento,
            //$permiso_modificar_conocimiento,
            //$permiso_pdf_conocimiento,
            //Comprobante Ingreso
            //$permiso_crear_comprobanteingreso,
            //$permiso_pdf_comprobanteingreso,
            //Kardex
            //$permiso_ingresar_kardex,
            //Solicitud Almacen
            //$permiso_crear_solicitudalmacen,
            //$permiso_modificar_solicitudalmacen,
            //$permiso_eliminar_solicitudalmacen,
            //Comprobante Salida
            //$permiso_crear_comprobantesalida,
            //$permiso_ver_fechas_elaboracion,
            //$permiso_pdf_comprobantesalida,
            //costos
            //$permiso_agregar_costo,
            //liberacion
            $permiso_revisar_liberacion,
            //$permiso_aprobar_liberacion,
            //$permiso_generarcarta_liberacion,
        ];

        $role_admin->syncPermissions($permissions_admin);
        $role_oficina->syncPermissions($permissions_oficina);
        $role_planta->syncPermissions($permissions_planta);
        $role_almacen->syncPermissions($permissions_almacen);
        $role_financiera->syncPermissions($permissions_financiera);
    }
}

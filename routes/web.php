<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
//CONTROLADORES PRUEBA
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
//CONTROLADORES EBA
use App\Http\Controllers\PlantaController;
use App\Http\Controllers\ConocimientoController;
use App\Http\Controllers\SolicitudcargaController;
use App\Http\Controllers\CargaController;
use App\Http\Controllers\ComprobanteIngresoController;
use App\Http\Controllers\ComprobanteSalidaController;
use App\Http\Controllers\KardexController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\SolicitudAlmacenController;
use App\Http\Controllers\SigaSalidaDetalleController;
use App\Http\Controllers\EtiquetaController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\ContratoController;
use App\Http\Controllers\CostoController;
use App\Http\Controllers\AcopioController;
use App\Http\Controllers\PoaController;
use App\Http\Controllers\LiberacionController;
use App\Http\Controllers\EstadisticaController;
use App\Http\Controllers\PreFacturaController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\RolController;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\App;

Route::get('/pdf', function(){
    $pdf = PDF::loadView('pdf.pdf');
    return $pdf->stream();
});
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {




    Route::get('/about', fn () => Inertia::render('About'))->name('about');

    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::put('users/{user}/update', [UserController::class, 'update'])->name('users.update');
    Route::get('users/{id}', [UserController::class, 'active'])->name('users.active');

    Route::put('user/password', [PasswordController::class, 'update'])->name('password.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('departments', DepartmentController::class);
    Route::resource('employees', EmployeeController::class);
    Route::get('graphic',[EmployeeController::class, 'EmployeeByDepartment'])->name('graphic');
    Route::get('reports',[EmployeeController::class, 'reports'])->name('reports');
    //roles
    Route::get('roles/index', [RolController::class, 'index'])->name('roles.index');//uso
    Route::post('roles/store', [RolController::class, 'store'])->name('roles.store');//uso
    Route::get('roles/show/{id}', [RolController::class, 'show'])->name('roles.show');//uso
    Route::post('roles/asignacion', [RolController::class, 'asignacion'])->name('roles.asignacion');//uso
    Route::post('roles/{id}/permissions', [RolController::class, 'updatePermissions'])->name('roles.updatePermissions');//uso
    //controladores planta
    Route::resource('plantas', PlantaController::class);
    Route::get('plantas/estado/{id}', [PlantaController::class, 'active'])->name('plantas.active');
    //PRODUCTO TERMINADO PLANTAS
    Route::get('inventario/index', [InventarioController::class, 'index'])->name('inventario.index');//uso
    Route::get('inventario/{producto}/{planta}', [InventarioController::class, 'show'])->name('inventario.show');//uso
    Route::get('sigaSalidaDetalle/verCargaPlanta/{id}', [SigaSalidaDetalleController::class, 'verCargaPlanta'])->name('sigaSalidaDetalle.verCargaPlanta');//uso
    Route::get('sigaSalidaDetalle/verSalidaPlanta/{id}', [SigaSalidaDetalleController::class, 'verSalidaPlanta'])->name('sigaSalidaDetalle.verSalidaPlanta');//uso
    //SOLICITUD CARGAS
    Route::get('solicitudcargas/index', [SolicitudcargaController::class, 'index'])->name('solicitudcargas.index');//uso
    Route::get('solicitudcargas/show/{id}', [SolicitudcargaController:: class, 'show'])->name('solicitudcargas.show');//uso
    Route::get('solicitudcargas/crearSolicitud/{planta_id}', [SolicitudcargaController::class, 'crearSolicitud'])->name('solicitudcargas.crearSolicitud');//uso
    Route::delete('solicitudcargas/delete/{id}', [SolicitudcargaController::class, 'delete'])->name('solicitudcargas.delete');//uso
    Route::post('solicitudcargas/store', [SolicitudcargaController::class, 'store'])->name('solicitudcargas.store');//uso
    Route::get('solicitudcargas/edit/{id}/{planta_id}', [SolicitudcargaController::class, 'edit'])->name('solicitudcargas.edit');//uso
    Route::put('solicitudcargas/update', [SolicitudcargaController::class, 'update'])->name('solicitudcargas.update');//uso
    //CONOCIMIENTO
    Route::get('conocimientos/index', [ConocimientoController::class, 'index'])->name('conocimientos.index');//uso
    Route::post('conocimientos/store', [ConocimientoController::class, 'store'])->name('conocimientos.store');//uso
    Route::get('conocimientos/show/{id}', [ConocimientoController::class, 'show'])->name('conocimientos.show');//uso
    Route::get('conocimientos/edit/{id}', [ConocimientoController::class, 'edit'])->name('conocimientos.edit');//uso
    Route::put('conocimientos/update', [ConocimientoController::class,'update'])->name('conocimientos.update');//uso
    Route::get('conocimientos/create/{id}', [ConocimientoController::class, 'create'])->name('conocimientos.crear');//uso
    Route::post('conocimientos/upload', [ConocimientoController::class, 'upload'])->name('conocimientos.upload');
    Route::get('conocimientos/pdf/{id}', [ConocimientoController::class, 'pdf'])->name('conocimientos.pdf');//uso
    //COMPROBANTE INGRESO
    Route::get('comprobante_ingreso/index', [ComprobanteIngresoController:: class, 'index'])->name('comprobante_ingreso.index');//uso
    Route::post('comprobante_ingreso/store', [ComprobanteIngresoController:: class, 'store'])->name('comprobante_ingreso.store');//uso
    Route::get('comprobante_ingreso/edit/{id}', [ComprobanteIngresoController::class, 'edit'])->name('comprobante_ingreso.edit');//uso
    Route::get('comprobante_ingreso/ingreso/{id}', [ComprobanteIngresoController::class, 'createAlmacen'])->name('comprobante_ingreso.createAlmacen');//uso
    Route::post('comprobante_ingreso/upload', [ComprobanteIngresoController::class, 'upload'])->name('comprobante_ingreso.upload');//uso
    Route::get('comprobante_ingreso/pdf/{id}', [ComprobanteIngresoController::class, 'pdf'])->name('comprobante_ingreso.pdf');//uso
    //KARDEX
    Route::get('kardexs/index', [KardexController::class, 'index'])->name('kardexs.index');//uso
    Route::get('kardexs/show/{id}', [KardexController:: class, 'show'])->name('kardexs.show');//uso
    Route::post('kardexs/store', [KardexController::class, 'store'])->name('kardexs.store');//uso
    //SOLICITUD ALMACEN
    Route::get('solicitudAlmacen/index', [SolicitudAlmacenController::class, 'index'])->name('solicitudAlmacen.index');//uso
    Route::get('solicitudAlmacen/create/{planta_id}', [SolicitudAlmacenController::class, 'create'])->name('solicitudAlmacen.create');//uso
    Route::post('solicitudAlmacen/store', [SolicitudAlmacenController::class, 'store'])->name('solicitudAlmacen.store');//uso
    Route::get('solicitudAlmacen/show/{id}', [SolicitudAlmacenController::class, 'show'])->name('solicitudAlmacen.show');//uso
    Route::get('solicitudAlmacen/edit/{id}', [SolicitudAlmacenController::class, 'edit'])->name('solicitudAlmacen.edit');//uso
    Route::get('solicitudcargas/updateAlmacen/{solicitudcarga}', [SolicitudcargaController::class, 'updateAlmacen'])->name('solicitudcargas.updateAlmacen');//uso
    Route::get('sigaSalidaDetalle/selectFechaAlmacen/{id}', [SigaSalidaDetalleController::class, 'selectFechaAlmacen'])->name('sigaSalidaDetalle.selectFechaAlmacen');//uso
    Route::get('sigaSalidaDetalle/viewSelectIds/{cargaId}', [SigaSalidaDetalleController::class, 'viewSelectIds'])->name('sigaSalidaDetalle.viewSelectIds');//uso
    Route::get('sigaSalidaDetalle/selectIds/{cargaId}', [SigaSalidaDetalleController::class, 'selectIds'])->name('sigaSalidaDetalle.selectIds');//uso
    Route::get('solicitudAlmacen/pdfFechasElaboracion/{planta_id}', [SolicitudAlmacenController::class, 'pdfFechasElaboracion'])->name('solicitudAlmacen.pdfFechasElaboracion');//uso
    //COMPROBANTE SALIDA
    Route::get('comprobante_salida/createSalida/{id}', [ComprobanteSalidaController::class, 'createSalida'])->name('comprobante_salida.createSalida');//uso
    Route::get('comprobante_salida/index', [ComprobanteSalidaController::class, 'index'])->name('comprobante_salida.index');//uso
    Route::get('comprobante_salida/show/{id}', [ComprobanteSalidaController::class, 'show'])->name('comprobante_salida.show');//uso
    Route::post('comprobante_salida/store', [ComprobanteSalidaController::class, 'store'])->name('comprobante_salida.store');//uso
    Route::get('comprobante_salida/pdf/{id}', [ComprobanteSalidaController::class, 'pdf'])->name('comprobante_salida.pdf');//uso
    Route::post('comprobante_salida/upload', [ComprobanteSalidaController::class, 'upload'])->name('comprobante_salida.upload');//uso
    //ETIQUETA
    Route::get('etiquetas/index', [EtiquetaController::class, 'index'])->name('etiquetas.index');//uso
    Route::get('etiquetas/cargasEtiqueta/{array}', [EtiquetaController::class, 'cargasEtiqueta'])->name('etiquetas.cargasEtiqueta');//uso
    Route::get('etiquetas/verEtiquetas', [EtiquetaController::class, 'verEtiquetas'])->name('etiquetas.verEtiquetas');//uso
    Route::post('etiquetas/etiquetasPdf/', [EtiquetaController::class, 'etiquetasPdf'])->name('etiquetas.etiquetasPdf');//uso
    Route::post('etiquetas/etiquetasChina', [EtiquetaController::class, 'etiquetasChina'])->name('etiquetas.etiquetasChina');//uso
    Route::post('etiquetas/guardarEtiqueta', [EtiquetaController::class, 'guardarEtiqueta'])->name('etiquetas.guardarEtiquetas');//uso
    Route::delete('etiquetas/eliminarEtiqueta/{id}', [EtiquetaController::class, 'eliminarEtiqueta'])->name('etiquetas.eliminarEtiqueta');//uso
    //tracking
    Route::get('tracking/index', [TrackingController:: class, 'index'])->name('tracking.index');//uso
    Route::get('tracking/show/{id}', [TrackingController:: class, 'show'])->name('tracking.show');//uso
    Route::post('tracking/liberacion', [TrackingController:: class, 'liberacion'])->name('tracking.liberacion');//uso
    //CONTRATOS
    Route::get('contratos/index', [ContratoController::class, 'index'])->name('contratos.index');//uso
    Route::get('contratos/create',[ContratoController::class, 'create'])->name('contratos.create');//uso
    Route::post('contratos/store', [ContratoController::class, 'store'])->name('contratos.store');//uso
    Route::get('contratos/show/{id}', [ContratoController::class, 'show'])->name('contratos.show');//uso
    Route::post('contratos/upload', [ContratoController::class, 'upload'])->name('contratos.upload');//uso
    Route::get('contratos/edit/{id}', [ContratoController:: class, 'edit'])->name('contratos.edit');//uso
    Route::put('contratos/update', [ContratoController:: class, 'update'])->name('contratos.update');//uso
    Route::get('contratos/pdf/{id}', [ContratoController:: class, 'pdf'])->name('contratos.pdf');//uso
    //COSTOS
    Route::get('costos/index', [CostoController::class, 'index'])->name('costos.index');//uso
    Route::post('costos/update_costo', [CostoController::class, 'update_costo'])->name('costos.update_costo');//uso
    //ACOPIO
    Route::get('acopio/index', [AcopioController::class, 'index'])->name('acopio.index');//uso
    //POA
    Route::get('poa/index', [PoaController::class, 'index'])->name('poa.index');//uso
    Route::post('poa/store', [PoaController::class, 'store'])->name('poa.store');//uso
    Route::get('poa/edit', [PoaController::class, 'edit'])->name('poa.edit');//uso
    //LIBERACION
    Route::get('liberacion/index', [LiberacionController::class, 'index'])->name('liberacion.index');//uso
    Route::get('liberacion/show/{id}', [LiberacionController::class, 'show'])->name('liberacion.show');//uso
    Route::get('liberacion/aprobacion/{estado}/{id}', [LiberacionController::class, 'aprobacion'])->name('liberacion.aprobacion');//uso
    Route::get('liberacion/pdf/{id}', [LiberacionController::class, 'pdf'])->name('liberacion.pdf');//uso
    Route::post('liberacion/upload', [LiberacionController::class, 'upload'])->name('liberacion.upload');//uso
    //ESTADISTICA
    Route::get('estadistica/index', [EstadisticaController::class, 'index'])->name('estadistica.index');//uso
    Route::post('estadistica/update_excel', [EstadisticaController::class, 'update_excel'])->name('estadistica.update_excel');//uso
    Route::get('estadistica/sumatoria', [EstadisticaController::class, 'sumatoria'])->name('estadistcia.sumatoria');//uso
    //PRE FACTURA
    Route::get('pre_factura/index', [PreFacturaController::class, 'index'])->name('pre_factura.index');//uso
    Route::get('pre_factura/create/{id}', [PreFacturaController::class, 'create'])->name('pre_factura.create');//uso
    Route::get('pre_factura/show/{id}', [PreFacturaController::class, 'show'])->name('pre_factura.show');//uso
    Route::post('pre_factura/store', [PreFacturaController::class, 'store'])->name('pre_factura.store');//uso
});

require __DIR__.'/auth.php';

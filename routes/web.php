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
use App\Http\Controllers\PreFacturaController;
use App\Http\Controllers\Auth\PasswordController;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\App;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('conocimientos/pdf/{id}', [ConocimientoController::class, 'pdf'])->name('conocimientos.pdf');
    Route::get('comprobante_ingreso/pdf/{id}', [ComprobanteIngresoController::class, 'pdf'])->name('comprobante_ingreso.pdf');

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
    //controladores planta
    Route::resource('plantas', PlantaController::class);
    Route::get('plantas/estado/{id}', [PlantaController::class, 'active'])->name('plantas.active');
    //CONOCIMIENTO
    Route::resource('conocimientos', ConocimientoController::class);
    Route::get('conocimientos/create/{id}', [ConocimientoController::class, 'CrearConocimiento'])->name('conocimientos.crear');
    //COMPROBANTE INGRESO
    Route::resource('comprobante_ingreso', ComprobanteIngresoController::class);
    Route::get('comprobante_ingreso/ingreso/{id}', [ComprobanteIngresoController::class, 'IngresarAlmacen'])->name('comprobante_ingreso.ingreso');
    //COMPROBANTE SALIDA
    Route::resource('comprobante_salida', ComprobanteSalidaController::class);
    //KARDEX
    Route::resource('kardexs', KardexController::class);
    //PRE FACTURA
    Route::resource('pre_factura', PreFacturaController::class);
    //CARGAS
    Route::resource('solicitudcargas', SolicitudcargaController::class);

    Route::get('/new-component', [SolicitudcargaController::class, 'showNewComponent'])->name('new-component');

    Route::resource('cargas', CargaController::class);
    //rutas para PDF

});

require __DIR__.'/auth.php';

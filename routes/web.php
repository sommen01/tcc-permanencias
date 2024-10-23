<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\PermanenciaController;
use App\Http\Controllers\AlunoPerfilController;

Route::get('/permanencias/{permanencia}/edit', [PermanenciaController::class, 'edit'])->name('permanencias.edit');
Route::put('/permanencias/{permanencia}', [PermanenciaController::class, 'update'])->name('permanencias.update');

Route::post('/excluir-permanencia', [PermanenciaController::class, 'excluir'])->name('excluir_permanencia');

Route::resource('permanencias', PermanenciaController::class);
Route::post('enviar-confirmacao', [PermanenciaController::class, 'enviarConfirmacao'])->name('enviar.confirmacao');

Route::get('tables', [PermanenciaController::class, 'index'])->middleware('auth')->name('tables');

Route::get('/home', function () {
    return redirect()->route('tables'); 
})->middleware('auth');


// Login com Google
Route::get('auth/google', [SessionsController::class, 'redirectToGoogle'])->name('login.google');
Route::get('auth/google/callback', [SessionsController::class, 'handleGoogleCallback']);


Route::get('/complete-profile', [AlunoPerfilController::class, 'show'])->middleware('auth');
Route::post('/complete-profile', [AlunoPerfilController::class, 'store'])->middleware('auth');
Route::get('/permanencias/confirmar/{id}/{token}', [PermanenciaController::class, 'confirmarPermanencia'])->name('permanencias.confirmar');
Route::post('/enviar-confirmacao', [PermanenciaController::class, 'enviarConfirmacao'])->name('enviar.confirmacao');
Route::get('/permanencias/search', [PermanenciaController::class, 'search'])->name('permanencias.search');
Route::get('permanencias/create', [PermanenciaController::class, 'create'])->name('permanencias.create');
Route::post('permanencias', [PermanenciaController::class, 'store'])->name('permanencias.store');

Route::get('/', function () {return redirect('sign-in');})->middleware('guest');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('sign-up', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('sign-up', [RegisterController::class, 'store'])->middleware('guest');

// Rota para exibir o formulário de login
Route::get('/sign-in', [SessionsController::class, 'create'])->name('login');

// Rota para processar o login
Route::post('/sign-in', [SessionsController::class, 'store']);




Route::post('verify', [SessionsController::class, 'show'])->middleware('guest');
Route::post('reset-password', [SessionsController::class, 'update'])->middleware('guest')->name('password.update');
Route::get('verify', function () {
	return view('sessions.password.verify');
})->middleware('guest')->name('verify'); 
Route::get('/reset-password/{token}', function ($token) {
	return view('sessions.password.reset', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('sign-out', [SessionsController::class, 'destroy'])->middleware('auth')->name('logout');


Route::get('profile', [ProfileController::class, 'create'])->middleware('auth')->name('profile');
Route::post('user-profile', [ProfileController::class, 'update'])->middleware('auth');
Route::group(['middleware' => 'auth'], function () {
	Route::get('billing', function () {
		return view('pages.billing');
	})->name('billing');
	// Route::get('tables', function () {
	// 	return view('pages.tables');
	// })->name('tables');
	Route::get('rtl', function () {
		return view('pages.rtl');
	})->name('rtl');
	Route::get('virtual-reality', function () {
		return view('pages.virtual-reality');
	})->name('virtual-reality');
	Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');
	Route::get('static-sign-in', function () {
		return view('pages.static-sign-in');
	})->name('static-sign-in');
	Route::get('static-sign-up', function () {
		return view('pages.static-sign-up');
	})->name('static-sign-up');
	Route::get('user-management', function () {
		return view('pages.laravel-examples.user-management');
	})->name('user-management');
	Route::get('user-profile', function () {
		return view('pages.laravel-examples.user-profile');
	})->name('user-profile');
});



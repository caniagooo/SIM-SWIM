<?php

use App\Http\Controllers\Apps\PermissionManagementController;
use App\Http\Controllers\Apps\RoleManagementController;
use App\Http\Controllers\Apps\UserManagementController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseMaterialController;
use Illuminate\Support\Facades\Route;
use App\Models\CourseMaterial;
use Illuminate\Http\Request;

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

Route::middleware(['auth'])->group(function () {

    Route::get('/', [DashboardController::class, 'index']);

    Route::name('user-management.')->group(function () {
        Route::resource('/user-management/users', UserManagementController::class);
        Route::resource('/user-management/roles', RoleManagementController::class);
        Route::resource('/user-management/permissions', PermissionManagementController::class);
    });

    Route::group(['middleware' => ['role:Super Admin|Admin']], function () {
        Route::resource('venues', VenueController::class);
    });
});

Route::middleware(['role:Super Admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index']);
});

Route::middleware(['role:Pelatih'])->group(function () {
    Route::get('/trainer/dashboard', [TrainerController::class, 'index']);
});

Route::resource('courses', CourseController::class)->middleware('role:Super Admin|Admin');
Route::resource('trainers', TrainerController::class)->middleware('role:Super Admin|Admin');
Route::resource('students', StudentController::class)->middleware('role:Super Admin|Admin');
Route::resource('payments', PaymentController::class)->middleware('role:Super Admin|Admin');
Route::resource('course-materials', CourseMaterialController::class)->middleware('role:Super Admin|Admin');

// Tambahkan rute untuk payments murid
Route::get('students/{student}/payments', [StudentController::class, 'payments'])->name('students.payments');

Route::get('/error', function () {
    abort(500);
});

Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// Profil User
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');

// Logout
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('/api/materials', function (Request $request) {
    $level = $request->query('level'); // Menggunakan instance Request
    \Log::info('Level:', ['level' => $level]);

    $materials = CourseMaterial::where('level', $level)->get();
    \Log::info('Materials:', $materials->toArray());

    return $materials;
});

require __DIR__ . '/auth.php';

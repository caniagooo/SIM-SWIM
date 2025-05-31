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
use App\Http\Controllers\CourseSessionController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\GeneralScheduleController;
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

// Route untuk menyimpan dan menghapus sesi kursus
//Route::post('/courses/{course}/sessions', [CourseSessionController::class, 'store'])->name('courses.sessions.store');
//Route::delete('/courses/{course}/sessions/{session}', [CourseSessionController::class, 'destroy'])->name('courses.sessions.destroy');

// Route untuk menyimpan kehadiran sesi
Route::post('/sessions/{session}/attendance', [AttendanceController::class, 'store'])->name('sessions.attendance.store');
Route::get('/sessions/{session}/attendance', [AttendanceController::class, 'index'])->name('sessions.attendance.index');

require __DIR__ . '/auth.php';

Route::middleware(['web'])->group(function () {
    Route::resource('courses', CourseController::class);
    Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');
});

Route::prefix('courses/{course}/sessions')->group(function () {
    Route::get('/', [CourseSessionController::class, 'index'])->name('sessions.index'); // Menampilkan daftar sesi
    Route::get('/create', [CourseSessionController::class, 'create'])->name('sessions.create'); // Form tambah sesi
    Route::post('/', [CourseSessionController::class, 'store'])->name('sessions.store'); // Simpan sesi baru
    Route::get('/{session}/edit', [CourseSessionController::class, 'edit'])->name('sessions.edit'); // Form edit sesi
    Route::put('/{session}', [CourseSessionController::class, 'update'])->name('sessions.update'); // Update sesi
    Route::delete('/{session}', [CourseSessionController::class, 'destroy'])->name('sessions.destroy'); // Hapus sesi
});

Route::prefix('sessions/{session}/attendances')->group(function () {
    Route::get('/', [AttendanceController::class, 'index'])->name('attendances.index');
    Route::post('/', [AttendanceController::class, 'store'])->name('attendances.store');
    Route::put('/{attendance}', [AttendanceController::class, 'update'])->name('attendances.update');
    Route::delete('/{attendance}', [AttendanceController::class, 'destroy'])->name('attendances.destroy');
});

Route::get('/general-schedule', [GeneralScheduleController::class, 'index'])->name('general-schedule.index');
Route::get('/general-schedule/export', [GeneralScheduleController::class, 'export'])->name('general-schedule.export');
Route::get('/general-schedule/export-pdf', [GeneralScheduleController::class, 'exportPdf'])->name('general-schedule.export-pdf');

Route::prefix('attendance')->group(function () {
    Route::get('/{sessionId}', [AttendanceController::class, 'show'])->name('attendance.show');
    Route::post('/{sessionId}/materials', [AttendanceController::class, 'saveMaterials'])->name('attendance.materials');
    Route::post('/{sessionId}', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::post('/{sessionId}/scores', [AttendanceController::class, 'saveScores'])->name('attendance.scores');
});

Route::get('/courses/{courseId}', [CourseController::class, 'show'])->name('courses.show');


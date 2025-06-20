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
use App\Http\Controllers\GeneralScheduleController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\GradeController;
use Illuminate\Support\Facades\Route;
use App\Models\CourseMaterial;
use Illuminate\Http\Request;
use App\Http\Controllers\CoursePaymentController;

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

    Route::post('/course-payments/create/{course}', [CoursePaymentController::class, 'createInvoice'])->name('course-payments.create');
    Route::post('/course-payments/process/{course}', [CoursePaymentController::class, 'processPayment'])->name('course-payments.process');
    Route::get('/course-payments/status/{payment}', [CoursePaymentController::class, 'paymentStatus'])->name('course-payments.status');
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


// Route untuk mengelola materi kursus
Route::middleware(['role:Super Admin|Admin'])->group(function () {
    Route::resource('course-materials', CourseMaterialController::class);
    Route::post('course-materials/{material}/courses', [CourseMaterialController::class, 'attachCourse'])->name('course-materials.attach-course');
    Route::delete('course-materials/{material}/courses/{course}', [CourseMaterialController::class, 'detachCourse'])->name('course-materials.detach-course');
    Route::get('/materials', [CourseMaterialController::class, 'index'])->name('materials.index');
    route::get('/{material}/edit', [CourseMaterialController::class, 'edit'])->name('materials.edit');
});

// route untuk membuat dan mengedit materi kursus
Route::middleware(['role:Super Admin|Admin'])->group(function () {
    Route::post('/course-materials', [CourseMaterialController::class, 'store'])->name('course-materials.store');
    Route::get('/course-materials/create', [CourseMaterialController::class, 'create'])->name('course-materials.create');
    
   
});



Route::prefix('courses/{course}/sessions')->group(function () {
    Route::get('/', [CourseSessionController::class, 'index'])->name('sessions.index'); // Menampilkan daftar sesi
    Route::get('/create', [CourseSessionController::class, 'create'])->name('sessions.create'); // Form tambah sesi
    Route::post('/', [CourseSessionController::class, 'store'])->name('sessions.store'); // Simpan sesi baru
    Route::get('/{session}/edit', [CourseSessionController::class, 'edit'])->name('sessions.edit'); // Form edit sesi
    Route::put('/{session}', [CourseSessionController::class, 'update'])->name('sessions.update'); // Update sesi
    Route::delete('/{session}', [CourseSessionController::class, 'destroy'])->name('sessions.destroy'); // Hapus sesi
    Route::post('/{session}/attendance', [AttendanceController::class, 'saveAttendance'])->name('sessions.attendance.save');
});


    Route::get('/general-schedule', [GeneralScheduleController::class, 'index'])->name('general-schedule.index');
    Route::get('/general-schedule/export', [GeneralScheduleController::class, 'export'])->name('general-schedule.export');
    Route::get('/general-schedule/export-pdf', [GeneralScheduleController::class, 'exportPdf'])->name('general-schedule.export-pdf');


    
    Route::post('/courses/{course}/students/{student}/grades', [GradeController::class, 'store'])->name('grades.store');
Route::get('/payments/{payment}', [CoursePaymentController::class, 'show'])->name('payments.show');
Route::post('/courses/{course}/assign', [CourseController::class, 'assign'])->name('courses.assign')->middleware('role:Super Admin|Admin');

Route::get('/course-payments/invoice/{course}', [CoursePaymentController::class, 'invoice'])->name('course-payments.invoice');
Route::post('/course-payments/process/{course}', [CoursePaymentController::class, 'process'])->name('course-payments.process');


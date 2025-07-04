<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Apps\UserManagementController;
use App\Http\Controllers\Apps\RoleManagementController;
use App\Http\Controllers\Apps\PermissionManagementController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseMaterialController;
use App\Http\Controllers\CourseSessionController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\GeneralScheduleController;
use App\Http\Controllers\CoursePaymentController;

// Route login (GET dan POST)
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// Password reset request (lupa password)
Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

// Password reset form & submit
Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');

// Semua route di-protect auth & role:Super Admin|Admin
Route::middleware(['auth'])->group(function () {

    // User Management: hanya untuk super admin & admin
    Route::middleware(['role:Super Admin|Admin'])->prefix('user-management')->name('user-management.')->group(function () {
        Route::resource('users', UserManagementController::class);
        Route::resource('roles', RoleManagementController::class);
        Route::resource('permissions', PermissionManagementController::class);
    });

    // Route lain: super admin, admin, pelatih
    Route::middleware(['role:Super Admin|Admin|Pelatih'])->group(function () {
        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [DashboardController::class, 'index']);

        // Profile (lihat catatan di bawah untuk murid)
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

        // Logout
        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

        // Venue
        Route::resource('venues', VenueController::class);

        // Trainer, Student, Payment
        Route::resource('trainers', TrainerController::class);
        Route::resource('students', StudentController::class);
        

        // Student Payments
        Route::get('students/{student}/payments', [StudentController::class, 'payments'])->name('students.payments');

        // Course Materials
        Route::resource('course-materials', CourseMaterialController::class);
        Route::post('course-materials/{material}/courses', [CourseMaterialController::class, 'attachCourse'])->name('course-materials.attach-course');
        Route::delete('course-materials/{material}/courses/{course}', [CourseMaterialController::class, 'detachCourse'])->name('course-materials.detach-course');
        Route::get('/materials', [CourseMaterialController::class, 'index'])->name('materials.index');
        Route::get('/materials/{material}/edit', [CourseMaterialController::class, 'edit'])->name('materials.edit');
        Route::post('/course-materials', [CourseMaterialController::class, 'store'])->name('course-materials.store');
        Route::get('/course-materials/create', [CourseMaterialController::class, 'create'])->name('course-materials.create');

        // Course AJAX (letakkan sebelum resource!)
        Route::get('/courses/ajax', [CourseController::class, 'ajaxIndex'])->name('courses.ajax');
        Route::get('/courses/{course}/sessions/table', [CourseSessionController::class, 'ajaxTable'])->name('sessions.ajaxTable');

        // Courses
        Route::resource('courses', CourseController::class);
        Route::post('/courses/{course}/assign', [CourseController::class, 'assign'])->name('courses.assign');

        // Course Payments
        Route::post('/course-payments/create/{course}', [CoursePaymentController::class, 'createInvoice'])->name('course-payments.create');
        Route::get('/course-payments/invoice/{course}', [CoursePaymentController::class, 'invoice'])->name('course-payments.invoice');
        Route::post('/course-payments/process/{course}', [CoursePaymentController::class, 'process'])->name('course-payments.process');
        Route::get('/payments/{payment}', [CoursePaymentController::class, 'show'])->name('payments.show');
        Route::get('/payments/{payment}/edit', [CoursePaymentController::class, 'edit'])->name('payments.edit');
        Route::put('/payments/{payment}', [CoursePaymentController::class, 'update'])->name('payments.update');
        Route::get('/payments', [CoursePaymentController::class, 'index'])->name('payments.index');
        

        // Course Sessions
        Route::prefix('courses/{course}/sessions')->group(function () {
            Route::get('/', [CourseSessionController::class, 'index'])->name('sessions.index');
            Route::get('/create', [CourseSessionController::class, 'create'])->name('sessions.create');
            Route::post('/', [CourseSessionController::class, 'store'])->name('sessions.store');
            Route::get('/{session}/edit', [CourseSessionController::class, 'edit'])->name('sessions.edit');
            Route::put('/{session}', [CourseSessionController::class, 'update'])->name('sessions.update');
            Route::delete('/{session}', [CourseSessionController::class, 'destroy'])->name('sessions.destroy');
            Route::post('/{session}/attendance', [AttendanceController::class, 'saveAttendance'])->name('sessions.attendance.save');
        });


        // Grade
        Route::post('/courses/{course}/students/{student}/grades', [GradeController::class, 'store'])->name('grades.store');

        // API Materials (for AJAX select2, etc)
        Route::get('/api/materials', function (Request $request) {
            $level = $request->query('level');
            \Log::info('Level:', ['level' => $level]);
            $materials = \App\Models\CourseMaterial::where('level', $level)->get();
            \Log::info('Materials:', $materials->toArray());
            return $materials;
        });

        // Error test
        Route::get('/error', function () {
            abort(500);
        });
    });
});

// Socialite Auth
Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);
<?php if (isset($component)) { $__componentOriginal1c2e2f4f77e507b499e79defc0d48b7e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1c2e2f4f77e507b499e79defc0d48b7e = $attributes; } ?>
<?php $component = App\View\Components\DefaultLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('default-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\DefaultLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="container mt-5">
        <div class="card shadow-lg">
            <!-- Header -->
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="card-title">General Schedule</h3>
                <div class="card-toolbar">
                    <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-light btn-sm">Back to Dashboard</a>
                    <a href="<?php echo e(route('general-schedule.export-pdf')); ?>" class="btn btn-danger btn-sm">Export to PDF</a>
                </div>
            </div>

            <!-- Body -->
            <div class="card-body">
                <div class="row">
                    <!-- Kalender -->
                    <div class="col-md-6">
                        <div class="border rounded p-3 shadow-sm">
                            <h5 class="text-muted mb-3">Calendar</h5>
                            <div id="calendar" style="height: 400px;"></div>
                        </div>
                    </div>
                    <!-- Summary -->
                    <div class="col-md-6">
                        <div class="border rounded p-3 shadow-sm">
                            <h5 class="text-muted mb-3">Summary</h5>
                            <div id="summary">
                                <p class="text-muted">Select a date on the calendar to see the summary.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Jadwal -->
                <div class="mt-5">
                    <h5 class="text-muted">Schedule List</h5>
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Course Name</th>
                                <th>Date</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($session->course->name); ?></td>
                                    <td><?php echo e(\Carbon\Carbon::parse($session->session_date)->translatedFormat('l, d F Y')); ?></td>
                                    <td><?php echo e(\Carbon\Carbon::parse($session->start_time)->format('H : i')); ?></td>
                                    <td><?php echo e(\Carbon\Carbon::parse($session->end_time)->format('H : i')); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo e($session->status == 'completed' ? 'success text-white' : ($session->status == 'canceled' ? 'danger text-white' : 'info text-white')); ?>">
                                            <?php echo e(ucfirst($session->status)); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('attendances.index', $session->id)); ?>" class="btn btn-info btn-sm">Manage Attendance</a>
                                        <a href="<?php echo e(route('sessions.edit', [$session->course->id, $session->id])); ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="<?php echo e(route('sessions.destroy', [$session->course->id, $session->id])); ?>" method="POST" style="display:inline;">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- FullCalendar Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 400, // Membatasi tinggi kalender agar lebih compact
                events: <?php echo json_encode($sessions->map(function ($session) {
                    return [
                        'title' => $session->course->name, 'start' => $session->session_date, 'extendedProps' => [
                            'students' => $session->course->students->count()
                        ]
                    ];
                })) ?>,
                eventClick: function(info) {
                    var studentsCount = info.event.extendedProps.students;
                    var date = info.event.start.toLocaleDateString('en-US', {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });

                    document.getElementById('summary').innerHTML = `
                        <h6>${date}</h6>
                        <p><strong>Course:</strong> ${info.event.title}</p>
                        <p><strong>Estimated Students:</strong> ${studentsCount}</p>
                    `;
                }
            });
            calendar.render();
        });
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1c2e2f4f77e507b499e79defc0d48b7e)): ?>
<?php $attributes = $__attributesOriginal1c2e2f4f77e507b499e79defc0d48b7e; ?>
<?php unset($__attributesOriginal1c2e2f4f77e507b499e79defc0d48b7e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1c2e2f4f77e507b499e79defc0d48b7e)): ?>
<?php $component = $__componentOriginal1c2e2f4f77e507b499e79defc0d48b7e; ?>
<?php unset($__componentOriginal1c2e2f4f77e507b499e79defc0d48b7e); ?>
<?php endif; ?><?php /**PATH C:\Users\JITU\swim\resources\views/general-schedule/index.blade.php ENDPATH**/ ?>
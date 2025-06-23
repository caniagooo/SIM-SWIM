<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>General Schedule</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h1>General Schedule</h1>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Course Name</th>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Status</th>
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
                    <td><?php echo e(ucfirst($session->status)); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</body>
</html><?php /**PATH C:\Users\JITU\swim\resources\views\exports\sessions-pdf.blade.php ENDPATH**/ ?>
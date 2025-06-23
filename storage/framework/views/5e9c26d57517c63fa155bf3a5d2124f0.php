<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body, html {
            height: 100%;
            width: 100%;
            overflow: hidden;
        }
        .video-bg {
            position: fixed;
            top: 0;
            left: 0;
            min-width: 100%;
            min-height: 100%;
            z-index: -1;
            object-fit: cover;
            filter: brightness(0.8);
        }
        .login-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(5px);
            border-radius: 15px;
            padding: 40px 30px;
            width: 400px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            animation: waterGradient 6s ease infinite;
        }
        .login-container img {
            display: block;
            margin: 0 auto 20px auto;
            width: 300px;
        }
        .text-center h1 {
            color: #fff !important;
        }
        .form-control {
            width: 100%;
            padding: 10px 15px;
            margin-bottom: 15px;
            border: none;
            border-radius: 8px;
            outline: none;
        }
        .form-control.is-invalid {
            border: 1px solid red;
        }
        .invalid-feedback {
            color: red;
            font-size: 0.9em;
            margin-bottom: 10px;
        }
        .btn-primary {
            width: 100%;
            padding: 10px 15px;
            background: rgba(0, 123, 255, 0.8);
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .btn-primary:hover {
            background: rgba(0, 123, 255, 1);
        }
        .text-muted {
            color: #ddd;
            text-decoration: none;
        }
        .text-muted:hover {
            text-decoration: underline;
        }

        @keyframes waterGradient {
            0% { background: rgba(255, 255, 255, 0.2); }
            50% { background: rgba(255, 255, 255, 0.25); }
            100% { background: rgba(255, 255, 255, 0.2); }
        }
    </style>
</head>
<body>

    <!-- Video Background -->
    <video autoplay muted loop class="video-bg">
        <source src="<?php echo e(asset('storage/videos/swim.mp4')); ?>" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>

    <!-- Login Form -->
    <div class="login-container">

        <!-- Logo -->
        <img src="<?php echo e(asset('storage/images/2logo.png')); ?>" alt="Logo">

        <!--begin::Form-->
        <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" data-kt-redirect-url="<?php echo e(route('dashboard')); ?>" action="<?php echo e(route('login')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <!--begin::Heading-->
            <div class="text-center mb-10">
                <h1 class="fw-bolder mb-3">Login</h1>
            </div>
            <!--end::Heading-->

            <!--begin::Input group-->
            <div class="mb-8">
                <input type="text" placeholder="Email" name="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('email')); ?>" required autofocus />
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="mb-8">
                <input type="password" placeholder="Password" name="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required />
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <!--end::Input group-->

            <!--begin::Submit button-->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
            <!--end::Submit button-->

            <!--begin::Forgot password-->
            <div class="text-center mt-4">
                <a href="<?php echo e(route('password.request')); ?>" class="text-muted">Forgot Password?</a>
            </div>
            <!--end::Forgot password-->
        </form>
        <!--end::Form-->

    </div>

</body>
</html>
<?php /**PATH C:\Users\JITU\swim\resources\views\pages\auth\login.blade.php ENDPATH**/ ?>
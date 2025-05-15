<x-auth-layout>

    <!--begin::Form-->
    <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" data-kt-redirect-url="{{ route('dashboard') }}" action="{{ route('login') }}" method="POST">
        @csrf
        <!--begin::Heading-->
        <div class="text-center mb-10">
            <h1 class="text-gray-900 fw-bolder mb-3">Login</h1>
        </div>
        <!--end::Heading-->

        <!--begin::Input group-->
        <div class="mb-8">
            <input type="text" placeholder="Email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus />
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-8">
            <input type="password" placeholder="Password" name="password" class="form-control @error('password') is-invalid @enderror" required />
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <!--end::Input group-->

        <!--begin::Submit button-->
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Login</button>
        </div>
        <!--end::Submit button-->

        <!--begin::Forgot password-->
        <div class="text-center mt-4">
            <a href="{{ route('password.request') }}" class="text-muted">Forgot Password?</a>
        </div>
        <!--end::Forgot password-->
    </form>
    <!--end::Form-->

</x-auth-layout>

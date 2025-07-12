<x-guest-layout>
    <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate autocomplete="off">
        @csrf
        <h2 class="mb-4 text-center fw-bold">Login Admin</h2>
        @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger small">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required
                    autofocus autocomplete="username">
                <div class="invalid-feedback">Email wajib diisi.</div>
            </div>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" class="form-control" id="password" name="password" required
                    autocomplete="current-password">
                <div class="invalid-feedback">Password wajib diisi.</div>
            </div>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
            <label class="form-check-label" for="remember_me">Remember me</label>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            @if (Route::has('password.request'))
                <a class="small text-decoration-underline" href="{{ route('password.request') }}">
                    Forgot your password?
                </a>
            @endif
        </div>
        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
            <i class="bi bi-box-arrow-in-right me-1"></i> Log in
        </button>
    </form>
    <script>
        // Bootstrap validation
        (() => {
            'use strict';
            const forms=document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach(form => {
                form.addEventListener('submit',event => {
                    if(!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                },false);
            });
        })();
    </script>
</x-guest-layout>
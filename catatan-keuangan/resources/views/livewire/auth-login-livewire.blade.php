<div class="row justify-content-center mt-5">
    <div class="col-md-5">

        <div class="card shadow-sm">
            <div class="card-body">

                <h3 class="text-center mb-4">Login</h3>

                <!-- ✅ alert sukses dari register -->
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- ✅ alert error global -->
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- EMAIL -->
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email"
                           class="form-control @error('email') is-invalid @enderror"
                           wire:model.defer="email"
                           placeholder="Masukkan email">

                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- PASSWORD -->
                <div class="mb-3">
                    <label>Password</label>
                    <input type="password"
                           class="form-control @error('password') is-invalid @enderror"
                           wire:model.defer="password"
                           placeholder="Masukkan password">

                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- LOGIN BUTTON -->
                <button class="btn btn-primary w-100" wire:click="login">
                    Login
                </button>

                <p class="text-center mt-3">
                    Belum punya akun?
                    <a href="{{ route('auth.register') }}">Daftar</a>
                </p>

            </div>
        </div>

    </div>
</div>

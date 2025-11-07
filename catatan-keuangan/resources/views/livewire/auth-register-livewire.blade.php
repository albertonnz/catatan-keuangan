<div class="row justify-content-center mt-5">
    <div class="col-md-6 col-lg-5">

        <div class="card shadow-sm">
            <div class="card-body">

                <h3 class="text-center mb-4">Daftar Akun</h3>

                <!-- ✅ alert sukses -->
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- NAMA -->
                <div class="mb-3">
                    <label>Nama Lengkap</label>
                    <input type="text"
                           class="form-control @error('name') is-invalid @enderror"
                           wire:model.defer="name"
                           placeholder="Masukkan nama lengkap">

                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

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
                           placeholder="Minimal 6 karakter">

                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- KONFIRMASI PASSWORD -->
                <div class="mb-3">
                    <label>Konfirmasi Password</label>
                    <input type="password"
                           class="form-control @error('password_confirmation') is-invalid @enderror"
                           wire:model.defer="password_confirmation"
                           placeholder="Ulangi password">

                    @error('password_confirmation')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- BUTTON REGISTER -->
                <button class="btn btn-primary w-100" wire:click="register">
                    Daftar
                </button>

                <p class="text-center mt-3">
                    Sudah punya akun?
                    <a href="{{ route('auth.login') }}">Login</a>
                </p>

            </div>
        </div>

    </div>
</div>

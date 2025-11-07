<div class="min-vh-100 d-flex align-items-center" style="background: linear-gradient(135deg, #6B73FF 0%, #000DFF 100%); position: fixed; top: 0; left: 0; right: 0; bottom: 0;">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-body p-5">
                        <div class="text-center mb-5">
                            <h3 class="fw-bold mb-2">💰 Catatan Keuangan</h3>
                            <p class="text-muted">Daftar akun baru</p>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="mb-4">
                            <label class="form-label fw-bold">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-user text-muted"></i>
                                </span>
                                <input type="text"
                                    class="form-control form-control-lg border-start-0 ps-0 @error('name') is-invalid @enderror"
                                    wire:model.defer="name"
                                    placeholder="Masukkan nama lengkap Anda">
                            </div>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-envelope text-muted"></i>
                                </span>
                                <input type="email"
                                    class="form-control form-control-lg border-start-0 ps-0 @error('email') is-invalid @enderror"
                                    wire:model.defer="email"
                                    placeholder="Masukkan email Anda">
                            </div>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-lock text-muted"></i>
                                </span>
                                <input type="password"
                                    class="form-control form-control-lg border-start-0 ps-0 @error('password') is-invalid @enderror"
                                    wire:model.defer="password"
                                    placeholder="Minimal 6 karakter">
                            </div>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Konfirmasi Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-lock text-muted"></i>
                                </span>
                                <input type="password"
                                    class="form-control form-control-lg border-start-0 ps-0 @error('password_confirmation') is-invalid @enderror"
                                    wire:model.defer="password_confirmation"
                                    placeholder="Ulangi password">
                            </div>
                            @error('password_confirmation')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <button class="btn btn-primary btn-lg w-100 mb-4" wire:click="register">
                            <i class="fas fa-user-plus me-2"></i> Daftar Sekarang
                        </button>

                        <p class="text-center mb-0">
                            Sudah punya akun? 
                            <a href="{{ route('auth.login') }}" class="text-primary fw-bold text-decoration-none">
                                Masuk sekarang
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

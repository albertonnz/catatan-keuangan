<div class="min-vh-100 d-flex align-items-center" style="background: linear-gradient(135deg, #6B73FF 0%, #000DFF 100%); position: fixed; top: 0; left: 0; right: 0; bottom: 0;">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-body p-5">
                        <div class="text-center mb-5">
                            <h3 class="fw-bold mb-2">💰 Catatan Keuangan</h3>
                            <p class="text-muted">Masuk ke akun Anda</p>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

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
                                    placeholder="Masukkan password Anda">
                            </div>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <button class="btn btn-primary btn-lg w-100 mb-4" wire:click="login">
                            <i class="fas fa-sign-in-alt me-2"></i> Masuk
                        </button>

                        <p class="text-center mb-0">
                            Belum punya akun? 
                            <a href="{{ route('auth.register') }}" class="text-primary fw-bold text-decoration-none">
                                Daftar sekarang
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

            </div>
        </div>

    </div>
</div>

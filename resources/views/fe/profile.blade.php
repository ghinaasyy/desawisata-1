<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - {{ auth()->user()->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>

@include('fe.navbar')

<div class="profile-container">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="profile-card">
                    <div class="profile-header">
                        <div class="profile-avatar">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <h4 class="profile-name">{{ auth()->user()->name }}</h4>
                        <p class="profile-email">{{ auth()->user()->email }}</p>
                        <span class="profile-badge">{{ ucfirst(auth()->user()->level) }}</span>
                    </div>

                    <div class="profile-body">
                        <div class="profile-info">
                            <h5 class="section-title">Informasi Akun</h5>
                            
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                @method('PATCH')
                                
                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name', auth()->user()->name) }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" value="{{ auth()->user()->email }}" readonly>
                                    <small class="text-muted">Email tidak dapat diubah</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Password Baru</label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                                    <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" class="form-control">
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('fe.footer')

<style>
.profile-container {
    background-color: #f5f6fa;
    min-height: 100vh;
    padding: 80px 0 20px 0;
}

.profile-card {
    background: #ffffff;
    border-radius: 15px;
    box-shadow: 0 0 20px rgba(0,0,0,0.05);
    overflow: hidden;
}

.profile-header {
    background: linear-gradient(135deg,rgba(255, 168, 114, 0.86) 0%,rgba(133, 164, 203, 0.65) 100%);
    color: #2c3e50;
    padding: 40px 20px;
    text-align: center;
}

.profile-avatar {
    width: 100px;
    height: 100px;
    background:rgb(255, 255, 255);
    border-radius: 50%;
    margin: 0 auto 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
}

.profile-avatar i {
    font-size: 50px;
    color:rgb(157, 88, 4);
}

.profile-name {
    font-size: 24px;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 5px;
}

.profile-email {
    font-size: 16px;
    color:rgb(67, 71, 71);
    margin-bottom: 15px;
}

.profile-badge {
    background: #ffffff;
    color: #34495e;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 16px;
    box-shadow: 0 2px 5px rgb(0, 0, 0);
}

.profile-body {
    padding: 30px;
}

.section-title {
    color: #2c3e50;
    margin-bottom: 25px;
    padding-bottom: 10px;
    border-bottom: 2px solid #ecf0f1;
}

.form-control {
    border: 1px solid #e0e6ed;
    border-radius: 8px;
    padding: 12px 15px;
}

.form-control:focus {
    border-color: #bdc3c7;
    box-shadow: 0 0 0 0.2rem rgba(189,195,199,0.25);
}

.btn-primary {
    background: #95a5a6;
    border: none;
    padding: 10px 25px;
    border-radius: 8px;
    font-weight: 500;
}

.btn-primary:hover {
    background: #7f8c8d;
}

.form-label {
    color: #34495e;
    font-weight: 500;
}

.text-muted {
    color: #95a5a6 !important;
}

.alert {
    border-radius: 8px;
    border: none;
}

.alert-success {
    background: #d5f5e3;
    color: #27ae60;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
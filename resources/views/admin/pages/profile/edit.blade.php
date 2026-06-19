@extends('admin.layouts.main')

@section('heading_title', 'Profil Tənzimləmələri')

@section('content')
<div class="row">
    <div class="col-xl-6">
        <div class="card glass-card">
            <div class="card-header">
                <h4 class="card-title mb-0">Profil Məlumatları</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Ad Soyad</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Yeni Şifrə (Dəyişmək istəmirsinizsə boş buraxın)</label>
                        <input type="password" class="form-control" id="password" name="password">
                        @error('password')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Şifrəni Təsdiqlə</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-vision-primary">Yadda Saxla</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

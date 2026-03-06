@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0">Add Cadet</h4>
                <small class="text-muted">Create a new cadet profile and enrollment details.</small>
            </div>
            <div>
                <a href="{{ route('admin.cadets.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
        </div>

        
        <div class="card-body">
            <form method="POST" action="{{ route('admin.cadets.store') }}">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Full name</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="form-control @error('name') is-invalid @enderror" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="form-text">Enter the cadet's full name.</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email address</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="form-text">Used for login and notifications.</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Enrollment No.</label>
                        <input type="text" name="enrollment_no" value="{{ old('enrollment_no') }}"
                               class="form-control @error('enrollment_no') is-invalid @enderror" required>
                        @error('enrollment_no')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="form-text">Unique enrollment identifier (e.g. NCC12345).</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Password</label>
                        <input type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @else
                            <div class="form-text">Minimum 8 characters recommended.</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Phone (optional)</label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                               class="form-control @error('phone') is-invalid @enderror">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Address (optional)</label>
                        <textarea name="address" rows="2"
                                  class="form-control @error('address') is-invalid @enderror">{{ old('address') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Save Cadet
                    </button>

                    <a href="{{ route('admin.cadets.index') }}" class="btn btn-outline-secondary">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
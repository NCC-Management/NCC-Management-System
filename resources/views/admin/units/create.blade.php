@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb bg-transparent p-0 mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.units.index') }}">Units</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create</li>
        </ol>
    </nav>

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">Create NCC Unit</h5>
                <small class="text-muted">Add a new organizational unit. Fill required fields and save.</small>
            </div>
            <div>
                <a href="{{ route('admin.units.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success mb-3">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger mb-3">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.units.store') }}" class="row g-3">
                @csrf

                <div class="col-12 col-md-6">
                    <label for="unit_name" class="form-label fw-semibold">Unit Name <span class="text-danger">*</span></label>
                    <input id="unit_name" type="text" name="unit_name" value="{{ old('unit_name') }}"
                           class="form-control @error('unit_name') is-invalid @enderror" placeholder="e.g. 1st NCC Wing" required>
                    @error('unit_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @else
                        <div class="form-text">Unique and descriptive unit name.</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label for="battalion" class="form-label fw-semibold">Battalion <span class="text-danger">*</span></label>
                    <input id="battalion" type="text" name="battalion" value="{{ old('battalion') }}"
                           class="form-control @error('battalion') is-invalid @enderror" placeholder="e.g. Alpha Battalion" required>
                    @error('battalion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @else
                        <div class="form-text">Parent battalion or grouping.</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label for="state" class="form-label fw-semibold">State <span class="text-danger">*</span></label>
                    <input id="state" type="text" name="state" value="{{ old('state') }}"
                           class="form-control @error('state') is-invalid @enderror" placeholder="e.g. California" required>
                    @error('state')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @else
                        <div class="form-text">Operational state of the unit.</div>
                    @enderror
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Save Unit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
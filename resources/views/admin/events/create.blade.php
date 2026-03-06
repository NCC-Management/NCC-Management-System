@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb bg-transparent p-0 mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.events.index') }}">Events</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create</li>
        </ol>
    </nav>

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">Create Event</h5>
                <small class="text-muted">Define event details and assign to a unit.</small>
            </div>
            <div>
                <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.events.store') }}" class="row g-3">
                @csrf

                <div class="col-12 col-md-6">
                    <label class="form-label fw-semibold">Unit <span class="text-danger">*</span></label>
                    <select name="unit_id" class="form-select @error('unit_id') is-invalid @enderror" required>
                        <option value="">Select Unit</option>
                        @foreach($units as $unit)
                            <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                {{ $unit->unit_name ?? $unit->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('unit_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <div class="form-text">Which unit will own this event.</div>
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}"
                           class="form-control @error('title') is-invalid @enderror" required>
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12 col-md-4">
                    <label class="form-label fw-semibold">Event Date <span class="text-danger">*</span></label>
                    <input type="date" name="event_date" value="{{ old('event_date') }}"
                           class="form-control @error('event_date') is-invalid @enderror" required>
                    @error('event_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12 col-md-4">
                    <label class="form-label fw-semibold">Start Time</label>
                    <input type="time" name="start_time" value="{{ old('start_time') }}"
                           class="form-control @error('start_time') is-invalid @enderror">
                    @error('start_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12 col-md-4">
                    <label class="form-label fw-semibold">End Time</label>
                    <input type="time" name="end_time" value="{{ old('end_time') }}"
                           class="form-control @error('end_time') is-invalid @enderror">
                    @error('end_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Location</label>
                    <input type="text" name="location" value="{{ old('location') }}"
                           class="form-control @error('location') is-invalid @enderror" placeholder="Venue or address">
                    @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" rows="4"
                              class="form-control @error('description') is-invalid @enderror"
                              placeholder="Optional notes for the event">{{ old('description') }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12 d-flex justify-content-end gap-2 mt-2">
                    <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save me-1"></i> Save Event
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
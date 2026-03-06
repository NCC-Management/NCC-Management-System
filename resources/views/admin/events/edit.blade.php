@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb bg-transparent p-0 mb-2">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.events.index') }}">Events</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">Edit Event</h5>
                <small class="text-muted">Update event details and save changes.</small>
            </div>

            <div>
                <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Back to Events
                </a>
            </div>
        </div>

        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger small mb-4">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.events.update', $event->id) }}" class="row g-3">
                @csrf
                @method('PUT')

                <div class="col-12 col-md-6">
                    <label for="unit_id" class="form-label fw-semibold">Unit <span class="text-danger">*</span></label>
                    <select id="unit_id" name="unit_id" class="form-select @error('unit_id') is-invalid @enderror" required>
                        <option value="">-- Select unit --</option>
                        @foreach($units as $unit)
                            <option value="{{ $unit->id }}" {{ old('unit_id', $event->unit_id) == $unit->id ? 'selected' : '' }}>
                                {{ $unit->unit_name ?? $unit->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('unit_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <div class="form-text">Which unit owns this event.</div>
                </div>

                <div class="col-12 col-md-6">
                    <label for="title" class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                    <input id="title" name="title" type="text"
                           value="{{ old('title', $event->title) }}"
                           class="form-control @error('title') is-invalid @enderror" required>
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12 col-md-4">
                    <label for="event_date" class="form-label fw-semibold">Event Date <span class="text-danger">*</span></label>
                    <input id="event_date" name="event_date" type="date"
                           value="{{ old('event_date', optional($event->event_date)->format('Y-m-d') ?: $event->event_date) }}"
                           class="form-control @error('event_date') is-invalid @enderror" required>
                    @error('event_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-6 col-md-4">
                    <label for="start_time" class="form-label fw-semibold">Start Time</label>
                    <input id="start_time" name="start_time" type="time"
                           value="{{ old('start_time', $event->start_time) }}"
                           class="form-control @error('start_time') is-invalid @enderror">
                    @error('start_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-6 col-md-4">
                    <label for="end_time" class="form-label fw-semibold">End Time</label>
                    <input id="end_time" name="end_time" type="time"
                           value="{{ old('end_time', $event->end_time) }}"
                           class="form-control @error('end_time') is-invalid @enderror">
                    @error('end_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <label for="location" class="form-label fw-semibold">Location</label>
                    <input id="location" name="location" type="text"
                           value="{{ old('location', $event->location) }}"
                           class="form-control @error('location') is-invalid @enderror" placeholder="Venue or address">
                    @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <label for="description" class="form-label fw-semibold">Description</label>
                    <textarea id="description" name="description" rows="4"
                              class="form-control @error('description') is-invalid @enderror"
                              placeholder="Optional details about the event">{{ old('description', $event->description) }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12 d-flex justify-content-end gap-2 mt-2">
                    <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Update Event
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
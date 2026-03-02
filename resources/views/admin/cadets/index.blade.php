@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Cadet Management</h3>
            <p class="text-muted mb-0">Manage NCC cadets, enrollment details and actions</p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('cadets.create') }}" class="btn btn-primary">
                <i class="bi bi-person-plus"></i> Add Cadet
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Card -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Enrollment No</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($cadets as $index => $cadet)
                            <tr>
                                <td class="text-muted">{{ $index + 1 }}</td>

                                <td>
                                    <div class="fw-semibold">{{ $cadet->user->name }}</div>
                                    <small class="text-muted">Cadet</small>
                                </td>

                                <td>{{ $cadet->user->email }}</td>

                                <td>
                                    <span class="badge bg-secondary">
                                        {{ $cadet->enrollment_no }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    <a href="{{ route('cadets.edit', $cadet) }}"
                                       class="btn btn-sm btn-outline-warning">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form method="POST"
                                          action="{{ route('cadets.destroy', $cadet) }}"
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this cadet?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    No cadets found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>

@endsection
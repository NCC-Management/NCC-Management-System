@extends('layouts.admin')
@section('content')

<div class="container-fluid">

    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb bg-transparent p-0 mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Units</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Units</h3>
            <p class="text-muted mb-0">Manage organizational units — add, edit or remove as needed.</p>
        </div>

        <div class="d-flex gap-2">
            <form class="d-flex" action="{{ route('admin.units.index') }}" method="GET" role="search">
                <div class="input-group input-group-sm">
                    <input name="q" value="{{ request('q') }}" class="form-control" type="search" placeholder="Search units">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>

            <a href="{{ route('admin.units.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg me-1"></i> Add Unit
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width:60px">#</th>
                            <th>Unit Name</th>
                            <th style="width:180px">Battalion</th>
                            <th style="width:140px">State</th>
                            <th style="width:160px">Created</th>
                            <th style="width:160px" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $isPaginator = method_exists($units, 'firstItem'); @endphp

                        @forelse($units as $i => $unit)
                            @php
                                $number = $isPaginator
                                    ? ($units->firstItem() ? $units->firstItem() + $i : $i + 1)
                                    : ($i + 1);
                            @endphp
                            <tr>
                                <td>{{ $number }}</td>
                                <td class="fw-semibold">{{ $unit->name ?? $unit->unit_name ?? '-' }}</td>
                                <td>{{ $unit->battalion ?? '-' }}</td>
                                <td>{{ $unit->state ?? '-' }}</td>
                                <td class="text-muted">{{ optional($unit->created_at)->format('Y-m-d') ?? '-' }}<br><small class="text-muted">{{ optional($unit->created_at)->diffForHumans() }}</small></td>
                                <td class="text-end">
                                    <a href="{{ route('admin.units.show', $unit) }}" class="btn btn-sm btn-outline-info me-1" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a href="{{ route('admin.units.edit', $unit) }}" class="btn btn-sm btn-outline-warning me-1" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form method="POST" action="{{ route('admin.units.destroy', $unit) }}" class="d-inline" onsubmit="return confirm('Delete this unit?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="text-muted">No units found. Click <strong>Add Unit</strong> to create one.</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer bg-white d-flex justify-content-between align-items-center">
            <div class="text-muted small">
                Showing {{ $isPaginator ? $units->total() : count($units) }} unit(s)
            </div>

            <div>
                @if($isPaginator)
                    {{ $units->withQueryString()->links() }}
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
@extends('layouts.app')

@section('title', 'Application List')

@section('content')
<div class="container">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-dark">Application List</h2>
    </div>

    <!-- Filter Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-body bg-light">
            <form method="GET" action="{{ route('applications.index') }}">
                <div class="row g-3 align-items-end">
                    <!-- Programme -->
                    <div class="col-md-3">
                        <label for="program" class="form-label fw-semibold">Programme</label>
                        <select name="program" id="program" class="form-select">
                            <option value="">All</option>
                            @php
                                $programs = \App\Models\Application::distinct()->pluck('program')->filter();
                            @endphp
                            @foreach($programs as $prog)
                                <option value="{{ $prog }}" {{ request('program') == $prog ? 'selected' : '' }}>
                                    {{ $prog }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- From Date -->
                    <div class="col-md-2">
                        <label for="from_date" class="form-label fw-semibold">From Date</label>
                        <input type="date" name="from_date" id="from_date" class="form-control" 
                               value="{{ request('from_date', date('Y-m-d')) }}">
                    </div>

                    <!-- To Date -->
                    <div class="col-md-2">
                        <label for="to_date" class="form-label fw-semibold">To Date</label>
                        <input type="date" name="to_date" id="to_date" class="form-control" 
                               value="{{ request('to_date', date('Y-m-d')) }}">
                    </div>

                    <!-- Application No -->
                    <div class="col-md-3">
                        <label for="application_no" class="form-label fw-semibold">Application No</label>
                        <input type="text" name="application_no" id="application_no" class="form-control" 
                               value="{{ request('application_no') }}" placeholder="Enter application number">
                    </div>

                    <!-- Search Button -->
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-warning w-100 fw-semibold">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card shadow">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead class="table-success">
                        <tr>
                            <th class="px-4 py-3 fw-semibold text-center">#</th>
                            <th class="px-4 py-3 fw-semibold">Application No</th>
                            <th class="px-4 py-3 fw-semibold">Status</th>
                            <th class="px-4 py-3 fw-semibold">Name</th>
                            <th class="px-4 py-3 fw-semibold">Programme</th>
                            <th class="px-4 py-3 fw-semibold">Created Date</th>
                            <th class="px-4 py-3 fw-semibold">Payment Status</th>
                            <th class="px-4 py-3 fw-semibold text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applications as $index => $application)
                            <tr>
                                <td class="px-4 py-3 text-center">{{ $applications->firstItem() + $index }}</td>
                                <td class="px-4 py-3">
                                    <strong class="text-primary">{{ $application->application_id }}</strong>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="badge bg-{{ 
                                        $application->status == 'submitted' ? 'warning' : 
                                        ($application->status == 'approved' ? 'success' : 
                                        ($application->status == 'enrolled' ? 'primary' : 'danger')) 
                                    }}">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">{{ $application->student_name }}</td>
                                <td class="px-4 py-3">{{ $application->program }}</td>
                                <td class="px-4 py-3">
                                    {{ \Carbon\Carbon::parse($application->created_at)->format('d/m/Y') }}
                                </td>
                                <td class="px-4 py-3">
                                    <span class="badge bg-{{ 
                                        $application->payment_status == 'paid' ? 'success' : 
                                        ($application->payment_status == 'partial' ? 'warning' : 'danger') 
                                    }}">
                                        {{ ucfirst($application->payment_status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('applications.show', $application) }}" 
                                           class="btn btn-sm btn-outline-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('applications.edit', $application) }}" 
                                           class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fas fa-folder-open fa-3x mb-3 opacity-50"></i>
                                    <br>
                                    <strong>No applications found</strong>
                                    <br>
                                    <small>Try adjusting your search filters</small>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($applications->hasPages())
                <div class="px-4 py-3 border-top">
                    {{ $applications->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Summary Info -->
    <div class="mt-3">
        <small class="text-muted">
            Showing {{ $applications->firstItem() ?? 0 }} to {{ $applications->lastItem() ?? 0 }} 
            of {{ $applications->total() }} results
        </small>
    </div>
</div>

<style>
.card {
    border-radius: 8px;
    border: none;
}

.table-success {
    --bs-table-bg: #198754;
    --bs-table-color: white;
}

.table-success th {
    border-color: #146c43;
}

.btn-warning {
    background-color: #ff9800;
    border-color: #ff9800;
    color: white;
}

.btn-warning:hover {
    background-color: #f57c00;
    border-color: #f57c00;
}

.form-label {
    font-size: 0.9rem;
}

.btn-group .btn {
    margin-right: 2px;
}

.btn-group .btn:last-child {
    margin-right: 0;
}
</style>
@endsection
@extends('layouts.app')

@section('title', 'Registrations')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Registrations</h1>
    <a href="{{ route('registrations.create') }}" class="btn btn-primary">New Registration</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Program</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($registrations as $registration)
                        <tr>
                            <td>{{ $registration->id }}</td>
                            <td>{{ $registration->full_name }}</td>
                            <td>{{ $registration->email }}</td>
                            <td>{{ $registration->phone }}</td>
                            <td>{{ $registration->program }}</td>
                            <td>{{ $registration->created_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('registrations.show', $registration) }}" class="btn btn-sm btn-info">View</a>
                                
                                @if(!$registration->applications()->exists())
                                    <form action="{{ route('applications.fromRegistration', $registration) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">Create Application</button>
                                    </form>
                                @else
                                    <span class="badge bg-success">Has Application</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No registrations found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $registrations->links() }}
    </div>
</div>
@endsection
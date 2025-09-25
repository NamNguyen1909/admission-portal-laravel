@extends('layouts.app')

@section('title', 'Application Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Application Details</h1>
    <div>
        <a href="{{ route('applications.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Application Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3"><strong>Application ID:</strong></div>
                    <div class="col-sm-9"><span class="badge bg-primary fs-6">{{ $application->application_id }}</span></div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-sm-3"><strong>Student Name:</strong></div>
                    <div class="col-sm-9">{{ $application->student_name }}</div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-sm-3"><strong>Program:</strong></div>
                    <div class="col-sm-9">{{ $application->program }}</div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-sm-3"><strong>Status:</strong></div>
                    <div class="col-sm-9">
                        <span class="badge bg-{{ $application->status == 'submitted' ? 'warning' : ($application->status == 'approved' ? 'success' : ($application->status == 'enrolled' ? 'primary' : 'danger')) }} fs-6">
                            {{ ucfirst($application->status) }}
                        </span>
                    </div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-sm-3"><strong>Payment Status:</strong></div>
                    <div class="col-sm-9">
                        <span class="badge bg-{{ $application->payment_status == 'paid' ? 'success' : ($application->payment_status == 'partial' ? 'warning' : 'danger') }} fs-6">
                            {{ ucfirst($application->payment_status) }}
                        </span>
                    </div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-sm-3"><strong>Created At:</strong></div>
                    <div class="col-sm-9">{{ $application->created_at->format('Y-m-d H:i:s') }}</div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-sm-3"><strong>Updated At:</strong></div>
                    <div class="col-sm-9">{{ $application->updated_at->format('Y-m-d H:i:s') }}</div>
                </div>
            </div>
        </div>

        @if($application->registration)
        <div class="card mt-4">
            <div class="card-header">
                <h5>Related Registration Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3"><strong>Registration ID:</strong></div>
                    <div class="col-sm-9">
                        <a href="{{ route('registrations.show', $application->registration) }}">
                            {{ $application->registration->id }}
                        </a>
                    </div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-sm-3"><strong>Email:</strong></div>
                    <div class="col-sm-9">{{ $application->registration->email }}</div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-sm-3"><strong>Phone:</strong></div>
                    <div class="col-sm-9">{{ $application->registration->phone }}</div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-sm-3"><strong>Date of Birth:</strong></div>
                    <div class="col-sm-9">{{ $application->registration->date_of_birth->format('Y-m-d') }}</div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Quick Actions</h5>
            </div>
            <div class="card-body">
                <!-- Update Status -->
                <form action="{{ route('applications.status', $application) }}" method="POST" class="mb-3">
                    @csrf
                    @method('PUT')
                    <label for="status" class="form-label">Update Status</label>
                    <div class="input-group">
                        <select name="status" id="status" class="form-control">
                            <option value="submitted" {{ $application->status == 'submitted' ? 'selected' : '' }}>Submitted</option>
                            <option value="approved" {{ $application->status == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="enrolled" {{ $application->status == 'enrolled' ? 'selected' : '' }}>Enrolled</option>
                            <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>

                <!-- Update Payment Status -->
                <form action="{{ route('applications.payment', $application) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <label for="payment_status" class="form-label">Update Payment Status</label>
                    <div class="input-group">
                        <select name="payment_status" id="payment_status" class="form-control">
                            <option value="unpaid" {{ $application->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="partial" {{ $application->payment_status == 'partial' ? 'selected' : '' }}>Partial</option>
                            <option value="paid" {{ $application->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                        </select>
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
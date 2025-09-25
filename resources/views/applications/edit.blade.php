@extends('layouts.app')

@section('title', 'Edit Application')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Edit Application</h1>
    <div>
        <a href="{{ route('applications.show', $application) }}" class="btn btn-info">View</a>
        <a href="{{ route('applications.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('applications.update', $application) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label"><strong>Application ID:</strong></label>
                <div class="form-control-plaintext">{{ $application->application_id }}</div>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Student Name:</strong></label>
                <div class="form-control-plaintext">{{ $application->student_name }}</div>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Program:</strong></label>
                <div class="form-control-plaintext">{{ $application->program }}</div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">Status *</label>
                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                        <option value="submitted" {{ $application->status == 'submitted' ? 'selected' : '' }}>Submitted</option>
                        <option value="approved" {{ $application->status == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="enrolled" {{ $application->status == 'enrolled' ? 'selected' : '' }}>Enrolled</option>
                        <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="payment_status" class="form-label">Payment Status *</label>
                    <select class="form-control @error('payment_status') is-invalid @enderror" id="payment_status" name="payment_status" required>
                        <option value="unpaid" {{ $application->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                        <option value="partial" {{ $application->payment_status == 'partial' ? 'selected' : '' }}>Partial</option>
                        <option value="paid" {{ $application->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                    </select>
                    @error('payment_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary">Update Application</button>
            </div>
        </form>
    </div>
</div>
@endsection
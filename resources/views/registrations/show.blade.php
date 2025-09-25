@extends('layouts.app')

@section('title', 'Registration Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Registration Details</h1>
    <div>
        <a href="{{ route('registrations.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Registration Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3"><strong>Registration ID:</strong></div>
                    <div class="col-sm-9">{{ $registration->id }}</div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-sm-3"><strong>Full Name:</strong></div>
                    <div class="col-sm-9">{{ $registration->full_name }}</div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-sm-3"><strong>Email:</strong></div>
                    <div class="col-sm-9">{{ $registration->email }}</div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-sm-3"><strong>Phone:</strong></div>
                    <div class="col-sm-9">{{ $registration->phone }}</div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-sm-3"><strong>Gender:</strong></div>
                    <div class="col-sm-9">{{ ucfirst($registration->gender) }}</div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-sm-3"><strong>Date of Birth:</strong></div>
                    <div class="col-sm-9">{{ $registration->date_of_birth->format('Y-m-d') }}</div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-sm-3"><strong>Country of Birth:</strong></div>
                    <div class="col-sm-9">{{ $registration->country_of_birth ?? 'N/A' }}</div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-sm-3"><strong>Nationality:</strong></div>
                    <div class="col-sm-9">{{ $registration->nationality ?? 'N/A' }}</div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-sm-3"><strong>Passport No:</strong></div>
                    <div class="col-sm-9">{{ $registration->passport_no ?? 'N/A' }}</div>
                </div>
                <hr>

                @if($registration->passport_file)
                <div class="row">
                    <div class="col-sm-3"><strong>Passport File:</strong></div>
                    <div class="col-sm-9">
                        <a href="{{ Storage::url($registration->passport_file) }}" target="_blank" class="btn btn-sm btn-info">View File</a>
                    </div>
                </div>
                <hr>
                @endif

                <div class="row">
                    <div class="col-sm-3"><strong>Permanent Address:</strong></div>
                    <div class="col-sm-9">{{ $registration->permanent_address ?? 'N/A' }}</div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-sm-3"><strong>Present Address:</strong></div>
                    <div class="col-sm-9">{{ $registration->present_address ?? 'N/A' }}</div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-sm-3"><strong>Program:</strong></div>
                    <div class="col-sm-9">{{ $registration->program }}</div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-sm-3"><strong>Created At:</strong></div>
                    <div class="col-sm-9">{{ $registration->created_at->format('Y-m-d H:i:s') }}</div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-sm-3"><strong>Updated At:</strong></div>
                    <div class="col-sm-9">{{ $registration->updated_at->format('Y-m-d H:i:s') }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Actions</h5>
            </div>
            <div class="card-body">
                @if(!$registration->applications()->exists())
                    <form action="{{ route('applications.fromRegistration', $registration) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success w-100 mb-2">Create Application</button>
                    </form>
                @else
                    <div class="alert alert-success">
                        <strong>Application Created!</strong><br>
                        @foreach($registration->applications as $application)
                            <a href="{{ route('applications.show', $application) }}" class="btn btn-sm btn-primary mt-1">
                                View Application {{ $application->application_id }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
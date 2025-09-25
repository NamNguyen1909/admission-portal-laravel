@extends('layouts.app')

@section('title', 'Personal Information')

@section('content')
<div class="container">
    <!-- Header với navigation buttons -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('registrations.index') }}" class="btn btn-outline-secondary me-2">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <button type="button" class="btn btn-outline-secondary" onclick="refreshForm()">
                <i class="fas fa-refresh"></i> Refresh
            </button>
        </div>
        <h2 class="mb-0">Personal Information</h2>
        <div></div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('registrations.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Profile Picture -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <label for="profile_picture" class="form-label">Profile Picture</label>
                        <div class="d-flex align-items-center">
                            <div class="profile-picture-preview me-3" style="width: 120px; height: 120px; border: 2px dashed #ddd; display: flex; align-items: center; justify-content: center; border-radius: 8px;">
                                <img id="preview-image" src="#" alt="Preview" style="width: 100%; height: 100%; object-fit: cover; border-radius: 6px; display: none;">
                                <span id="preview-text" class="text-muted">No Image</span>
                            </div>
                            <div>
                                <input type="file" class="form-control @error('profile_picture') is-invalid @enderror" 
                                       id="profile_picture" name="profile_picture" accept=".jpg,.jpeg,.png" onchange="previewImage(this)">
                                @error('profile_picture')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Choose File to upload profile picture</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- First Name -->
                    <div class="col-md-6 mb-3">
                        <label for="first_name" class="form-label">First Name *</label>
                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                               id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                        @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Last Name -->
                    <div class="col-md-6 mb-3">
                        <label for="last_name" class="form-label">Last Name *</label>
                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                               id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                        @error('last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Phone -->
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">Phone *</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" name="phone" value="{{ old('phone') }}" required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Gender -->
                    <div class="col-md-6 mb-3">
                        <label for="gender" class="form-label">Gender *</label>
                        <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Date of Birth -->
                    <div class="col-md-6 mb-3">
                        <label for="date_of_birth" class="form-label">Date of Birth * <small class="text-muted">(dd/mm/yyyy)</small></label>
                        <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" 
                               id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                        @error('date_of_birth')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Country of Birth -->
                    <div class="col-md-6 mb-3">
                        <label for="country_of_birth" class="form-label">Country of Birth *</label>
                        <input type="text" class="form-control @error('country_of_birth') is-invalid @enderror" 
                               id="country_of_birth" name="country_of_birth" value="{{ old('country_of_birth') }}" 
                               placeholder="Enter country of birth" required>
                        @error('country_of_birth')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nationality -->
                    <div class="col-md-6 mb-3">
                        <label for="nationality" class="form-label">Nationality *</label>
                        <input type="text" class="form-control @error('nationality') is-invalid @enderror" 
                               id="nationality" name="nationality" value="{{ old('nationality') }}" 
                               placeholder="Enter nationality" required>
                        @error('nationality')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Additional Fields -->
                <div class="row">
                    <!-- Passport No -->
                    <div class="col-md-6 mb-3">
                        <label for="passport_no" class="form-label">Passport No</label>
                        <input type="text" class="form-control @error('passport_no') is-invalid @enderror" 
                               id="passport_no" name="passport_no" value="{{ old('passport_no') }}" 
                               placeholder="Enter passport number">
                        @error('passport_no')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Passport File -->
                    <div class="col-md-6 mb-3">
                        <label for="passport_file" class="form-label">Passport File</label>
                        <input type="file" class="form-control @error('passport_file') is-invalid @enderror" 
                               id="passport_file" name="passport_file" accept=".pdf,.jpg,.jpeg,.png">
                        @error('passport_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Upload passport file (PDF, JPG, PNG - Max 2MB)</small>
                    </div>
                </div>

                <div class="row">
                    <!-- Permanent Address -->
                    <div class="col-md-6 mb-3">
                        <label for="permanent_address" class="form-label">Permanent Address</label>
                        <textarea class="form-control @error('permanent_address') is-invalid @enderror" 
                                  id="permanent_address" name="permanent_address" rows="3" 
                                  placeholder="Enter permanent address">{{ old('permanent_address') }}</textarea>
                        @error('permanent_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Present Address -->
                    <div class="col-md-6 mb-3">
                        <label for="present_address" class="form-label">Present Address</label>
                        <textarea class="form-control @error('present_address') is-invalid @enderror" 
                                  id="present_address" name="present_address" rows="3" 
                                  placeholder="Enter present address">{{ old('present_address') }}</textarea>
                        @error('present_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Program -->
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="program" class="form-label">Program *</label>
                        <select class="form-select @error('program') is-invalid @enderror" id="program" name="program" required>
                            <option value="">Select Program</option>
                            <option value="Computer Science" {{ old('program') == 'Computer Science' ? 'selected' : '' }}>Computer Science</option>
                            <option value="Business Administration" {{ old('program') == 'Business Administration' ? 'selected' : '' }}>Business Administration</option>
                            <option value="Engineering" {{ old('program') == 'Engineering' ? 'selected' : '' }}>Engineering</option>
                            <option value="Economics" {{ old('program') == 'Economics' ? 'selected' : '' }}>Economics</option>
                            <option value="Medicine" {{ old('program') == 'Medicine' ? 'selected' : '' }}>Medicine</option>
                            <option value="Law" {{ old('program') == 'Law' ? 'selected' : '' }}>Law</option>
                        </select>
                        @error('program')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-secondary" disabled>
                        <i class="fas fa-arrow-left"></i> Previous
                    </button>
                    
                    <div>
                        <button type="submit" name="action" value="save_and_continue" class="btn btn-success">
                            Next <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('preview-image');
    const previewText = document.getElementById('preview-text');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            previewText.style.display = 'none';
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.style.display = 'none';
        previewText.style.display = 'block';
    }
}

function refreshForm() {
    // Confirm before refresh
    if (confirm('Are you sure you want to clear all fields? This action cannot be undone.')) {
        // Reset all form fields
        document.querySelector('form').reset();
        
        // Reset profile picture preview
        const preview = document.getElementById('preview-image');
        const previewText = document.getElementById('preview-text');
        preview.style.display = 'none';
        previewText.style.display = 'block';
        
        // Clear validation errors
        const errorElements = document.querySelectorAll('.is-invalid');
        errorElements.forEach(element => {
            element.classList.remove('is-invalid');
        });
        
        const feedbackElements = document.querySelectorAll('.invalid-feedback');
        feedbackElements.forEach(element => {
            element.style.display = 'none';
        });
        
        // Optional: Show success message
        // alert('Form has been cleared successfully!');
    }
}
</script>

<style>
.card {
    border-radius: 10px;
}

.form-label {
    font-weight: 600;
    color: #333;
}

.btn {
    border-radius: 6px;
    font-weight: 500;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

.btn-success {
    background-color: #28a745;
    border-color: #28a745;
}
</style>
@endsection
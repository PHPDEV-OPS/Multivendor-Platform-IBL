@extends('layouts.unified')

@section('page-title', 'Profile')
@section('page-subtitle', 'Manage your personal information')

@push('styles')
<style>
.status-badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
}
.status-active {
    background-color: #d4edda;
    color: #155724;
}
.status-inactive {
    background-color: #f8d7da;
    color: #721c24;
}
.status-verified {
    background-color: #d1ecf1;
    color: #0c5460;
}
.status-pending {
    background-color: #fff3cd;
    color: #856404;
}
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Profile Information -->
        <div class="col-md-8">
            <!-- Personal Information -->
            <div class="user-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Personal Information</h5>
                </div>
                <div class="card-body">
                    <form id="personalForm" action="{{ route('user.profile.personal') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">Full Name *</label>
                                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Email Address *</label>
                                    <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="tel" name="phone" class="form-control" value="{{ $user->phone }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Date of Birth</label>
                                    <input type="date" name="date_of_birth" class="form-control" value="{{ $user->date_of_birth ? $user->date_of_birth->format('Y-m-d') : '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Gender</label>
                                    <select name="gender" class="form-select">
                                        <option value="">Select Gender</option>
                                        <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ $user->gender == 'other' ? 'selected' : '' }}>Other</option>
                                        <option value="prefer-not" {{ $user->gender == 'prefer-not' ? 'selected' : '' }}>Prefer not to say</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Bio</label>
                            <textarea name="bio" class="form-control" rows="3" placeholder="Tell us about yourself...">{{ $user->bio }}</textarea>
                        </div>
                        <button type="submit" class="user-btn user-btn-primary">Update Personal Information</button>
                    </form>
                </div>
            </div>



            <!-- Address Information -->
            <div class="user-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Address Information</h5>
                </div>
                <div class="card-body">
                    <form id="addressForm" action="{{ route('user.profile.address') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">Primary Address</h6>
                                <div class="form-group mb-3">
                                    <label class="form-label">Street Address *</label>
                                    <input type="text" name="primary_address[street]" class="form-control" value="{{ $user->primary_address['street'] ?? '' }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">City *</label>
                                    <input type="text" name="primary_address[city]" class="form-control" value="{{ $user->primary_address['city'] ?? '' }}" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">State *</label>
                                            <input type="text" name="primary_address[state]" class="form-control" value="{{ $user->primary_address['state'] ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">ZIP Code *</label>
                                            <input type="text" name="primary_address[postal_code]" class="form-control" value="{{ $user->primary_address['postal_code'] ?? '' }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Country *</label>
                                    <select name="primary_address[country]" class="form-select" required>
                                        <option value="">Select Country</option>
                                        <option value="KE" {{ ($user->primary_address['country'] ?? '') == 'KE' ? 'selected' : '' }}>Kenya</option>
                                        <option value="UG" {{ ($user->primary_address['country'] ?? '') == 'UG' ? 'selected' : '' }}>Uganda</option>
                                        <option value="TZ" {{ ($user->primary_address['country'] ?? '') == 'TZ' ? 'selected' : '' }}>Tanzania</option>
                                        <option value="RW" {{ ($user->primary_address['country'] ?? '') == 'RW' ? 'selected' : '' }}>Rwanda</option>
                                        <option value="US" {{ ($user->primary_address['country'] ?? '') == 'US' ? 'selected' : '' }}>United States</option>
                                        <option value="UK" {{ ($user->primary_address['country'] ?? '') == 'UK' ? 'selected' : '' }}>United Kingdom</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">Shipping Address</h6>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="same_as_primary" id="sameAsPrimary" value="1"
                                           {{ (!$user->shipping_address || $user->shipping_address == $user->primary_address) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="sameAsPrimary">
                                        Same as primary address
                                    </label>
                                </div>
                                <div id="shippingAddress" style="display: {{ (!$user->shipping_address || $user->shipping_address == $user->primary_address) ? 'none' : 'block' }};">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Street Address</label>
                                        <input type="text" name="shipping_address[street]" class="form-control" value="{{ $user->shipping_address['street'] ?? '' }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">City</label>
                                        <input type="text" name="shipping_address[city]" class="form-control" value="{{ $user->shipping_address['city'] ?? '' }}">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">State</label>
                                                <input type="text" name="shipping_address[state]" class="form-control" value="{{ $user->shipping_address['state'] ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">ZIP Code</label>
                                                <input type="text" name="shipping_address[postal_code]" class="form-control" value="{{ $user->shipping_address['postal_code'] ?? '' }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Country</label>
                                        <select name="shipping_address[country]" class="form-select">
                                            <option value="">Select Country</option>
                                            <option value="KE" {{ ($user->shipping_address['country'] ?? '') == 'KE' ? 'selected' : '' }}>Kenya</option>
                                            <option value="UG" {{ ($user->shipping_address['country'] ?? '') == 'UG' ? 'selected' : '' }}>Uganda</option>
                                            <option value="TZ" {{ ($user->shipping_address['country'] ?? '') == 'TZ' ? 'selected' : '' }}>Tanzania</option>
                                            <option value="RW" {{ ($user->shipping_address['country'] ?? '') == 'RW' ? 'selected' : '' }}>Rwanda</option>
                                            <option value="US" {{ ($user->shipping_address['country'] ?? '') == 'US' ? 'selected' : '' }}>United States</option>
                                            <option value="UK" {{ ($user->shipping_address['country'] ?? '') == 'UK' ? 'selected' : '' }}>United Kingdom</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="user-btn user-btn-primary">Update Address Information</button>
                    </form>
                </div>
            </div>


        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Profile Picture -->
            <div class="user-card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Profile Picture</h6>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3 profile-image">
                        <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : 'https://via.placeholder.com/150x150?text=' . substr($user->name, 0, 1) }}"
                             alt="Profile Picture" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                    <form id="pictureForm" action="{{ route('user.profile.picture') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <input type="file" name="profile_picture" id="profilePicture" class="form-control" accept="image/*" onchange="previewImage(this)">
                        </div>
                        <button type="submit" class="user-btn user-btn-outline">Upload New Picture</button>
                    </form>
                </div>
            </div>

            <!-- Account Status -->
            <div class="user-card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Account Status</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Account Status:</span>
                        <span class="status-badge {{ $user->is_active ? 'status-active' : 'status-inactive' }}">
                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Email Status:</span>
                        <span class="status-badge {{ $user->email_verified_at ? 'status-verified' : 'status-pending' }}">
                            {{ $user->email_verified_at ? 'Verified' : 'Pending' }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Member Since:</span>
                        <span>{{ $user->created_at->format('M Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Last Login:</span>
                        <span>{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}</span>
                    </div>
                </div>
            </div>




        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = input.parentElement.previousElementSibling.querySelector('img');
            img.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Handle shipping address toggle
    const sameAsPrimaryCheckbox = document.getElementById('sameAsPrimary');
    const shippingAddressDiv = document.getElementById('shippingAddress');

    sameAsPrimaryCheckbox.addEventListener('change', function() {
        if (this.checked) {
            shippingAddressDiv.style.display = 'none';
        } else {
            shippingAddressDiv.style.display = 'block';
        }
    });

    // Form submission handlers
    const forms = ['personalForm', 'addressForm', 'pictureForm'];

    forms.forEach(formId => {
        const form = document.getElementById(formId);
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                console.log('Form submitted:', formId);
                console.log('Form action:', this.action);

                const formData = new FormData(this);
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;

                // Log form data
                for (let [key, value] of formData.entries()) {
                    console.log(key, value);
                }

                // Show loading state
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';

                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    if (data.success) {
                        showAlert(data.message, 'success');

                        // If it's profile picture update, update the image
                        if (data.image_url && formId === 'pictureForm') {
                            document.querySelector('.profile-image img').src = data.image_url;
                        }

                        // Reload page after 2 seconds to show updated data
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    } else {
                        showAlert(data.message || 'An error occurred', 'error');
                        if (data.errors) {
                            console.log('Validation errors:', data.errors);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('An error occurred while updating: ' + error.message, 'error');
                })
                .finally(() => {
                    // Reset button state
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                });
            });
        }
    });
});

function showAlert(message, type) {
    // Create alert element
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    document.body.appendChild(alertDiv);

    // Auto remove after 3 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 3000);
}
</script>
@endpush

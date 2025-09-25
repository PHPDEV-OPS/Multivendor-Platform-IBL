@extends('layouts.main')

@section('content')
<style>
.merchant-apply-section {
    padding: 80px 0;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.merchant-form-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    padding: 40px;
    margin-bottom: 30px;
}

.form-section {
    margin-bottom: 30px;
}

.form-section h4 {
    color: var(--base_color);
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid var(--base_color_10);
}

.form-label {
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
}

.form-control {
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 12px 15px;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: var(--base_color);
    box-shadow: 0 0 0 3px var(--base_color_10);
}

.form-select {
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 12px 15px;
    transition: all 0.3s ease;
}

.form-select:focus {
    border-color: var(--base_color);
    box-shadow: 0 0 0 3px var(--base_color_10);
}

.btn-apply {
    background: var(--base_color);
    color: white;
    border: none;
    padding: 15px 30px;
    border-radius: 8px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
}

.btn-apply:hover {
    background: #e55a1a;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255, 107, 53, 0.3);
}

.benefits-list {
    list-style: none;
    padding: 0;
}

.benefits-list li {
    padding: 10px 0;
    border-bottom: 1px solid #e9ecef;
    position: relative;
    padding-left: 30px;
}

.benefits-list li:before {
    content: '✓';
    position: absolute;
    left: 0;
    color: var(--success_color);
    font-weight: bold;
    font-size: 18px;
}

.benefits-list li:last-child {
    border-bottom: none;
}

.alert {
    border-radius: 8px;
    border: none;
    padding: 15px 20px;
}

.alert-danger {
    background: #ffe6e6;
    color: #d63384;
}

.alert-success {
    background: #d1e7dd;
    color: #0f5132;
}

@media (max-width: 768px) {
    .merchant-form-card {
        padding: 20px;
    }

    .merchant-apply-section {
        padding: 40px 0;
    }
}
</style>

<!-- Merchant Application Section -->
<section class="merchant-apply-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="text-center mb-5">
                    <h2 class="mb-3">Become a Merchant</h2>
                    <p class="text-muted">Join our platform and start selling your products to customers worldwide</p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="row">
                    <!-- Application Form -->
                    <div class="col-lg-8">
                        <div class="merchant-form-card">
                            <form method="POST" action="{{ route('register') }}" id="merchantForm" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="role" value="vendor">

                                <!-- Personal Information -->
                                <div class="form-section">
                                    <h4>Personal Information</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="first_name" class="form-label">First Name *</label>
                                                <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                                       id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                                                @error('first_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="last_name" class="form-label">Last Name</label>
                                                <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                                       id="last_name" name="last_name" value="{{ old('last_name') }}">
                                                @error('last_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email Address *</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                               id="email" name="email" value="{{ old('email') }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="password" class="form-label">Password *</label>
                                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                                       id="password" name="password" required>
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="password_confirmation" class="form-label">Confirm Password *</label>
                                                <input type="password" class="form-control"
                                                       id="password_confirmation" name="password_confirmation" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Business Information -->
                                <div class="form-section">
                                    <h4>Business Information</h4>
                                    <div class="mb-3">
                                        <label for="company_name" class="form-label">Company/Business Name *</label>
                                        <input type="text" class="form-control @error('company_name') is-invalid @enderror"
                                               id="company_name" name="company_name" value="{{ old('company_name') }}" required>
                                        @error('company_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="business_type" class="form-label">Business Type</label>
                                        <select class="form-select @error('business_type') is-invalid @enderror"
                                                id="business_type" name="business_type">
                                            <option value="">Select Business Type</option>
                                            <option value="Retail" {{ old('business_type') === 'Retail' ? 'selected' : '' }}>Retail</option>
                                            <option value="Wholesale" {{ old('business_type') === 'Wholesale' ? 'selected' : '' }}>Wholesale</option>
                                            <option value="Manufacturing" {{ old('business_type') === 'Manufacturing' ? 'selected' : '' }}>Manufacturing</option>
                                            <option value="Service" {{ old('business_type') === 'Service' ? 'selected' : '' }}>Service</option>
                                            <option value="Online Store" {{ old('business_type') === 'Online Store' ? 'selected' : '' }}>Online Store</option>
                                            <option value="Other" {{ old('business_type') === 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        @error('business_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="business_address" class="form-label">Business Address *</label>
                                        <textarea class="form-control @error('business_address') is-invalid @enderror"
                                                  id="business_address" name="business_address" rows="3" required>{{ old('business_address') }}</textarea>
                                        @error('business_address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="contact_person" class="form-label">Contact Person *</label>
                                                <input type="text" class="form-control @error('contact_person') is-invalid @enderror"
                                                       id="contact_person" name="contact_person" value="{{ old('contact_person') }}" required>
                                                @error('contact_person')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="contact_phone" class="form-label">Contact Phone *</label>
                                                <input type="tel" class="form-control @error('contact_phone') is-invalid @enderror"
                                                       id="contact_phone" name="contact_phone" value="{{ old('contact_phone') }}"
                                                       placeholder="254XXXXXXXXX" required>
                                                @error('contact_phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Additional Contact Details -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="alternative_phone" class="form-label">Alternative Phone</label>
                                                <input type="tel" class="form-control @error('alternative_phone') is-invalid @enderror"
                                                       id="alternative_phone" name="alternative_phone" value="{{ old('alternative_phone') }}"
                                                       placeholder="254XXXXXXXXX">
                                                @error('alternative_phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="whatsapp_number" class="form-label">WhatsApp Number</label>
                                                <input type="tel" class="form-control @error('whatsapp_number') is-invalid @enderror"
                                                       id="whatsapp_number" name="whatsapp_number" value="{{ old('whatsapp_number') }}"
                                                       placeholder="254XXXXXXXXX">
                                                @error('whatsapp_number')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Business Registration Details -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="business_registration_number" class="form-label">Business Registration Number *</label>
                                                <input type="text" class="form-control @error('business_registration_number') is-invalid @enderror"
                                                       id="business_registration_number" name="business_registration_number" value="{{ old('business_registration_number') }}" required>
                                                @error('business_registration_number')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="kra_pin" class="form-label">KRA PIN *</label>
                                                <input type="text" class="form-control @error('kra_pin') is-invalid @enderror"
                                                       id="kra_pin" name="kra_pin" value="{{ old('kra_pin') }}"
                                                       placeholder="AXXXXXXXXX" required>
                                                @error('kra_pin')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="business_start_date" class="form-label">Business Start Date *</label>
                                                <input type="date" class="form-control @error('business_start_date') is-invalid @enderror"
                                                       id="business_start_date" name="business_start_date" value="{{ old('business_start_date') }}"
                                                       max="{{ date('Y-m-d') }}" required>
                                                @error('business_start_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="number_of_employees" class="form-label">Number of Employees *</label>
                                                <select class="form-select @error('number_of_employees') is-invalid @enderror"
                                                        id="number_of_employees" name="number_of_employees" required>
                                                    <option value="">Select Range</option>
                                                    <option value="1" {{ old('number_of_employees') == '1' ? 'selected' : '' }}>1 (Solo)</option>
                                                    <option value="2-5" {{ old('number_of_employees') == '2-5' ? 'selected' : '' }}>2-5 employees</option>
                                                    <option value="6-10" {{ old('number_of_employees') == '6-10' ? 'selected' : '' }}>6-10 employees</option>
                                                    <option value="11-50" {{ old('number_of_employees') == '11-50' ? 'selected' : '' }}>11-50 employees</option>
                                                    <option value="51+" {{ old('number_of_employees') == '51+' ? 'selected' : '' }}>51+ employees</option>
                                                </select>
                                                @error('number_of_employees')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="business_description" class="form-label">Business Description *</label>
                                        <textarea class="form-control @error('business_description') is-invalid @enderror"
                                                  id="business_description" name="business_description" rows="3"
                                                  placeholder="Describe your business, products, and services... (minimum 10 characters)"
                                                  minlength="10" required>{{ old('business_description') }}</textarea>
                                        <small class="form-text text-muted">Please provide a detailed description of your business (minimum 10 characters)</small>
                                        @error('business_description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Address Information -->
                                <div class="form-section">
                                    <h4>Address Information</h4>
                                    <div class="mb-3">
                                        <label for="physical_address" class="form-label">Physical Address *</label>
                                        <textarea class="form-control @error('physical_address') is-invalid @enderror"
                                                  id="physical_address" name="physical_address" rows="2"
                                                  placeholder="Street address, building name, floor..." required>{{ old('physical_address') }}</textarea>
                                        @error('physical_address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="postal_address" class="form-label">Postal Address</label>
                                        <input type="text" class="form-control @error('postal_address') is-invalid @enderror"
                                               id="postal_address" name="postal_address" value="{{ old('postal_address') }}"
                                               placeholder="P.O. Box 12345">
                                        @error('postal_address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="city" class="form-label">City/Town *</label>
                                                <input type="text" class="form-control @error('city') is-invalid @enderror"
                                                       id="city" name="city" value="{{ old('city') }}" required>
                                                @error('city')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="county" class="form-label">County *</label>
                                                <select class="form-select @error('county') is-invalid @enderror"
                                                        id="county" name="county" required>
                                                    <option value="">Select County</option>
                                                    <option value="Nairobi" {{ old('county') == 'Nairobi' ? 'selected' : '' }}>Nairobi</option>
                                                    <option value="Mombasa" {{ old('county') == 'Mombasa' ? 'selected' : '' }}>Mombasa</option>
                                                    <option value="Kiambu" {{ old('county') == 'Kiambu' ? 'selected' : '' }}>Kiambu</option>
                                                    <option value="Nakuru" {{ old('county') == 'Nakuru' ? 'selected' : '' }}>Nakuru</option>
                                                    <option value="Kisumu" {{ old('county') == 'Kisumu' ? 'selected' : '' }}>Kisumu</option>
                                                    <option value="Uasin Gishu" {{ old('county') == 'Uasin Gishu' ? 'selected' : '' }}>Uasin Gishu</option>
                                                    <option value="Machakos" {{ old('county') == 'Machakos' ? 'selected' : '' }}>Machakos</option>
                                                    <option value="Kajiado" {{ old('county') == 'Kajiado' ? 'selected' : '' }}>Kajiado</option>
                                                    <option value="Other" {{ old('county') == 'Other' ? 'selected' : '' }}>Other</option>
                                                </select>
                                                @error('county')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="postal_code" class="form-label">Postal Code</label>
                                                <input type="text" class="form-control @error('postal_code') is-invalid @enderror"
                                                       id="postal_code" name="postal_code" value="{{ old('postal_code') }}"
                                                       placeholder="00100">
                                                @error('postal_code')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Required Documents -->
                                <div class="form-section">
                                    <h4>Required Documents *</h4>
                                    <p class="text-muted mb-4">Please upload clear, readable copies of the following documents:</p>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="kra_certificate" class="form-label">KRA Certificate *</label>
                                                <input type="file" class="form-control @error('kra_certificate') is-invalid @enderror"
                                                       id="kra_certificate" name="kra_certificate"
                                                       accept=".pdf,.jpg,.jpeg,.png" required>
                                                <small class="form-text text-muted">Upload your KRA Tax Compliance Certificate (PDF, JPG, PNG - Max 5MB)</small>
                                                @error('kra_certificate')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="certificate_of_registration" class="form-label">Certificate of Registration *</label>
                                                <input type="file" class="form-control @error('certificate_of_registration') is-invalid @enderror"
                                                       id="certificate_of_registration" name="certificate_of_registration"
                                                       accept=".pdf,.jpg,.jpeg,.png" required>
                                                <small class="form-text text-muted">Business Registration Certificate (PDF, JPG, PNG - Max 5MB)</small>
                                                @error('certificate_of_registration')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="id_card_front" class="form-label">National ID Card (Front) *</label>
                                                <input type="file" class="form-control @error('id_card_front') is-invalid @enderror"
                                                       id="id_card_front" name="id_card_front"
                                                       accept=".jpg,.jpeg,.png" required>
                                                <small class="form-text text-muted">Front side of your National ID (JPG, PNG - Max 5MB)</small>
                                                @error('id_card_front')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="id_card_back" class="form-label">National ID Card (Back) *</label>
                                                <input type="file" class="form-control @error('id_card_back') is-invalid @enderror"
                                                       id="id_card_back" name="id_card_back"
                                                       accept=".jpg,.jpeg,.png" required>
                                                <small class="form-text text-muted">Back side of your National ID (JPG, PNG - Max 5MB)</small>
                                                @error('id_card_back')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <strong>Document Requirements:</strong>
                                        <ul class="mb-0 mt-2">
                                            <li>All documents must be clear and readable</li>
                                            <li>Maximum file size: 5MB per document</li>
                                            <li>Accepted formats: PDF, JPG, PNG</li>
                                            <li>Documents will be verified during the approval process</li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Additional Information -->
                                <div class="form-section">
                                    <h4>Additional Information</h4>
                                    <div class="mb-3">
                                        <label for="referral_code" class="form-label">Referral Code (Optional)</label>
                                        <input type="text" class="form-control @error('referral_code') is-invalid @enderror"
                                               id="referral_code" name="referral_code" value="{{ old('referral_code') }}">
                                        @error('referral_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Terms and Conditions -->
                                <div class="form-section">
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input @error('terms') is-invalid @enderror"
                                                   type="checkbox" id="terms" name="terms" required>
                                            <label class="form-check-label" for="terms">
                                                I agree to the <a href="#" target="_blank">Terms and Conditions</a> and
                                                <a href="#" target="_blank">Privacy Policy</a> *
                                            </label>
                                            @error('terms')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn-apply">
                                        <i class="fas fa-paper-plane me-2"></i>Submit Application
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Benefits Sidebar -->
                    <div class="col-lg-4">
                        <div class="merchant-form-card">
                            <h4 class="mb-4">Why Become a Merchant?</h4>
                            <ul class="benefits-list">
                                <li>Start selling immediately after approval</li>
                                <li>Access to our large customer base</li>
                                <li>Secure payment processing</li>
                                <li>Professional store dashboard</li>
                                <li>Marketing and promotional tools</li>
                                <li>24/7 customer support</li>
                                <li>Analytics and reporting</li>
                                <li>Mobile-friendly store management</li>
                            </ul>

                            <div class="mt-4 p-3 bg-light rounded">
                                <h6 class="mb-2">Application Process</h6>
                                <ol class="mb-0">
                                    <li>Fill out the application form</li>
                                    <li>Submit required information</li>
                                    <li>Admin review (24-48 hours)</li>
                                    <li>Approval and account activation</li>
                                    <li>Start selling your products</li>
                                </ol>
                            </div>

                            <div class="mt-4 text-center">
                                <p class="text-muted mb-2">Already have an account?</p>
                                <a href="{{ route('login') }}" class="btn btn-outline-primary">Sign In</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.getElementById('merchantForm');

    form.addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirmation').value;

        if (password !== confirmPassword) {
            e.preventDefault();
            alert('Passwords do not match!');
            return false;
        }

        if (password.length < 8) {
            e.preventDefault();
            alert('Password must be at least 8 characters long!');
            return false;
        }
    });

    // Phone number formatting for Kenyan numbers
    const phoneInputs = ['contact_phone', 'alternative_phone', 'whatsapp_number'];
    phoneInputs.forEach(inputId => {
        const phoneInput = document.getElementById(inputId);
        if (phoneInput) {
            phoneInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');

                // If user starts typing without 254, add it
                if (value.length > 0 && !value.startsWith('254')) {
                    // If they start with 0, replace with 254
                    if (value.startsWith('0')) {
                        value = '254' + value.substring(1);
                    }
                    // If they start with 7, 1, or other valid Kenyan prefixes, add 254
                    else if (value.match(/^[71]/)) {
                        value = '254' + value;
                    }
                }

                // Limit to 12 characters (254 + 9 digits)
                if (value.length > 12) {
                    value = value.substring(0, 12);
                }

                e.target.value = value;
            });
        }
    });

    // File upload validation
    const fileInputs = ['kra_certificate', 'certificate_of_registration', 'id_card_front', 'id_card_back'];
    fileInputs.forEach(inputId => {
        const fileInput = document.getElementById(inputId);
        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Check file size (5MB limit)
                    if (file.size > 5 * 1024 * 1024) {
                        alert('File size must be less than 5MB');
                        e.target.value = '';
                        return;
                    }

                    // Check file type
                    const allowedTypes = {
                        'kra_certificate': ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'],
                        'certificate_of_registration': ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'],
                        'id_card_front': ['image/jpeg', 'image/jpg', 'image/png'],
                        'id_card_back': ['image/jpeg', 'image/jpg', 'image/png']
                    };

                    if (!allowedTypes[inputId].includes(file.type)) {
                        alert('Invalid file type. Please upload the correct file format.');
                        e.target.value = '';
                        return;
                    }
                }
            });
        }
    });

    // KRA PIN validation
    const kraPinInput = document.getElementById('kra_pin');
    if (kraPinInput) {
        kraPinInput.addEventListener('input', function(e) {
            let value = e.target.value.toUpperCase();
            // KRA PIN format: A123456789X
            value = value.replace(/[^A-Z0-9]/g, '');
            if (value.length > 11) {
                value = value.substring(0, 11);
            }
            e.target.value = value;
        });
    }
});
</script>
@endpush

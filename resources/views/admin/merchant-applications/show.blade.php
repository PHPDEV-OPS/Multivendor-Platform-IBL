@extends('admin.layouts.app')

@section('page-title', 'Merchant Application Details')
@section('page-subtitle', 'Review application details and take action')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <a href="{{ route('admin.merchant-applications.index') }}" class="admin-btn">
                    <i class="fas fa-arrow-left"></i> Back to Applications
                </a>
            </div>
            <div class="d-flex gap-2">
                @if($application->status === 'pending')
                    <button type="button" class="admin-btn btn-success" onclick="approveApplication({{ $application->id }})">
                        <i class="fas fa-check"></i> Approve
                    </button>
                    <button type="button" class="admin-btn btn-danger" onclick="rejectApplication({{ $application->id }})">
                        <i class="fas fa-times"></i> Reject
                    </button>
                @elseif($application->status === 'approved')
                    <button type="button" class="admin-btn btn-warning" onclick="suspendApplication({{ $application->id }})">
                        <i class="fas fa-pause"></i> Suspend
                    </button>
                @elseif($application->status === 'suspended')
                    <button type="button" class="admin-btn btn-success" onclick="reactivateApplication({{ $application->id }})">
                        <i class="fas fa-play"></i> Reactivate
                    </button>
                @endif
                <button type="button" class="admin-btn btn-danger" onclick="deleteApplication({{ $application->id }})">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Debug Information -->


        @if(!$application->user)
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Warning:</strong> User account not found for this application. The user may have been deleted or the user_id is invalid.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <!-- Application Details -->
            <div class="col-lg-8">
                <div class="admin-card">
                    <h5 class="mb-4">Application Details</h5>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Application ID</label>
                                <p class="mb-0 fw-bold">#{{ $application->id }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Status</label>
                                <div>
                                    @switch($application->status)
                                        @case('pending')
                                            <span class="status-badge status-pending">Pending Review</span>
                                            @break
                                        @case('approved')
                                            <span class="status-badge status-active">Approved</span>
                                            @break
                                        @case('rejected')
                                            <span class="status-badge status-inactive">Rejected</span>
                                            @break
                                        @case('suspended')
                                            <span class="status-badge status-inactive">Suspended</span>
                                            @break
                                    @endswitch
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Company Name</label>
                                <p class="mb-0 fw-bold">{{ $application->company_name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Business Type</label>
                                <p class="mb-0">{{ $application->business_type ?? 'Not specified' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Tax ID</label>
                                <p class="mb-0">{{ $application->tax_id ?? 'Not provided' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Business License</label>
                                <p class="mb-0">{{ $application->business_license ?? 'Not provided' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted">Business Address</label>
                        <p class="mb-0">{{ $application->business_address }}</p>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Contact Person</label>
                                <p class="mb-0 fw-bold">{{ $application->contact_person }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Contact Phone</label>
                                <p class="mb-0">{{ $application->contact_phone }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted">Contact Email</label>
                        <p class="mb-0">{{ $application->contact_email }}</p>
                    </div>

                    <!-- Additional Contact Details -->
                    @if($application->alternative_phone || $application->whatsapp_number)
                        <div class="row">
                            @if($application->alternative_phone)
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Alternative Phone</label>
                                        <p class="mb-0">{{ $application->alternative_phone }}</p>
                                    </div>
                                </div>
                            @endif
                            @if($application->whatsapp_number)
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">WhatsApp Number</label>
                                        <p class="mb-0">{{ $application->whatsapp_number }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Business Registration Details -->
                    @if($application->business_registration_number || $application->kra_pin)
                        <div class="row">
                            @if($application->business_registration_number)
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Business Registration Number</label>
                                        <p class="mb-0">{{ $application->business_registration_number }}</p>
                                    </div>
                                </div>
                            @endif
                            @if($application->kra_pin)
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">KRA PIN</label>
                                        <p class="mb-0 fw-bold">{{ $application->kra_pin }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Address Information -->
                    @if($application->physical_address)
                        <div class="mb-3">
                            <label class="form-label text-muted">Physical Address</label>
                            <p class="mb-0">{{ $application->physical_address }}</p>
                        </div>
                    @endif

                    @if($application->postal_address || $application->city || $application->county)
                        <div class="row">
                            @if($application->postal_address)
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Postal Address</label>
                                        <p class="mb-0">{{ $application->postal_address }}</p>
                                    </div>
                                </div>
                            @endif
                            @if($application->city)
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">City</label>
                                        <p class="mb-0">{{ $application->city }}</p>
                                    </div>
                                </div>
                            @endif
                            @if($application->county)
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">County</label>
                                        <p class="mb-0">{{ $application->county }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    @if($application->postal_code)
                        <div class="mb-3">
                            <label class="form-label text-muted">Postal Code</label>
                            <p class="mb-0">{{ $application->postal_code }}</p>
                        </div>
                    @endif

                    <!-- Business Details -->
                    @if($application->business_start_date || $application->number_of_employees)
                        <div class="row">
                            @if($application->business_start_date)
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Business Start Date</label>
                                        <p class="mb-0">{{ $application->business_start_date->setTimezone('Africa/Nairobi')->format('F d, Y') }}</p>
                                    </div>
                                </div>
                            @endif
                            @if($application->number_of_employees)
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Number of Employees</label>
                                        <p class="mb-0">{{ $application->number_of_employees }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    @if($application->business_description)
                        <div class="mb-3">
                            <label class="form-label text-muted">Business Description</label>
                            <p class="mb-0">{{ $application->business_description }}</p>
                        </div>
                    @endif

                    @if($application->commission_rate > 0)
                        <div class="mb-3">
                            <label class="form-label text-muted">Commission Rate</label>
                            <p class="mb-0">{{ $application->commission_rate }}%</p>
                        </div>
                    @endif

                    @if($application->rejection_reason)
                        <div class="mb-3">
                            <label class="form-label text-muted">Rejection Reason</label>
                            <div class="alert alert-danger">
                                {{ $application->rejection_reason }}
                            </div>
                        </div>
                    @endif

                    @if($application->bank_details)
                        <div class="mb-3">
                            <label class="form-label text-muted">Bank Details</label>
                            <div class="card bg-light">
                                <div class="card-body">
                                    @foreach($application->bank_details as $key => $value)
                                        <div class="row">
                                            <div class="col-md-4">
                                                <strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong>
                                            </div>
                                            <div class="col-md-8">
                                                {{ $value }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Applied Date</label>
                                <p class="mb-0">
                                    @if($application->created_at)
                                        {{ $application->created_at->setTimezone('Africa/Nairobi')->format('F d, Y \a\t g:i A') }}
                                        <small class="text-muted d-block">East Africa Time (EAT)</small>
                                    @else
                                        Not available
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Last Updated</label>
                                <p class="mb-0">
                                    @if($application->updated_at)
                                        {{ $application->updated_at->setTimezone('Africa/Nairobi')->format('F d, Y \a\t g:i A') }}
                                        <small class="text-muted d-block">East Africa Time (EAT)</small>
                                    @else
                                        Not available
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Required Documents Section -->
                @if($application->kra_certificate || $application->certificate_of_registration || $application->id_card_front || $application->id_card_back)
                    <div class="admin-card mt-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">
                                <i class="fas fa-file-alt me-2"></i>Uploaded Documents
                                <span class="badge bg-info ms-2">Verification Required</span>
                            </h5>
                            <button onclick="downloadAllDocuments()" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-download me-1"></i>Download All
                            </button>
                        </div>

                        <div class="row">
                            @if($application->kra_certificate)
                                <div class="col-md-6 mb-4">
                                    <div class="document-card">
                                        <div class="document-header">
                                            <h6 class="mb-1">
                                                <i class="fas fa-certificate text-primary me-2"></i>KRA Certificate
                                            </h6>
                                            <small class="text-muted">Tax Compliance Certificate</small>
                                        </div>
                                        <div class="document-preview">
                                            @php
                                                $extension = pathinfo($application->kra_certificate, PATHINFO_EXTENSION);
                                                $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png']);
                                            @endphp

                                            @if($isImage)
                                                <img src="{{ asset('storage/' . $application->kra_certificate) }}"
                                                     alt="KRA Certificate"
                                                     class="document-image"
                                                     onclick="openDocumentModal('{{ asset('storage/' . $application->kra_certificate) }}', 'KRA Certificate')">
                                            @else
                                                <div class="pdf-preview" onclick="openDocument('{{ asset('storage/' . $application->kra_certificate) }}')">
                                                    <i class="fas fa-file-pdf text-danger"></i>
                                                    <p class="mb-0">PDF Document</p>
                                                    <small>Click to view</small>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="document-actions">
                                            <a href="{{ asset('storage/' . $application->kra_certificate) }}"
                                               target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye me-1"></i>View
                                            </a>
                                            <a href="{{ asset('storage/' . $application->kra_certificate) }}"
                                               download class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-download me-1"></i>Download
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($application->certificate_of_registration)
                                <div class="col-md-6 mb-4">
                                    <div class="document-card">
                                        <div class="document-header">
                                            <h6 class="mb-1">
                                                <i class="fas fa-building text-success me-2"></i>Certificate of Registration
                                            </h6>
                                            <small class="text-muted">Business Registration Certificate</small>
                                        </div>
                                        <div class="document-preview">
                                            @php
                                                $extension = pathinfo($application->certificate_of_registration, PATHINFO_EXTENSION);
                                                $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png']);
                                            @endphp

                                            @if($isImage)
                                                <img src="{{ asset('storage/' . $application->certificate_of_registration) }}"
                                                     alt="Certificate of Registration"
                                                     class="document-image"
                                                     onclick="openDocumentModal('{{ asset('storage/' . $application->certificate_of_registration) }}', 'Certificate of Registration')">
                                            @else
                                                <div class="pdf-preview" onclick="openDocument('{{ asset('storage/' . $application->certificate_of_registration) }}')">
                                                    <i class="fas fa-file-pdf text-danger"></i>
                                                    <p class="mb-0">PDF Document</p>
                                                    <small>Click to view</small>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="document-actions">
                                            <a href="{{ asset('storage/' . $application->certificate_of_registration) }}"
                                               target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye me-1"></i>View
                                            </a>
                                            <a href="{{ asset('storage/' . $application->certificate_of_registration) }}"
                                               download class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-download me-1"></i>Download
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($application->id_card_front)
                                <div class="col-md-6 mb-4">
                                    <div class="document-card">
                                        <div class="document-header">
                                            <h6 class="mb-1">
                                                <i class="fas fa-id-card text-warning me-2"></i>National ID (Front)
                                            </h6>
                                            <small class="text-muted">Front side of National ID</small>
                                        </div>
                                        <div class="document-preview">
                                            <img src="{{ asset('storage/' . $application->id_card_front) }}"
                                                 alt="National ID Front"
                                                 class="document-image"
                                                 onclick="openDocumentModal('{{ asset('storage/' . $application->id_card_front) }}', 'National ID (Front)')">
                                        </div>
                                        <div class="document-actions">
                                            <a href="{{ asset('storage/' . $application->id_card_front) }}"
                                               target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye me-1"></i>View
                                            </a>
                                            <a href="{{ asset('storage/' . $application->id_card_front) }}"
                                               download class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-download me-1"></i>Download
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($application->id_card_back)
                                <div class="col-md-6 mb-4">
                                    <div class="document-card">
                                        <div class="document-header">
                                            <h6 class="mb-1">
                                                <i class="fas fa-id-card text-warning me-2"></i>National ID (Back)
                                            </h6>
                                            <small class="text-muted">Back side of National ID</small>
                                        </div>
                                        <div class="document-preview">
                                            <img src="{{ asset('storage/' . $application->id_card_back) }}"
                                                 alt="National ID Back"
                                                 class="document-image"
                                                 onclick="openDocumentModal('{{ asset('storage/' . $application->id_card_back) }}', 'National ID (Back)')">
                                        </div>
                                        <div class="document-actions">
                                            <a href="{{ asset('storage/' . $application->id_card_back) }}"
                                               target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye me-1"></i>View
                                            </a>
                                            <a href="{{ asset('storage/' . $application->id_card_back) }}"
                                               download class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-download me-1"></i>Download
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="alert alert-info mt-3">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Document Verification:</strong> Please review all uploaded documents carefully before approving the application.
                            Ensure all documents are clear, valid, and match the provided business information.
                        </div>
                    </div>
                @endif
            </div>

            <!-- Applicant Information -->
            <div class="col-lg-4">
                <div class="admin-card">
                    <h5 class="mb-4">Applicant Information</h5>

                    @if($application->user)
                        <div class="text-center mb-4">
                            <div class="avatar-lg mx-auto mb-3">
                                <div class="avatar-title bg-light rounded-circle">
                                    <span class="fs-1">{{ strtoupper(substr($application->user->name ?? 'U', 0, 1)) }}</span>
                                </div>
                            </div>
                            <h5 class="mb-1">{{ $application->user->name ?? 'Unknown User' }}</h5>
                            <p class="text-muted mb-0">{{ $application->user->email ?? 'No email' }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted">User ID</label>
                            <p class="mb-0">#{{ $application->user->id ?? 'N/A' }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted">Current Role</label>
                            <p class="mb-0">
                                <span class="badge bg-{{ ($application->user->role ?? '') === 'vendor' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($application->user->role ?? 'unknown') }}
                                </span>
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted">Email Verified</label>
                            <p class="mb-0">
                                @if($application->user->email_verified_at)
                                    <span class="badge bg-success">Verified</span>
                                @else
                                    <span class="badge bg-warning">Not Verified</span>
                                @endif
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted">Member Since</label>
                            <p class="mb-0">
                                @if($application->user->created_at)
                                    {{ $application->user->created_at->setTimezone('Africa/Nairobi')->format('F d, Y \a\t g:i A') }}
                                    <small class="text-muted d-block">East Africa Time (EAT)</small>
                                @else
                                    Not available
                                @endif
                            </p>
                        </div>
                                         @else
                         <div class="alert alert-warning mb-4">
                             <strong>Warning:</strong> User account not found for this application.
                         </div>

                         <!-- Contact Information from Vendor Profile -->
                         <div class="mb-3">
                             <label class="form-label text-muted">Contact Email</label>
                             <p class="mb-0">{{ $application->contact_email }}</p>
                         </div>

                         <div class="mb-3">
                             <label class="form-label text-muted">Contact Person</label>
                             <p class="mb-0">{{ $application->contact_person }}</p>
                         </div>

                         <div class="mb-3">
                             <label class="form-label text-muted">Contact Phone</label>
                             <p class="mb-0">{{ $application->contact_phone }}</p>
                         </div>
                     @endif

                    @if($application->vendor_code)
                        <div class="mb-3">
                            <label class="form-label text-muted">Vendor Code</label>
                            <p class="mb-0 fw-bold">{{ $application->vendor_code }}</p>
                        </div>
                    @endif

                                         <div class="d-grid gap-2">
                         @if($application->user && $application->user->email)
                             <a href="mailto:{{ $application->user->email }}" class="admin-btn">
                                 <i class="fas fa-envelope"></i> Send Email to User
                             </a>
                         @endif
                         @if($application->contact_email)
                             <a href="mailto:{{ $application->contact_email }}" class="admin-btn">
                                 <i class="fas fa-envelope"></i> Send Email to Contact
                             </a>
                         @endif
                         @if($application->contact_phone)
                             <a href="tel:{{ $application->contact_phone }}" class="admin-btn btn-outline-secondary">
                                 <i class="fas fa-phone"></i> Call Contact
                             </a>
                         @endif
                     </div>
                </div>

                <!-- Store Assets -->
                @if($application->store_logo || $application->store_banner)
                    <div class="admin-card mt-4">
                        <h5 class="mb-4">Store Assets</h5>

                        @if($application->store_logo)
                            <div class="mb-3">
                                <label class="form-label text-muted">Store Logo</label>
                                <div class="text-center">
                                    <img src="{{ asset('uploads/' . $application->store_logo) }}"
                                         alt="Store Logo" class="img-fluid rounded" style="max-height: 100px;">
                                </div>
                            </div>
                        @endif

                        @if($application->store_banner)
                            <div class="mb-3">
                                <label class="form-label text-muted">Store Banner</label>
                                <div class="text-center">
                                    <img src="{{ asset('uploads/' . $application->store_banner) }}"
                                         alt="Store Banner" class="img-fluid rounded" style="max-height: 100px;">
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Rejection Modal -->
<div class="modal fade" id="rejectionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject Application</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="rejectionForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="rejection_reason" class="form-label">Rejection Reason</label>
                        <textarea class="form-control" id="rejection_reason" name="rejection_reason"
                                  rows="4" required placeholder="Please provide a reason for rejection..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="admin-btn">Reject Application</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Document Viewer Modal -->
<div class="modal fade" id="documentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="documentModalTitle">Document Viewer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="documentModalImage" src="" alt="Document" class="img-fluid" style="max-height: 70vh;">
            </div>
            <div class="modal-footer">
                <a id="documentModalDownload" href="" download class="btn btn-primary">
                    <i class="fas fa-download me-1"></i>Download
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function approveApplication(id) {
    if (confirm('Are you sure you want to approve this merchant application?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/merchant-applications/${id}/approve`;

        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'PATCH';

        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        form.submit();
    }
}

function rejectApplication(id) {
    const modal = new bootstrap.Modal(document.getElementById('rejectionModal'));
    const form = document.getElementById('rejectionForm');
    form.action = `/admin/merchant-applications/${id}/reject`;
    modal.show();
}

function suspendApplication(id) {
    if (confirm('Are you sure you want to suspend this merchant account?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/merchant-applications/${id}/suspend`;

        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'PATCH';

        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        form.submit();
    }
}

function reactivateApplication(id) {
    if (confirm('Are you sure you want to reactivate this merchant account?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/merchant-applications/${id}/reactivate`;

        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'PATCH';

        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        form.submit();
    }
}

function deleteApplication(id) {
    if (confirm('Are you sure you want to delete this merchant application? This action cannot be undone.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/merchant-applications/${id}`;

        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';

        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        form.submit();
    }
}

// Document viewing functions
function openDocumentModal(imageSrc, title) {
    document.getElementById('documentModalTitle').textContent = title;
    document.getElementById('documentModalImage').src = imageSrc;
    document.getElementById('documentModalDownload').href = imageSrc;

    const modal = new bootstrap.Modal(document.getElementById('documentModal'));
    modal.show();
}

function openDocument(documentUrl) {
    window.open(documentUrl, '_blank');
}

function downloadAllDocuments() {
    const documents = [
        @if($application->kra_certificate)
            '{{ asset('storage/' . $application->kra_certificate) }}',
        @endif
        @if($application->certificate_of_registration)
            '{{ asset('storage/' . $application->certificate_of_registration) }}',
        @endif
        @if($application->id_card_front)
            '{{ asset('storage/' . $application->id_card_front) }}',
        @endif
        @if($application->id_card_back)
            '{{ asset('storage/' . $application->id_card_back) }}',
        @endif
    ];

    documents.forEach((url, index) => {
        setTimeout(() => {
            const link = document.createElement('a');
            link.href = url;
            link.download = '';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }, index * 500); // Delay each download by 500ms
    });
}
</script>

<style>
.avatar-lg {
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--base_color_10);
    border-radius: 50%;
    margin: 0 auto;
}

.avatar-lg .avatar-title {
    font-size: 2rem;
    font-weight: bold;
    color: var(--base_color);
}

.btn-outline-secondary {
    border-color: var(--border_color);
    color: var(--text_color);
}

.btn-outline-secondary:hover {
    background-color: var(--border_color);
    border-color: var(--border_color);
    color: var(--text_color);
}

/* Document Cards Styles */
.document-card {
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 15px;
    background: #fff;
    transition: all 0.3s ease;
    height: 100%;
}

.document-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    border-color: #007bff;
}

.document-header {
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid #f1f3f4;
}

.document-header h6 {
    color: #333;
    margin-bottom: 5px;
}

.document-preview {
    margin-bottom: 15px;
    text-align: center;
    min-height: 150px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    border-radius: 6px;
    position: relative;
    overflow: hidden;
}

.document-image {
    max-width: 100%;
    max-height: 150px;
    object-fit: contain;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.document-image:hover {
    transform: scale(1.05);
}

.pdf-preview {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 150px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.pdf-preview:hover {
    background: #e9ecef;
}

.pdf-preview i {
    font-size: 3rem;
    margin-bottom: 10px;
}

.document-actions {
    display: flex;
    gap: 8px;
    justify-content: center;
}

.document-actions .btn {
    flex: 1;
    max-width: 100px;
}

/* Document verification badge */
.badge.bg-info {
    background-color: #17a2b8 !important;
}

/* Modal improvements */
#documentModal .modal-body {
    padding: 20px;
    background: #f8f9fa;
}

#documentModal .modal-body img {
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .document-card {
        margin-bottom: 20px;
    }

    .document-actions {
        flex-direction: column;
    }

    .document-actions .btn {
        max-width: none;
    }
}
</style>
@endpush

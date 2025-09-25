@extends('admin.layouts.app')

@section('page-title', 'Merchant Applications')
@section('page-subtitle', 'Manage vendor applications and approvals')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="admin-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0">Merchant Applications</h5>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.merchant-applications.export') }}" class="admin-btn">
                        <i class="fas fa-download"></i> Export CSV
                    </a>
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

            <!-- Filters -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <select class="form-select" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" id="searchInput" placeholder="Search by name or company..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control" id="dateFilter" placeholder="Filter by date" value="{{ request('date') }}">
                </div>
                <div class="col-md-3">
                    <button class="admin-btn w-100" onclick="clearFilters()">
                        <i class="fas fa-times"></i> Clear Filters
                    </button>
                </div>
            </div>

            <!-- Applications Table -->
            <div class="admin-table">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Applicant</th>
                            <th>Company</th>
                            <th>Business Type</th>
                            <th>Contact</th>
                            <th>Status</th>
                            <th>Applied Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applications as $application)
                            <tr>
                                <td>{{ $application->id }}</td>
                                <td>
                                    @if($application->user)
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-3">
                                                <div class="avatar-title bg-light rounded-circle">
                                                    {{ strtoupper(substr($application->user->name ?? 'U', 0, 1)) }}
                                                </div>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $application->user->name ?? 'Unknown User' }}</h6>
                                                <small class="text-muted">{{ $application->user->email ?? 'No email' }}</small>
                                            </div>
                                        </div>
                                    @else
                                        <div class="text-muted">
                                            <i class="fas fa-exclamation-triangle"></i> User not found
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $application->company_name }}</strong>
                                    @if($application->vendor_code)
                                        <br><small class="text-muted">Code: {{ $application->vendor_code }}</small>
                                    @endif
                                </td>
                                <td>{{ $application->business_type ?? 'N/A' }}</td>
                                <td>
                                    <div>
                                        <strong>{{ $application->contact_person }}</strong>
                                        <br><small class="text-muted">{{ $application->contact_phone }}</small>
                                    </div>
                                </td>
                                <td>
                                    @switch($application->status)
                                        @case('pending')
                                            <span class="status-badge status-pending">Pending</span>
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
                                </td>
                                <td>
                                    @if($application->created_at)
                                        {{ $application->created_at->setTimezone('Africa/Nairobi')->format('M d, Y g:i A') }}
                                        <small class="text-muted d-block">EAT</small>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.merchant-applications.show', $application) }}"
                                           class="btn btn-sm btn-outline-primary" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        @if($application->status === 'pending')
                                            <button type="button" class="btn btn-sm btn-outline-success"
                                                    onclick="approveApplication({{ $application->id }})" title="Approve">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                    onclick="rejectApplication({{ $application->id }})" title="Reject">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @elseif($application->status === 'approved')
                                            <button type="button" class="btn btn-sm btn-outline-warning"
                                                    onclick="suspendApplication({{ $application->id }})" title="Suspend">
                                                <i class="fas fa-pause"></i>
                                            </button>
                                        @elseif($application->status === 'suspended')
                                            <button type="button" class="btn btn-sm btn-outline-success"
                                                    onclick="reactivateApplication({{ $application->id }})" title="Reactivate">
                                                <i class="fas fa-play"></i>
                                            </button>
                                        @endif

                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                                onclick="deleteApplication({{ $application->id }})" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                        <h5>No merchant applications found</h5>
                                        <p>There are currently no merchant applications to review.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($applications->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $applications->links() }}
                </div>
            @endif
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

@endsection

@push('scripts')
<script>
// Filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const statusFilter = document.getElementById('statusFilter');
    const searchInput = document.getElementById('searchInput');
    const dateFilter = document.getElementById('dateFilter');

    // Apply filters
    function applyFilters() {
        const status = statusFilter.value;
        const search = searchInput.value;
        const date = dateFilter.value;

        let url = new URL(window.location);

        if (status) url.searchParams.set('status', status);
        if (search) url.searchParams.set('search', search);
        if (date) url.searchParams.set('date', date);

        window.location.href = url.toString();
    }

    statusFilter.addEventListener('change', applyFilters);
    dateFilter.addEventListener('change', applyFilters);

    searchInput.addEventListener('keyup', function(e) {
        if (e.key === 'Enter') {
            applyFilters();
        }
    });
});

function clearFilters() {
    window.location.href = window.location.pathname;
}

// Application actions
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
</script>
@endpush

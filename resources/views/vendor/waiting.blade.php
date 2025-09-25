@extends('layouts.main')

@section('content')
<style>
.waiting-section {
    min-height: 100vh;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 0;
}

.waiting-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    padding: 3rem;
    text-align: center;
    max-width: 600px;
    width: 100%;
    margin: 0 auto;
}

.waiting-icon {
    width: 120px;
    height: 120px;
    background: linear-gradient(135deg, #ff6f20, #ff8f40);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 2rem;
    color: white;
    font-size: 3rem;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        transform: scale(1);
        box-shadow: 0 0 0 0 rgba(255, 111, 32, 0.7);
    }
    70% {
        transform: scale(1.05);
        box-shadow: 0 0 0 20px rgba(255, 111, 32, 0);
    }
    100% {
        transform: scale(1);
        box-shadow: 0 0 0 0 rgba(255, 111, 32, 0);
    }
}

.waiting-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 1rem;
}

.waiting-subtitle {
    font-size: 1.2rem;
    color: #7f8c8d;
    margin-bottom: 2rem;
    line-height: 1.6;
}

.status-badge {
    display: inline-block;
    padding: 0.5rem 1.5rem;
    border-radius: 25px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 2rem;
}

.status-pending {
    background: #fff3cd;
    color: #856404;
    border: 2px solid #ffeaa7;
}

.status-rejected {
    background: #f8d7da;
    color: #721c24;
    border: 2px solid #f5c6cb;
}

.status-suspended {
    background: #d1ecf1;
    color: #0c5460;
    border: 2px solid #bee5eb;
}

.application-details {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 2rem;
    margin: 2rem 0;
    text-align: left;
}

.application-details h4 {
    color: #2c3e50;
    margin-bottom: 1rem;
    font-weight: 600;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 0;
    border-bottom: 1px solid #e9ecef;
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-label {
    font-weight: 600;
    color: #2c3e50;
}

.detail-value {
    color: #7f8c8d;
}

.rejection-reason {
    background: #f8d7da;
    border: 1px solid #f5c6cb;
    border-radius: 10px;
    padding: 1rem;
    margin: 1rem 0;
    color: #721c24;
}

.contact-info {
    background: #d1ecf1;
    border: 1px solid #bee5eb;
    border-radius: 10px;
    padding: 1.5rem;
    margin: 2rem 0;
}

.contact-info h5 {
    color: #0c5460;
    margin-bottom: 1rem;
    font-weight: 600;
}

.contact-info p {
    color: #0c5460;
    margin-bottom: 0.5rem;
}

.action-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 2rem;
}

.btn-primary-custom {
    background: #ff6f20;
    color: white;
    border: none;
    padding: 12px 25px;
    border-radius: 25px;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.btn-primary-custom:hover {
    background: #e55a1a;
    color: white;
    transform: translateY(-2px);
    text-decoration: none;
}

.btn-secondary-custom {
    background: transparent;
    color: #ff6f20;
    border: 2px solid #ff6f20;
    padding: 10px 25px;
    border-radius: 25px;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.btn-secondary-custom:hover {
    background: #ff6f20;
    color: white;
    transform: translateY(-2px);
    text-decoration: none;
}

.progress-bar {
    width: 100%;
    height: 8px;
    background: #e9ecef;
    border-radius: 4px;
    overflow: hidden;
    margin: 1rem 0;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #ff6f20, #ff8f40);
    border-radius: 4px;
    animation: progress 2s ease-in-out infinite;
}

@keyframes progress {
    0% { width: 0%; }
    50% { width: 70%; }
    100% { width: 0%; }
}

@media (max-width: 768px) {
    .waiting-card {
        padding: 2rem;
        margin: 1rem;
    }
    
    .waiting-title {
        font-size: 2rem;
    }
    
    .waiting-subtitle {
        font-size: 1rem;
    }
    
    .action-buttons {
        flex-direction: column;
        align-items: center;
    }
    
    .btn-primary-custom,
    .btn-secondary-custom {
        width: 100%;
        max-width: 300px;
        text-align: center;
    }
}
</style>

<div class="waiting-section">
    <div class="waiting-card">
        <div class="waiting-icon">
            <i class="fas fa-clock"></i>
        </div>
        
        <h1 class="waiting-title">Application Under Review</h1>
        <p class="waiting-subtitle">
            Thank you for your interest in becoming a merchant! Your application is currently being reviewed by our team.
        </p>
        
        @if($vendorProfile)
            <div class="status-badge status-{{ $vendorProfile->status }}">
                {{ ucfirst($vendorProfile->status) }}
            </div>
            
            @if($vendorProfile->status === 'pending')
                <div class="progress-bar">
                    <div class="progress-fill"></div>
                </div>
                <p class="text-muted">We typically review applications within 24-48 hours</p>
            @endif
            
            @if($vendorProfile->status === 'rejected' && $vendorProfile->rejection_reason)
                <div class="rejection-reason">
                    <strong>Reason for Rejection:</strong><br>
                    {{ $vendorProfile->rejection_reason }}
                </div>
            @endif
            
            @if($vendorProfile->status === 'suspended')
                <div class="rejection-reason">
                    <strong>Account Suspended:</strong><br>
                    Your account has been temporarily suspended. Please contact support for more information.
                </div>
            @endif
            
            <div class="application-details">
                <h4>Application Details</h4>
                <div class="detail-row">
                    <span class="detail-label">Company Name:</span>
                    <span class="detail-value">{{ $vendorProfile->company_name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Contact Person:</span>
                    <span class="detail-value">{{ $vendorProfile->contact_person }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Contact Email:</span>
                    <span class="detail-value">{{ $vendorProfile->contact_email }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Contact Phone:</span>
                    <span class="detail-value">{{ $vendorProfile->contact_phone }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Business Type:</span>
                    <span class="detail-value">{{ $vendorProfile->business_type ?? 'Not specified' }}</span>
                </div>
                                 <div class="detail-row">
                     <span class="detail-label">Applied Date:</span>
                     <span class="detail-value">{{ $vendorProfile->created_at ? $vendorProfile->created_at->format('F d, Y \a\t g:i A') : 'Not available' }}</span>
                 </div>
            </div>
        @else
            <div class="status-badge status-pending">
                No Profile Found
            </div>
            <p class="text-muted">Please complete your vendor profile to proceed with the application.</p>
        @endif
        
        <div class="contact-info">
            <h5><i class="fas fa-info-circle me-2"></i>Need Help?</h5>
            <p>If you have any questions about your application or need assistance, please don't hesitate to contact our support team.</p>
            <p><strong>Email:</strong> support@tununue.com</p>
            <p><strong>Phone:</strong> +254 700 000 000</p>
        </div>
        
        <div class="action-buttons">
            @if($vendorProfile && $vendorProfile->status === 'rejected')
                <a href="{{ route('merchant.apply') }}" class="btn-primary-custom">
                    <i class="fas fa-edit me-2"></i>Update Application
                </a>
            @endif
            
            <a href="{{ route('home') }}" class="btn-secondary-custom">
                <i class="fas fa-home me-2"></i>Back to Home
            </a>
            
            <a href="mailto:support@tununue.com" class="btn-secondary-custom">
                <i class="fas fa-envelope me-2"></i>Contact Support
            </a>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-refresh the page every 5 minutes to check for status updates
    setTimeout(function() {
        window.location.reload();
    }, 300000); // 5 minutes
    
    // Add some interactive elements
    const statusBadge = document.querySelector('.status-badge');
    if (statusBadge) {
        statusBadge.addEventListener('click', function() {
            // Show more detailed status information
            alert('Status: ' + this.textContent + '\n\nOur team is working to review your application as quickly as possible.');
        });
    }
});
</script>
@endpush

@extends('admin.layouts.app')

@section('page-title', 'Support Center')
@section('page-subtitle', 'Get help and manage support tickets')

@section('content')
<div class="container-fluid">
    <!-- Support Overview Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="admin-stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-primary">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    <div class="stats-content">
                        <h4>24</h4>
                        <p>Open Tickets</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="admin-stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stats-content">
                        <h4>156</h4>
                        <p>Resolved</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="admin-stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-warning">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stats-content">
                        <h4>2.3h</h4>
                        <p>Avg Response</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="admin-stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-info">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="stats-content">
                        <h4>4.8</h4>
                        <p>Satisfaction</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Support Tickets -->
        <div class="col-md-8">
            <div class="admin-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Support Tickets</h5>
                    <button class="admin-btn admin-btn-primary" data-bs-toggle="modal" data-bs-target="#newTicketModal">
                        <i class="fas fa-plus"></i> New Ticket
                    </button>
                </div>
                <div class="card-body">
                    <!-- Filters -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <select class="form-select">
                                <option>All Status</option>
                                <option>Open</option>
                                <option>In Progress</option>
                                <option>Resolved</option>
                                <option>Closed</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select">
                                <option>All Priority</option>
                                <option>Low</option>
                                <option>Medium</option>
                                <option>High</option>
                                <option>Urgent</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="Search tickets...">
                        </div>
                        <div class="col-md-2">
                            <button class="admin-btn admin-btn-secondary w-100">Filter</button>
                        </div>
                    </div>

                    <!-- Tickets Table -->
                    <div class="table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Ticket ID</th>
                                    <th>Subject</th>
                                    <th>Status</th>
                                    <th>Priority</th>
                                    <th>Created</th>
                                    <th>Last Update</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#TKT-001</td>
                                    <td>Payment processing issue</td>
                                    <td><span class="status-badge status-open">Open</span></td>
                                    <td><span class="status-badge status-high">High</span></td>
                                    <td>2 hours ago</td>
                                    <td>1 hour ago</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">View</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#TKT-002</td>
                                    <td>Product listing not showing</td>
                                    <td><span class="status-badge status-progress">In Progress</span></td>
                                    <td><span class="status-badge status-medium">Medium</span></td>
                                    <td>1 day ago</td>
                                    <td>3 hours ago</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">View</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#TKT-003</td>
                                    <td>Commission calculation query</td>
                                    <td><span class="status-badge status-resolved">Resolved</span></td>
                                    <td><span class="status-badge status-low">Low</span></td>
                                    <td>3 days ago</td>
                                    <td>1 day ago</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">View</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#TKT-004</td>
                                    <td>Shipping zone configuration</td>
                                    <td><span class="status-badge status-closed">Closed</span></td>
                                    <td><span class="status-badge status-medium">Medium</span></td>
                                    <td>1 week ago</td>
                                    <td>2 days ago</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">View</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <nav class="mt-3">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Previous</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Quick Actions & FAQ -->
        <div class="col-md-4">
            <!-- Quick Actions -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="fas fa-book me-3 text-primary"></i>
                            <div>
                                <h6 class="mb-1">Knowledge Base</h6>
                                <small class="text-muted">Browse help articles</small>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="fas fa-video me-3 text-success"></i>
                            <div>
                                <h6 class="mb-1">Video Tutorials</h6>
                                <small class="text-muted">Watch how-to videos</small>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="fas fa-phone me-3 text-warning"></i>
                            <div>
                                <h6 class="mb-1">Live Chat</h6>
                                <small class="text-muted">Chat with support</small>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="fas fa-envelope me-3 text-info"></i>
                            <div>
                                <h6 class="mb-1">Email Support</h6>
                                <small class="text-muted">support@tununue.com</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- FAQ -->
            <div class="admin-card">
                <div class="card-header">
                    <h6 class="mb-0">Frequently Asked Questions</h6>
                </div>
                <div class="card-body">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    How do I add new products?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Go to Products > Add New Product and fill in all required information including images, pricing, and inventory details.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    When do I receive payments?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Payments are processed weekly on Fridays. You'll receive your earnings minus platform fees within 3-5 business days.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    How do I handle returns?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Customers can initiate returns within 30 days. You'll be notified and can approve or reject the return request.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- New Ticket Modal -->
<div class="modal fade" id="newTicketModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Support Ticket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Subject *</label>
                                <input type="text" class="form-control" placeholder="Brief description of your issue">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Priority *</label>
                                <select class="form-select">
                                    <option>Low</option>
                                    <option>Medium</option>
                                    <option>High</option>
                                    <option>Urgent</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Category *</label>
                                <select class="form-select">
                                    <option>Technical Issue</option>
                                    <option>Payment & Billing</option>
                                    <option>Product Management</option>
                                    <option>Order Management</option>
                                    <option>Account Settings</option>
                                    <option>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Related Order (Optional)</label>
                                <input type="text" class="form-control" placeholder="Order ID if applicable">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Description *</label>
                        <textarea class="form-control" rows="5" placeholder="Please provide detailed information about your issue..."></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Attachments</label>
                        <input type="file" class="form-control" multiple>
                        <small class="text-muted">You can attach screenshots, documents, or other files (max 5MB each)</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="admin-btn admin-btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="admin-btn admin-btn-primary">Submit Ticket</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Add any JavaScript for ticket management functionality
document.addEventListener('DOMContentLoaded', function() {
    // Example: Auto-save draft tickets
    const form = document.querySelector('#newTicketModal form');
    const inputs = form.querySelectorAll('input, textarea, select');
    
    inputs.forEach(input => {
        input.addEventListener('change', function() {
            // Save to localStorage as draft
            localStorage.setItem('ticketDraft', JSON.stringify({
                subject: form.querySelector('input[placeholder*="Subject"]').value,
                description: form.querySelector('textarea').value,
                category: form.querySelector('select').value,
                priority: form.querySelectorAll('select')[1].value
            }));
        });
    });
});
</script>
@endpush

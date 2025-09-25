@extends('layouts.main')

@section('content')
<style>
:root {
    --primary-color: #ff6f20;
    --primary-dark: #e55a1a;
    --secondary-color: #2c3e50;
    --accent-color: #3498db;
    --success-color: #27ae60;
    --warning-color: #f39c12;
    --light-bg: #f8f9fa;
    --dark-bg: #2c3e50;
    --text-dark: #2c3e50;
    --text-light: #7f8c8d;
    --border-color: #ecf0f1;
    --shadow: 0 10px 30px rgba(0,0,0,0.1);
    --shadow-hover: 0 20px 40px rgba(0,0,0,0.15);
}

/* Hero Section */
.hero-section {
    background: linear-gradient(135deg, var(--primary-color) 0%, #ff8f40 50%, #ffa726 100%);
    color: white;
    padding: 120px 0 80px;
    position: relative;
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}

.hero-content {
    position: relative;
    z-index: 2;
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
    line-height: 1.2;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.hero-subtitle {
    font-size: 1.3rem;
    margin-bottom: 2rem;
    opacity: 0.95;
    line-height: 1.6;
}

.hero-stats {
    display: flex;
    justify-content: center;
    gap: 3rem;
    margin: 3rem 0;
    flex-wrap: wrap;
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    display: block;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.9;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.cta-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 2rem;
}

.btn-primary-custom {
    background: white;
    color: var(--primary-color);
    border: none;
    padding: 15px 35px;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 1px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.btn-primary-custom:hover {
    background: var(--primary-dark);
    color: white;
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.3);
    text-decoration: none;
}

.btn-secondary-custom {
    background: transparent;
    color: white;
    border: 2px solid white;
    padding: 13px 30px;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.btn-secondary-custom:hover {
    background: white;
    color: var(--primary-color);
    transform: translateY(-3px);
    text-decoration: none;
}

/* Benefits Section */
.benefits-section {
    padding: 100px 0;
    background: white;
}

.section-header {
    text-align: center;
    margin-bottom: 4rem;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 1rem;
}

.section-subtitle {
    font-size: 1.1rem;
    color: var(--text-light);
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.6;
}

.benefits-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
    margin-top: 3rem;
}

.benefit-card {
    background: white;
    padding: 2.5rem 2rem;
    border-radius: 20px;
    text-align: center;
    box-shadow: var(--shadow);
    transition: all 0.3s ease;
    border: 1px solid var(--border-color);
    position: relative;
    overflow: hidden;
}

.benefit-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.benefit-card:hover {
    transform: translateY(-10px);
    box-shadow: var(--shadow-hover);
}

.benefit-card:hover::before {
    transform: scaleX(1);
}

.benefit-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    color: white;
    font-size: 2rem;
    transition: all 0.3s ease;
}

.benefit-card:hover .benefit-icon {
    transform: scale(1.1) rotate(5deg);
}

.benefit-title {
    font-size: 1.3rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 1rem;
}

.benefit-description {
    color: var(--text-light);
    line-height: 1.6;
}

/* How It Works Section */
.how-it-works {
    padding: 100px 0;
    background: var(--light-bg);
}

.steps-container {
    position: relative;
    max-width: 1000px;
    margin: 0 auto;
}

.steps-container::before {
    content: '';
    position: absolute;
    top: 100px;
    left: 50px;
    right: 50px;
    height: 2px;
    background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
    z-index: 1;
}

.step-item {
    display: flex;
    align-items: center;
    margin-bottom: 3rem;
    position: relative;
    z-index: 2;
}

.step-number {
    width: 80px;
    height: 80px;
    background: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: 700;
    margin-right: 2rem;
    flex-shrink: 0;
    box-shadow: 0 5px 15px rgba(255, 111, 32, 0.3);
}

.step-content {
    background: white;
    padding: 2rem;
    border-radius: 15px;
    box-shadow: var(--shadow);
    flex: 1;
}

.step-title {
    font-size: 1.3rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
}

.step-description {
    color: var(--text-light);
    line-height: 1.6;
}

/* Pricing Section */
.pricing-section {
    padding: 100px 0;
    background: white;
}

.pricing-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-top: 3rem;
}

.pricing-card {
    background: white;
    border-radius: 20px;
    padding: 2.5rem 2rem;
    text-align: center;
    box-shadow: var(--shadow);
    transition: all 0.3s ease;
    border: 2px solid transparent;
    position: relative;
}

.pricing-card.featured {
    border-color: var(--primary-color);
    transform: scale(1.05);
}

.pricing-card.featured::before {
    content: 'Most Popular';
    position: absolute;
    top: -15px;
    left: 50%;
    transform: translateX(-50%);
    background: var(--primary-color);
    color: white;
    padding: 8px 20px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
}

.pricing-card:hover {
    transform: translateY(-10px);
    box-shadow: var(--shadow-hover);
}

.pricing-card.featured:hover {
    transform: scale(1.05) translateY(-10px);
}

.pricing-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 1rem;
}

.pricing-price {
    font-size: 3rem;
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 0.5rem;
}

.pricing-period {
    color: var(--text-light);
    margin-bottom: 2rem;
}

.pricing-features {
    list-style: none;
    padding: 0;
    margin-bottom: 2rem;
}

.pricing-features li {
    padding: 0.5rem 0;
    color: var(--text-light);
    position: relative;
    padding-left: 1.5rem;
}

.pricing-features li::before {
    content: '✓';
    position: absolute;
    left: 0;
    color: var(--success-color);
    font-weight: bold;
}

.pricing-btn {
    background: var(--primary-color);
    color: white;
    border: none;
    padding: 12px 30px;
    border-radius: 25px;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.pricing-btn:hover {
    background: var(--primary-dark);
    color: white;
    transform: translateY(-2px);
    text-decoration: none;
}

/* FAQ Section */
.faq-section {
    padding: 100px 0;
    background: var(--light-bg);
}

.faq-container {
    max-width: 800px;
    margin: 0 auto;
}

.faq-item {
    background: white;
    border-radius: 15px;
    margin-bottom: 1rem;
    box-shadow: var(--shadow);
    overflow: hidden;
}

.faq-question {
    background: white;
    color: var(--text-dark);
    cursor: pointer;
    padding: 1.5rem 2rem;
    width: 100%;
    text-align: left;
    border: none;
    outline: none;
    transition: all 0.3s ease;
    font-weight: 600;
    font-size: 1.1rem;
    position: relative;
}

.faq-question::after {
    content: '+';
    position: absolute;
    right: 2rem;
    top: 50%;
    transform: translateY(-50%);
    font-size: 1.5rem;
    color: var(--primary-color);
    transition: transform 0.3s ease;
}

.faq-question.active::after {
    transform: translateY(-50%) rotate(45deg);
}

.faq-question:hover {
    background: var(--light-bg);
}

.faq-answer {
    padding: 0 2rem;
    max-height: 0;
    overflow: hidden;
    transition: all 0.3s ease;
    background: white;
}

.faq-answer.active {
    padding: 1.5rem 2rem;
    max-height: 200px;
}

.faq-answer p {
    color: var(--text-light);
    line-height: 1.6;
    margin: 0;
}

/* Contact Section */
.contact-section {
    padding: 100px 0;
    background: white;
}

.contact-form {
    background: white;
    padding: 3rem;
    border-radius: 20px;
    box-shadow: var(--shadow);
    max-width: 600px;
    margin: 0 auto;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: var(--text-dark);
}

.form-control {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid var(--border-color);
    border-radius: 10px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(255, 111, 32, 0.1);
}

.form-select {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid var(--border-color);
    border-radius: 10px;
    font-size: 1rem;
    background: white;
    transition: all 0.3s ease;
}

.form-select:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(255, 111, 32, 0.1);
}

.submit-btn {
    background: var(--primary-color);
    color: white;
    border: none;
    padding: 15px 40px;
    border-radius: 25px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
}

.submit-btn:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }

    .hero-stats {
        gap: 2rem;
    }

    .stat-number {
        font-size: 2rem;
    }

    .cta-buttons {
        flex-direction: column;
        align-items: center;
    }

    .btn-primary-custom,
    .btn-secondary-custom {
        width: 100%;
        max-width: 300px;
        text-align: center;
    }

    .steps-container::before {
        display: none;
    }

    .step-item {
        flex-direction: column;
        text-align: center;
    }

    .step-number {
        margin-right: 0;
        margin-bottom: 1rem;
    }

    .pricing-card.featured {
        transform: none;
    }

    .pricing-card.featured:hover {
        transform: translateY(-10px);
    }

    .contact-form {
        padding: 2rem;
        margin: 0 1rem;
    }
}

@media (max-width: 480px) {
    .hero-section {
        padding: 80px 0 60px;
    }

    .hero-title {
        font-size: 2rem;
    }

    .hero-subtitle {
        font-size: 1.1rem;
    }

    .section-title {
        font-size: 2rem;
    }

    .benefit-card,
    .pricing-card {
        padding: 2rem 1.5rem;
    }
}
</style>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <div class="hero-content">
                    <h1 class="hero-title">Start Your E-commerce Journey Today</h1>
                    <p class="hero-subtitle">Join thousands of successful merchants who are already selling their products on our platform. Get started in minutes and reach millions of customers worldwide.</p>

                    <div class="hero-stats">
                        <div class="stat-item">
                            <span class="stat-number">10K+</span>
                            <span class="stat-label">Active Merchants</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">KES 6.5B+</span>
                            <span class="stat-label">Total Sales</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">2M+</span>
                            <span class="stat-label">Happy Customers</span>
                        </div>
                    </div>

                    <div class="cta-buttons">
                        <a href="{{ route('merchant.apply') }}" class="btn-primary-custom">
                            <i class="fas fa-rocket me-2"></i>Start Selling Now
                        </a>
                        <a href="#how-it-works" class="btn-secondary-custom">
                            <i class="fas fa-play me-2"></i>Learn How
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Benefits Section -->
<section class="benefits-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Why Choose Our Platform?</h2>
            <p class="section-subtitle">We provide everything you need to succeed in e-commerce, from powerful tools to dedicated support.</p>
        </div>

        <div class="benefits-grid">
            <div class="benefit-card">
                <div class="benefit-icon">
                    <i class="fas fa-rocket"></i>
                </div>
                <h3 class="benefit-title">Quick Setup</h3>
                <p class="benefit-description">Get your store up and running in minutes with our streamlined onboarding process.</p>
            </div>

            <div class="benefit-card">
                <div class="benefit-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3 class="benefit-title">Advanced Analytics</h3>
                <p class="benefit-description">Track your performance with detailed analytics and insights to grow your business.</p>
            </div>

            <div class="benefit-card">
                <div class="benefit-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3 class="benefit-title">Secure Payments</h3>
                <p class="benefit-description">Multiple payment options with bank-level security to protect your transactions.</p>
            </div>

            <div class="benefit-card">
                <div class="benefit-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h3 class="benefit-title">Mobile Optimized</h3>
                <p class="benefit-description">Manage your store from anywhere with our mobile-friendly dashboard.</p>
            </div>

            <div class="benefit-card">
                <div class="benefit-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h3 class="benefit-title">24/7 Support</h3>
                <p class="benefit-description">Get help whenever you need it with our dedicated customer support team.</p>
            </div>

            <div class="benefit-card">
                <div class="benefit-icon">
                    <i class="fas fa-gift"></i>
                </div>
                <h3 class="benefit-title">Marketing Tools</h3>
                <p class="benefit-description">Built-in marketing features to help you reach more customers and increase sales.</p>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="how-it-works" id="how-it-works">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">How It Works</h2>
            <p class="section-subtitle">Getting started is simple. Follow these easy steps to launch your online store.</p>
        </div>

        <div class="steps-container">
            <div class="step-item">
                <div class="step-number">1</div>
                <div class="step-content">
                    <h3 class="step-title">Sign Up & Apply</h3>
                    <p class="step-description">Complete our simple application form with your business details. Our team will review and approve your application within 24-48 hours.</p>
                </div>
            </div>

            <div class="step-item">
                <div class="step-number">2</div>
                <div class="step-content">
                    <h3 class="step-title">Set Up Your Store</h3>
                    <p class="step-description">Customize your store with your branding, add product categories, and configure your payment and shipping settings.</p>
                </div>
            </div>

            <div class="step-item">
                <div class="step-number">3</div>
                <div class="step-content">
                    <h3 class="step-title">Add Your Products</h3>
                    <p class="step-description">Upload your product catalog with high-quality images, detailed descriptions, and competitive pricing to attract customers.</p>
                </div>
            </div>

            <div class="step-item">
                <div class="step-number">4</div>
                <div class="step-content">
                    <h3 class="step-title">Start Selling</h3>
                    <p class="step-description">Go live and start receiving orders! Monitor your sales, manage inventory, and grow your business with our tools and support.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Pricing Section -->
<section class="pricing-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Choose Your Plan</h2>
            <p class="section-subtitle">Flexible pricing options designed to help you grow your business at your own pace.</p>
        </div>

        <div class="pricing-grid">
            <div class="pricing-card">
                <h3 class="pricing-title">Starter</h3>
                <div class="pricing-price">Free</div>
                <div class="pricing-period">No monthly fees</div>
                <ul class="pricing-features">
                    <li>Up to 50 products</li>
                    <li>Basic analytics</li>
                    <li>Email support</li>
                    <li>Standard payment processing</li>
                    <li>Mobile app access</li>
                </ul>
                <a href="{{ route('merchant.apply') }}" class="pricing-btn">Get Started</a>
            </div>

            <div class="pricing-card featured">
                <h3 class="pricing-title">Professional</h3>
                <div class="pricing-price">KES 3,500</div>
                <div class="pricing-period">per month</div>
                <ul class="pricing-features">
                    <li>Unlimited products</li>
                    <li>Advanced analytics</li>
                    <li>Priority support</li>
                    <li>Multiple payment gateways</li>
                    <li>Marketing tools</li>
                    <li>Inventory management</li>
                    <li>Order fulfillment tools</li>
                </ul>
                <a href="{{ route('merchant.apply') }}" class="pricing-btn">Start Free Trial</a>
            </div>

            <div class="pricing-card">
                <h3 class="pricing-title">Enterprise</h3>
                <div class="pricing-price">KES 12,000</div>
                <div class="pricing-period">per month</div>
                <ul class="pricing-features">
                    <li>Everything in Professional</li>
                    <li>Custom integrations</li>
                    <li>Dedicated account manager</li>
                    <li>Advanced reporting</li>
                    <li>Multi-store management</li>
                    <li>API access</li>
                    <li>White-label options</li>
                </ul>
                <a href="{{ route('merchant.apply') }}" class="pricing-btn">Contact Sales</a>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Frequently Asked Questions</h2>
            <p class="section-subtitle">Find answers to common questions about becoming a merchant on our platform.</p>
        </div>

        <div class="faq-container">
            <div class="faq-item">
                <button class="faq-question">How long does the approval process take?</button>
                <div class="faq-answer">
                    <p>Our team typically reviews and approves merchant applications within 24-48 hours. We'll notify you via email once your application has been processed.</p>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">What documents do I need to provide?</button>
                <div class="faq-answer">
                    <p>You'll need to provide basic business information, contact details, and optionally business registration documents. We'll guide you through the process step by step.</p>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">How do I get paid for my sales?</button>
                <div class="faq-answer">
                    <p>We offer multiple payment options including direct bank transfers, PayPal, and other popular payment methods. Payments are typically processed within 2-3 business days.</p>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">Can I sell any type of product?</button>
                <div class="faq-answer">
                    <p>We support most product categories, but we do have restrictions on certain items like weapons, illegal substances, and counterfeit goods. Check our terms of service for complete details.</p>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">Is there a limit on how many products I can sell?</button>
                <div class="faq-answer">
                    <p>Product limits depend on your chosen plan. The Starter plan allows up to 50 products, while Professional and Enterprise plans offer unlimited product listings.</p>
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question">What kind of support do you provide?</button>
                <div class="faq-answer">
                    <p>We offer comprehensive support including email support for all plans, priority support for Professional and Enterprise plans, and a dedicated account manager for Enterprise customers.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Ready to Get Started?</h2>
            <p class="section-subtitle">Have questions? Our team is here to help you succeed.</p>
        </div>

        <div class="contact-form">
            <form id="contactForm" method="POST" action="#">
                @csrf
                <div class="form-group">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="business_name" class="form-label">Business Name</label>
                    <input type="text" id="business_name" name="business_name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="inquiry_type" class="form-label">Inquiry Type</label>
                    <select id="inquiry_type" name="inquiry_type" class="form-select" required>
                        <option value="">Select an option</option>
                        <option value="general">General Questions</option>
                        <option value="technical">Technical Support</option>
                        <option value="billing">Billing & Payments</option>
                        <option value="partnership">Partnership Opportunities</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="message" class="form-label">Message</label>
                    <textarea id="message" name="message" class="form-control" rows="5" required placeholder="Tell us more about your business and how we can help you..."></textarea>
                </div>

                <button type="submit" class="submit-btn">
                    <i class="fas fa-paper-plane me-2"></i>Send Message
                </button>
            </form>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // FAQ Accordion functionality
    const faqQuestions = document.querySelectorAll('.faq-question');

    faqQuestions.forEach(question => {
        question.addEventListener('click', function() {
            const answer = this.nextElementSibling;
            const isActive = this.classList.contains('active');

            // Close all other FAQ items
            faqQuestions.forEach(q => {
                q.classList.remove('active');
                q.nextElementSibling.classList.remove('active');
            });

            // Toggle current FAQ item
            if (!isActive) {
                this.classList.add('active');
                answer.classList.add('active');
            }
        });
    });

    // Smooth scrolling for anchor links
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    anchorLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);

            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Contact form handling
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Get form data
            const formData = new FormData(this);

            // Show loading state
            const submitBtn = this.querySelector('.submit-btn');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sending...';
            submitBtn.disabled = true;

            // Simulate form submission (replace with actual AJAX call)
            setTimeout(() => {
                alert('Thank you for your message! We\'ll get back to you soon.');
                this.reset();
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 2000);
        });
    }

    // Animate elements on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe elements for animation
    const animateElements = document.querySelectorAll('.benefit-card, .step-item, .pricing-card');
    animateElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
});
</script>
@endpush

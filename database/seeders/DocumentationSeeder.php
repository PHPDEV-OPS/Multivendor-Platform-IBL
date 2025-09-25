<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\User;
use App\Models\Category;

class DocumentationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin user
        $admin = User::where('role', 'admin')->first();
        
        if (!$admin) {
            $admin = User::first();
        }

        // Create documentation pages
        $documentationPages = [
            [
                'title' => 'Getting Started Guide',
                'page_type' => 'documentation',
                'content' => '
                    <h1>Getting Started with TUNUNUE</h1>
                    <p>Welcome to TUNUNUE, your comprehensive e-commerce platform. This guide will help you get started with using our platform effectively.</p>
                    
                    <h2>Creating Your Account</h2>
                    <p>To get started, you need to create an account:</p>
                    <ol>
                        <li>Click on the "Register" button in the top navigation</li>
                        <li>Fill in your personal information</li>
                        <li>Verify your email address</li>
                        <li>Complete your profile setup</li>
                    </ol>
                    
                    <h2>Browsing Products</h2>
                    <p>Our platform offers a wide variety of products:</p>
                    <ul>
                        <li>Use the search bar to find specific items</li>
                        <li>Browse categories to discover new products</li>
                        <li>Filter products by price, brand, or rating</li>
                        <li>Read customer reviews before making a purchase</li>
                    </ul>
                    
                    <h2>Making Your First Purchase</h2>
                    <p>Follow these steps to complete your first order:</p>
                    <ol>
                        <li>Add items to your cart</li>
                        <li>Review your cart and apply any available discounts</li>
                        <li>Proceed to checkout</li>
                        <li>Enter your shipping and payment information</li>
                        <li>Confirm your order</li>
                    </ol>
                    
                    <h2>Need Help?</h2>
                    <p>If you need assistance, our support team is here to help. You can contact us through:</p>
                    <ul>
                        <li>Live chat support</li>
                        <li>Email support</li>
                        <li>Phone support</li>
                        <li>FAQ section</li>
                    </ul>
                ',
                'meta_description' => 'Learn how to get started with TUNUNUE e-commerce platform. Create account, browse products, and make your first purchase.',
                'meta_keywords' => 'getting started, tutorial, guide, e-commerce, shopping',
                'status' => 'published',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'How to Track Your Order',
                'page_type' => 'documentation',
                'content' => '
                    <h1>How to Track Your Order</h1>
                    <p>Once you place an order, you can easily track its progress from confirmation to delivery.</p>
                    
                    <h2>Order Confirmation</h2>
                    <p>After placing an order, you will receive:</p>
                    <ul>
                        <li>An email confirmation with your order number</li>
                        <li>SMS notification (if you provided a phone number)</li>
                        <li>Order details in your account dashboard</li>
                    </ul>
                    
                    <h2>Tracking Your Order</h2>
                    <p>You can track your order in several ways:</p>
                    
                    <h3>Through Your Account</h3>
                    <ol>
                        <li>Log in to your account</li>
                        <li>Go to "My Orders" section</li>
                        <li>Click on the order you want to track</li>
                        <li>View the current status and tracking information</li>
                    </ol>
                    
                    <h3>Using Order Number</h3>
                    <ol>
                        <li>Visit the "Track Order" page</li>
                        <li>Enter your order number</li>
                        <li>Enter your email address</li>
                        <li>Click "Track Order" to see the status</li>
                    </ol>
                    
                    <h2>Order Status Meanings</h2>
                    <ul>
                        <li><strong>Pending:</strong> Order is being processed</li>
                        <li><strong>Confirmed:</strong> Order has been confirmed and payment received</li>
                        <li><strong>Processing:</strong> Order is being prepared for shipping</li>
                        <li><strong>Shipped:</strong> Order has been shipped and is in transit</li>
                        <li><strong>Delivered:</strong> Order has been successfully delivered</li>
                        <li><strong>Cancelled:</strong> Order has been cancelled</li>
                    </ul>
                    
                    <h2>Delivery Timeframes</h2>
                    <p>Typical delivery timeframes:</p>
                    <ul>
                        <li>Standard delivery: 3-5 business days</li>
                        <li>Express delivery: 1-2 business days</li>
                        <li>Same day delivery: Available in select areas</li>
                    </ul>
                ',
                'meta_description' => 'Learn how to track your order status from confirmation to delivery. Get real-time updates on your package location.',
                'meta_keywords' => 'order tracking, delivery status, package tracking, shipping',
                'status' => 'published',
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Payment Methods',
                'page_type' => 'documentation',
                'content' => '
                    <h1>Payment Methods</h1>
                    <p>We offer multiple secure payment options to make your shopping experience convenient and safe.</p>
                    
                    <h2>Accepted Payment Methods</h2>
                    
                    <h3>Mobile Money</h3>
                    <ul>
                        <li><strong>M-Pesa:</strong> Send money to our registered number</li>
                        <li><strong>Airtel Money:</strong> Quick and secure mobile payments</li>
                        <li><strong>Telkom Money:</strong> Alternative mobile payment option</li>
                    </ul>
                    
                    <h3>Bank Transfers</h3>
                    <ul>
                        <li>Direct bank transfers to our account</li>
                        <li>Paybill number: 123456</li>
                        <li>Account number: Your order number</li>
                    </ul>
                    
                    <h3>Card Payments</h3>
                    <ul>
                        <li>Visa and Mastercard accepted</li>
                        <li>Secure payment processing</li>
                        <li>3D Secure authentication</li>
                    </ul>
                    
                    <h2>Payment Security</h2>
                    <p>Your payment information is protected by:</p>
                    <ul>
                        <li>SSL encryption for all transactions</li>
                        <li>PCI DSS compliance</li>
                        <li>Secure payment gateways</li>
                        <li>Fraud protection systems</li>
                    </ul>
                    
                    <h2>Payment Process</h2>
                    <ol>
                        <li>Add items to your cart</li>
                        <li>Proceed to checkout</li>
                        <li>Select your preferred payment method</li>
                        <li>Enter payment details</li>
                        <li>Complete the transaction</li>
                        <li>Receive confirmation</li>
                    </ol>
                    
                    <h2>Refund Policy</h2>
                    <p>We offer refunds for:</p>
                    <ul>
                        <li>Damaged or defective items</li>
                        <li>Wrong items received</li>
                        <li>Cancelled orders</li>
                    </ul>
                    <p>Refunds are processed within 3-5 business days.</p>
                ',
                'meta_description' => 'Learn about our secure payment methods including mobile money, bank transfers, and card payments.',
                'meta_keywords' => 'payment methods, mobile money, m-pesa, bank transfer, card payment',
                'status' => 'published',
                'is_featured' => false,
                'sort_order' => 3,
            ],
            [
                'title' => 'Frequently Asked Questions',
                'page_type' => 'faq',
                'content' => '
                    <h1>Frequently Asked Questions</h1>
                    <p>Find answers to the most common questions about our platform and services.</p>
                    
                    <h2>General Questions</h2>
                    
                    <h3>How do I create an account?</h3>
                    <p>Click on the "Register" button in the top navigation, fill in your details, and verify your email address.</p>
                    
                    <h3>How can I reset my password?</h3>
                    <p>Click on "Forgot Password" on the login page, enter your email, and follow the instructions sent to your email.</p>
                    
                    <h3>Is my personal information secure?</h3>
                    <p>Yes, we use industry-standard security measures to protect your personal information and payment details.</p>
                    
                    <h2>Ordering Questions</h2>
                    
                    <h3>How long does shipping take?</h3>
                    <p>Standard delivery takes 3-5 business days, express delivery takes 1-2 business days.</p>
                    
                    <h3>Can I cancel my order?</h3>
                    <p>You can cancel your order within 1 hour of placing it. Contact our support team for assistance.</p>
                    
                    <h3>What if I receive a damaged item?</h3>
                    <p>Contact our support team immediately with photos of the damage. We will arrange a replacement or refund.</p>
                    
                    <h2>Payment Questions</h2>
                    
                    <h3>What payment methods do you accept?</h3>
                    <p>We accept mobile money (M-Pesa, Airtel Money), bank transfers, and card payments.</p>
                    
                    <h3>Is it safe to pay online?</h3>
                    <p>Yes, all our payment methods are secure and encrypted. We never store your payment information.</p>
                    
                    <h3>When will I be charged?</h3>
                    <p>You will be charged when your order is confirmed and payment is processed.</p>
                    
                    <h2>Returns and Refunds</h2>
                    
                    <h3>What is your return policy?</h3>
                    <p>You can return items within 7 days of delivery if they are unused and in original packaging.</p>
                    
                    <h3>How long do refunds take?</h3>
                    <p>Refunds are processed within 3-5 business days after we receive your returned item.</p>
                    
                    <h3>Do you offer exchanges?</h3>
                    <p>Yes, we offer exchanges for items of equal value. Contact our support team for assistance.</p>
                ',
                'meta_description' => 'Find answers to frequently asked questions about our e-commerce platform, ordering, payments, and returns.',
                'meta_keywords' => 'FAQ, frequently asked questions, help, support, customer service',
                'status' => 'published',
                'is_featured' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($documentationPages as $pageData) {
            Page::create(array_merge($pageData, [
                'author_id' => $admin->id,
                'slug' => \Illuminate\Support\Str::slug($pageData['title']),
                'published_at' => now(),
            ]));
        }

        $this->command->info('Documentation pages seeded successfully!');
    }
}

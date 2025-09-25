<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    public function index(Request $request)
    {
        $query = Page::with(['author', 'category']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        // Filter by page type
        if ($request->filled('page_type')) {
            $query->where('page_type', $request->page_type);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $pages = $query->latest()->paginate(15);
        $categories = Category::active()->get();

        // Get statistics
        $stats = [
            'total' => Page::count(),
            'published' => Page::where('status', Page::STATUS_PUBLISHED)->count(),
            'draft' => Page::where('status', Page::STATUS_DRAFT)->count(),
            'documentation' => Page::where('page_type', Page::TYPE_DOCUMENTATION)->count(),
        ];

        return view('admin.content.index', compact('pages', 'categories', 'stats'));
    }

    public function create()
    {
        $categories = Category::active()->get();
        $pageTypes = [
            Page::TYPE_PAGE => 'Page',
            Page::TYPE_DOCUMENTATION => 'Documentation',
            Page::TYPE_FAQ => 'FAQ',
            Page::TYPE_TERMS => 'Terms & Conditions',
            Page::TYPE_PRIVACY => 'Privacy Policy',
            Page::TYPE_ABOUT => 'About Us',
            Page::TYPE_CONTACT => 'Contact',
        ];

        $statuses = [
            Page::STATUS_DRAFT => 'Draft',
            Page::STATUS_PUBLISHED => 'Published',
            Page::STATUS_ARCHIVED => 'Archived',
        ];

        return view('admin.content.create', compact('categories', 'pageTypes', 'statuses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'page_type' => 'required|in:' . implode(',', [
                Page::TYPE_PAGE, Page::TYPE_DOCUMENTATION, Page::TYPE_FAQ,
                Page::TYPE_TERMS, Page::TYPE_PRIVACY, Page::TYPE_ABOUT, Page::TYPE_CONTACT
            ]),
            'status' => 'required|in:' . implode(',', [
                Page::STATUS_DRAFT, Page::STATUS_PUBLISHED, Page::STATUS_ARCHIVED
            ]),
            'category_id' => 'nullable|exists:categories,id',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
            'published_at' => 'nullable|date',
        ]);

        // Generate slug from title
        $validated['slug'] = Str::slug($validated['title']);
        
        // Set author
        $validated['author_id'] = auth()->id();

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('pages', 'public');
        }

        // Set published_at if status is published
        if ($validated['status'] === Page::STATUS_PUBLISHED && !$request->filled('published_at')) {
            $validated['published_at'] = now();
        }

        Page::create($validated);

        return redirect()->route('admin.content.index')
            ->with('success', 'Page created successfully.');
    }

    public function edit(Page $page)
    {
        $categories = Category::active()->get();
        $pageTypes = [
            Page::TYPE_PAGE => 'Page',
            Page::TYPE_DOCUMENTATION => 'Documentation',
            Page::TYPE_FAQ => 'FAQ',
            Page::TYPE_TERMS => 'Terms & Conditions',
            Page::TYPE_PRIVACY => 'Privacy Policy',
            Page::TYPE_ABOUT => 'About Us',
            Page::TYPE_CONTACT => 'Contact',
        ];

        $statuses = [
            Page::STATUS_DRAFT => 'Draft',
            Page::STATUS_PUBLISHED => 'Published',
            Page::STATUS_ARCHIVED => 'Archived',
        ];

        return view('admin.content.edit', compact('page', 'categories', 'pageTypes', 'statuses'));
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'page_type' => 'required|in:' . implode(',', [
                Page::TYPE_PAGE, Page::TYPE_DOCUMENTATION, Page::TYPE_FAQ,
                Page::TYPE_TERMS, Page::TYPE_PRIVACY, Page::TYPE_ABOUT, Page::TYPE_CONTACT
            ]),
            'status' => 'required|in:' . implode(',', [
                Page::STATUS_DRAFT, Page::STATUS_PUBLISHED, Page::STATUS_ARCHIVED
            ]),
            'category_id' => 'nullable|exists:categories,id',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
            'published_at' => 'nullable|date',
        ]);

        // Generate slug from title
        $validated['slug'] = Str::slug($validated['title']);

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($page->featured_image) {
                Storage::disk('public')->delete($page->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('pages', 'public');
        }

        // Set published_at if status is published
        if ($validated['status'] === Page::STATUS_PUBLISHED && !$request->filled('published_at')) {
            $validated['published_at'] = now();
        }

        $page->update($validated);

        return redirect()->route('admin.content.index')
            ->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page)
    {
        // Delete featured image
        if ($page->featured_image) {
            Storage::disk('public')->delete($page->featured_image);
        }

        $page->delete();

        return redirect()->route('admin.content.index')
            ->with('success', 'Page deleted successfully.');
    }

    public function show(Page $page)
    {
        $page->load(['author', 'category']);
        
        return view('admin.content.show', compact('page'));
    }
}

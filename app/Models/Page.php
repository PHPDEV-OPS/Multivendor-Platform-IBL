<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'meta_description',
        'meta_keywords',
        'status',
        'page_type',
        'featured_image',
        'author_id',
        'published_at',
        'sort_order',
        'is_featured',
        'view_count',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'view_count' => 'integer',
        'sort_order' => 'integer',
    ];

    // Page types
    const TYPE_PAGE = 'page';
    const TYPE_DOCUMENTATION = 'documentation';
    const TYPE_FAQ = 'faq';
    const TYPE_TERMS = 'terms';
    const TYPE_PRIVACY = 'privacy';
    const TYPE_ABOUT = 'about';
    const TYPE_CONTACT = 'contact';

    // Status options
    const STATUS_DRAFT = 'draft';
    const STATUS_PUBLISHED = 'published';
    const STATUS_ARCHIVED = 'archived';

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', self::STATUS_PUBLISHED)
                    ->where('published_at', '<=', now());
    }

    public function scopeDocumentation($query)
    {
        return $query->where('page_type', self::TYPE_DOCUMENTATION);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getPageTypeLabelAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->page_type));
    }

    public function getStatusLabelAttribute()
    {
        return ucfirst($this->status);
    }

    public function getExcerptAttribute($length = 150)
    {
        return substr(strip_tags($this->content), 0, $length) . '...';
    }
}

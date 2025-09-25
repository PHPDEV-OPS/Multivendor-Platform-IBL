<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'sort_order',
        'is_active',
        'meta_title',
        'meta_description',
        'icon',
        'color',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    public function getFullPathAttribute()
    {
        $path = [$this->name];
        $parent = $this->parent;
        
        while ($parent) {
            array_unshift($path, $parent->name);
            $parent = $parent->parent;
        }
        
        return implode(' > ', $path);
    }

    public function getChildrenCountAttribute()
    {
        return $this->children()->count();
    }

    public function getPagesCountAttribute()
    {
        return $this->pages()->count();
    }

    public function getActiveProductsCountAttribute()
    {
        return $this->products()
            ->where('status', 'active')
            ->where('stock_quantity', '>', 0)
            ->count();
    }

    public function getTotalProductsCountAttribute()
    {
        return $this->products()->count();
    }

    public function getActiveChildrenCountAttribute()
    {
        return $this->children()->active()->count();
    }

    public function getAllProductsCountAttribute()
    {
        $count = $this->products()
            ->where('status', 'active')
            ->where('stock_quantity', '>', 0)
            ->count();
        
        // Add products from child categories
        foreach ($this->children as $child) {
            $count += $child->getAllProductsCountAttribute();
        }
        
        return $count;
    }

    public function getCategoryStatsAttribute()
    {
        return [
            'total_products' => $this->getTotalProductsCountAttribute(),
            'active_products' => $this->getActiveProductsCountAttribute(),
            'children_count' => $this->getChildrenCountAttribute(),
            'active_children_count' => $this->getActiveChildrenCountAttribute(),
            'all_products_count' => $this->getAllProductsCountAttribute(),
        ];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'thumbnail', 'images', 'price', 'short_description', 'description', 'properties', 'is_active', 'source', 'preview_source_url', 'is_virtual_product'];
}

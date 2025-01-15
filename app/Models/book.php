<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    use HasFactory;

    // Allow mass assignment for relevant fields

    protected $table = 'books'; 
    protected $fillable = [
        'name',
        'category_id',
        'auther_id',
        'publisher_id',
        'status',
        'cover_image', // New cover image field
        'product_code', // New cover image field
        'sinopsis', // New cover image field
    ];

    /**
     * Get the auther that owns the book.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function auther(): BelongsTo
    {
        return $this->belongsTo(Auther::class, 'auther_id', 'id');
    }

    /**
     * Get the category that owns the book.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the publisher that owns the book.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }

    public function bookIssues()
    {
        return $this->hasMany(book_issue::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class auther extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table = 'authers';

    public function books(): HasMany
    {
        return $this->hasMany(Book::class, 'auther_id', 'id');
    }
}

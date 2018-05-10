<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model {
    protected $table = 'reviews';
    protected $primaryKey = 'review_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'review', 
        'rating', 
        'product_id',
        'user_id'
    ];
}

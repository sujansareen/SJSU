<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visited extends Model
{
    protected $table = 'visited';
    protected $primaryKey = 'visited_id'; 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'user_id',
        'company_id'
    ];
}

<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    protected $table = 'products';
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'img', 
        'url',
        'description',
        'visited',
        'service',
        'company_id'
    ];
    public function reviews() {
        return $this->hasMany('App\Models\Review');
    }
    public function company() {
        return $this->hasOne('App\Models\Company','company_id','company_id');
    }
}

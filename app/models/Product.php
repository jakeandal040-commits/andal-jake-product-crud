<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Product extends \LavaLust\Database\Model
{
    protected $table = 'products';
    
    protected $primaryKey = 'id';
    
    protected $timestamps = true;
    
    protected $fillable = [
        'product_name',
        'description',
        'price',
        'quantity'
    ];
    
    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
        'created_at' => 'datetime'
    ];
}

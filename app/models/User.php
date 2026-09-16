<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class User extends \LavaLust\Database\Model
{
    protected $table = 'users';
    
    protected $primaryKey = 'id';
    
    protected $timestamps = true;
    
    protected $fillable = [
        'username',
        'email',
        'password'
    ];
    
    protected $hidden = [
        'password'
    ];
}

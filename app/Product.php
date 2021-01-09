<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guard = [];
    protected $fillable = ['name', "price", 'description', "image"];
}

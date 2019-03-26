<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    public $table = 'ingredients';
    public $fillable = ['name'];
}

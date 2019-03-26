<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReceiptIngredients extends Model
{
    public $table = 'receipt_ingredients';
    public $fillable = ['receipt_id', 'ingredient_id', 'quantity'];
}

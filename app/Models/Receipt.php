<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    /**
     * @var array
     */
    public $fillable = ['name', 'description', 'user_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ingredients()
    {
        return $this->belongsToMany('App\Models\Ingredient', 'receipt_ingredients',
            'receipt_id', 'ingredient_id');
    }
}

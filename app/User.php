<?php

namespace App;

use App\Models\User\Role;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Activitylog\Traits\CausesActivity;

/**
 * Class User
 * @package App
 */
class User extends Authenticatable
{
    use Notifiable, CausesActivity;

    protected $table = 'users';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $fillable = [
        'name', 'email', 'password'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function receipts()
    {
        return $this->hasMany('App\Models\Receipt','user_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SaleUser extends Model
{
    protected $fillable = [
        'name',
    ];

    /**
     * The roles that belong to the sale user.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }


}

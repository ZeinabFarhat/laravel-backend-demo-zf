<?php

namespace App\Models\Users;

use App\Helpers\Minion;
use App\Models\Traits\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Lab404\Impersonate\Models\Impersonate;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use Notifiable, HasRoles, Sluggable, Impersonate, SoftDeletes, HasApiTokens;

    protected $table = 'users';

    protected $hidden = ['created_at', 'updated_at', 'remember_token'];

    protected $dates = ['created_at', 'updated'];

    protected $fillable = ['first_name', 'last_name', 'email', 'password', 'slug'];

    public function sluggable(): array
    {
        return [
            'source' => 'name'
        ];
    }

    public function setPasswordAttribute($value)
    {

        $this->attributes['password'] = Hash::make($value);
    }


    public function setSlugAttribute()
    {
        $title = $this->name;
        $this->attributes['slug'] = Minion::create_slug($title, get_class($this));
    }


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFullNameAttribute()
    {
        return preg_replace('/\s+/', ' ', $this->first_name . '' . $this->last_name);
    }
}


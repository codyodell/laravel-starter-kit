<?php

namespace App\Components\User\Models;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 * @package App\Components\User\Models
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property array $permissions
 * @property string|null $active
 */
class User extends Authenticatable
{
    use Notifiable, UserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'remember_token', 'permissions', 'last_login', 'active', 'activation_key',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = [
        'photo_url',
    ];

    /**
     * the validation rules
     *
     * @var array
     */
    public static $rules = [];

    public function AuthRouteAPI(Request $request)
    {
        return $request->user();
    }

    public function getPhotoUrlAttribute()
    {
        return 'https://www.gravatar.com/avatar/' . md5(strtolower($this->email)) . '.jpg?s=200&d=mm';
    }
}

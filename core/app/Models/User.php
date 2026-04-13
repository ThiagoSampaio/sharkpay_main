<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\Contracts\OAuthenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\DB;
use App\Traits\UserSettingsTrait;

class User extends Authenticatable implements OAuthenticatable
{
    use HasApiTokens, Notifiable, UserSettingsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'facebook', 
        'twitter', 
        'instagram', 
        'linkedin', 
        'youtube'
    ];
    protected $guard = 'user';

    protected $table = 'users';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function deposit()
    {
        return $this->hasMany('App\Model\Deposit', 'user_id');
    }

    public function banks()
    {
        return $this->hasMany('App\Models\Bank', 'user_id');
    }


    public function updateBalance($user, $balance, $type) {

        if (strtolower($type) == "debit") {
            $query = "UPDATE users SET balance = (balance - ".number_format($balance, 2, ".", "").") WHERE id = {$user->id};";
        } else {
            $query = "UPDATE users SET balance = (balance + ".number_format($balance, 2, ".", "").") WHERE id = {$user->id};";
        }

        DB::statement($query);
    }

}

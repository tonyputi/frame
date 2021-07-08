<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'hostname', 'ip'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_enabled' => 'boolean',
        'is_admin' => 'boolean',
        'options' => 'json'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
        'current_ips'
    ];

    /**
     * Route notifications for the Slack channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForSlack($notification)
    {
        return optional($this->options)->slack_webhook_url;
    }

    /**
     * Return current ip of the user
     *
     * @return string
     */
    public function getCurrentIpAttribute()
    {
        return with(app(Request::class), function ($request) {
            return $request->ip();
        });
    }

    /**
     * Return current ips of the user
     *
     * @return array
     */
    public function getCurrentIpsAttribute()
    {
        return with(app(Request::class), function ($request) {
           return $request->ips();
        });
    }

    /**
     * Return true if current ip is not matching the previous one and not null
     *
     * @return bool
     */
    public function getHasChangedIpAttribute()
    {
        return ($this->ip and $this->ip != $this->current_ip);
    }
}

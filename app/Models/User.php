<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use LdapRecord\Container;   
use LdapRecord\Connection;
use LdapRecord\Models\Entry;
use Illuminate\Auth\Notifications\ResetPassword;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'id_user',
        'last_name',
        'first_name',
        'login',
        'email',
        'password',
        'id_service',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Ajoutez cette méthode pour relier id_service à Service
    public function service()
    {
        return $this->belongsTo(Service::class, 'id_service');
    }

    public function authAttempLdap(String $password): bool
    {
        $connection = new Connection([
            'hosts' => [env('LDAP_HOST')],
            'port' => env('LDAP_PORT'),
            'base_dn' => env('LDAP_BASE_DN'),
            'username' => env('LDAP_USERNAME'),
            'password' => env('LDAP_PASSWORD'),
        ]);
        
        Container::addConnection($connection);
        
        
        // Find user in ldap where email = $email
        $cn = Entry::findBy('mail', $this->email);

        if(!$cn) {
            return false;
        } else {
            $cn = $cn->getFirstAttribute('cn');
        }

        if(!$cn) {
            return false;
        }
        
        // If user is found, try to authenticate else return false
        
        if ($connection->auth()->attempt($cn, $password)) {
            return true;
        } else {
            return false;
        }
    }


    public function copiedCouriers()
{
    return $this->belongsToMany(Courier::class, 'courier_user');
}

public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }


public function sendPasswordResetNotification($token)
{
    $this->notify(new ResetPassword($token));
}


}

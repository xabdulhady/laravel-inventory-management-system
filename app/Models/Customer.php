<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Customer extends User
{
    use HasFactory;
    protected $table = 'users';
    protected $dates = ['deleted_at'];
    protected $hidden = ['password', 'remember_token', 'email_verified_at'];

    protected $fillable = ['name', 'email', 'password', 'phone', 'fax', 'address'];


}

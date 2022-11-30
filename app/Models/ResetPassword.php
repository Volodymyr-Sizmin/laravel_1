<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class ResetPassword extends Model

{
    use HasApiTokens, HasFactory;

    public $table = 'reset_password';

    protected $fillable = [
        'user_id',
        'token'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appoinment extends Model
{
    use HasFactory;

    protected $guarded = ['_token'];
}

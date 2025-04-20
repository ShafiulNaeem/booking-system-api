<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appoinment extends Model
{
    use HasFactory;

    protected $guarded = ['_token'];

    public function avaiability()
    {
        return $this->belongsTo(Avaiability::class, 'avaiability_id');
    }
    public function guest()
    {
        return $this->hasOne(User::class, 'id', 'guest_id');
    }
}

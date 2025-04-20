<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avaiability extends Model
{
    use HasFactory;

    protected $guarded = ['_token'];

    public function host()
    {
        return $this->hasOne(User::class, 'id', 'host_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Person;

class Raffle extends Model
{
    use HasFactory;
    
    public function people()
    {
        return $this->belongsToMany(Person::class, 'people_raffles');
    }
    public function prizes()
    {
        return $this->hasMany(Prize::class);
    }
}

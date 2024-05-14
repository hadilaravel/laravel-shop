<?php

namespace App\Models;

use App\Models\Market\City;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    public function cities()
    {
        return $this->hasMany(City::class);
    }

}

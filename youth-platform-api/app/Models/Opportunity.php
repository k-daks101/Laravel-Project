<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opportunity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'url',
        'criteria',
        'country_region',
        'deadline',
        'type',
        'funding_salary',
        'status'
    ];
}

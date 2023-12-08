<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terminal extends Model
{
    use HasFactory;
    protected $fillable = [
        'atm_id',
        'alias_name',
        'atm_type',
        'install_date',
        'model',
        'location',
        'bank',
        'active'
    ];
}

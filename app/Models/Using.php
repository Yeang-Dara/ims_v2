<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Using extends Model
{
    use HasFactory;
    protected $table='usings';
    
    protected $fillable= [
        'user_id',
        'atm_id',
        'alias_id',
        'install_date',
        'apk_version',
        'image_version',
        'mainboard_version',
        'android_version',
        'delivery_date',
        'take_over_date',
        'category_name',
        'serial_number',
        'model_name',
        'warranty_days',
        'comment',
        'type_name',
        'status',
        'bank_name',
        'site_id',
        'region_name',
        'site_name',
        'location',
        'city',
        'state_name',
        'accessibility',
        'address',
    ];
    public static function rulesToCreate():array
    {
        return [];
    }
    public static function rulesToCreateMessages(){
        return [];
    }
    public static function rulesToUpdate(){
        return [];
    }
    public static function rulesToUpdateMessages(){
        return [];
    }
    public function usings(): BelongsTo
    {
        return $this->belongsTo(Users::class,'user_id', 'id');
    }
    public function mainparts():HasMany
    {
        return $this->hasMany(Mainpart::class,'machine_id', 'id');
    }
    public function maintenaces():HasMany
    {
        return $this->hasMany(Maintenace::class,'atm_id', 'id');
    }
}

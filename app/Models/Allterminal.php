<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Allterminal extends Model
{
    use HasFactory;
    protected $table = 'allterminals';
    protected $fillable = [
        'atm_id',
        'serial_number',
        'alias_id',
        'install_date',
        'delivery_date',
        'takeover_date',
        'android_version',
        'model_id',
        'type_id',
        'banklocation_id',
        'category_id',
        'status_id',
        'warrenty',
    ];
    public static function rulesToCreate(): array
    {
        return[];
    }
    public static function rulesToCreateMessages(){
        return [];
    }
    public static function rulesToUpdate($id = null): array
    {
        return [];
    }
    public static function rulesToUpdateMessages(): array
    {
        return [];
    }
    public function models():BelongsTo
    {
        return $this->belongsTo(Terminalmodel::class,'model_id','id');
    }
    public function types():BelongsTo
    {
        return $this->belongsTo(Terminaltype::class,'type_id','id');
    }
    public function locations():BelongsTo
    {
        return $this->belongsTo(Banklocation::class,'banklocation_id','id');
    }
    public function categories():BelongsTo
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }
    public function statuses():BelongsTo
    {
        return $this->belongsTo(Terminalstatus::class,'status_id','id');
    }

}

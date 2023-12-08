<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sparepart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'spareparts_name',
        'quantity',
        'quantity_used',
        'quantity_remain',
        'for_machine_model',
        'part_number',
    ];
    public static function rulesToCreate(): array
    {
        return[];
    }
    public static function rulesToCreateMessages()
    {
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
    public function spareparts():BelongsTo
    {
        return $this->belongsTo(Users::class, 'user_id', 'id');
    }
}

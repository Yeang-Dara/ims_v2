<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sparepart extends Model
{
    use HasFactory;

    protected $fillable = [
        'model_id',
        'sparepart_name',
        'quantity',
        'quantity_used',
        'quantity_remain',
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
        return $this->belongsTo(Terminalmodel::class, 'model_id', 'id');
    }
}

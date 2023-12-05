<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mainpart extends Model
{
    use HasFactory;

    protected $table = 'mainparts';
    protected $fillable = [
        'machine_id',
        'mainpart_name',
        'part_number',
        'replacer_name',
        'remarks',
        'replace_date',
        'quantity',

    ];
    public static function rulesToCreate(): array
    {
        return['replace_date' =>'date_format:Y-m-d'];
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
    public function mainparts():BelongsTo
    {
        return $this->belongsTo(Usings::class, 'machine_id','id');
    }
}

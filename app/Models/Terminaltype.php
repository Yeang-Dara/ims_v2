<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Terminaltype extends Model
{
    use HasFactory;
    protected $table = 'terminaltypes';

    protected $fillable = [
        'terminal_type',
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
    public function terminalmodels():HasMany
    {
        return $this->hasMany(Terminalmodel::class, 'terminaltype_id','id');
    }
}

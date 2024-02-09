<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ordermachine extends Model
{
    use HasFactory;

    protected $table = 'ordermachines';
    protected $fillable = [
        'customer_id',
        'type_id',
        'model_id',
        'quantity',
        'warehouse_id',
        'status_id',
    ];
    public function customers():BelongsTo
    {
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
    public function ordertypes():BelongsTo
    {
        return $this->belongsTo(Terminaltype::class,'type_id','id');
    }
    public function ordermodels():BelongsTo
    {
        return $this->belongsTo(Terminalmodel::class,'model_id','id');
    }
    public function orderwarehouses():BelongsTo
    {
        return $this->belongsTo(Warehouse::class,'warehouse_id','id');
    }
    public function orderstatuses():BelongsTo
    {
        return $this->belongsTo(Terminalstatus::class,'status_id','id');
    }
}

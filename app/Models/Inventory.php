<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'inventory_name',
        'model_type_id',
        'owner_id',
        'warehouse_id',
        'serial_number',
        'stock_quantity',
        'status',
        'stored_at',
        'inventory_in_date',
        'inventory_out_date',
        'notes'
    ];

    public function modelType()
    {
        return $this->belongsTo(ModelType::class, 'model_type_id');
    }
    public function owner()
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }
}

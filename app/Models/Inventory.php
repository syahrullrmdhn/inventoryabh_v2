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
        public function scopeSearch($query, ?string $term)
    {
        $term = trim((string) $term);
        if ($term === '') return $query;

        return $query->where(function ($q) use ($term) {
            $like = "%{$term}%";
            $q->where('inventory_name', 'like', $like)
              ->orWhere('serial_number', 'like', $like)
              ->orWhere('status', 'like', $like)
              ->orWhere('notes', 'like', $like)
              ->orWhereHas('modelType', fn($m) => $m->where('name', 'like', $like))
              ->orWhereHas('owner', fn($o) => $o->where('name', 'like', $like))
              ->orWhereHas('warehouse', fn($w) => $w->where('name', 'like', $like));
        });
    }
}

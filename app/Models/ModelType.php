<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelType extends Model
{
    protected $fillable = ['name', 'minimum_stock'];

    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'model_type_id');
    }

    /** Simple keyword + numeric range search */
    public function scopeSearch($query, ?string $term = null, ?int $min = null, ?int $max = null)
    {
        if ($term !== null && trim($term) !== '') {
            $like = '%'.trim($term).'%';
            $query->where('name', 'like', $like);
        }
        if ($min !== null && $min !== '') {
            $query->where('minimum_stock', '>=', (int) $min);
        }
        if ($max !== null && $max !== '') {
            $query->where('minimum_stock', '<=', (int) $max);
        }
        return $query;
    }
}

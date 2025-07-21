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
}

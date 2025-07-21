<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = ['user_id', 'activity', 'ip_address', 'info'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ActivityLog extends Model
{
    use LogsActivity;
    protected $table='activity_log';
    protected $fillable = [
        'id',
        'user_id',
        'log_name',
        'description',
        'username',
        'subject_id',
        'subject_type',
        'causer_id',
        'causer_type',
        'properties',
        'created_at',
        'updated_at',
    ];
    public function user()
    {
        return $this->belongsTo(Ktp::class, 'causer_id');
    }
}

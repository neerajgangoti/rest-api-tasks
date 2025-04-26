<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Task extends Model
{
    protected $fillable = [
        'task_id',
        'status',
        'input_data',
        'result'
    ];

    protected $casts = [
        'input_data' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->task_id = (string) Str::uuid();
        });
    }
}

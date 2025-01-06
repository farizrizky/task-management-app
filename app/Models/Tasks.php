<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Tasks extends Model
{
    use HasFactory, Notifiable;
    protected $table = "task";
    protected $fillable = [
        'title',
        'description',
        'deadline',
        'status',
        'label',
        'created_by'
    ];
    public $timestamps = false;
}

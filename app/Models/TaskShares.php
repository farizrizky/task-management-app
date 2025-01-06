<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class TaskShares extends Model
{
    use HasFactory, Notifiable;
    protected $table = "task_shares";
    protected $fillable = [
        'task_id',
        'shared_with',
        'permission'
    ];
    public $timestamps = false;
}

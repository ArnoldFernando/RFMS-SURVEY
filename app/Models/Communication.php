<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Communication extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_name',
        'tracking_number',
        'location',
        'description',
        'file',
        'status',
        'date',
        'user_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

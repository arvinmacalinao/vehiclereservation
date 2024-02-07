<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Driver extends Model
{
    use SoftDeletes;

    protected $table        = 'drivers';
    protected $primaryKey   = 'd_id';
    protected $fillable = [
        'name', 'created_at', 'updated_at',
    ];
}

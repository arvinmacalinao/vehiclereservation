<?php

namespace App\Models;

use App\Models\Approval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApprovalStatus extends Model
{
    protected $table = 'approval_statuses';
    protected $fillable = ['id', 'name', 'created_at', 'updated_at'];

    public function approvals()
    {
        return $this->hasMany(Approval::class);
    }
}

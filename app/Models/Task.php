<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title','description','assignee_id','start_date','end_date'
    ];

    public function assignee()
    {
        return $this->belongsTo(\App\Models\User::class, 'assignee_id');
    }
}

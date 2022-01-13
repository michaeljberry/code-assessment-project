<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = "tasks";
    protected $fillable = ['title','details','status'];
    protected $appends = ['created_at_display'];

    public function getCreatedAtDisplayAttribute()
    {
        $date = $this->attributes['created_at'];
        if($date) {
            return Carbon::parse($date)->format('F d, Y');
        }

        return;
    }
}

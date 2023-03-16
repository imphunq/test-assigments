<?php

namespace App\Models;

use App\Models\Thread;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'cost',
        'start_at',
        'end_at',
        'instructor_id',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_courses');
    }

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }
}

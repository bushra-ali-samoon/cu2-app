<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['title', 'slug', 'description'];

    public $timestamps = false;  
    
    public function topics()
{
    return $this->hasMany(CourseTopic::class, 'course_id');
}

}

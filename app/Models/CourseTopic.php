<?php

 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseTopic extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'audio_path',
        'transcript_pdf',
        'worksheet_pdf',
        'test_pdf',
        'visible_for'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}

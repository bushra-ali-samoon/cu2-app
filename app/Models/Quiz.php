<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 

class Quiz extends Model
{
    use HasFactory;

     
    protected $table = 'quizes'; 

    protected $fillable = [
        'topic_id',
        'name',
        'duration_minutes',
        'total_marks'
    ];

  public function topic()
{
    return $this->belongsTo(CourseTopic::class, 'topic_id');
}

 
 

}




 
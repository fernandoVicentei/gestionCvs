<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;
    protected $table = 'skill';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'name',
        'level',
        'cv_id'
    ];
    public $timestamps = false;
    public function cv()
    {
        return $this->belongsTo(Cv::class);
    }

}

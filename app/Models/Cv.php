<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cv extends Model
{
    use HasFactory;
    protected $table = 'cv';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'created_on',
        'title',
        'biography',
        'salary',
        'jobseeker_id'
    ];
    public $timestamps = false;
    public function jobSeeker()
    {
        return $this->belongsTo(Jobseeker::class);
    }
    public function skills()
    {
        return $this->hasMany(Skill::class);
    }
}

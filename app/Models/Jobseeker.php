<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobseeker extends Model
{
    use HasFactory;
    protected $table = 'jobseeker';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'phone_number',
        'address',
        'email'
    ];
    public $timestamps = false;
    public function cvs()
    {
        return $this->hasMany(Cv::class);
    }
}

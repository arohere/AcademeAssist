<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    // Example
    // +"number": "76"
    // +"year": "2"
    // +"academic_year": "2022-2023"
    // +"semester": "Even Sem"
    // +"course_code": "UC0014"
    // +"course_description": "ACTIVITY BASED LEARNING"
    // +"ltps": "P"
    // +"section": "S-1"
    // +"faculty_name": "Pinapatruni Sree Lakshmi"

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'user_id',
        'year',
        'academic_year',
        'semester',
        'course_code',
        'course_description',
        'ltps',
        'section',
        'faculty_name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}

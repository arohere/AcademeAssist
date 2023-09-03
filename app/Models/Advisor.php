<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advisor extends Model
{
    use HasFactory;

    // Example
    // +"advisor_uni_id": "5993"
    // +"advisor_name": "PRATHIPATI RATNA KUMAR"

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'advisor_uni_id',
        'advisor_name',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

}

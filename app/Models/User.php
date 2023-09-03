<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'password',
        "first_name",
        "middle_name",
        "last_name",
        "gender",
        "father_name",
        "mother_name",
        "mother_maiden_name",
        "date_of_birth",
        "blood_group",
        "martial_status",
        "mother_tongue",
        "cast_category",
        "personal_e-mail",
        "identification",
        "disability",
        "place_of_birth",
        "height",
        "weight",
        "religion",
        "nationality",
        "admission_date",
        "major_degree",
        "refered_by",
        "program",
        "regulation",
        "campus",
        "admission_type",
        "hostel_status",
        "address",
        "advisor_uni_id",

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}

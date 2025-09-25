<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Registration extends Model
{
    use HasFactory;

    //fillable là nhựng cột dc gán hàng loạt=> bảo mật
    protected $fillable = [
        'profile_picture', // Thêm ảnh hồ sơ
        'first_name',
        'last_name',
        'phone',
        'email',
        'gender',
        'date_of_birth',
        'country_of_birth', // Bắt buộc
        'nationality', // Bắt buộc
        'passport_no',
        'passport_file',
        'permanent_address',
        'present_address',
        'program'
    ];

    protected $casts = [
        'date_of_birth' => 'date'
    ];

    /**
     * Relationship với Application
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Get full name
     * Tạo một thuộc tính ảo full_name /Accessor
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}

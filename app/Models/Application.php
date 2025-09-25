<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'student_name',
        'program',
        'status',
        'payment_status',
        'registration_id'
    ];

    protected static function boot()
    {
        parent::boot(); // Gọi boot của lớp cha, gắn kết sự kiện

        static::creating(function ($application) {
            // Tự sinh Application ID nếu chưa có
            if (empty($application->application_id)) {
                $application->application_id = self::generateApplicationId();
            }
            
            // Tự động lấy thông tin từ Registration nếu có registration_id
            if ($application->registration_id && empty($application->student_name)) {
                $registration = Registration::find($application->registration_id);
                if ($registration) {
                    $application->student_name = $registration->full_name;
                    $application->program = $registration->program;
                }
            }
        });
    }

    /**
     * Generate Application ID format: APP-YYYY-####
     */
    private static function generateApplicationId()
    {
        $year = date('Y'); 
        $prefix = "APP-{$year}-";
        
        // Lấy số sequence cao nhất trong năm hiện tại
        $lastApplication = self::where('application_id', 'like', $prefix . '%')
            ->orderBy('application_id', 'desc')
            ->first();
        
        if ($lastApplication) {
            // Lấy 4 số cuối từ application_id
            $lastNumber = (int) substr($lastApplication->application_id, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        // Format thành 4 chữ số (pad với 0)
        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Relationship với Registration
     */
    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    /**
     * Tạo Application từ Registration
     */
    public static function createFromRegistration($registrationId, $additionalData = [])
    {
        $registration = Registration::findOrFail($registrationId);
        
        return self::create(array_merge([
            'registration_id' => $registrationId,
            // student_name và program sẽ được tự động lấy từ boot() method
        ], $additionalData));
    }
}

<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [

        'name',
        'email',
        'password',
        'role_id',
        'reporting_to',
        'designation',
        'mobile_number',
        'joining_date',
        'employee_code',
        'probation_period',
        'status',
        'profile_image'
        
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function reportingManager()
    {
        return $this->belongsTo(User::class, 'reporting_to');
    }
    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }

    public function salaryStructure()
    {
        return $this->hasOne(SalaryStructure::class);
    }

    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }
    public function reportingManagers()
    {
        return $this->belongsToMany(

            User::class,
            'user_reporting',
            'user_id',
            'reporting_user_id'

        );
    }
    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }
    public function leaveApplications()
    {
        return $this->hasMany(
            LeaveApplication::class
        );
    }
    /*
    |--------------------------------------------------------------------------
    | Daily EODs
    |--------------------------------------------------------------------------
    */

    public function dailyEods()
    {
        return $this->hasMany(DailyEod::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Subordinates
    |--------------------------------------------------------------------------
    */

    public function subordinates()
    {
        return $this->belongsToMany(

            User::class,

            'user_reporting',

            'reporting_user_id',

            'user_id'

        );
    }

    public function documents()
    {
        return $this->hasMany(

            EmployeeDocument::class

        );
    }
}

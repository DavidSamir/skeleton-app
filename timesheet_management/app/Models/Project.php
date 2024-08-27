<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'department',
        'start_date',
        'end_date',
        'status',
    ];

    public static function createMigration()
    {
        return function ($table) {
            $table->id();
            $table->string('name');
            $table->string('department');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status');
            $table->timestamps();
        };
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function timesheets()
    {
        return $this->hasMany(Timesheet::class);
    }
}

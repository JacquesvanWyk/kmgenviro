<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingSchedule extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'training_course_id',
        'start_date',
        'end_date',
        'location',
        'is_online',
        'available_seats',
        'price_override',
        'notes',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'training_course_id' => 'integer',
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'is_online' => 'boolean',
            'price_override' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function trainingCourse(): BelongsTo
    {
        return $this->belongsTo(TrainingCourse::class);
    }

    public function trainingBookings(): HasMany
    {
        return $this->hasMany(TrainingBooking::class);
    }
}

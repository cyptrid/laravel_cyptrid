<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hospital extends Model
{
    use HasFactory;

    protected $table = 'hospitals';

    protected $guarded = ['id'];

    /**
     * Get all of the patients for the Hospital
     */
    public function patients(): HasMany
    {
        return $this->hasMany(Patient::class, 'hospital_id');
    }
}

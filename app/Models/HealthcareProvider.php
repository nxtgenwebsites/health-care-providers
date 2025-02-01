<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HealthcareProvider extends Model
{
    protected $fillable = [
        'organization_name',
        'facility_type',
        'other_facility_type',
        'ownership_type',
        'other_ownership_type',
        'email_address',
        'phone_number',
        'country',
        'state',
        'city',
        'zipcode',
        'google_map_link',
        'is_ae_available',
        'is_24hours'
    ];

    protected $casts = [
        'is_ae_available' => 'boolean',
        'is_24hours' => 'boolean',
    ];

    public function operatingHours()
    {
        return $this->hasMany(OperatingHour::class);
    }
}
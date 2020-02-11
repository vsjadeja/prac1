<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'price', 'thumb', 'package_type_id', 'status',
    ];

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    // protected $touches = ['packageType'];

    /**
     * Get PackageType
     * @return App\Models\PackageType
     */
    public function packageType()
    {
        return $this->belongsTo('App\Models\PackageType');
    }

}

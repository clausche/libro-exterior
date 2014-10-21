<?php

namespace Tricks;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'countries';

    /**
     * Query the tricks that belong to the ciudad.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tricks()
    {
        return $this->belongsToMany('Tricks\Trick');
    }
}
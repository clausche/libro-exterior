<?php

namespace Tricks;

use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ciudades';

    /**
     * Query the tricks that belong to the ciudad.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
	public function tricks()
	{
		return $this->belongsToMany('Tricks\Trick');
	}
    public function paises()
    {
        return $this->belongsTo('Tricks\Tag');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Source extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name'
    ];

    /**
     * Relationships
     */

    /**
     * Get source batch
     *
     * @author goper
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    /**
     * Get user sources
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function client()
    {
        return $this->belongsToMany(User::class, 'client_sources', 'source_id', 'user_id');
    }

    public function scopeSearch($query, $key)
    {
       $key = strtolower($key);
       return $query->where('name', 'LIKE', '%' . $key . '%')->orWhere("code","like","%$key%");
    }

}

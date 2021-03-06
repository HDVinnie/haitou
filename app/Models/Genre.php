<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Genre extends Model
{
    use SoftDeletes;
    use Sluggable;

    protected $table = 'genres';

    protected $casts = [
        'views' => 'int'
    ];

    protected $fillable = [
        'name',
        'slug',
        'views'
    ];

    public function media()
    {
        return $this->belongsToMany(Media::class, 'media_genres')
            ->withPivot('id');
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}

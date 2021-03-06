<?php

namespace App\Models;

use App\Helpers\BBCode;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Character extends Model
{
    use SoftDeletes;
    use Sluggable;

    const uploaderFolder = 'characters';
    protected $table = 'characters';
    protected $casts = [
        'views' => 'int'
    ];
    protected $fillable = [
        'name',
        'slug',
        'image',
        'description',
        'views'
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function descriptionHtml()
    {
        return (new BBCode())->parse($this->description, true);
    }

    public function image()
    {
        return asset('storage/characters/' . $this->image);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Post
 *
 * @property $id
 * @property $titulo
 * @property $contenido
 * @property $publicado
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Post extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['titulo', 'contenido', 'publicado'];


}

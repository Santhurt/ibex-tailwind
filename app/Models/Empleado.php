<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Empleado
 *
 * @property $id
 * @property $name
 * @property $email
 * @property $email_verified_at
 * @property $password
 * @property $remember_token
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Empleado extends Model
{

    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'email'];

    public function ventas()
    {
        return $this->hasMany(Venta::class, "empleado_id");
    }

}

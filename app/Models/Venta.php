<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Venta
 *
 * @property $id
 * @property $total
 * @property $id_producto
 * @property $created_at
 * @property $updated_at
 *
 * @property VentasEmpleado[] $ventasEmpleados
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Venta extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['total', 'id_producto'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ventasEmpleados()
    {
        return $this->hasMany(\App\Models\VentasEmpleado::class, 'id_venta', 'id_venta');
    }
    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Venta
 *
 * @property $id
 * @property $fecha
 * @property $total
 * @property $empleado_id
 * @property $created_at
 * @property $updated_at
 *
 * @property Empleado $empleado
 * @property VentasEmpleado[] $ventasEmpleados
 * @property VentaProducto[] $ventaProductos
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
    protected $fillable = ['fecha', 'total', 'empleado_id'];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, "venta_producto", "id_venta", "id_producto")
            ->withPivot("cantidad", "subtotal");
    }
}

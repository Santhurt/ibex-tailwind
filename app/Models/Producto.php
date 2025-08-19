<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Producto
 *
 * @property $id
 * @property $nombre
 * @property $descripcion
 * @property $precio
 * @property $stock
 * @property $created_at
 * @property $updated_at
 *
 * @property Notificacione[] $notificaciones
 * @property OrdenesDetalle[] $ordenesDetalles
 * @property RecetasIngrediente[] $recetasIngredientes
 * @property Comentario[] $comentarios
 * @property Descuento[] $descuentos
 * @property DetallePedido[] $detallePedidos
 * @property ImagenesProd[] $imagenesProds
 * @property DetallesPedido[] $detallesPedidos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Producto extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['nombre', 'descripcion', 'precio', 'stock'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notificaciones()
    {
        return $this->hasMany(\App\Models\Notificacione::class, 'id_producto', 'id_producto');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ordenesDetalles()
    {
        return $this->hasMany(\App\Models\OrdenesDetalle::class, 'id_producto', 'id_producto');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recetasIngredientes()
    {
        return $this->hasMany(\App\Models\RecetasIngrediente::class, 'id_producto', 'id_producto');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comentarios()
    {
        return $this->hasMany(\App\Models\Comentario::class, 'id_producto', 'id_producto');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function descuentos()
    {
        return $this->hasMany(\App\Models\Descuento::class, 'id_producto', 'id_producto');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detallePedidos()
    {
        return $this->hasMany(\App\Models\DetallePedido::class, 'id_producto', 'id_producto');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function imagenesProds()
    {
        return $this->hasMany(\App\Models\ImagenesProd::class, 'id_producto', 'id_producto');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detallesPedidos()
    {
        return $this->hasMany(\App\Models\DetallesPedido::class, 'id', 'producto_id');
    }
    
}

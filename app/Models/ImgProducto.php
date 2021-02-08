<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImgProducto extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'img_producto';

    protected $fillable = [
        'nombre', 'producto_id'
    ];

    public function producto()
    {
        return $this->belongsTo('App\Models\Producto', 'producto_id');
    }
}

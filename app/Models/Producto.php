<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'producto';

    protected $fillable = [
        'nombre', 'precio', 'descripcion', 'uso_id', 'categoria_id', 'estado_id'
    ];

    protected $guarded = [
        'user_id', 'fecha'
    ];

    public function categoria()
    {
        return $this->belongsTo('App\Models\Categoria', 'categoria_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function img_productos()
    {
        return $this->hasMany('App\Models\ImgProducto');
    }

    public function uso()
    {
        return $this->belongsTo('App\Models\Uso', 'uso_id');
    }

    public function estado()
    {
        return $this->belongsTo('App\Models\Estado', 'estado_id');
    }

    public function mensajes()
    {
        return $this->hasMany('App\Models\Mensaje', 'mensaje_id', 'id');
    }
}

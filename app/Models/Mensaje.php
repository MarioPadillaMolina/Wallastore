<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    use HasFactory;

    protected $table = 'mensaje';

    protected $fillable = [
        'emisor_id', 'receptor_id', 'producto_id', 'mensaje', 'leido'
    ];

    public function usuario()
    {
        return $this->hasMany('App\Models\User');
    }

    public function producto()
    {
        return $this->belongsTo('App\Models\Producto', 'producto_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categoria';

    protected $fillable = [
        'nombre',
    ];

    public function productos() {//relacion 1:N ->esta es la parte del 1 (1 categoria tiene N productos)
        return $this->hasMany ('App\Models\Producto', 'producto_id'); //hay que especificar la clave foranea, su nombre, por haber cambiado el nommbre de la tabla por defecto
    }
}

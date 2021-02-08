<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Megusta extends Model
{
    use HasFactory;

    protected $table = 'megusta';

    protected $fillable = [
        'producto_id'
    ];

    protected $guarded = [
        'user_id'
    ];

    public function producto()
    {
        return $this->belongsTo('App\Models\Producto', 'producto_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}

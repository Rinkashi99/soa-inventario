<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class productos extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'precio',
        'sku'
    ];

    public function tienda()
    {
        return $this->hasMany(productos_tienda::class, 'producto_id', 'sku');
    }
}

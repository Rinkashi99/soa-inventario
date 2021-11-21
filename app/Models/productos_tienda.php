<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class productos_tienda extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'tienda_id',
        'producto_id',
        'stock'
    ];

    public function producto()
    {
        return $this->hasOne(productos::class, 'sku', 'producto_id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compras extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'compra_id';

    protected $casts = [
        'horario' => 'datetime',
    ];

    public function produtosCompras()
    {
        return $this->hasMany(ProdutosCompras::class, 'compra_id', 'compra_id');
    }

    public function status()
    {
        return $this->belongsTo(ComprasStatus::class, 'status_id', 'status_id');
    }

    public function getQuantidadeTotalAttribute()
    {
        return $this->produtosCompras->sum('quantidade');
    }
}
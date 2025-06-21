<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutosCompras extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $primaryKey = 'produto_compra_id';

    public function produtoEstoque()
    {
        return $this->belongsTo(ProdutosEstoques::class, 'produto_estoque_id', 'produto_estoque_id');
    }

    public function compra()
    {
        return $this->belongsTo(Compras::class, 'compra_id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutosEstoque extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'produto_estoque_id';

    public function produto()
    {
        return $this->belongsTo(Produtos::class, 'produto_id', 'produto_id');
    }

    public function cor()
    {
        return $this->belongsTo(Cores::class, 'cor_id', 'cor_id');
    }

    public function tamanho()
    {
        return $this->belongsTo(Tamanhos::class, 'tamanho_id', 'tamanho_id');
    }
}
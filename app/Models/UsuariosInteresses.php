<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuariosInteresses extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'usuario_interesse_id';

    public function produtoEstoque()
    {
        return $this->belongsTo(ProdutosEstoques::class, 'produto_estoque_id', 'produto_estoque_id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'usuario_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Produtos;
use App\Models\Usuario;

class ProdutosEstoques extends Model
{
    use HasFactory;

    protected $table = 'Produtos_Estoques';
    protected $primaryKey = 'produto_estoque_id';
    public $timestamps = false;

    protected $fillable = [
        'produto_id',
        'tamanho_id',
        'cor_id',
        'prontaEntrega',
        'unidades',
        'excluido',
    ];

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

    public function interessados()
    {
        return $this->belongsToMany(
            Usuario::class,
            'Usuarios_Interesses',
            'produto_estoque_id',
            'usuario_id'
        )->withPivot('usuario_interesse_id');
    }
}

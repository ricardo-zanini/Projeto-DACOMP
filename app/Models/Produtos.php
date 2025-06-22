<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProdutosEstoques;
use App\Models\Usuario;

class Produtos extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'produto_id';

    public function estoque()
    {
        return $this->hasMany(ProdutosEstoques::class, 'produto_id', 'produto_id');
    }
    public function estoqueIndisponivel()
    {
        return $this->estoque()->where('unidades', 0);
    }

    public function totalInteresse(): int
    {
        return $this->estoqueIndisponivel()
                    ->get()
                    ->sum(fn($e) => $e->interessados()->count());
    }

}

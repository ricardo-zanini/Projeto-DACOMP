<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produtos extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'produto_id';

    public function estoque()
    {
        return $this->hasMany(ProdutosEstoques::class, 'produto_id', 'produto_id');
    }
}

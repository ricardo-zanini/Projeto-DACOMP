<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiposProdutos extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'tipo_produto_id';
}

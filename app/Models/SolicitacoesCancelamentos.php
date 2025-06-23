<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitacoesCancelamentos extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $primaryKey = 'solicitacao_cancelamento_id';
}
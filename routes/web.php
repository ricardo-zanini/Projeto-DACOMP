<?php

use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\ProdutosController;
use App\Http\Controllers\ComprasController;
use App\Http\Controllers\InteressesController;
use App\Http\Controllers\RelatoriosController;
use App\Http\Controllers\Home;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

//============================================================================================
// Rota de Início da aplicação
Route::get('/', function () {return view('home.index');})->name('home');

//============================================================================================
// Rotas para cadastro de usuários
Route::get('/cadastrar', [UsuariosController::class, 'create'])->name('usuarios.inserir');
Route::post('/cadastrar', [UsuariosController::class, 'insert'])->name('usuarios.gravar');

//============================================================================================
// Rotas para login / logout
Route::get('/login', [UsuariosController::class, 'login'])->name('login');
Route::post('/login', [UsuariosController::class, 'login']);
Route::get('/logout', [UsuariosController::class, 'logout'])->name('logout');

//============================================================================================
// Rotas de edição de dados
Route::get('/perfil/edit', [UsuariosController::class, 'edit'])->middleware('auth')->name('perfil.edit');
Route::put('/perfil/edit', [UsuariosController::class, 'update'])->middleware('auth')->name('perfil.update');
Route::get('/perfil/trocarSenha', [UsuariosController::class, 'alterar_senha'])->middleware('auth')->name('senha.edit');
Route::put ('/perfil/trocarSenha', [UsuariosController::class, 'update_senha'])->middleware('auth')->name('senha.update');

//============================================================================================
// Rotas de Produtos
Route::get('/produtos/catalogo', [ProdutosController::class, 'list'])->name('produtos.list');
Route::get('/produtos/cadastro', [ProdutosController::class, 'create'])->middleware('auth')->name('produtos.create');
Route::post('/produtos/cadastro', [ProdutosController::class, 'insert'])->middleware('auth')->name('produtos.gravar');
Route::post('/produtos/delete', [ProdutosController::class, 'delete'])->middleware('auth')->name('produtos.delete');
Route::get('/produtos/pesquisar', [ProdutosController::class, 'search'])->name('produtos.search');
Route::get('/produtos/{produto}', [ProdutosController::class, 'show'])->name('produtos.show');
Route::get('/produtos/editar/{produto}', [ProdutosController::class, 'edit'])->middleware('auth')->name('produtos.edit');
Route::post('/produtos/editar/{produto}', [ProdutosController::class, 'update'])->middleware('auth')->name('produtos.update');
Route::post('/produtos-estoque/{estoque}/interesse',[ProdutosController::class, 'demonstrarInteresse'])->middleware('auth')->name('estoque.interesse');

//============================================================================================
// Rotas de Compras
Route::get('/pedidos', [ComprasController::class, 'list'])->name('compras.list');
Route::get('/carrinho', [ComprasController::class, 'show'])->name('compras.show');
Route::post('/pedidos/cadastro', [ComprasController::class, 'createOrder'])->middleware('auth')->name('compras.create');
Route::post('/pedidos/cadastro', [ComprasController::class, 'insert'])->middleware('auth')->name('compras.gravar');

Route::get('/relatorios/pedidos', [ComprasController::class, 'relatorios'])->middleware('auth')->name('pedidos.relatorios');
Route::get('/relatorios/pedidos/entrega/{pedido}', [ComprasController::class, 'confirmacaoEntrega'])->name('pedidos.entrega');

Route::get('/pedidos/cancelamentos', [ComprasController::class, 'cancelamentos'])->middleware('auth')->name('compras.cancelamentos');
Route::post('/pedidos/remove', [ComprasController::class, 'cancel'])->middleware('auth')->name('compras.cancel');

Route::post('/carrinho/{compra}/add/{item}',    [ComprasController::class, 'add'])->middleware('auth')->name('compras.add');
Route::post('/carrinho/{compra}/remove/{item}', [ComprasController::class, 'remove'])->middleware('auth')->name('compras.remove');
Route::post('/carrinho/{compra}/delete/{item}', [ComprasController::class, 'delete'])->middleware('auth')->name('compras.delete');
Route::get('/pagamento/{compra}', [ComprasController::class, 'pagamento'])->middleware('auth')->name('compras.pagamento');


//============================================================================================
// Rotas de Interesse
Route::get('/interesses', [InteressesController::class, 'list'])->name('interesses.list');
Route::post('/interesses/{interesse}/remove', [InteressesController::class, 'cancel'])->middleware('auth')->name('interesses.cancel');
Route::post('/interesses/cadastro', [InteressesController::class, 'insert'])->middleware('auth')->name('interesses.gravar');
Route::get('/relatorios/interesses', [InteressesController::class, 'relatorios'])->middleware('auth')->name('interesses.relatorios');

//============================================================================================
// Rotas de Relatório
Route::get('/relatorios', [RelatoriosController::class, 'list'])->middleware('auth')->name('relatorios.list');
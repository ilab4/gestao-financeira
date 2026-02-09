<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'SubdominioController@index');

Route::group(['prefix' => 'financeiro', 'namespace' => 'Financeiro'], function()
{
  
  Route::get('/', 'IndexController@index');
  Route::post('/login', 'LoginController@login');
  Route::get('/dashboard', 'DashboardController@index');
  
  Route::get('/contas', 'ContaController@index');
  Route::get('/conta/novo', 'ContaController@novo');
  Route::get('/conta/editar/{id}', 'ContaController@editar');
  Route::post('/conta/salvar', 'ContaController@salvar');
  
  Route::get('/bancos', 'BancoController@index');
  Route::get('/banco/novo', 'BancoController@novo');
  Route::get('/banco/editar/{id}', 'BancoController@editar');
  Route::post('/banco/salvar', 'BancoController@salvar');
  
  Route::get('/cargos', 'CargoController@index');
  Route::get('/cargo/novo', 'CargoController@novo');
  Route::get('/cargo/editar/{id}', 'CargoController@editar');
  Route::post('/cargo/salvar', 'CargoController@salvar');
  
  Route::get('/categorias', 'CategoriaController@index');
  Route::get('/categoria/novo', 'CategoriaController@novo');
  Route::get('/categoria/editar/{id}', 'CategoriaController@editar');
  Route::post('/categoria/salvar', 'CategoriaController@salvar');
  
  Route::get('/meios-de-pagamento', 'MeioPagamentoController@index');
  Route::get('/meios-de-pagamento/novo', 'MeioPagamentoController@novo');
  Route::get('/meios-de-pagamento/editar/{id}', 'MeioPagamentoController@editar');
  Route::post('/meios-de-pagamento/salvar', 'MeioPagamentoController@salvar');
  
  Route::get('/documento-tipo', 'DocumentoTipoController@index');
  Route::get('/documento-tipo/novo', 'DocumentoTipoController@novo');
  Route::get('/documento-tipo/editar/{id}', 'DocumentoTipoController@editar');
  Route::post('/documento-tipo/salvar', 'DocumentoTipoController@salvar');
  
  Route::get('/conta-tipo', 'ContaTipoController@index');
  Route::get('/conta-tipo/novo', 'ContaTipoController@novo');
  Route::get('/conta-tipo/editar/{id}', 'ContaTipoController@editar');
  Route::post('/conta-tipo/salvar', 'ContaTipoController@salvar');
  
  Route::get('/plano-de-contas', 'PlanoContasController@index');
  Route::get('/plano-de-contas/novo/{id}', 'PlanoContasController@novo');
  Route::get('/plano-de-contas/editar/{id}', 'PlanoContasController@editar');
  Route::post('/plano-de-contas/salvar', 'PlanoContasController@salvar');
  
  Route::get('/centro-de-custo', 'CentroCustoController@index');
  Route::get('/centro-de-custo/novo', 'CentroCustoController@novo');
  Route::get('/centro-de-custo/editar/{id}', 'CentroCustoController@editar');
  Route::post('/centro-de-custo/salvar', 'CentroCustoController@salvar');
  
  Route::get('/configuracao', 'ConfiguracaoController@sistema');
  Route::post('/configuracao/salvar', 'ConfiguracaoController@sistema_salvar');

  Route::get('/lancamento/depositar', 'LancamentoController@index');
  Route::post('/lancamento/depositar', 'LancamentoController@index');
  Route::get('/lancamento/pagar', 'LancamentoController@index');
  Route::post('/lancamento/pagar', 'LancamentoController@index');
  Route::get('/lancamento/transferir', 'LancamentoController@index');
  Route::get('/lancamento/editar/{id}', 'LancamentoController@editar');
  Route::get('/lancamento/excluir/{id}', 'LancamentoController@excluir');
  Route::post('/lancamento/salvar', 'LancamentoController@salvar');
  Route::post('/transferencia/salvar', 'LancamentoController@salvar_transferencia');
  
  Route::get('/programado/a-receber', 'ProgramacaoController@index');
  Route::get('/programado/a-pagar', 'ProgramacaoController@index');

  Route::get('/pessoa/clientes', 'PessoaController@index');
  Route::get('/pessoa/clientes/novo', 'PessoaController@novo');
  Route::get('/pessoa/fornecedores', 'PessoaController@index');
  Route::get('/pessoa/fornecedores/novo', 'PessoaController@novo');
  Route::get('/pessoa/colaboradores', 'PessoaController@index');
  Route::get('/pessoa/colaboradores/novo', 'PessoaController@novo');
  Route::get('/pessoa/editar/{id}', 'PessoaController@editar');
  Route::post('/pessoa/salvar', 'PessoaController@salvar');
  Route::get('/pessoa/{id}/programadas', 'ProgramacaoController@index_parcelas');
  Route::get('/pessoa/programado/excluir/{id}', 'ProgramacaoController@pessoa_excluir');
  
  Route::get('/relatorio/saldo-contas', 'RelatorioController@saldo_contas');
  Route::post('/relatorio/saldo-contas', 'RelatorioController@saldo_contas');
  Route::get('/relatorio/extrato-contas', 'RelatorioController@extrato_contas');
  Route::post('/relatorio/extrato-contas', 'RelatorioController@extrato_contas');
  Route::get('/relatorio/razao', 'RelatorioController@razao');
  Route::get('/relatorio/fluxo-caixa', 'RelatorioController@fluxo_caixa');
  Route::post('/relatorio/fluxo-caixa', 'RelatorioController@fluxo_caixa');
  Route::get('/relatorio/receitas-depesas-cliente', 'RelatorioController@receitas_despesas');
  Route::post('/relatorio/receitas-depesas-cliente', 'RelatorioController@receitas_despesas');
  Route::get('/relatorio/fluxo-caixa-conta', 'RelatorioController@fluxo_caixa_conta');
  Route::get('/relatorio/demonstrativo-financeiro', 'RelatorioController@demonstrativo');
  Route::post('/relatorio/demonstrativo-financeiro', 'RelatorioController@demonstrativo');
  Route::get('/relatorio/demonstrativo-financeiro-excel', 'RelatorioController@demonstrativo_excel');
  
  Route::get('/usuarios', 'UsuarioController@index');
  Route::get('/usuario/novo', 'UsuarioController@novo');
  Route::get('/usuario/editar/{id}', 'UsuarioController@editar');
  Route::get('/usuario/excluir/{id}', 'UsuarioController@excluir');
  Route::post('/usuario/salvar', 'UsuarioController@salvar'); 
  
  Route::get('/integracoes', 'IntegracaoController@index');
  
  Route::post('/ajaxPlanoContas', 'LancamentoController@_ajax_planocontas');
  Route::post('/ajaxCpf', 'PessoaController@_ajax_cnpj_cpf');
  Route::post('/ajaxCep', 'PessoaController@_ajax_cep');
  
  Route::get('/sair', 'LoginController@sair');
  
});
<?php
if(isset($p)):
    $return_id = $p->id;
    $return_nome = $p->nome;
    $return_nome_fantasia = $p->nome_fantasia;
    $return_razao_social = $p->razao_social;
    $return_email = $p->email;
    $return_cnpj_cpf = $p->cnpj_cpf;
    $return_ie = $p->ie;
    $return_rg = $p->rg;
    $return_tipo_pessoa = $p->tipo_pessoa;
    $return_tipo_cadastro = $p->tipo_cadastro;
    $return_cargo_id = $p->cargo_id;
    $return_nascimento = $p->nascimento;
    $return_sexo = $p->sexo;
    $return_categoria_id = $p->categoria_id;
    $return_telefone1 = $p->telefone1;
    $return_telefone2 = $p->telefone2;
    $return_celular = $p->celular;
    $return_endereco_tipo = $p->endereco_tipo;
    $return_endereco = $p->endereco;
    $return_numero = $p->numero;
    $return_complemento = $p->complemento;
    $return_bairro = $p->bairro;
    $return_cidade = $p->cidade;
    $return_uf = $p->uf;
    $return_cep = $p->cep;
    $return_endereco2 = $p->endereco2;
    $return_numero2 = $p->numero2;
    $return_complemento2 = $p->complemento2;
    $return_bairro2 = $p->bairro2;
    $return_cidade2 = $p->cidade2;
    $return_uf2 = $p->uf2;
    $return_cep2 = $p->cep2;
    $return_conta_banco = $p->conta_banco;
    $return_conta_tipo = $p->conta_tipo;
    $return_conta_agencia = $p->conta_agencia;
    $return_conta_numero = $p->conta_numero;
    $return_conta_obs = $p->conta_obs;
    $return_obs = $p->obs;
    $return_ativo = $p->ativo;
else:
    $return_id = '';
    $return_nome = '';
    $return_nome_fantasia = '';
    $return_razao_social = '';
    $return_email = '';
    $return_cnpj_cpf = '';
    $return_ie = '';
    $return_rg = '';
    $return_tipo_pessoa = '';
    $return_tipo_cadastro = '';
    $return_cargo_id = '';
    $return_nascimento = '';
    $return_sexo = '';
    $return_categoria_id = '';
    $return_telefone1 = '';
    $return_telefone2 = '';
    $return_celular = '';
    $return_endereco_tipo = '';
    $return_endereco = '';
    $return_numero = '';
    $return_complemento = '';
    $return_bairro = '';
    $return_cidade = '';
    $return_uf = '';
    $return_cep = '';
    $return_endereco2 = '';
    $return_numero2 = '';
    $return_complemento2 = '';
    $return_bairro2 = '';
    $return_cidade2 = '';
    $return_uf2 = '';
    $return_cep2 = '';
    $return_conta_banco = '';
    $return_conta_tipo = '';
    $return_conta_agencia = '';
    $return_conta_numero = '';
    $return_conta_obs = '';
    $return_obs = '';
    $return_ativo = '1';
endif;


if(!isset($area)):
    if($return_tipo_cadastro == 'cliente'):
        $area = 'clientes';
    elseif($return_tipo_cadastro == 'colaborador'):
        $area = 'colaboradores';
    elseif($return_tipo_cadastro == 'fornecedor'):
        $area = 'fornecedores';
    endif;
endif;
?>


@extends('financeiro.admin')

@section('conteudo')

<style>
    .thumb-image{
        width: 160px;
        height: 100px;
    }
</style>


<div class="main-container container-fluid">

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">{{ strtoupper($area) }}</span>
        </div>
    </div>
    <!-- /breadcrumb -->

    <!-- row -->
    <div class="row row-sm">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="card  box-shadow-0 ">
                <div class="card-header">
                    <h4 class="card-title mb-1">Cadastrar/Editar</h4>
                </div>
                <div class="card-body pt-0">

            <form id="formUsuario" method="post" action="/financeiro/pessoa/salvar" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php print $return_id; ?>">
                <input type="hidden" name="area" value="<?php print $area; ?>">
                {{ csrf_field() }}
                <!-- text input -->

                <div class="box-body">
                        
                    
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tipo</label>
                                    <select name="tipo" id="tipo" class="form-control" required>
                                        <option value="" selected>Selecione</option>
                                        <option value="Pessoa Fisica" {{ ($return_tipo_pessoa == 'Pessoa Fisica') ? "selected" : "" }}>Pessoa Fisica</option>
                                        <option value="Pessoa Juridica" {{ ($return_tipo_pessoa == 'Pessoa Juridica') ? "selected" : "" }}>Pessoa Juridica</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4" id="box-cnpj-cpf" style="display: none;">
                                <div class="form-group">
                                    <label><span id="label-cnpj-cpf"></span></label><span id="has-error-cpf" style="color: red;"></span>
                                    <input type="text" name="cnpj_cpf" id="cnpj_cpf" maxlength="20" value="<?php print $return_cnpj_cpf; ?>" class="form-control cnpj_cpf2">
                                </div>
                            </div>
                        </div>
                        
                        
                        <div id="box-dados" style="display: none;">
                            
                            <hr style="border-top: 1px solid #f4f4f4;">
                            <h4><i class="fas fa-info-circle"></i> Informações Básicas</h4>
                            <div class="row" style="margin-bottom: 20px;"></div>


<!--                            <div id="box-pj" style="display: none;">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Razão Social</label>
                                            <input type="text" name="razao_social" id="razao_social" maxlength="100" value="<?php print $return_razao_social; ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Nome Fantasia</label>
                                            <input type="text" name="nome_fantasia" id="nome_fantasia" maxlength="100" value="<?php print $return_nome_fantasia; ?>" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>IE</label>
                                            <input type="text" name="ie" maxlength="20" value="<?php print $return_ie; ?>" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>-->

<!--                            <div id="box-pf" style="display: none;">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Nome</label>
                                            <input type="text" name="nome" id="nome" maxlength="100" value="<?php print $return_nome; ?>" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>RG</label>
                                            <input type="text" name="rg" maxlength="20" value="<?php print $return_rg; ?>" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>-->


                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Nome</label>
                                        <input type="text" name="nome" id="nome" maxlength="100" value="<?php print $return_nome; ?>" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Categoria</label>
                                        <select name="categoria" class="form-control">
                                            <option value="" selected></option>
                                            @foreach($categorias as $categoria)
                                            <option value="{{ $categoria->id }}" {{ ($return_categoria_id == $categoria->id) ? "selected" : "" }}>{{ $categoria->descricao }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Observações</label>
                                        <textarea name="obs" class="form-control"><?php print $return_obs; ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <hr style="border-top: 1px solid #f4f4f4;">
                            <h4><i class="far fa-address-book"></i> Informações de Contato</h4>
                            <div class="row" style="margin-bottom: 20px;"></div>


                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="email" maxlength="100" value="<?php print $return_email; ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Celular</label>
                                        <input type="text" name="celular" maxlength="20" value="<?php print $return_celular; ?>" class="form-control whats">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Telefone 1</label>
                                        <input type="text" name="telefone1" maxlength="20" value="<?php print $return_telefone1; ?>" class="form-control whats">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Telefone 2</label>
                                        <input type="text" name="telefone2" maxlength="20" value="<?php print $return_telefone2; ?>" class="form-control whats">
                                    </div>
                                </div>
                            </div>


                            <hr style="border-top: 1px solid #f4f4f4;">
                            <h4><i class="fas fa-map-marker-alt"></i> Informações de Localização</h4>
                            <div class="row" style="margin-bottom: 20px;"></div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>CEP</label>
                                        <input type="text" name="cep" id="cep" maxlength="10" value="<?php print $return_cep; ?>" class="form-control cep">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Endereço</label>
                                        <input type="text" name="endereco" id="endereco" maxlength="100" value="<?php print $return_endereco; ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Numero</label>
                                        <input type="text" name="numero" id="numero" maxlength="10" value="<?php print $return_numero; ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Complemento</label>
                                        <input type="text" name="complemento" id="complemento" maxlength="40" value="<?php print $return_complemento; ?>" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Bairro</label>
                                        <input type="text" name="bairro" id="bairro" maxlength="50" value="<?php print $return_bairro; ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Cidade</label>
                                        <input type="text" name="cidade" id="cidade" maxlength="50" value="<?php print $return_cidade; ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>UF</label>
                                        <input type="text" name="uf" id="uf" maxlength="2" value="<?php print $return_uf; ?>" class="form-control">
                                    </div>
                                </div>
                            </div>


                            <hr style="border-top: 1px solid #f4f4f4;">
                            <h4><i class="fas fa-university"></i> Informações Bancárias</h4>
                            <div class="row" style="margin-bottom: 20px;"></div>


                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Banco</label>
                                        <select name="conta_banco" class="form-control">
                                            <option value="0" selected></option>
                                            @foreach($bancos as $banco)
                                                <option value="{{ $banco->descricao }}" {{ ($return_conta_banco == $banco->descricao) ? "selected" : "" }}>{{ $banco->numero }} - {{ $banco->descricao }}</option>
                                            @endforeach;
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Tipo da Conta</label>
                                        <select name="conta_tipo" class="form-control">
                                            <option value="" selected></option>
                                            <option value="corrente" {{ ($return_conta_tipo == 'corrente') ? "selected" : "" }}>Corrente</option>
                                            <option value="poupanca" {{ ($return_conta_tipo == 'poupanca') ? "selected" : "" }}>Poupança</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Agência</label>
                                        <input type="text" name="conta_agencia" maxlength="10" value="<?php print $return_conta_agencia; ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Conta</label>
                                        <input type="text" name="conta_numero" maxlength="20" value="<?php print $return_conta_numero; ?>" class="form-control">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Observações Bancárias</label>
                                        <textarea name="conta_obs" class="form-control"><?php print $return_conta_obs; ?></textarea>
                                    </div>
                                </div>
                            </div>



                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="ativo" class="form-control" required>
                                            <option value=""></option>
                                            <option value="1" <?php if($return_ativo == 1) echo('selected'); ?>>Ativo</option>
                                            <option value="0" <?php if($return_ativo == 0) echo('selected'); ?>>Inativo</option>
                                        </select> 
                                    </div>
                                </div>
                            </div>
                        
                        
                        </div>
                    
                </div>

                <div class="box-footer" id="box-submit" style="display: none;">
                    <button type="submit" id="razao-salvar" class="btn btn-primary btnCadastro pull-left">Salvar</button>
                </div> 

            </form>    
                    
            </div>
            </div>
        </div>
    </div>
    <!-- row -->

</div>
    
    
@endsection
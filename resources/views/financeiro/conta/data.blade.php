<?php
if(isset($resultado)):
    $return_id = $resultado->id;
    $return_nome = $resultado->nome;
    $return_conta_tipo_id = $resultado->conta_tipo_id;
    $return_banco_id = $resultado->banco_id;
    $return_agencia = $resultado->agencia;
    $return_numero = $resultado->numero;
    $return_abertura = $resultado->abertura->format('d/m/Y');
    $return_contato = $resultado->contato;
    $return_telefone = $resultado->telefone;
    $return_email = $resultado->email;
    $return_obs = $resultado->obs;
    $return_ativo = $resultado->ativo;
    $return_dashboard = $resultado->dashboard;
    
    $return_valor = $resultado->valor;
    if($return_valor < 0):
        $valor = $return_valor * (-1);
    else:
        $valor = $return_valor;
    endif;

    $return_valor = number_format($valor, 2, ",", "");
else:
    $return_id = '';
    $return_nome = '';
    $return_conta_tipo_id = '';
    $return_banco_id = '';
    $return_agencia = '';
    $return_numero = '';
    $return_abertura = '';
    $return_valor = '0.00';
    $return_contato = '';
    $return_telefone = '';
    $return_email = '';
    $return_obs = '';
    $return_ativo = '1';
    $return_dashboard = '0';
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
            <span class="main-content-title mg-b-0 mg-b-lg-1">CONTAS</span>
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
            
            
            <form id="formUsuario" method="post" action="/financeiro/conta/salvar" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php print $return_id; ?>">
                {{ csrf_field() }}
                <!-- text input -->

                <div class="box-body">
                    
                    <div class="card">
                        <!-- Nav tabs -->
                        
                        <ul class="nav panel-tabs main-nav-line" style="margin-bottom: 30px;">
                            <!--<li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#network" role="tab">Network - Binary</a> </li>-->
                            <li class="nav-item"> <a class="nav-link active" data-bs-toggle="tab" href="#geral" role="tab">Geral</a> </li>
                            <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#outras" role="tab">Outras Informações</a> </li>
                        </ul>
                                   
                        <div class="tab-content">
                            <div class="tab-pane active" id="geral" role="tabpanel" style="height: auto !important;">
                                <div class="card-body">
                                    
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Nome</label>
                                                <input type="text" name="nome" maxlength="100" value="<?php print $return_nome; ?>" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Tipo de Conta</label>
                                                <select name="conta_tipo_id" id="conta_tipo_id" class="form-control" required>
                                                    <option value="" selected></option>
                                                    @foreach($conta_tipo as $menu)
                                                        <option value="{{ $menu->id }}" {{ ($return_conta_tipo_id == $menu->id) ? "selected" : "" }}>{{ $menu->descricao }}</option>
                                                    @endforeach;
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Banco</label>
                                                <select name="banco_id" id="conta_tipo_id" class="form-control">
                                                    <option value="" selected></option>
                                                    @foreach($bancos as $menu)
                                                        <option value="{{ $menu->id }}" {{ ($return_banco_id == $menu->id) ? "selected" : "" }}>{{ $menu->descricao }} - {{ $menu->numero }}</option>
                                                    @endforeach;
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Agência</label>
                                                <input type="text" name="agencia" maxlength="10" value="<?php print $return_agencia; ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Conta</label>
                                                <input type="text" name="conta" maxlength="20" value="<?php print $return_numero; ?>" class="form-control">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Data de Abertura</label>
                                                <input type="text" name="abertura" maxlength="10" value="<?php print $return_abertura; ?>" class="form-control fc-datepicker2 datemask" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Saldo de Abertura</label>
                                                <input type="text" name="valor" maxlength="20" value="<?php print $return_valor; ?>" class="form-control dinheiro">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Mostrar no Dashboard?</label>
                                                <select name="dashboard" class="form-control" required>
                                                    <option value=""></option>
                                                    <option value="1" <?php if($return_dashboard == 1) echo('selected'); ?>>Sim</option>
                                                    <option value="0" <?php if($return_dashboard == 0) echo('selected'); ?>>Não</option>
                                                </select> 
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
                            
                            <div class="tab-pane" id="outras" role="tabpanel" style="height: auto !important;">
                                <div class="card-body">
                                    
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Contato</label>
                                                <input type="text" name="contato" maxlength="100" value="<?php print $return_contato; ?>" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Telefone</label>
                                                <input type="text" name="telefone" maxlength="20" value="<?php print $return_telefone; ?>" class="form-control telefone">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" name="email" maxlength="100" value="<?php print $return_email; ?>" class="form-control">
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
                                    
                                </div>
                            </div>
                        </div>    
                        
                    </div>
                    
                        
                    
                </div>

                <div class="box-footer">
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
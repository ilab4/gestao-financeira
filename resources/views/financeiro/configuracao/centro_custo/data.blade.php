<?php
if(isset($data)):
    $return_id = $data->id;
    $return_descricao = $data->descricao;
    $return_plano_contas_id = $data->parent_id;
    $return_responsavel = $data->responsavel;
    $return_email = $data->email;
    $return_telefone = $data->telefone;
    $return_ramal = $data->ramal;
    $return_ativo = $data->ativo;
else:
    $return_id = '';
    $return_descricao = '';
    $return_plano_contas_id = '';
    $return_responsavel = '';
    $return_email = '';
    $return_telefone = '';
    $return_ramal = '';
    $return_ativo = '1';
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
            <span class="main-content-title mg-b-0 mg-b-lg-1">CENTRO DE CUSTO</span>
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
            
            
            <form id="formUsuario" method="post" action="/financeiro/centro-de-custo/salvar" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php print $return_id; ?>">
                
                {{ csrf_field() }}
                <!-- text input -->

                <div class="box-body">
                    
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Descrição</label>
                                    <input type="text" name="descricao" maxlength="100" value="<?php print $return_descricao; ?>" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Sub-categoria de</label>
                                    <select name="centro_custo_id" id="plano_contas_id" class="form-control">
                                        <option value="" selected></option>
                                        @foreach($cc as $menu)
                                            <option value="{{ $menu->id }}" {{ ($return_plano_contas_id == $menu->id) ? "selected" : "" }}>{{ $menu->descricao }}</option>
                                        @endforeach;
                                    </select>
                                    <small>Ao configurar como sub-categoria de um item pai, o "Tipo de Plano de Contas" preeenchido acima será ignorado</small>
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
                    
                        <hr style="border-color: #f4f4f4;">
                    
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Responsável</label>
                                    <input type="text" name="responsavel" maxlength="100" value="<?php print $return_responsavel; ?>" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" maxlength="100" value="<?php print $return_email; ?>" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Telefone</label>
                                    <input type="text" name="telefone" maxlength="20" value="<?php print $return_telefone; ?>" class="form-control whats">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Ramal</label>
                                    <input type="text" name="ramal" maxlength="5" value="<?php print $return_ramal; ?>" class="form-control">
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
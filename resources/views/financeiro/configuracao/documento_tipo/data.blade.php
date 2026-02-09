<?php
if(isset($resultado)):
    $return_id = $resultado->id;
    $return_descricao = $resultado->descricao;
    $return_ativo = $resultado->ativo;
else:
    $return_id = '';
    $return_descricao = '';
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
            <span class="main-content-title mg-b-0 mg-b-lg-1">TIPO DE DOCUMENTO</span>
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
            
            
            <form id="formUsuario" method="post" action="/financeiro/documento-tipo/salvar" enctype="multipart/form-data">
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
<?php
if(isset($p)):
    $return_id = $p->id;
    $return_descricao = $p->descricao;
    $return_ativo = $p->ativo;
else:
    
    $return_id = '';
    $return_descricao = '';
    $return_ativo = '1';
endif;
?>


@extends('painel.admin')

@section('conteudo')

<style>
    .thumb-image{
        width: 160px;
        height: 100px;
    }
</style>

<!-- Content Header (Page header) -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tipos de Pagamento
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Cadastrar/Editar</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
            
            <form id="formUsuario" method="post" action="/painel/tipos-de-pagamento/salvar" enctype="multipart/form-data">
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
          <!-- /.box -->

        </div>
        <!--/.col (left) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
    
    
@endsection
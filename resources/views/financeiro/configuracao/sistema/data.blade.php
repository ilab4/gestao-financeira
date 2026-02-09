<?php $url_base = getenv('URL_BASE_FIN'); ?>
<?php
if(isset($sistema)):

    $return_id = $sistema->id;
    $return_nome = $sistema->nome;
    $return_email = $sistema->email;
    $return_cnpj = $sistema->cnpj;
    $return_telefone = $sistema->telefone;
    $return_whatsapp = $sistema->whatsapp;
    $return_cep = $sistema->cep;
    $return_endereco = $sistema->endereco;
    $return_numero = $sistema->numero;
    $return_bairro = $sistema->bairro;
    $return_cidade = $sistema->cidade;
    $return_uf = $sistema->uf;
    
endif;
?>


@extends('financeiro.admin')

@section('conteudo')

<!-- Content Header (Page header) -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Configurações do Sistema
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
            
            
            <form id="formUsuario" method="post" action="/financeiro/configuracao/salvar" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php print $return_id; ?>">
                {{ csrf_field() }}
                <!-- text input -->

                <div class="box-body">
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Nome</label>
                                    <input type="text" name="nome" maxlength="100" value="<?php print $return_nome; ?>" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="email" maxlength="100" value="<?php print $return_email; ?>" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>CNPJ</label>
                                    <input type="text" name="cnpj" maxlength="18" value="<?php print $return_cnpj; ?>" class="form-control cnpj" required>
                                </div>
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Endereço</label>
                                    <input type="text" name="endereco" maxlength="100" value="<?php print $return_endereco; ?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Numero</label>
                                    <input type="text" name="numero" maxlength="20" value="<?php print $return_numero; ?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Bairro</label>
                                    <input type="text" name="bairro" maxlength="50" value="<?php print $return_bairro; ?>" class="form-control">
                                </div>
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Cidade</label>
                                    <input type="text" name="cidade" maxlength="50" value="<?php print $return_cidade; ?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>UF</label>
                                    <input type="text" name="uf" maxlength="2" value="<?php print $return_uf; ?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>CEP</label>
                                    <input type="text" name="cep" maxlength="10" value="<?php print $return_cep; ?>" class="form-control">
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
                                    <label>Whatsapp</label>
                                    <input type="text" name="whatsapp" maxlength="20" value="<?php print $return_whatsapp; ?>" class="form-control whats">
                                </div>
                            </div>
                        </div>
                    
                </div>

                <div class="box-footer">
                    <button type="submit" id="razao-salvar" class="btn btn-primary btnCadastro pull-right">Salvar Configuração</button>
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
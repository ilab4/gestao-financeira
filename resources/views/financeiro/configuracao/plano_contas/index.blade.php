<?php $url_base = getenv('URL_BASE'); ?>

@extends('financeiro.admin')

@section('conteudo')


<div class="main-container container-fluid">
    
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">PLANO DE CONTAS</span>
        </div>
    </div>

    <!-- Main content -->
      <div class="row row-sm">
          
        <div class="col-lg-6">
          
          <div class="card custom-card">
              <div class="card-body">
            <div class="breadcrumb-header justify-content-between">
                <div class="left-content">
                    <span class="main-content-title mg-b-0 mg-b-lg-1">Plano de Contas - Receitas</span>
                </div>
                <div class="right-content">
                    <a href="/financeiro/plano-de-contas/novo/receita" class="btn btn-success btn-sm d-lg-block m-l-15 text-white"><i class="fa fa-plus-circle"></i> Novo Item do Plano de Contas</a>
                </div>
            </div>  
              
            <!-- /.box-header -->
            <div class="table-responsive ">
              <table class="table table-bordered text-nowrap border-bottom" id="responsive-datatable-e2">
                <thead>
                <tr>
                  <th>Descrição</th>
                  <th>Status</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                
                <?php if(count($paginas_receita)): ?>  
                <?php foreach($paginas_receita['n0'] as $n0): ?>
                    <tr> 
                      <td><i class='fa fa-arrow-circle-o-right'></i> {{ $n0['titulo'] }}</td>
                      <td>{{ ($n0['status'] == 1) ? "Ativo" : "Inativo" }}</td>
                      <td>
                          <a href='/financeiro/plano-de-contas/editar/{{ $n0['id'] }}' class="btn btn-sm btn-info"><i class="far fa-edit"></i> Editar</a>
                      </td>
                    </tr>
                    <?php 
                    if(isset($paginas_receita['n1'][$n0['titulo']])):
                    foreach($paginas_receita['n1'][$n0['titulo']] as $n1): ?>
                        <tr>
                          <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-level-down-alt"></i> {{ $n1['titulo'] }}</td>
                          <td>{{ ($n1['status'] == 1) ? "Ativo" : "Inativo" }}</td>
                          <td>
                              <a href='/financeiro/plano-de-contas/editar/{{ $n1['id'] }}' class="btn btn-sm btn-info"><i class="far fa-edit"></i> Editar</a>
                          </td>
                        </tr>
                    <?php 
                    endforeach; 
                    endif;
                    ?>
                <?php endforeach; ?>  
                <?php endif; ?>            
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          </div>
          <!-- /.box -->
        </div>
          
        
        <div class="col-lg-6">
          
          <div class="card custom-card">
              
            <div class="card-body">  
            <div class="breadcrumb-header justify-content-between">
                <div class="left-content">
                    <span class="main-content-title mg-b-0 mg-b-lg-1">Plano de Contas - Despesas</span>
                </div>
                <div class="right-content">
                    <a href="/financeiro/plano-de-contas/novo/despesa" class="btn btn-danger btn-sm d-lg-block m-l-15 text-white"><i class="fa fa-plus-circle"></i> Novo Item do Plano de Contas</a>
                </div>
            </div>  
              
            <!-- /.box-header -->
            <div class="table-responsive ">
              <table class="table table-bordered text-nowrap border-bottom" id="responsive-datatable-e1">
                <thead>
                <tr>
                  <th>Descrição</th>
                  <th>Status</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                
                <?php if(count($paginas_despesa)): ?>    
                <?php foreach($paginas_despesa['n0'] as $n0): ?>
                    <tr> 
                      <td><i class='fa fa-arrow-circle-o-right'></i> {{ $n0['titulo'] }}</td>
                      <td>{{ ($n0['status'] == 1) ? "Ativo" : "Inativo" }}</td>
                      <td>
                          <a href='/financeiro/plano-de-contas/editar/{{ $n0['id'] }}' class="btn btn-sm btn-info"><i class="far fa-edit"></i> Editar</a>
                      </td>
                    </tr>
                    <?php 
                    if(isset($paginas_despesa['n1'][$n0['titulo']])):
                    foreach($paginas_despesa['n1'][$n0['titulo']] as $n1): ?>
                        <tr>
                          <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-level-down-alt"></i> {{ $n1['titulo'] }}</td>
                          <td>{{ ($n1['status'] == 1) ? "Ativo" : "Inativo" }}</td>
                          <td>
                              <a href='/financeiro/plano-de-contas/editar/{{ $n1['id'] }}' class="btn btn-sm btn-info"><i class="far fa-edit"></i> Editar</a>
                          </td>
                        </tr>
                    <?php 
                    endforeach; 
                    endif;
                    ?>
                <?php endforeach; ?>  
                <?php endif; ?>        
                            
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          </div>
          <!-- /.box -->
        </div>  
          
          
          
        <!-- /.col -->
      </div>
      <!-- /.row -->
    
</div>    
    
@endsection
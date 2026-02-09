<?php $url_base = getenv('URL_BASE'); ?>

@extends('painel.admin')

@section('conteudo')


<div class="main-container container-fluid">

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">TIPOS DE PAGAMENTO</span>
        </div>
    </div>


    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="breadcrumb-header justify-content-between">
                        <div class="left-content">
                            <span class="main-content-title mg-b-0 mg-b-lg-1">Listagem de Tipos de Pagamento</span>
                        </div>
                        <div class="right-content">
                            <a href="/financeiro/meios-de-pagamento/novo" class="btn btn-success btn-sm d-lg-block m-l-15 text-white"><i class="fa fa-plus-circle"></i> Novo Meio de Pagamento</a>
                        </div>
                    </div>
                    <div class="table-responsive ">
                        <table class="table table-bordered text-nowrap border-bottom" id="responsive-datatable">



    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tipos de Pagamento
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          
          <div class="box">
            <div class="box-header">
                <div class="col-md-6" style="padding-left: 0;">
                    <h3 class="box-title">Listagem de Tipos de Pagamento</h3>
                </div>  
                <div class="col-md-6 text-right">
                    <a href='/painel/tipos-de-pagamento/novo' class="btn btn-md btn-success"><i class="fa fa-plus"></i> Novo Tipo de Pagamento</a>
                    <a href="/painel/tipos-de-pagamento/download" target="blank"><button type="button" class="btn btn-default btn-md"><span><i class="fa fa-file-excel-o"></i> Exportar Excel</span></button></a>
                </div>  
              
              
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Descrição</th>
                  <th>Status</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($pagamentos_tipo as $pagamento_tipo)
                    <tr>
                        <td>{{ $pagamento_tipo->descricao }}</td>
                        <td>{{ ($pagamento_tipo->ativo == 1) ? "Ativo" : "Inativo" }}</td>
                        <td>
                            <a href='/painel/tipos-de-pagamento/editar/{{ $pagamento_tipo->id }}' class="btn btn-xs btn-default"><i class="fa fa-pencil"></i> Editar</a>
                        </td>
                    </tr>
                @endforeach 
                </tbody>
              </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
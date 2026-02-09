<?php $url_base = getenv('URL_BASE_FIN'); ?>

@extends('financeiro.admin')

@section('conteudo')


<div class="main-container container-fluid">

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">CONTAS</span>
        </div>
        <div class="right-content">
            <a href="/financeiro/conta/novo" class="btn btn-info btn-sm d-lg-block m-l-15 text-white"><i class="fa fa-plus-circle"></i> Nova Conta</a>
        </div>
    </div>


    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card custom-card">
                <div class="card-body">
                    <div>
                        <h6 class="main-content-label mb-1">Listagem de Contas</h6>
                        <!--<p class="text-muted card-sub-title">Responsive is an extension for DataTables that resolves that problem by optimising the table's layout for different screen sizes through the dynamic insertion and removal of columns from the table.</p>-->
                    </div>
                    <div class="table-responsive ">
                        <table class="table table-bordered text-nowrap border-bottom" id="responsive-datatable">

                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Tipo de Conta</th>
                                    <th>Abertura</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($resultado as $resultado_item)
                                <tr>
                                    <td>{{ $resultado_item->nome }}</td>
                                    <td>{{ $resultado_item->contaTipo->descricao }}</td>
                                    <td>{{ $resultado_item->abertura->format('d/m/Y') }}</td>
                                    <td>{{ ($resultado_item->ativo == 1) ? "Ativo" : "Inativo" }}</td>
                                    <td>
                                        <a href='/financeiro/conta/editar/{{ $resultado_item->id }}' class="btn btn-sm btn-info"><i class="far fa-edit"></i> Editar</a>
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
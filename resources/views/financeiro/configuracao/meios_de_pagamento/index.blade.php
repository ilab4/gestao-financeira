<?php $url_base = getenv('URL_BASE_FIN'); ?>

@extends('financeiro.admin')

@section('conteudo')

<div class="main-container container-fluid">

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">MEIOS DE PAGAMENTO</span>
        </div>
    </div>


    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="breadcrumb-header justify-content-between">
                        <div class="left-content">
                            <span class="main-content-title mg-b-0 mg-b-lg-1">Listagem de Meios de Pagamento</span>
                        </div>
                        <div class="right-content">
                            <a href="/financeiro/meios-de-pagamento/novo" class="btn btn-success btn-sm d-lg-block m-l-15 text-white"><i class="fa fa-plus-circle"></i> Novo Meio de Pagamento</a>
                        </div>
                    </div>
                    <div class="table-responsive ">
                        <table class="table table-bordered text-nowrap border-bottom" id="responsive-datatable">
                            <thead>
                                <tr>
                                    <th>Descrição</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($resultado as $resultado_item)
                                <tr>
                                    <td>{{ $resultado_item->descricao }}</td>
                                    <td>{{ ($resultado_item->ativo == 1) ? "Ativo" : "Inativo" }}</td>
                                    <td>
                                        <a href='/financeiro/meios-de-pagamento/editar/{{ $resultado_item->id }}' class="btn btn-sm btn-info"><i class="far fa-edit"></i> Editar</a>
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
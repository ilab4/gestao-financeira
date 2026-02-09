<?php $url_base = getenv('URL_BASE_FIN'); ?>
<?php
if($area == 'clientes'):
    $varArea = 'cliente';
elseif($area == 'colaboradores'):
    $varArea = 'colaborador';
elseif($area == 'fornecedores'):
    $varArea = 'fornecedor';
endif;
?>
@extends('financeiro.admin')

@section('conteudo')


<div class="main-container container-fluid">

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">{{ strtoupper($area) }}</span>
        </div>
        <div class="right-content">
            <a href="/financeiro/pessoa/{{ $area }}/novo" class="btn btn-info btn-sm d-lg-block m-l-15 text-white"><i class="fa fa-plus-circle"></i> Novo {{ ucfirst($varArea) }}</a>
        </div>
    </div>


    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card custom-card">
                <div class="card-body">
                    <div>
                        <h6 class="main-content-label mb-1">Listagem de {{ ucfirst($area) }}</h6>
                        <!--<p class="text-muted card-sub-title">Responsive is an extension for DataTables that resolves that problem by optimising the table's layout for different screen sizes through the dynamic insertion and removal of columns from the table.</p>-->
                    </div>
                    <div class="table-responsive ">
                        <table class="table table-bordered text-nowrap border-bottom" id="responsive-datatable">

                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Tipo</th>
                                    <th>CNPJ/CPF</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pessoas as $pessoa)
                                <tr>
                                    <td>{{ $pessoa->nome }}</td>
                                    <td>{{ strtoupper($pessoa->tipo_pessoa) }}</td>
                                    <td>{{ $pessoa->cnpj_cpf }}</td>
                                    <td>{{ ($pessoa->ativo == 1) ? "Ativo" : "Inativo" }}</td>
                                    <td>
                                        <a href='/financeiro/pessoa/editar/{{ $pessoa->id }}' class="btn btn-sm btn-info disabled" ><i class="far fa-edit"></i> Editar</a>
                                        <a href='/financeiro/pessoa/{{ $pessoa->id }}/programadas' class="btn btn-sm btn-info"><i class="fa fa-money-bill-alt"></i> Parcelas Programadas</a>
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
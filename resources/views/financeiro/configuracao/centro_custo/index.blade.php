<?php $url_base = getenv('URL_BASE'); ?>

@extends('financeiro.admin')

@section('conteudo')
 
<div class="main-container container-fluid">

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">CENTRO DE CUSTO</span>
        </div>
    </div>


    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="breadcrumb-header justify-content-between">
                        <div class="left-content">
                            <span class="main-content-title mg-b-0 mg-b-lg-1">Listagem de Centros de Custo</span>
                        </div>
                        <div class="right-content">
                            <a href="/financeiro/centro-de-custo/novo" class="btn btn-success btn-sm d-lg-block m-l-15 text-white"><i class="fa fa-plus-circle"></i> Novo Centro de Custo</a>
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

                                <?php if (count($centro_custo)): ?>  
                                    <?php foreach ($centro_custo['n0'] as $n0): ?>
                                        <tr> 
                                            <td><i class='fa fa-arrow-circle-o-right'></i> {{ $n0['titulo'] }}</td>
                                            <td>{{ ($n0['status'] == 1) ? "Ativo" : "Inativo" }}</td>
                                            <td>
                                                <a href='/financeiro/centro-de-custo/editar/{{ $n0['id'] }}' class="btn btn-sm btn-info"><i class="far fa-edit"></i> Editar</a>
                                            </td>
                                        </tr>
                                        <?php
                                        if (isset($centro_custo['n1'][$n0['titulo']])):
                                            foreach ($centro_custo['n1'][$n0['titulo']] as $n1):
                                                ?>
                                                <tr>
                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='fas fa-level-down-alt'></i> {{ $n1['titulo'] }}</td>
                                                    <td>{{ ($n1['status'] == 1) ? "Ativo" : "Inativo" }}</td>
                                                    <td>
                                                        <a href='/financeiro/centro-de-custo/editar/{{ $n1['id'] }}' class="btn btn-sm btn-info"><i class="far fa-edit"></i> Editar</a>
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
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
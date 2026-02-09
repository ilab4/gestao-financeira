<?php $url_base = getenv('URL_BASE_FIN'); ?>

@extends('financeiro.admin')

@section('conteudo')

<div class="main-container container-fluid">

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">RELATÓRIO :: SALDO DE CONTAS</span>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <form name="form_add" method="POST" class="valid">	
                        
                        {{ csrf_field() }}

                        <input type="hidden" name="acao" value="filtro_pedido">

                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Saldo Até:</label>							
                                        <input type="date" value="{{ $periodo_fim_form }}" name="dt_fim" class="form-control" autocomplete="off" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Conta</label>
                                        <select name="conta" class="form-control">
                                            <option value="">Todas</option>
                                            @foreach ($contas_listagem as $item): 
                                            <option value="<?php print $item->id; ?>"><?php print $item->nome; ?></option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-left"><span>Atualizar Relatório</span></button>
                        </div>
                    </form>    

                </div>
            </div>
        </div>  
    </div>


    <div class="row row-sm">

        <div class="col-lg-12">

            <div class="card custom-card">
                <div class="card-body">
                    <div class="breadcrumb-header justify-content-between">
                        <div class="left-content">
                            <span class="main-content-title mg-b-0 mg-b-lg-1">
                                <h5>{{ $intervalo }} 
                                    @if(!empty($conta_nome))
                                    <br>
                                    Conta: {{ $conta_nome }}
                                    @endif
                                </h5>
                            </span>
                        </div>
                        <div class="right-content">
                            <h5>Emitido em: {{ Date('d/m/Y H:i:s') }}</h5>
                        </div>
                    </div>  

                    <!-- /.box-header -->
                    <div class="table-responsive ">
                        <table class="table table-bordered text-nowrap border-bottom" id="responsive-datatable-e2">
                            <thead>
                                <tr>
                                    <th width='80%'>Conta</th>
                                    <th width='20%'>Saldo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                ?>
                                @foreach($contas as $conta)
                                <?php
                                $cssBox = 'text-success';
                                if ($conta['saldo'] < 0):
                                    $cssBox = 'text-danger';
                                endif;
                                ?>

                                <tr class="{{ $cssBox }}">
                                    <td>{{ $conta['nome'] }}</td>
                                    <td>R${{ number_format($conta['saldo'], 2, ",", ".") }}</td>
                                </tr>



                                @endforeach 
                                <tr>
                                    <td><br></td>
                                    <td></td>
                                </tr>
                            </tbody>
                            <?php
                            $cssBox = 'text-success';
                            if ($contas_saldo < 0):
                                $cssBox = 'text-danger';
                            endif;
                            ?>
                            <tfoot>
                                <tr>
                                    <td><b>Saldo Geral</b></td>
                                    <td class="{{ $cssBox }}"><b>R${{ number_format($contas_saldo, 2, ",", ".") }}</b></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>


</div>
@endsection    
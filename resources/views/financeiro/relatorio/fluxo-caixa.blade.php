<?php $url_base = getenv('URL_BASE_FIN'); ?>

@extends('financeiro.admin')

@section('conteudo')

<div class="main-container container-fluid">

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">RELATÓRIO :: FLUXO DE CAIXA PROJETADO</span>
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
                                    <label>De:</label>							
                                    <input type="text" value="{{ $periodo_inicio_form }}" name="dt_inicio" class="form-control fc-datepicker2 datemask" autocomplete="off" required/>
                                </div>
                        </div>
                        <div class="col-md-4">
                                <div class="form-group">
                                    <label>Até:</label>							
                                    <input type="text" value="{{ $periodo_fim_form }}" name="dt_fim" class="form-control fc-datepicker2 datemask" autocomplete="off" required/>
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

                    <?php
                    $valor_saldo = 0;
                    $valor_entradas = 0;
                    $valor_saidas = 0;
                    ?>

                    <!-- /.box-header -->
                    <div class="table-responsive ">
                        <table class="table table-bordered text-nowrap border-bottom" id="responsive-datatable-e2">
                <thead>
                <tr>
                  <th width='15%'>Vencimento</th>
                  <th width='15%'>Conta</th>
                  <th width='20%'>Cliente/Fornecedor</th>
                  <th width='30%'>Plano de Conta</th>
                  <th width='10%'>Valor</th>
                  <th width='10%'>Saldo</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $cssCel = 'text-success';
                if(($saldo_atual) < 0):
                    $cssCel = 'text-danger';
                endif;

                $saldo_atual1 = '(R$ '. number_format($saldo_atual*(-1), 2, ',', '.').')';
                
                $valor_saldo = $saldo_atual;
                ?>    
                <tr>
                    <td width='85%' colspan="5"><b>Saldo atual</b></td>
                    <td width='15%' colspan="1" class="{{ $cssCel }}"><b>{{ $saldo_atual1 }}</b></td>
                </tr>
                @foreach($contas as $conta_programada)    
                <?php
//                die("<PRE>" . print_r($lancamento,1));
                $cssBox = 'text-success';
                if($conta_programada['valor_total'] < 0):
                    $cssBox = 'text-danger';
                endif;
                
                
                ?>
                <?php
                    $valor_lancado = '';
                    
                    $valor_saldo = $valor_saldo + $conta_programada->valor_total;
                    
                    
                    $cssSaldo = 'text-success';
                    if($valor_saldo < 0):
                        $cssSaldo = 'text-danger';
                    endif;

                    if($conta_programada->operacao == 'C'):
                        $valor_lancado = 'R$ ' . number_format($conta_programada->valor_total, 2, ',', '.');
                        $varOperacao = 'C';
                        $valor_entradas = $valor_entradas + $conta_programada->valor_total;
                    elseif($conta_programada->operacao == 'D'):
                        $valor_lancado = '(R$ '. number_format($conta_programada->valor_total*(-1), 2, ',', '.').')';
                        $varOperacao = 'D';
                        $valor_saidas = $valor_saidas + $conta_programada->valor_total;
                    endif;
                    
                    $favorecido_texto = '-';
                    if(!empty($conta_programada->pessoa_id)):
                        $favorecido_texto = $conta_programada->pessoa->nome;
                    endif;

                    
                    if(!empty($conta_programada->plano_conta_id)):
                        $parent_id = $conta_programada->planoConta->parent_id;
                        $plano_conta_completo = $conta_programada->planoConta->descricao;
                    else:
                        $parent_id = 0;
                        $plano_conta_completo = '-';
                    endif;
                    
                    
                    if($parent_id > 0):
                        $plano_conta = App\Model\Financeiro\PlanoConta::find($parent_id);
                        $plano_conta_completo = $plano_conta->descricao . '::' . $conta_programada->planoConta->descricao;
                    endif;
                    
                    if($valor_saldo < 0):
                        $valor_saldo1 = '(R$ '. number_format($valor_saldo*(-1), 2, ',', '.').')';
                    else:
                        $valor_saldo1 = 'R$ ' . number_format($valor_saldo, 2, ',', '.');
                    endif;
                    ?>
                    
                    <tr>
                        <td>{{ $conta_programada['data_vencimento']->format('d/m/Y') }}</td>
                        <td>
                            @if(!empty($conta_programada->conta_id))
                            {{ $conta_programada->conta->nome }}
                            @else
                            -
                            @endif
                        </td>
                        <td>{{ $favorecido_texto }}</td>
                        <td>{{ $plano_conta_completo }}</td>
                        <td class="{{ $cssBox }}">{{ $valor_lancado }}</td>
                        <td class="{{ $cssSaldo }}">{{ $valor_saldo1 }}</td>
                    </tr>
                @endforeach            

                    
                <tr>
                    <td colspan="6"><br></td>
                </tr>
                </tbody>
                <?php
                $cssCel = 'text-success';
                $saldo_final = $valor_entradas+$valor_saidas;
                if(($saldo_final) < 0):
                    $cssCel = 'text-danger';
                endif;
                ?>
                <tfoot>
                    <tr>
                        <td colspan="4"></td>
                        <td><b>Entradas</b></td>
                        <td class="text-black"><b>R${{ number_format($valor_entradas, 2, ",", ".") }}</b></td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td><b>Saídas</b></td>
                        <?php 
                        $valor_saidas1 = $valor_saidas;
                        $valor_saidas = '(R$ '. number_format($valor_saidas*(-1), 2, ',', '.').')'; ?>
                        <td class="text-red"><b>{{ $valor_saidas }}</b></td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td><b>Entradas - Saídas</b></td>
                        <?php 
                        if($saldo_final < 0):
                            $saldo_final = '(R$ '. number_format($saldo_final*(-1), 2, ',', '.').')';
                        else:
                            $saldo_final = 'R$ '. number_format($saldo_final, 2, ',', '.').'';
                        endif;
                         ?>
                        <td class="{{ $cssCel }}"><b>{{ $saldo_final }}</b></td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td><b>Saldo Final</b></td>
                        <?php 
                        $saldo_final2 = $valor_entradas + $valor_saidas1 + $saldo_atual;
                        ?>
                        <?php
                        $cssCel = 'text-success';
                        if(($saldo_final2) < 0):
                            $cssCel = 'text-danger';
                        endif;
                        
                        if($saldo_final2 < 0):
                            $saldo_final2 = '(R$ '. number_format($saldo_final2*(-1), 2, ',', '.').')';
                        else:
                            $saldo_final2 = '(R$ '. number_format($saldo_final2, 2, ',', '.').')';
                        endif;
                        ?>
                        <td class="{{ $cssCel }}"><b>{{ $saldo_final2 }}</b></td>
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
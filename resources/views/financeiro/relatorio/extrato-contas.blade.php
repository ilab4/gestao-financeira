<?php $url_base = getenv('URL_BASE_FIN'); ?>

@extends('financeiro.admin')

@section('conteudo')

<div class="main-container container-fluid">

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">RELATÓRIO :: MOVIMENTAÇÃO FINANCEIRA</span>
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
                                    <input type="date" value="{{ $periodo_inicio_form }}" name="dt_inicio" class="form-control" autocomplete="off" required/>
                                </div>
                        </div>
                        <div class="col-md-4">
                                <div class="form-group">
                                    <label>Até:</label>							
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

                    @foreach($contas as $nome_conta => $conta_lancamentos)
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
                  <th colspan="6">{{ strtoupper($nome_conta) }}</th>
                </tr>
                </thead>
                <thead>
                <tr>
                  <th width='15%'>Data</th>
                  <th width='30%'>Favorecido/Pagador</th>
                  <th width='30%'>Plano de Conta</th>
                  <th width='10%'>Valor</th>
                  <th width='10%'>Saldo</th>
                  <th width='5%'>C/D</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td width='85%' colspan="4"><b>Saldo em {{ $periodo_inicio_form }}</b></td>
                    <td width='15%' colspan="2"><b>R$ 0,00</b></td>
                </tr>
                @foreach($conta_lancamentos[0] as $lancamento)    
                <?php
//                die("<PRE>" . print_r($lancamento,1));
                $cssBox = 'text-success';
                if($lancamento['valor_total'] < 0):
                    $cssBox = 'text-danger';
                endif;
                
                
                ?>
                <?php
                    $valor_lancado = '';
                    
                    $valor_saldo = $valor_saldo + $lancamento->valor_total;
                    
                    
                    $cssSaldo = 'text-success';
                    if($valor_saldo < 0):
                        $cssSaldo = 'text-danger';
                    endif;

                    if($lancamento->operacao == 'C'):
                        $valor_lancado = 'R$ ' . number_format($lancamento->valor_total, 2, ',', '.');
                        $varOperacao = 'C';
                        $valor_entradas = $valor_entradas + $lancamento->valor_total;
                    elseif($lancamento->operacao == 'D'):
                        $valor_lancado = '(R$ '. number_format($lancamento->valor_total*(-1), 2, ',', '.').')';
                        $varOperacao = 'D';
                        $valor_saidas = $valor_saidas + $lancamento->valor_total;
                    endif;
                    
                    if($lancamento->transferencia == 1):
                        $plano_conta_completo = 'Transferência';
                        $favorecido_texto = $lancamento->transferencia_texto;
                    else:
                        
                        if(!empty($lancamento->pessoa_id)):
                            $favorecido_texto = $lancamento->pessoa->nome;
                        else:
                            $favorecido_texto = '-';
                        endif;    
                        
                        if(!empty($lancamento->plano_conta_id)):
                            $parent_id = $lancamento->planoConta->parent_id;
                            $plano_conta_completo = $lancamento->planoConta->descricao;
                        else:
                            $parent_id = 0;
                            $plano_conta_completo = '-';
                        endif;

                        if($parent_id > 0):
                            $plano_conta = App\Model\Financeiro\PlanoConta::find($parent_id);
                            $plano_conta_completo = $plano_conta->descricao . '::' . $lancamento->planoConta->descricao;
                        endif;
                    endif;
                    
                    if($valor_saldo < 0):
                        $valor_saldo1 = '(R$ '. number_format($valor_saldo*(-1), 2, ',', '.').')';
                    else:
                        $valor_saldo1 = 'R$ ' . number_format($valor_saldo, 2, ',', '.');
                    endif;
                    ?>
                    
                    <tr>
                        <td>{{ $lancamento['data_lancamento']->format('d/m/Y') }}</td>
                        <td>{{ $favorecido_texto }}</td>
                        <td>{{ $plano_conta_completo }}</td>
                        <td class="{{ $cssBox }}">{{ $valor_lancado }}</td>
                        <td class="{{ $cssSaldo }}">{{ $valor_saldo1 }}</td>
                        <td>{{ $varOperacao }}</td>
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
                        <td colspan="3" colrow="3"></td>
                        <td><b>Total de Entradas</b></td>
                        <td colspan="2" class="text-black"><b>R${{ number_format($valor_entradas, 2, ",", ".") }}</b></td>
                    </tr>
                    <tr>
                        <td colspan="3" colrow="3"></td>
                        <td><b>Total de Saídas</b></td>
                        <?php $valor_saidas = '(R$ '. number_format($valor_saidas*(-1), 2, ',', '.').')'; ?>
                        <td colspan="2" class="text-red"><b>{{ $valor_saidas }}</b></td>
                    </tr>
                    <tr>
                        <td colspan="3" colrow="3"></td>
                        <td><b>Saldo Final</b></td>
                        <?php $saldo_final = '(R$ '. number_format($saldo_final*(-1), 2, ',', '.').')'; ?>
                        <td colspan="2" class="{{ $cssCel }}"><b>{{ $saldo_final }}</b></td>
                    </tr>
                </tfoot>
              </table>
            </div>
            @endforeach 
            <!-- /.box-body -->
</div>
            </div>
            <!-- /.box -->
        </div>
    </div>
</div>

    

@endsection    
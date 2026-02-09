<?php $url_base = getenv('URL_BASE_FIN'); ?>

@extends('financeiro.admin')

@section('conteudo')

<div class="main-container container-fluid">

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">RELATÓRIO :: ANÁLISE POR STAKEHOLDERS</span>
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
                                    <label>Cliente</label>
                                    <select name="cliente" class="form-control" required>
                                        <option value="">Selecione</option>
                                        @foreach ($pessoas_listagem as $item): 
                                        <option value="<?php print $item->id; ?>" <?php if($_POST AND $_POST['cliente'] AND $_POST['cliente'] == $item->id) echo('selected'); ?>><?php print $item->nome; ?></option>
                                        @endforeach
                                    </select>
                                </div>
                        </div>
                        <div class="col-md-4">
                                <div class="form-group">
                                    <label>Conta</label>
                                    <select name="conta" class="form-control">
                                        <option value="">Todas</option>
                                        @foreach ($contas_listagem as $item): 
                                        <option value="<?php print $item->id; ?>" <?php if($_POST AND $_POST['conta'] AND $_POST['conta'] == $item->id) echo('selected'); ?>><?php print $item->nome; ?></option>
                                        @endforeach
                                    </select>
                                </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                                <div class="form-group">
                                    <label>Plano de Contas</label>
                                    <select name="plano_conta" class="form-control">
                                        <option value="">Todos</option>
                                        <optgroup label="Receitas" style="color: #00a651;">
                                            @foreach($plano_de_contas_receitas as $planoitem)
                                                <?php
                                                $varClasse = '';
                                                $varEspaco = '&nbsp;&nbsp;';
                                                if($planoitem['pai'] == 1):
                                                    $varClasse = "font-weight:bold;";
                                                    $varEspaco = '';
                                                endif;
                                                ?>
                                                <option value="{{ $planoitem['id'] }}" style="color: #000000;" <?php if($_POST AND $_POST['plano_conta'] AND $_POST['plano_conta'] == $item->id) echo('selected'); ?>>{!! $varEspaco !!} {{ $planoitem['descricao'] }}</option>
                                            @endforeach;
                                        </optgroup>
                                        <optgroup label="Despesas" style="color: #E52D27;">
                                            @foreach($plano_de_contas_despesas as $planoitem)
                                                <?php
                                                $varClasse = '';
                                                $varEspaco = '&nbsp;&nbsp;';
                                                if($planoitem['pai'] == 1):
                                                    $varClasse = "font-weight:bold;";
                                                    $varEspaco = '';
                                                endif;
                                                ?>
                                                <option value="{{ $planoitem['id'] }}" style="color: #000000;" <?php if($_POST AND $_POST['plano_conta'] AND $_POST['plano_conta'] == $item->id) echo('selected'); ?>>{!! $varEspaco !!} {{ $planoitem['descricao'] }}</option>
                                            @endforeach;
                                        </optgroup>
                                    </select>
                                </div>
                        </div>
                        <div class="col-md-4">
                                <div class="form-group">
                                    <label>Centro de Custo</label>
                                    <select name="centro_custo" class="form-control">
                                        <option value="">Todos</option>
                                        @foreach ($centro_custos_listagem as $item): 
                                        <option value="<?php print $item->id; ?>" <?php if($_POST AND $_POST['centro_custo'] AND $_POST['centro_custo'] == $item->id) echo('selected'); ?>><?php print $item->descricao; ?></option>
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
    
    
    

@if($contas)



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
                                @if(!empty($pessoa_nome))
                                <br>
                                Cliente/Fornecedor: {{ $pessoa_nome }}
                                @endif
                                @if(!empty($plano_conta_nome))
                                <br>
                                Plano de Contas: {{ $plano_conta_nome }}
                                @endif
                                @if(!empty($centro_custo_nome))
                                <br>
                                Centro de Custo: {{ $centro_custo_nome }}
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
                @foreach($contas as $conta_programada)    
                <?php
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
                    
                    
                    if(!empty($conta_programada->pessoa_id)):
                        $favorecido_texto = $conta_programada->pessoa->nome;
                    else:
                        $favorecido_texto = '-';
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
                        <td>{{ $conta_programada['data_lancamento']->format('d/m/Y') }}</td>
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
                        <td><b>Total de Entradas</b></td>
                        <td class="text-black"><b>R${{ number_format($valor_entradas, 2, ",", ".") }}</b></td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td><b>Total de Saídas</b></td>
                        <?php 
                        $valor_saidas1 = $valor_saidas;
                        $valor_saidas = '(R$ '. number_format($valor_saidas*(-1), 2, ',', '.').')'; ?>
                        <td class="text-red"><b>{{ $valor_saidas }}</b></td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td><b>Resultado Final</b></td>
                        <?php 
                        if($saldo_final < 0):
                            $saldo_final = '(R$ '. number_format($saldo_final*(-1), 2, ',', '.').')';
                        else:
                            $saldo_final = 'R$ '. number_format($saldo_final, 2, ',', '.').'';
                        endif;
                         ?>
                        <td class="{{ $cssCel }}"><b>{{ $saldo_final }}</b></td>
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
@endif
    

@endsection    
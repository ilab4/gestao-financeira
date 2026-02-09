<?php $url_base = getenv('URL_BASE_FIN'); ?>

<?php
if($area == 'depositar'):
    $varArea = 'Recebimento';
    $varTexto = 'Receber De';
    $varArea2 = 'Receitas';
elseif($area == 'pagar'):
    $varArea = 'Pagamento';
    $varTexto = 'Pagar Para';
    $varArea2 = 'Despesas';
elseif($area == 'transferir'):
    $varArea = 'Transferência';
    $varTexto = 'Transferir Para';
endif;
?>



@extends('financeiro.admin')

@section('conteudo')
    

<div class="main-container container-fluid">

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">LANÇAMENTOS</span>
        </div>
    </div>

    
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <form name="form_add" method="POST" class="form-horizontal p-t-20">	
                        {{ csrf_field() }}
                        
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Lançamento De:</label>							
                                        <input type="date" value="{{ $periodo_inicio_form }}" name="dt_inicio" class="form-control" required/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Lançamento Até:</label>							
                                        <input type="date" value="{{ $periodo_fim_form }}" name="dt_fim" class="form-control" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Conta</label>
                                        <select name="conta" class="form-control">
                                            <option value="">Todas</option>
                                            @foreach ($contas_listagem as $item): 
                                            <option value="<?php print $item->id; ?>" <?php if ($_POST AND $_POST['conta'] AND $_POST['conta'] == $item->id) echo('selected'); ?>><?php print $item->nome; ?></option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Plano de Contas</label>
                                        <select name="plano_conta" class="form-control">
                                            <option value="">Todos</option>
                                            @if($area == 'depositar')
                                            <optgroup label="Receitas" style="color: #00a651;">
                                                @foreach($plano_de_contas_receitas as $planoitem)
                                                <?php
                                                $varClasse = '';
                                                $varEspaco = '&nbsp;&nbsp;';
                                                if ($planoitem['pai'] == 1):
                                                    $varClasse = "font-weight:bold;";
                                                    $varEspaco = '';
                                                endif;
                                                ?>
                                                <option value="{{ $planoitem['id'] }}" style="color: #000000;" <?php if ($_POST AND $_POST['plano_conta'] AND $_POST['plano_conta'] == $item->id) echo('selected'); ?>>{!! $varEspaco !!} {{ $planoitem['descricao'] }}</option>
                                                @endforeach;
                                            </optgroup>
                                            @endif

                                            @if($area == 'pagar')
                                            <optgroup label="Despesas" style="color: #E52D27;">
                                                @foreach($plano_de_contas_despesas as $planoitem)
                                                <?php
                                                $varClasse = '';
                                                $varEspaco = '&nbsp;&nbsp;';
                                                if ($planoitem['pai'] == 1):
                                                    $varClasse = "font-weight:bold;";
                                                    $varEspaco = '';
                                                endif;
                                                ?>
                                                <option value="{{ $planoitem['id'] }}" style="color: #000000;" <?php if ($_POST AND $_POST['plano_conta'] AND $_POST['plano_conta'] == $item->id) echo('selected'); ?>>{!! $varEspaco !!} {{ $planoitem['descricao'] }}</option>
                                                @endforeach;
                                            </optgroup>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Centro de Custo</label>
                                        <select name="centro_custo" class="form-control">
                                            <option value="">Todos</option>
                                            @foreach ($centro_custos_listagem as $item): 
                                            <option value="<?php print $item->id; ?>" <?php if ($_POST AND $_POST['centro_custo'] AND $_POST['centro_custo'] == $item->id) echo('selected'); ?>><?php print $item->descricao; ?></option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-left"><span>Filtrar</span></button>
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
                     
                        <div>
                        <h6 class="main-content-label mb-1">Listagem de Lançamentos ({{ $varArea }})</h6>
                        <!--<p class="text-muted card-sub-title">Responsive is an extension for DataTables that resolves that problem by optimising the table's layout for different screen sizes through the dynamic insertion and removal of columns from the table.</p>-->
                    </div>
                    <div style="margin-top: 15px; margin-bottom: 15px;text-align: right;">
                        <a href='#' data-bs-target="#modal-novo-transferencia" data-bs-toggle="modal" class="btn btn-info btn-sm m-l-15 text-white"><i class="fas fa-exchange-alt"></i> Transferir</a>
                        <a href='#' data-bs-target="#modal-novo-lancamento" data-bs-toggle="modal" class="btn btn-info btn-sm m-l-15 text-white"><i class="fa fa-plus"></i> Novo {{ $varArea }}</a>
                    </div>
                        
                    
                    <div class="table-responsive ">
                        <table class="table table-bordered text-nowrap border-bottom" id="responsive-datatable">
                        
                <thead>
                <tr>
                  <th>Favorecido</th>
                  <th>Conta</th>
                  <th>Operação</th>
                  <th>Data</th>
                  <th>Numero</th>
                  <th>Plano de Conta</th>
                  <th>Valor</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
                ?>
                @foreach($resultado as $resultado_item)
                    <?php
                    $valor_deposito = '';
                    $valor_pagamento = '';
                    $classe_deposito = '';
                    $classe_pagamento = '';
                    
                    if($resultado_item->operacao == 'C'):
                        $valor_lancamento = 'R$ ' . number_format($resultado_item->valor, 2, ',', '.');
                        $classe_lancamento = 'text-success';
                        $varOperacao = 'Crédito';
                    elseif($resultado_item->operacao == 'D'):
                        $valor_lancamento = '-(R$ '. number_format($resultado_item->valor*(-1), 2, ',', '.').')';
                        $classe_lancamento = 'text-danger';
                        $varOperacao = 'Débito';
                    endif;
                    
                    if($resultado_item->transferencia == 1):
                        $plano_conta_completo = 'Transferência';
                        $favorecido_texto = $resultado_item->transferencia_texto;
                    else:
                        
                        if(!empty($resultado_item->pessoa_id)):
                            $favorecido_texto = $resultado_item->pessoa->nome;
                        else:
                            $favorecido_texto = '-';
                        endif;
                          
                        
                        if(!empty($resultado_item->plano_conta_id)):
                            $parent_id = $resultado_item->planoConta->parent_id;
                            $plano_conta_completo = $resultado_item->planoConta->descricao;
                        else:
                            $parent_id = 0;
                            $plano_conta_completo = '-';
                        endif;

                        if($parent_id > 0):
                            $plano_conta = App\Model\Financeiro\PlanoConta::find($parent_id);
                            $plano_conta_completo = $plano_conta->descricao . ' :: ' . $resultado_item->planoConta->descricao;
                        endif;
                    endif;
                    ?>
                    <tr>
                        <td><a href='#' data-bs-target="#modal-lancamento-{{ $resultado_item->id }}" data-bs-toggle="modal">{{ $favorecido_texto }}</a></td>
                        <td>{{ $resultado_item->conta->nome }}</td>
                        <td><a href='#' data-bs-target="#modal-lancamento-{{ $resultado_item->id }}" data-bs-toggle="modal">{{ $varOperacao }}</a></td>
                        <td>{{ $resultado_item->data_lancamento->format('d/m/Y') }}</td>
                        <td>{{ $resultado_item->numero }}</td>
                        <td>{{ $plano_conta_completo }}</td>
                        <td><span class="{{ $classe_lancamento }}">{{ $valor_lancamento }}</span></td>
                        <td>
                            <a href='#' data-url="<?php print $url_base; ?>/financeiro/lancamento/excluir/{{ $resultado_item->id }}" data-msg="Tem certeza que deseja excluir esse registro?" class="btn btn-sm btn-danger btnExluir"><i class="fa fa-ban"></i> Excluir</a>
                        </td>
                    </tr>
                    
                    <div id="modal-lancamento-{{ $resultado_item->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header text-center">
                                    <h2 class="modal-title"><i class="fa fa-money-bill-alt"></i> {{ $varArea }}</h2>
                                </div>
                                <!-- END Modal Header -->

                                <!-- Modal Body -->
                                <div class="modal-body">

                                    
                                    <form autocomplete="off" method="post" action="/financeiro/lancamento/salvar" enctype="multipart/form-data">

                                        {{ csrf_field() }}

                                        <div class="modal-body">

                                                    <input type="hidden" name="id" value="{{ $resultado_item->id }}">
                                                    <input type="hidden" name="operacao" value="{{ $area }}">

                                                    <div class="form-group">
                                                        <label>{{ $varTexto }}</label>
                                                        <select name="pessoa_id" class="form-control" style="width: 100%;" required>
                                                            <option value=""></option>
                                                            @foreach($pessoas_lancamento as $pessoa)
                                                                <option value="{{ $pessoa->id }}" <?php if($resultado_item->pessoa_id == $pessoa->id) echo('selected'); ?>>{{ $pessoa->nome }}</option>
                                                            @endforeach
                                                        </select> 
                                                    </div>

                                                    <style>
                                                        optgroup[label="Receitas"]{
                                                            color: #002a80;
                                                        }
                                                        optgroup[label="Despesas"]{
                                                            color:firebrick;
                                                        }
                                                        option{
                                                            color: black;
                                                        }
                                                    </style>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-4 col-xs-12">
                                                                <label>Conta</label>
                                                                <select name="conta_id" class="form-control" required>
                                                                    <option disabled="disabled" selected="selected"></option>
                                                                    @foreach($contas as $item)
                                                                        <option value="{{ $item['id'] }}" <?php if($resultado_item->conta_id == $item['id']) echo('selected'); ?>>{{ $item['nome'] }}</option>
                                                                    @endforeach;
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4 col-xs-12">
                                                                <label>Plano de Contas</label>
                                                                <select name="plano_conta_id" class="form-control" required>
                                                                    <option disabled="disabled" selected="selected"></option>
                                                                    <optgroup label="{{ $varArea2 }}">
                                                                        @foreach($plano_de_contas as $planoitem)
                                                                            <?php
                                                                            $varClasse = '';
                                                                            $varEspaco = '&nbsp;&nbsp;';
                                                                            if($planoitem['pai'] == 1):
                                                                                $varClasse = "font-weight:bold;";
                                                                                $varEspaco = '';
                                                                            endif;
                                                                            ?>
                                                                            <option value="{{ $planoitem['id'] }}" style="{{ $varClasse }}" <?php if($resultado_item->plano_conta_id == $planoitem['id']) echo('selected'); ?>>{!! $varEspaco !!} {{ $planoitem['descricao'] }}</option>
                                                                        @endforeach;
                                                                    </optgroup>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4 col-xs-12">
                                                                    <label>Centro de Custo</label>
                                                                    <select name="centro_custo_id" class="form-control" required>
                                                                        <option disabled="disabled" selected="selected"></option>
                                                                        @foreach($centro_de_custo as $centroitem)
                                                                            <?php
                                                                            $varClasse = '';
                                                                            $varEspaco = '&nbsp;&nbsp;';
                                                                            if($centroitem['pai'] == 1):
                                                                                $varClasse = "font-weight:bold;";
                                                                                $varEspaco = '';
                                                                            endif;
                                                                            ?>
                                                                            <option value="{{ $centroitem['id'] }}" style="{{ $varClasse }}" <?php if($resultado_item->centro_custo_id == $centroitem['id']) echo('selected'); ?>>{!! $varEspaco !!} {{ $centroitem['descricao'] }}</option>
                                                                        @endforeach;
                                                                    </select>
                                                            </div>
                                                        </div>
                                                    </div>    

                                                    <div class="form-group">
                                                        <label>Descrição</label>
                                                        <input type="text" name="historico" class="form-control" placeholder="Descrição do Lançamento" value="{{ $resultado_item->historico }}" required>
                                                    </div>
                                                    <?php
                                                    if($resultado_item->valor_total < 0):
                                                        $valor = $resultado_item->valor_total * (-1);
                                                    else:
                                                        $valor = $resultado_item->valor_total;
                                                    endif;

                                                    $valor = number_format($valor, 2, ".", "");

                                                    $data_lancamento = '';
                                                    if(!empty($resultado_item->data_lancamento)):
                                                        $data_lancamento = $resultado_item->data_lancamento->format('Y-m-d');
                                                    endif;
                                                    ?>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-4 col-xs-12">
                                                                    <label>Data</label>
                                                                    <input type="date" name="data_lancamento" class="form-control" placeholder="Data" value="{{ $data_lancamento }}" required>
                                                            </div>
                                                            <div class="col-md-4 col-xs-12">
                                                                    <label>Número</label>
                                                                    <input type="text" name="numero" class="form-control" placeholder="Número" value="{{ $resultado_item->numero }}">
                                                            </div>
                                                            <div class="col-md-4 col-xs-12">
                                                                    <label>Valor</label>
                                                                    <input type="text" name="valor" class="form-control dinheiro" placeholder="Valor" value="{{ $valor }}" required>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-4 col-xs-12">
                                                                    <label>Competência</label>
                                                                    <input type="date" name="data_competencia" class="form-control" value="{{ $resultado_item->competencia }}" placeholder="Data">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-12 col-xs-12">
                                                                    <label>Observação</label>
                                                                    <textarea name="obs" class="form-control">{{ $resultado_item->obs }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group" style="margin-top: 20px;">
                                                        <hr>
                                                        <label class="text-muted"><i class="fa fa-paperclip"></i> Gestão de Documentos</label>

                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                {{-- 1 & 3. Visualização com Ícone Dinâmico e Caminho Correto --}}
                                                                @if(!empty($resultado_item->anexo))
                                                                
                                                                    @php
                                                                        $anexo = $resultado_item->anexo;
                                                                        $extensao = strtolower(pathinfo($anexo, PATHINFO_EXTENSION));

                                                                        $icones = [
                                                                            'pdf'  => ['icon' => 'fa-file-pdf', 'color' => 'text-danger'],
                                                                            'jpg'  => ['icon' => 'fa-file-image', 'color' => 'text-primary'],
                                                                            'jpeg' => ['icon' => 'fa-file-image', 'color' => 'text-primary'],
                                                                            'png'  => ['icon' => 'fa-file-image', 'color' => 'text-primary'],
                                                                            'doc'  => ['icon' => 'fa-file-word', 'color' => 'text-info'],
                                                                            'docx' => ['icon' => 'fa-file-word', 'color' => 'text-info'],
                                                                            'xls'  => ['icon' => 'fa-file-excel', 'color' => 'text-success'],
                                                                            'xlsx' => ['icon' => 'fa-file-excel', 'color' => 'text-success'],
                                                                            'zip'  => ['icon' => 'fa-file-archive', 'color' => 'text-warning'],
                                                                            'rar'  => ['icon' => 'fa-file-archive', 'color' => 'text-warning'],
                                                                        ];

                                                                        $estilo = $icones[$extensao] ?? ['icon' => 'fa-file', 'color' => 'text-muted'];

                                                                        // Forma correta de recuperar a URL no Laravel Storage
                                                                        $caminho_arquivo = asset('storage/upload/anexo/' . $anexo);
                                                                    @endphp
                                                                
                                                                    <div class="card mb-3" style="border: 1px solid #e9ecef; background: #fdfdfd;">
                                                                        <div class="card-body p-2 d-flex align-items-center justify-content-between">
                                                                            <div class="d-flex align-items-center">
                                                                                <div class="p-3 bg-light rounded text-center" style="width: 50px;">
                                                                                    <i class="far {{ $estilo['icon'] }} {{ $estilo['color'] }} fa-2x"></i>
                                                                                </div>
                                                                                <div class="ml-3">
                                                                                    <small class="text-muted d-block">Arquivo atual:</small>
                                                                                    <strong class="text-dark">{{ $resultado_item->anexo }}</strong>
                                                                                </div>
                                                                            </div>
                                                                            <div class="btn-group">
                                                                                <a href="{{ $caminho_arquivo }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                                                                                    <i class="fa fa-eye"></i> Ver
                                                                                </a>
                                                                                <a href="{{ $caminho_arquivo }}" download class="btn btn-outline-secondary btn-sm">
                                                                                    <i class="fa fa-download"></i> Baixar
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif

                                                                <div class="upload-wrapper mt-2">
                                                                    <input type="file" name="anexo" id="anexo-{{ $resultado_item->id }}" 
                                                                           class="input-anexo-custom" style="display: none;" />

                                                                    <label for="anexo-{{ $resultado_item->id }}" style="
                                                                        display: flex;
                                                                        align-items: center;
                                                                        justify-content: center;
                                                                        padding: 15px;
                                                                        background: #f8f9fa;
                                                                        border: 2px dashed #dee2e6;
                                                                        border-radius: 8px;
                                                                        cursor: pointer;
                                                                        width: 100%;
                                                                    ">
                                                                        <i class="fa fa-cloud-upload-alt fa-lg mr-2"></i> 

                                                                        <span class="file-name-display">
                                                                            @if(!empty($resultado_item->anexo)) 
                                                                                Substituir arquivo 
                                                                            @else 
                                                                                Clique para selecionar um anexo 
                                                                            @endif
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light pull-left" data-bs-dismiss="modal">Fechar</button>
                                            <button type="submit" class="btn btn-primary">Salvar</button>
                                        </div>

                                    </form>                                    
                                    
                                    
                                </div>
                                <!-- END Modal Body -->
                            </div>
                        </div>
                    </div>    
                @endforeach 
                </tbody>
              </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<div id="modal-novo-lancamento" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header text-left">
                <h2 class="modal-title"><i class="fa fa-money-bill-alt"></i> {{ $varArea }}</h2>
            </div>
            
            <form autocomplete="off" method="post" action="/financeiro/lancamento/salvar" enctype="multipart/form-data">
                
                {{ csrf_field() }}
                
                <div class="modal-body">

                            <input type="hidden" name="lancamento_id" value="">
                            <input type="hidden" name="operacao" value="{{ $area }}">
                            
                            <div class="form-group">
                                <label>{{ $varTexto }}</label>
                                <select name="pessoa_id" class="form-control" style="width: 100%;" required>
                                    <option value=""></option>
                                    @foreach($pessoas_lancamento as $pessoa)
                                        <option value="{{ $pessoa->id }}">{{ $pessoa->nome }}</option>
                                    @endforeach
                                </select> 
                            </div>
                            
                            <style>
                                optgroup[label="Receitas"]{
                                    color: #002a80;
                                }
                                optgroup[label="Despesas"]{
                                    color:firebrick;
                                }
                                option{
                                    color: black;
                                }
                            </style>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4 col-xs-12">
                                        <label>Conta</label>
                                        <select name="conta_id" class="form-control" required>
                                            <option disabled="disabled" selected="selected"></option>
                                            @foreach($contas as $item)
                                                <option value="{{ $item['id'] }}">{{ $item['nome'] }}</option>
                                            @endforeach;
                                        </select>
                                    </div>
                                    <div class="col-md-4 col-xs-12">
                                        <label>Plano de Contas</label>
                                        <select name="plano_conta_id" class="form-control" required>
                                            <option disabled="disabled" selected="selected"></option>
                                            <optgroup label="{{ $varArea2 }}">
                                                @foreach($plano_de_contas as $planoitem)
                                                    <?php
                                                    $varClasse = '';
                                                    $varEspaco = '&nbsp;&nbsp;';
                                                    if($planoitem['pai'] == 1):
                                                        $varClasse = "font-weight:bold;";
                                                        $varEspaco = '';
                                                    endif;
                                                    ?>
                                                    <option value="{{ $planoitem['id'] }}" style="{{ $varClasse }}">{!! $varEspaco !!} {{ $planoitem['descricao'] }}</option>
                                                @endforeach;
                                            </optgroup>
                                        </select>
                                    </div>
                                    <div class="col-md-4 col-xs-12">
                                            <label>Centro de Custo</label>
                                            <select name="centro_custo_id" class="form-control" required>
                                                <option disabled="disabled" selected="selected"></option>
                                                @foreach($centro_de_custo as $centroitem)
                                                    <?php
                                                    $varClasse = '';
                                                    $varEspaco = '&nbsp;&nbsp;';
                                                    if($centroitem['pai'] == 1):
                                                        $varClasse = "font-weight:bold;";
                                                        $varEspaco = '';
                                                    endif;
                                                    ?>
                                                    <option value="{{ $centroitem['id'] }}" style="{{ $varClasse }}">{!! $varEspaco !!} {{ $centroitem['descricao'] }}</option>
                                                @endforeach;
                                            </select>
                                    </div>
                                </div>
                            </div>    
                            
                            <div class="form-group">
                                <label>Descrição</label>
                                <input type="text" name="historico" class="form-control" placeholder="Descrição do Lançamento" required>
                            </div>
                            
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4 col-xs-12">
                                            <label>Data</label>
                                            <input type="date" name="data_lancamento" class="form-control" placeholder="Data" required>
                                    </div>
                                    <div class="col-md-4 col-xs-12">
                                            <label>Número</label>
                                            <input type="text" name="numero" class="form-control" placeholder="Número">
                                    </div>
                                    <div class="col-md-4 col-xs-12">
                                            <label>Valor</label>
                                            <input type="text" name="valor" class="form-control dinheiro" placeholder="Valor" required>
                                    </div>
                                </div>
                            </div> 
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4 col-xs-12">
                                            <label>Competência</label>
                                            <input type="date" name="data_competencia" class="form-control" placeholder="Data">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                            <label>Observação</label>
                                            <textarea name="obs" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group" style="margin-top: 20px;">
                                <hr>
                                <label class="text-muted"><i class="fa fa-paperclip"></i> Gestão de Documentos</label>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="upload-wrapper mt-2">
                                            <input type="file" name="anexo" id="anexo-novo" 
                                                   class="input-anexo-custom" style="display: none;" />

                                            <label for="anexo-novo" style="
                                                display: flex;
                                                align-items: center;
                                                justify-content: center;
                                                padding: 15px;
                                                background: #f8f9fa;
                                                border: 2px dashed #dee2e6;
                                                border-radius: 8px;
                                                cursor: pointer;
                                                width: 100%;
                                            ">
                                                <i class="fa fa-cloud-upload-alt fa-lg mr-2"></i> 

                                                <span class="file-name-display">
                                                    Clique para selecionar um anexo 
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light pull-left" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            
            </form>
            <br>
        </div>
    </div>
</div>
    
<div id="modal-novo-transferencia" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header text-left">
                <h2 class="modal-title"><i class="fas fa-exchange-alt"></i> Transferência</h2>
            </div>
            
            <form autocomplete="off" method="post" action="/financeiro/transferencia/salvar" enctype="multipart/form-data">
                
                {{ csrf_field() }}
                
                <div class="modal-body">

                            <input type="hidden" name="id" value="">
                            
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 col-xs-12">
                                        <label>Transferir De:</label>
                                        <select name="conta_id_origem" class="form-control" required>
                                            <option disabled="disabled" selected="selected"></option>
                                            @foreach($contas as $item)
                                                <option value="{{ $item['id'] }}">{{ $item['nome'] }}</option>
                                            @endforeach;
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        <label>Para:</label>
                                        <select name="conta_id_destino" class="form-control" required>
                                            <option disabled="disabled" selected="selected"></option>
                                            @foreach($contas as $item)
                                                <option value="{{ $item['id'] }}">{{ $item['nome'] }}</option>
                                            @endforeach;
                                        </select>
                                    </div>
                                </div>
                            </div> 
                            
                            
                            <div class="form-group">
                                <label>Descrição</label>
                                <input type="text" name="historico" class="form-control" placeholder="Descrição do Lançamento" required>
                            </div>
                            
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4 col-xs-12">
                                            <label>Data</label>
                                            <input type="date" name="data_lancamento" class="form-control" placeholder="Data" required>
                                    </div>
                                    <div class="col-md-4 col-xs-12">
                                            <label>Número</label>
                                            <input type="text" name="numero" class="form-control" placeholder="Número">
                                    </div>
                                    <div class="col-md-4 col-xs-12">
                                            <label>Valor</label>
                                            <input type="text" name="valor" class="form-control dinheiro" placeholder="Valor" required>
                                    </div>
                                </div>
                            </div> 
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4 col-xs-12">
                                            <label>Competência</label>
                                            <input type="date" name="data_competencia" class="form-control" placeholder="Data">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                            <label>Observação</label>
                                            <textarea name="obs" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group" style="margin-top: 20px;">
                                <hr>
                                <label class="text-muted"><i class="fa fa-paperclip"></i> Gestão de Documentos</label>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="upload-wrapper mt-2">
                                            <input type="file" name="anexo" id="anexo-novo" 
                                                   class="input-anexo-custom" style="display: none;" />

                                            <label for="anexo-novo" style="
                                                display: flex;
                                                align-items: center;
                                                justify-content: center;
                                                padding: 15px;
                                                background: #f8f9fa;
                                                border: 2px dashed #dee2e6;
                                                border-radius: 8px;
                                                cursor: pointer;
                                                width: 100%;
                                            ">
                                                <i class="fa fa-cloud-upload-alt fa-lg mr-2"></i> 

                                                <span class="file-name-display">
                                                    Clique para selecionar um anexo 
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light pull-left" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            
            </form>
            <br>
        </div>
    </div>
</div>    

    
@endsection
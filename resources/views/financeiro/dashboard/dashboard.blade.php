
@extends('financeiro.admin')

@section('conteudo')

<?php $whats_numero = '5521967461824'; ?>

<style>
    /* Badge suave para não carregar o visual */
    .badge-primary-transparent {
        background-color: rgba(34, 192, 60, 0.08);
        color: #22c03c;
        border: 1px solid rgba(34, 192, 60, 0.2);
    }

    /* Efeito de pulso discreto no botão para atrair o olhar sem irritar */
    .pulse-button {
        animation: pulse-animation 2s infinite;
    }

    @keyframes pulse-animation {
        0% { box-shadow: 0 0 0 0px rgba(34, 192, 60, 0.4); }
        100% { box-shadow: 0 0 0 15px rgba(34, 192, 60, 0); }
    }

    /* Ajuste de cards de integração para ficarem mais clean */
    .custom-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border-radius: 10px;
    }

    .custom-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 20px rgba(0,0,0,0.08) !important;
    }
    
    /* Estilo do botão WhatsApp */
    .pulse-whatsapp {
        transition: all 0.3s ease;
    }

    .pulse-whatsapp:hover {
        background-color: #128C7E !important; /* Verde mais escuro do WhatsApp no hover */
        transform: scale(1.05);
        color: #fff !important;
    }

    /* Animação de pulso no verde do WhatsApp */
    .pulse-whatsapp {
        animation: pulse-green 2s infinite;
    }

    @keyframes pulse-green {
        0% { box-shadow: 0 0 0 0px rgba(37, 211, 102, 0.5); }
        70% { box-shadow: 0 0 0 15px rgba(37, 211, 102, 0); }
        100% { box-shadow: 0 0 0 0px rgba(37, 211, 102, 0); }
    }

    /* Ajuste para as badges e textos do banner */
    .badge-primary-transparent {
        background-color: rgba(37, 211, 102, 0.1); /* Usando o tom do verde para harmonia */
        color: #128C7E;
        border: 1px solid rgba(37, 211, 102, 0.2);
    }
</style>


<div class="main-container container-fluid">

        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="left-content">
                <span class="main-content-title mg-b-0 mg-b-lg-1">DASHBOARD</span>
            </div>
            <div class="justify-content-center mt-2">
            </div>
        </div>

        <div class="row">
        <div class="col-md-12">
            <div class="card custom-card overflow-hidden" style="border: none; background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%); box-shadow: 0 10px 25px rgba(0,0,0,0.05); border-radius: 12px;">
                <div class="card-body p-4 p-lg-5">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <h3 class="display-6 font-weight-bold text-dark mb-2" style="letter-spacing: -1px;">
                                Transforme sua visão em <span class="text-primary">Módulos Reais</span>
                            </h3>
                            <p class="lead text-muted mb-4" style="font-size: 1.1rem; line-height: 1.6;">
                                Esta plataforma foi desenhada para crescer. Oferecemos consultoria especializada para 
                                <strong>integrações complexas, automação de fluxos e novos recursos</strong> 
                                sob medida para o seu modelo de negócio.
                            </p>
                            <div class="d-flex flex-wrap" style="gap: 5px;">
                                <span class="badge badge-pill badge-primary-transparent py-2 px-3 mb-2">
                                    🚀 Desenvolvimento Ágil
                                </span>

                                <span class="badge badge-pill badge-primary-transparent py-2 px-3 mb-2">
                                    ⚙️ APIs Customizadas
                                </span>

                                <span class="badge badge-pill badge-primary-transparent py-2 px-3 mb-2">
                                    🛠️ Manutenção Profissional
                                </span>

                                <span class="badge badge-pill badge-primary-transparent py-2 px-3 mb-2">
                                    <i class="fa fa-file-invoice mr-1"></i> Integração NFSe
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-4 text-center mt-4 mt-lg-0">
                            <a href="https://wa.me/{{$whats_numero}}?text=Olá! Tenho interesse em contratar o desenvolvimento de um módulo personalizado para minha plataforma." 
                               target="_blank" 
                               class="btn btn-lg px-5 shadow-lg pulse-whatsapp" 
                               style="border-radius: 50px; font-weight: 700; text-transform: uppercase; font-size: 0.9rem; background-color: #25D366; color: #fff; border: none;">
                                <i class="fab fa-whatsapp mr-2" style="font-size: 1.2rem; vertical-align: middle;"></i> Solicitar Desenvolvimento
                            </a>
                            <p class="text-muted mt-3 mb-0 small">Resposta média em menos de 1 hora.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
        <div class="row">

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <!-- <div class="container"> -->
                <div class="row">

                    @foreach($contas as $conta)
                    <?php
                    $cssText = 'text-success';
                    $cssBox = 'bg-success';
                    if($conta['saldo'] < 0):
                        $cssText = 'text-danger';
                        $cssBox = 'bg-danger';
                    endif;
                    ?>
                    <div class="col-xl-4 col-lg-4 col-md-12 col-xs-12">
                        <div class="card sales-card circle-image2">
                            <div class="row">
                                <div class="col-8">
                                    <div class="ps-4 pt-4 pe-3 pb-4">
                                        <div class="">
                                            <h6 class="mb-2 tx-12">{{ $conta['nome'] }}</h6>
                                        </div>
                                        <div class="pb-0 mt-0">
                                            <div class="d-flex">
                                                <h4 class="tx-20 font-weight-semibold mb-2 {{$cssText}}">R$ {{ number_format($conta['saldo'], 2, ",", ".") }}</h4>
                                            </div>
                                        </div>
                                        <div class="">
                                            <h6 class="mb-2 tx-10">Saldo em {{ Date('d/m/Y') }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="circle-icon {{$cssBox}} text-center align-self-center overflow-hidden">
                                        <i class="fe fe-dollar-sign tx-16 text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    
                    <?php
                    $cssText = 'text-success';
                    $cssBox = 'bg-success';
                    if($contas_saldo < 0):
                        $cssText = 'text-danger';
                        $cssBox = 'bg-danger';
                    endif;
                    ?>
                    <div class="col-xl-4 col-lg-4 col-md-12 col-xs-12">
                        <div class="card sales-card circle-image2">
                            <div class="row">
                                <div class="col-8">
                                    <div class="ps-4 pt-4 pe-3 pb-4">
                                        <div class="">
                                            <h6 class="mb-2 tx-12">SALDO GERAL</h6>
                                        </div>
                                        <div class="pb-0 mt-0">
                                            <div class="d-flex">
                                                <h4 class="tx-20 font-weight-semibold mb-2 {{$cssText}}">R$ {{ number_format($contas_saldo, 2, ",", ".") }}</h4>
                                            </div>
                                        </div>
                                        <div class="">
                                            <h6 class="mb-2 tx-10">Saldo geral em {{ Date('d/m/Y') }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="circle-icon {{$cssBox}} text-center align-self-center overflow-hidden">
                                        <i class="fe fe-dollar-sign tx-16 text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


        </div>
        
        <div class="row" style="margin-bottom: 20px;">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-bar-chart"></i> Fluxo de Caixa (Últimos 6 Meses)</h3>
                    </div>
                    <div class="card-body">
                        <div style="height: 300px; width: 100%;">
                            <canvas id="canvasFluxoCaixa"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-6 col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Próximas Contas Programadas</h4>
                    </div>
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table class="table  table-bordered text-nowrap mb-0" id="example2">
                                <thead>
                                    <tr>
                                        <th>Vencimento</th>
                                        <th>Conta</th>
                                        <th>Cliente/Fornecedor</th>
                                        <th>Plano de Conta</th>
                                        <th>Valor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($contas_programadas as $conta_programada)    
                                    <?php
                                    if ($conta_programada->operacao == 'C'):
                                        $valor_programado = 'R$ ' . number_format($conta_programada->valor, 2, ',', '.');
                                        $classe_title_modal = 'text-success';
                                    elseif ($conta_programada->operacao == 'D'):
                                        $valor_programado = '-(R$ ' . number_format($conta_programada->valor * (-1), 2, ',', '.') . ')';
                                        $classe_title_modal = 'text-danger';
                                    endif;
                                    ?>
                                    <tr class="{{ $classe_title_modal}}">
                                        <td>{{ $conta_programada->data_vencimento->format('d/m/Y') }}</a></td>
                                        <td>
                                            @if(!empty($conta_programada->conta->nome))
                                            {{ $conta_programada->conta->nome }}
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($conta_programada->conta->nome))
                                            {{ $conta_programada->pessoa->nome }}
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($conta_programada->plano_conta_id))
                                            {{ $conta_programada->planoConta->descricao }}
                                            @endif
                                        </td>
                                        <td>{{ $valor_programado }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            
            <div class="col-6 col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Últimos Lançamentos</h4>
                    </div>
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table class="table  table-bordered text-nowrap mb-0" id="example21">
                                <thead>
                                    <tr>
                                        <th>Conta</th>
                                        <th>Data</th>
                                        <th>Favorecido</th>
                                        <th>Plano de Conta</th>
                                        <th>Valor</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ultimos_lancamentos as $ultimo_lancamento)  
                                    <?php
                                    if ($ultimo_lancamento->operacao == 'C'):
                                        $valor = 'R$ ' . number_format($ultimo_lancamento->valor_total, 2, ',', '.');
                                        $classe_lancamento = 'text-success';
                                        $varOperacao = 'Credito';
                                    elseif ($ultimo_lancamento->operacao == 'D'):
                                        $valor = '-(R$ ' . number_format($ultimo_lancamento->valor_total * (-1), 2, ',', '.') . ')';
                                        $classe_lancamento = 'text-danger';
                                        $varOperacao = 'Debito';
                                    endif;

                                    if ($ultimo_lancamento->transferencia == 1):
                                        $plano_conta_completo = 'Transferencia';
                                        $favorecido_texto = $ultimo_lancamento->transferencia_texto;
                                    else:
                                        $favorecido_texto = $ultimo_lancamento->pessoa->nome;

                                        $plano_conta_completo = '';

                                        if (!empty($ultimo_lancamento->plano_conta_id)):
                                            $parent_id = $ultimo_lancamento->planoConta->parent_id;
                                            $plano_conta_completo = $ultimo_lancamento->planoConta->descricao;
                                            if ($parent_id > 0):
                                                $plano_conta = App\Model\Financeiro\PlanoConta::find($parent_id);
                                                $plano_conta_completo = $plano_conta->descricao . '::' . $ultimo_lancamento->planoConta->descricao;
                                            endif;
                                        endif;
                                    endif;
                                    ?>
                                    <tr class="{{ $classe_lancamento}}">
                                        <td>{{ $ultimo_lancamento->conta->nome }}</td>
                                        <td>{{ $ultimo_lancamento->data_lancamento->format('d/m/Y') }}</td>
                                        <td>{{ $favorecido_texto }}</td>
                                        <td>{{ $plano_conta_completo }}</td>
                                        <td>{{ $valor }}</td>

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
        
          
        
</div>        
        
@endsection


@extends('financeiro.admin')

@section('conteudo')

<?php $url_base = getenv('URL_BASE_FIN'); ?>
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
</style>
<style>
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
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">CENTRAL DE INTEGRAÇÕES</span>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="card custom-card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fa fa-plug text-primary"></i> Módulos de Expansão</h5>
                    <p class="text-muted">Abaixo listamos algumas integrações que podem ser contratadas separadamente para automação total de webhooks e baixas automáticas.</p>
                </div>
            </div>
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

    <div class="row row-sm">
        <?php
        $integracoes = [
            ['nome' => 'ASAAS', 'slug' => 'asaas', 'logo' => "$url_base/img/api-pagamento/asaas.png", 'desc' => 'Automação completa de Boletos, PIX e Cartão com baixa imediata.'],
            ['nome' => 'PAGAR.ME', 'slug' => 'pagarme', 'logo' => "$url_base/img/api-pagamento/pagarme.png", 'desc' => 'Integração via Webhook para recebimento de status de pedidos e vendas.'],
            ['nome' => 'KIWIFY', 'slug' => 'kiwify', 'logo' => "$url_base/img/api-pagamento/kiwify.png", 'desc' => 'Sincronize suas vendas de infoprodutos diretamente no fluxo de caixa.'],
            ['nome' => 'HOTMART', 'slug' => 'hotmart', 'logo' => "$url_base/img/api-pagamento/hotmart.png", 'desc' => 'Gestão de comissões e vendas de afiliados integradas ao financeiro.'],
            ['nome' => 'EDUZZ', 'slug' => 'eduzz', 'logo' => "$url_base/img/api-pagamento/eduzz.png", 'desc' => 'Receba notificações de faturamento e reembolsos em tempo real.'],
            ['nome' => 'GURU', 'slug' => 'guru', 'logo' => "$url_base/img/api-pagamento/guru.png", 'desc' => 'Conecte o checkout do Digital Manager Guru ao seu sistema.'],
            ['nome' => 'STRIPE', 'slug' => 'stripe', 'logo' => "$url_base/img/api-pagamento/stripe.png", 'desc' => 'Ideal para pagamentos recorrentes e transações internacionais.'],
        ];
        ?>

        @foreach($integracoes as $int)
        <div class="col-xl-4 col-md-6 col-sm-12">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-md mr-3 bg-light p-1 rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <img alt="{{ $int['nome'] }}" src="{{ $int['logo'] }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        </div>
                        <h6 class="mb-0 font-weight-bold">{{ $int['nome'] }}</h6>
                        <span class="badge badge-light-secondary ml-auto small">Opcional</span>
                    </div>

                    <p class="small text-muted" style="min-height: 40px;">{{ $int['desc'] }}</p>
                    
                    <div class="alert alert-light py-2 px-3 border-0">
                        <span class="small"><i class="fa fa-lock"></i> Requer licença do módulo</span>
                    </div>
                </div>
                <div class="card-footer px-3 py-2 bg-light">
                    <a href="https://wa.me/{{$whats_numero}}?text=Olá! Vi o módulo da {{ $int['nome'] }} na plataforma e gostaria de um orçamento." 
                       target="_blank" 
                       class="btn btn-sm btn-outline-primary btn-block font-weight-bold">
                        <i class="fa fa-shopping-cart"></i> Solicitar Integração
                    </a>
                </div>
            </div>
        </div>
        @endforeach

        <div class="col-xl-4 col-md-6 col-sm-12">
            <div class="card custom-card border-dashed" style="border: 2px dashed #d1d6d8; background: transparent;">
                <div class="card-body d-flex flex-column align-items-center justify-content-center text-center py-4">
                    <div class="avatar-md bg-light-primary rounded-circle mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="fa fa-plus fa-2x text-primary"></i>
                    </div>
                    <h6 class="font-weight-bold">Outra Integração?</h6>
                    <p class="small text-muted">Desenvolvemos conexões com qualquer API de mercado.</p>
                    <a href="https://wa.me/{{$whats_numero}}?text=Olá! Preciso de uma integração específica que não está na lista." target="_blank" class="btn btn-sm btn-primary mt-2">Customizar Agora</a>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    /* Estilo para o card de customização */
    .border-dashed { border-style: dashed !important; }
    .bg-light-primary { background-color: rgba(34, 192, 60, 0.1); }
</style>

@endsection
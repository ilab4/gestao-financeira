<?php $url_base = getenv('URL_BASE_FIN'); ?>

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
            <span class="main-content-title mg-b-0 mg-b-lg-1">RELATÓRIO :: DRE</span>
        </div>
    </div>

    
    <div class="row">
        <div class="col-md-12">
            <div class="card custom-card overflow-hidden" style="border: none; background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%); box-shadow: 0 10px 25px rgba(0,0,0,0.05); border-radius: 12px;">
                <div class="card-body p-4 p-lg-5">
                    <div class="row align-items-center">
                        
                        
                        <div class="col-lg-8">
                            <h3 class="display-6 font-weight-bold text-dark mb-2" style="letter-spacing: -1px;">
                                Módulos de <span class="text-primary">Inteligência Financeira</span>
                            </h3>
                            <p class="lead text-muted mb-4" style="font-size: 1.1rem; line-height: 1.6;">
                                O DRE e a Programação de Contas são módulos proprietários da iLAB4. 
                                Oferecemos o licenciamento e a <strong>implementação técnica assistida</strong> para garantir a integridade dos seus dados e a segurança da sua operação.
                            </p>
                            <div class="d-flex flex-wrap" style="gap: 5px;">
                                <span class="badge badge-pill badge-primary-transparent py-2 px-3 mb-2">
                                    💎 Licenciamento Proprietário
                                </span>
                                <span class="badge badge-pill badge-primary-transparent py-2 px-3 mb-2">
                                    👨‍💻 Implementação Técnica Especializada
                                </span>
                                <span class="badge badge-pill badge-primary-transparent py-2 px-3 mb-2">
                                    🛡️ Garantia de Integridade
                                </span>
                            </div>
                        </div>

                        <div class="col-lg-4 text-center mt-4 mt-lg-0">
                            <a href="https://wa.me/{{$whats_numero}}?text=Olá! Gostaria de um orçamento para a implementação e licenciamento dos módulos de DRE e Programação na minha instância da iLAB4." 
                               target="_blank" 
                               class="btn btn-lg px-5 shadow-lg pulse-whatsapp" 
                               style="border-radius: 50px; font-weight: 700; text-transform: uppercase; font-size: 0.9rem; background-color: #25D366; color: #fff; border: none;">
                                <i class="fab fa-whatsapp mr-2" style="font-size: 1.2rem; vertical-align: middle;"></i> Solicitar Orçamento
                            </a>
                            <p class="text-muted mt-3 mb-0 small">Consulte disponibilidade de agenda para implementação</p>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>

    

@endsection    
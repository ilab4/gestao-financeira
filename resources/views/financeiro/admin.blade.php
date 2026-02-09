<?php $url_base = getenv('APP_URL'); ?>
<?php $configuracao = App\Model\Financeiro\Configuracao::find(1); ?>
<?php $global_nome = Session::get('login.nome'); ?>
<?php $global_tipo = Session::get('login.tipo'); ?>

<!doctype html>
<html dir="ltr" style="--primary02: rgba(0, 0, 0, 0.2); --primary05: rgba(0, 0, 0, 0.5); --primary-bg-color: rgba(0, 0, 0, 1); --primary-bg-hover: rgba(0, 0, 0, 0.99); --primary-bg-border: rgba(0, 0, 0, 0.2); --dark-null: rgba(0, 0, 0, 1); --primary-transparentcolor: rgba(0, 0, 0, 0.2); --darkprimary-null: rgba(0, 0, 0, 0.2); --transparent-null: #00000095; --transparentprimary-null: #00000020;" lang="en">
    
    <head>

        <meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <!-- Title -->
        <title> {{ $configuracao->nome }} | Financeiro </title>

        <link rel="icon" href="<?php print $url_base; ?>/img/apple-touch-icon.png" type="image/x-icon"/>
        <link href="<?php print $url_base; ?>/assets/css/icons.css" rel="stylesheet">
        <link href="<?php print $url_base; ?>/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
        <link href="<?php print $url_base; ?>/assets/plugins/inputtags/inputtags.css" rel="stylesheet">
        <link href="<?php print $url_base; ?>/assets/plugins/sidebar/sidebar.css" rel="stylesheet">
        <link href="<?php print $url_base; ?>/assets/plugins/perfect-scrollbar/p-scrollbar.css" rel="stylesheet" />
        <link href="<?php print $url_base; ?>/assets/css/style.css" rel="stylesheet">
        <link href="<?php print $url_base; ?>/assets/css/style-dark.css" rel="stylesheet">
        <link href="<?php print $url_base; ?>/assets/css/style-transparent.css" rel="stylesheet">
        <link href="<?php print $url_base; ?>/assets/css/skin-modes.css" rel="stylesheet" />
        <link href="<?php print $url_base; ?>/assets/css/animate.css" rel="stylesheet">
        <link href="<?php print $url_base; ?>/assets/plugins/sweet-alert/sweetalert.css" rel="stylesheet">
        <link href="<?php print $url_base; ?>/assets/plugins/select2/css/select2.min.css" rel="stylesheet">
        <link href="<?php print $url_base; ?>/assets/plugins/datatable/css/dataTables.bootstrap5.css" rel="stylesheet" />
        <link href="<?php print $url_base; ?>/assets/plugins/datatable/css/buttons.bootstrap5.min.css"  rel="stylesheet">
        <link href="<?php print $url_base; ?>/assets/plugins/datatable/responsive.bootstrap5.css" rel="stylesheet" />

    </head>

    <body class="ltr main-body app sidebar-mini color-menu light-theme sidebar-gone">

        <!-- Loader -->
        <div id="global-loader">
            <img src="<?php print $url_base; ?>/assets/img/loader.svg" class="loader-img" alt="Loader">
        </div>
        <!-- /Loader -->

        <!-- Page -->
        <div class="page">

            <div>
                <!-- main-header -->
                <div class="main-header side-header sticky nav nav-item">
                    <div class=" main-container container-fluid">
                        <div class="main-header-left ">
                            <div class="responsive-logo">
                                <a href="<?php print $url_base; ?>/financeiro/dashboard" class="header-logo">
                                    <img src="<?php print $url_base; ?>/img/logo.png" class="mobile-logo logo-1" alt="logo" width="140">
                                    <img src="<?php print $url_base; ?>/img/logo_white.png" class="mobile-logo dark-logo-1" width="140" alt="logo">
                                </a>
                            </div>
                            <div class="app-sidebar__toggle" data-bs-toggle="sidebar">
                                <a class="open-toggle" href="javascript:void(0);"><i class="header-icon fe fe-align-left" ></i></a>
                                <a class="close-toggle" href="javascript:void(0);"><i class="header-icon fe fe-x"></i></a>
                            </div>
                            <div class="logo-horizontal">
                                <a href="<?php print $url_base; ?>/financeiro/dashboard" class="header-logo">
                                    <img src="<?php print $url_base; ?>/img/logo.png" class="mobile-logo logo-1" alt="logo" width="140">
                                    <img src="<?php print $url_base; ?>/img/logo_white.png" class="mobile-logo dark-logo-1" alt="logo" width="140">
                                </a>
                            </div>
                        </div>
                        <div class="main-header-right">
                            <button class="navbar-toggler navresponsive-toggler d-md-none ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon fe fe-more-vertical "></span>
                            </button>
                            <div class="mb-0 navbar navbar-expand-lg navbar-nav-right responsive-navbar navbar-dark p-0">
                                <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                                    <ul class="nav nav-item header-icons navbar-nav-right ms-auto">
 
                                        <li class="dropdown main-profile-menu nav nav-item nav-link ps-lg-2">
                                            <a class="new nav-link profile-user d-flex" href="" data-bs-toggle="dropdown"><img alt="" src="<?php print $url_base; ?>/assets/img/faces/2.jpg" class=""></a>
                                            <div class="dropdown-menu">
                                                <div class="menu-header-content p-3 border-bottom">
                                                    <div class="d-flex wd-100p">
                                                        <div class="main-img-user"><img alt="" src="<?php print $url_base; ?>/assets/img/faces/2.jpg" class=""></div>
                                                        <div class="ms-3 my-auto">
                                                            <h6 class="tx-15 font-weight-semibold mb-0">{{ $global_nome }}</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a class="dropdown-item" href="<?php print $url_base; ?>/financeiro/sair"><i class="far fa-arrow-alt-circle-left"></i> Sair</a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /main-header -->
                <style>
                    .color-menu .side-menu__label {
                        color: #454a4f !important;
                    }
                    .color-menu .slide a {
                      color: #454a4f !important;
                    }
                    .color-menu .side-menu .side-menu__icon {
                        fill: #454a4f !important;
                    }
                </style>
                <!-- main-sidebar -->
                <div class="sticky">
                    <aside class="app-sidebar" style="background: #96c9e6 !important;">
                        <div class="main-sidebar-header active" style="background: #fff;">
                            <a class="header-logo active" href="<?php print $url_base; ?>/financeiro/dashboard">
                                <img src="<?php print $url_base; ?>/img/logo.png" class="main-logo  desktop-logo" alt="logo">
                                <img src="<?php print $url_base; ?>/img/logo.png" class="main-logo  desktop-dark" alt="logo">
                                <img src="<?php print $url_base; ?>/img/cropped-logo-assegura-simples-1-192x192.png" class="main-logo  mobile-logo" alt="logo">
                                <img src="<?php print $url_base; ?>/img/cropped-logo-assegura-simples-1-192x192.png" class="main-logo  mobile-dark" alt="logo">
                                <!--<h3>DataZZ</h3>-->
                            </a>
                        </div>
                        
                        @include('financeiro.menu') 
                        
                    </aside>
                </div>
                <!-- main-sidebar -->
            </div>

            <!-- main-content -->
            <div class="main-content app-content">

                @yield('conteudo')

            </div>
            <!-- main-content closed -->


            <!-- Footer opened -->
            <div class="main-footer">
                <div class="container-fluid pd-t-0-f ht-100p">
                    Copyright © {{ date('Y') }} <a href="https://ilab4.me" target="blank" class="text-primary">{{ $configuracao->nome }}</a>. Todos os direitos reservados
                </div>
            </div>
            <!-- Footer closed -->

        </div>
        <!-- End Page -->

        <!-- Back-to-top -->
        <a href="#top" id="back-to-top"><i class="las la-arrow-up"></i></a>

        <!-- JQuery min js -->
        <script src="<?php print $url_base; ?>/assets/plugins/jquery/jquery.min.js"></script>

        <!-- Bootstrap js -->
        <script src="<?php print $url_base; ?>/assets/plugins/bootstrap/js/popper.min.js"></script>
        <script src="<?php print $url_base; ?>/assets/plugins/bootstrap/js/bootstrap.min.js"></script>

        <script src="<?php print $url_base; ?>/dist/js/jquery.mask.min.js"></script>
        <script src="<?php print $url_base; ?>/dist/js/jquery.maskMoney.js"></script>
        <script src="<?php print $url_base; ?>/assets/plugins/select2/js/select2.min.js"></script>
        <script src="<?php print $url_base; ?>/assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
        <script src="<?php print $url_base; ?>/assets/plugins/perfect-scrollbar/p-scroll.js"></script>
        <script src="<?php print $url_base; ?>/assets/plugins/side-menu/sidemenu.js"></script>
        <script src="<?php print $url_base; ?>/assets/plugins/sidebar/sidebar.js"></script>
        <script src="<?php print $url_base; ?>/assets/plugins/sidebar/sidebar-custom.js"></script>
        <script src="<?php print $url_base; ?>/assets/js/form-elements.js"></script>
        <script src="<?php print $url_base; ?>/assets/plugins/sweet-alert/sweetalert.min.js"></script>
        
        <!--- Tabs JS-->
        <script src="<?php print $url_base; ?>/assets/plugins/tabs/jquery.multipurpose_tabcontent.js"></script>
        <script src="<?php print $url_base; ?>/assets/js/tabs.js"></script>
        
        <!-- Internal Data tables -->
        <script src="<?php print $url_base; ?>/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
        <script src="<?php print $url_base; ?>/assets/plugins/datatable/js/dataTables.bootstrap5.js"></script>
        <script src="<?php print $url_base; ?>/assets/plugins/datatable/js/dataTables.buttons.min.js"></script>
        <script src="<?php print $url_base; ?>/assets/plugins/datatable/js/buttons.bootstrap5.min.js"></script>
        <script src="<?php print $url_base; ?>/assets/plugins/datatable/js/jszip.min.js"></script>
        <script src="<?php print $url_base; ?>/assets/plugins/datatable/pdfmake/pdfmake.min.js"></script>
        <script src="<?php print $url_base; ?>/assets/plugins/datatable/pdfmake/vfs_fonts.js"></script>
        <script src="<?php print $url_base; ?>/assets/plugins/datatable/js/buttons.html5.min.js"></script>
        <script src="<?php print $url_base; ?>/assets/plugins/datatable/js/buttons.print.min.js"></script>
        <script src="<?php print $url_base; ?>/assets/plugins/datatable/js/buttons.colVis.min.js"></script>
        <script src="<?php print $url_base; ?>/assets/plugins/datatable/dataTables.responsive.min.js"></script>
        <script src="<?php print $url_base; ?>/assets/plugins/datatable/responsive.bootstrap5.min.js"></script>
        
        <script src="<?php print $url_base; ?>/assets/js/custom.js"></script>
        
        <script src="<?php print $url_base; ?>/dist/js/site.js"></script>
        <script src="<?php print $url_base; ?>/assets/plugins/inputtags/inputtags.js"></script>
        <script src="<?php print $url_base; ?>/dist/js/custom-file-input.js"></script>
      
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>

            $(function () {
                /** 1. CONFIGURAÇÕES GLOBAIS E TRADUÇÕES **/
                const langPTBR = {
                    "sLengthMenu": "Mostrar _MENU_ registros por página",
                    "sZeroRecords": "Nenhum registro encontrado",
                    "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
                    "sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
                    "sInfoFiltered": "(filtrado de _MAX_ registros)",
                    "sSearch": "Pesquisar: ",
                    "oPaginate": {
                        "sFirst": "Início", "sPrevious": "Anterior", "sNext": "Próximo", "sLast": "Último"
                    }
                };

                /** 2. INICIALIZAÇÃO DE COMPONENTES UI **/
                $(".select2").select2();

                // DataTables
                $("#example1").DataTable();
                $('#example2, #example21').DataTable({
                    "responsive": true, "paging": true, "lengthChange": false,
                    "searching": true, "ordering": false, "info": true,
                    "autoWidth": false, "pageLength": 50, "oLanguage": langPTBR
                });
                $('#example3').DataTable({
                    "responsive": true, "paging": false, "info": false,
                    "searching": false, "ordering": false, "oLanguage": langPTBR
                });
                $('#responsive-datatable').DataTable({
                    responsive: true,
                    language: { searchPlaceholder: 'Procurar...', sSearch: '' },
                    "oLanguage": langPTBR
                });


                /** 3. EVENTOS (DELEGAÇÃO) **/

                // Botão Excluir Único (Substitui as 3 versões repetidas)
                $(document).on('click', '.btnExluir', function(e) {
                    
                    if ($(this).hasClass('disabled')) {
                        e.preventDefault();
                        return false;
                    }
                    
                    e.preventDefault();
                    var url = $(this).data('url');
                    var msg = $(this).data('msg') || "Deseja excluir este registro?";

                    swal({
                        title: msg,
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Sim",
                        cancelButtonText: "Não",
                        closeOnConfirm: true
                    }, function(isConfirm){
                        if (isConfirm) window.location.href = url;
                    });
                });

                // Upload de Arquivos
                $('body').on('change', '.input-anexo-custom', function() {
                    var fileName = this.files[0] ? this.files[0].name : "Clique para selecionar um anexo";
                    $(this).closest('.upload-wrapper').find('.file-name-display').text(fileName);
                });

                // Validação de CPF no campo #cpf1
                $('#cpf1').on('change', function(){
                    var cpf = $(this).val().replace(/\D/g, "");
                    if (!valida_cpf(cpf)) {
                        alert('CPF inválido!');
                        $(this).focus();
                        $('.btnCadastro').attr('disabled', 'disabled');
                    } else {
                        $('.btnCadastro').removeAttr('disabled');
                    }
                });

                // Autocomplete Pessoa
                $("#pessoa_autocomplete").on("select", function(){
                    if($('option[value="'+this.value+'"]').length > 0){
                        $(this).val($('option[value="'+this.value+'"]').data("text"));
                    }
                });
            });

            /** 4. FUNÇÕES GLOBAIS (FORA DO READY) **/

            function setaDadosModal(id, tipo, data_ajuste, hora) {
                if(tipo == 'entrada'){
                    $('#tipo-entrada-'+id).prop("checked", true);
                    $('#tipo-saida-'+id).prop("checked", false);
                } else if(tipo == 'saida'){
                    $('#tipo-saida-'+id).prop("checked", true);
                    $('#tipo-entrada-'+id).prop("checked", false);
                }
                $('#tipo-periodo-'+id).prop("checked", false);
                $("#data-"+id).val(data_ajuste);
                $("#hora-"+id).val(hora);
            }

            // Funções de Validação (Mantenha-as limpas)
            function verifica_cpf_cnpj(v) {
                v = v.toString().replace(/\D/g, '');
                return v.length === 11 ? 'CPF' : (v.length === 14 ? 'CNPJ' : false);
            }

            function calc_digitos_posicoes(digitos, posicoes = 10) {
                var soma = 0;
                for (var i = 0; i < digitos.length; i++) {
                    soma += digitos[i] * posicoes;
                    posicoes--;
                    if (posicoes < 2) posicoes = 9;
                }
                soma = soma % 11;
                var resultado = soma < 2 ? 0 : 11 - soma;
                return digitos + resultado;
            }

            function valida_cpf(valor) {
                valor = valor.toString().replace(/\D/g, '');
                if (/^(\d)\1+$/.test(valor)) return false; // Bloqueia 111.111...
                var novo = calc_digitos_posicoes(valor.substr(0, 9), 10);
                novo = calc_digitos_posicoes(novo, 11);
                return novo === valor;
            }

        </script>

        @if(isset($labels_grafico))
        <script>
            var ctx = document.getElementById('canvasFluxoCaixa').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! $labels_grafico !!},
                    datasets: [
                        { label: 'Receitas', data: {!! $dados_receitas !!}, borderColor: '#2ecc71', backgroundColor: 'rgba(46, 204, 113, 0.2)', fill: true, tension: 0.4 },
                        { label: 'Despesas', data: {!! $dados_despesas !!}, borderColor: '#e74c3c', backgroundColor: 'rgba(231, 76, 60, 0.2)', fill: true, tension: 0.4 }
                    ]
                },
                options: { 
                    responsive: true, maintainAspectRatio: false,
                    scales: { y: { beginAtZero: true, ticks: { callback: v => 'R$ ' + v.toLocaleString('pt-br') } } },
                    plugins: { tooltip: { mode: 'index', intersect: false } }
                }
            });
        </script>
        @endif

        @if (Session::has('status.msg'))
        <script>swal("{{ Session::get('status.msg') }}");</script>
        @php Session::forget('status.msg'); @endphp
        @endif


    </body>
</html>
$(document).ready( function() {

    var dir_root = 'https://painel.assegurapet.com.br';
    var dir_root_cliente = 'https://cliente.assegurapet.com.br';
    
    var cpf_cnpj_pre = $('#cnpj_cpf').val();
    var tipo_pre = $('#tipo').val();
    
    
    $('.datemask').mask('00/00/0000');
    $('.telefone').mask('(00) 0000-0000');
    $('.whats').mask('(00) 00000-0000');
    $('.cpf').mask('000.000.000-00');
    $('.cep').mask('00.000-000');
    $('.cnpj').mask('00.000.000/0000-00');
    $('.time').mask('00:00');
    $('.mes').mask('00');
    $('.ano').mask('0000');
    $('.cartao').mask('0000 0000 0000 0000');
    $(".dinheiro").maskMoney({
        decimal: ".",
        thousands: ""
    });



if(tipo_pre != ''){
        
        $('#box-dados').show();
        $('#box-cnpj-cpf').show();
        
        if(tipo_pre == 'Pessoa Fisica'){
            $('#box-pf').show();
            $('#box-pj').hide();
            $('#label-cnpj-cpf').html('CPF');
            $('#nome').attr("required", true);
            $('#razao_social').attr("required", false);
            $('#nome_fantasia').attr("required", false);
            $('#cnpj_cpf').mask('000.000.000-00');
        } else if(tipo_pre == 'Pessoa Juridica'){
            $('#box-pf').hide();
            $('#box-pj').show();
            $('#label-cnpj-cpf').html('CNPJ');
            $('#nome').attr("required", false);
            $('#razao_social').attr("required", true);
            $('#nome_fantasia').attr("required", true);
            $('#cnpj_cpf').mask('00.000.000/0000-00');
        }
        
        $('#box-submit').show();
        
    }

    $('#tipo').change(function(){

        var tipo = $('#tipo').val();

        if(tipo == 'Pessoa Fisica'){
            $('#label-cnpj-cpf').html('CPF');
            $('#cnpj_cpf').mask('000.000.000-00');
        } else if(tipo == 'Pessoa Juridica'){
            $('#label-cnpj-cpf').html('CNPJ');
            $('#cnpj_cpf').mask('00.000.000/0000-00');
        }
        
        $('#box-cnpj-cpf').show();
        $('#box-dados').show();
        $('#box-submit').show();
 
    });
    
    $('.parcelamento').change(function(){
        
        $('#box-msg-parcelamento').hide();
        
        var parcela = $('#parcela').val();
        
        if(parcela > 1){
            
            $('#msg-parcelamento').html('Frequência relativa a data de vencimento das parcelas');
            
        } else {
            $('#msg-parcelamento').html('Frequência relativa a programação de lançamentos');
            $('#box-msg-parcelamento').hide();
        }
        
        $('#box-msg-parcelamento').show();
 
    });


    $('.btnSeleciona').click(function(){
        
        $('.multi-collapse').removeClass('show');
    });

    
    $('.btnCadastroReembolso').attr('disabled', 'disabled');
    
    
    var pet_id = $('#pet_id').val();
    
    if(pet_id != ''){
        
        var _token = $("input[type=hidden][name=_token]").val();
        
        $.ajax({
            type: "POST",
            url: "ajaxPlano",
            dataType: 'json',
            data: {
                pet_id: pet_id,
                _token: _token
            },
            success: function(data) {

                if(data.comprovante_vacinacao == '1'){
                    
                    $('#pet_sem_comprovante').hide();
                    
                    console.log('com comprovante');
                    
                    if (data.servicos.length > 0) {

                        $('#plano').val(data.plano);
                        $('#pet_select').hide();
                        $('#pet_selected').show();
                        $('#pet_selecionado').val(data.pet);
                        $('#pet_id').val(pet_id);
                        $('#pet_id1').val(pet_id);
                        $('#procedimento_inclui').show();
                        $('#complemento').show();

                        var options = '';
                        options = '<option value="">Selecione</select>';
                        for (var i = 0; i < data.servicos.length; i++) {
                            options += '<option value="' + data.servicos[i].servico_id + '">' + data.servicos[i].servico_nome + '</option>';
                        }

                        $('#procedimento_reembolso').html(options).show();
                        $('#procedimento_reembolso').focus();
                        $('.btnCadastroReembolso').removeAttr('disabled');
                    } else {
                        $('.btnCadastroReembolso').attr('disabled', 'disabled');
                        swal("Nenhum procedimento foi encontrado!");
                    }
                    
                } else {
                    
                    console.log('sem comprovante');
                    
                    var url_pet = dir_root_cliente + '/cliente/pet/' + data.uuid;
                    
                    console.log(url_pet);
                    
                    $("#pet_selecionado_comprovante").attr("href", url_pet);
                    
                    $('#pet_sem_comprovante').show();
                    
                }
                
                
            }
        });
        
        
    }
    
    
    
    $('#pet_reembolso').change(function(){
        
//        
        
        var pet_id = $('#pet_reembolso').val();
        var _token = $("input[type=hidden][name=_token]").val();
        
        $.ajax({
            type: "POST",
            url: "ajaxPlano",
            dataType: 'json',
            data: {
                pet_id: pet_id,
                _token: _token
            },
            success: function(data) {

                if(data.comprovante_vacinacao == '1'){
                    
                    $('#pet_sem_comprovante').hide();
                    
                    console.log('com comprovante');
                    
                    if (data.servicos.length > 0) {

                        $('#plano').val(data.plano);
                        $('#pet_select').hide();
                        $('#pet_selected').show();
                        $('#pet_selecionado').val(data.pet);
                        $('#pet_id').val(pet_id);
                        $('#pet_id1').val(pet_id);
                        $('#procedimento_inclui').show();
                        $('#complemento').show();

                        var options = '';
                        options = '<option value="">Selecione</select>';
                        for (var i = 0; i < data.servicos.length; i++) {
                            options += '<option value="' + data.servicos[i].servico_id + '">' + data.servicos[i].servico_nome + '</option>';
                        }

                        $('#procedimento_reembolso').html(options).show();
                        $('#procedimento_reembolso').focus();
                        $('.btnCadastroReembolso').removeAttr('disabled');
                    } else {
                        $('.btnCadastroReembolso').attr('disabled', 'disabled');
                        swal("Nenhum procedimento foi encontrado!");
                    }
                    
                } else {
                  
                    console.log('sem comprovante');
                    
                    var url_pet = dir_root_cliente + '/cliente/pet/' + data.uuid;
                    
                    console.log(url_pet);
                    
                    $("#pet_selecionado_comprovante").attr("href", url_pet);
                    
                    $('#pet_sem_comprovante').show();
                    
                }
                
                
            }
        });
    });
    
    
    $('#valor_reembolso').change(function(){
        
        $('.btnIncluirProcedimento').removeAttr('disabled');
        
        var valor_maximo = $('#valor_maximo').val()*100;
        var valor_reembolso = $('#valor_reembolso').val()*100;
        
        console.log(valor_maximo);
        console.log(valor_reembolso);
        
        if(valor_reembolso > valor_maximo){
            $('#valor_reembolso').focus();
            $('.btnIncluirProcedimento').attr('disabled', 'disabled');
            alert('Valor informado maior que valor máximo de reembolso desse procedimento');
        }
        
    });
    
    $('#procedimento_reembolso').change(function(){
        
        var pet_id = $('#pet_id').val();
        var servico_id = $('#procedimento_reembolso').val();
        var _token = $("input[type=hidden][name=_token]").val();
        
        $.ajax({
            type: "POST",
            url: "ajaxProcedimento",
            dataType: 'json',
            data: {
                pet_id: pet_id,
                servico_id: servico_id,
                _token: _token
            },
            success: function(data) {

                if(data.erro.length > 0){
                    $('.btnCadastroReembolso').attr('disabled', 'disabled');
                    alert(data.erro[0]);
                    
                } else {
                    $('#valor_maximo').val(data.limite_valor);
                    $('.btnCadastroReembolso').removeAttr('disabled');
                }
                
            }
        });
    });
    
    $('#data_utilizacao').change(function(){
        
        var data_utilizacao = $('#data_utilizacao').val();
        var _token = $("input[type=hidden][name=_token]").val();
        var pet_id = $('#pet_id').val();
        
        $.ajax({
            type: "POST",
            url: "ajaxData",
            dataType: 'json',
            data: {
                data_utilizacao: data_utilizacao,
                pet_id: pet_id,
                _token: _token
            },
            success: function(data) {
                if(data == 2){
                    $('#data_utilizacao').focus();
                    $('.btnIncluirProcedimento').attr('disabled', 'disabled');
                    alert('Data de utilização inválida!');
                    return false;
                } else if(data == 3){
                    $('#data_utilizacao').focus();
                    $('.btnIncluirProcedimento').attr('disabled', 'disabled');
                    alert('Data de utilização anterior a contratação do plano!');
                } else {
                    $('.btnIncluirProcedimento').removeAttr('disabled');
                }
            }
        });
    });
    
    
    
    $('#email').change(function(){

        var email = $('#email').val();
        //var _token = $('#_token').val();
        var _token = $("input[type=hidden][name=_token]").val();
        
        $.ajax({
            type: "POST",
            url: dir_root + "/painel/ajaxEmail",
            dataType: 'json',
            data: {
                email: email,
                _token: _token
            },
            success: function(data) {
                $('#has-error-email').html('').hide();
                if(data > 1){
                    $('#has-error-email').html(' (Esse email já está sendo utilizado)').show();
                    $('#email').focus();
                    $('.btnCadastro').attr('disabled', 'disabled');
                    return false;
                } else {
                    $('.btnCadastro').removeAttr('disabled');
                }
            }
        });
    });


    $('#cpf').change(function(){

        var cpf = $('#cpf').val();
        //var _token = $('#_token').val();
        var _token = $("input[type=hidden][name=_token]").val();
        
        $.ajax({
            type: "POST",
            url: dir_root + "/painel/ajaxCpf",
            dataType: 'json',
            data: {
                cpf: cpf,
                _token: _token
            },
            success: function(data) {
                $('#has-error-cpf').html('').hide();
                if(data > 1){
                    $('#has-error-cpf').html(' (Esse CPF já está sendo utilizado)').show();
                    $('#cpf').focus();
                    $('.btnCadastro').attr('disabled', 'disabled');
                    return false;
                } else {
                    $('.btnCadastro').removeAttr('disabled');
                }
            }
        });
    });
    
    

    
    
    $('.cnpj_cpf').change(function(){

        var cpf_cnpj = $('#cnpj_cpf').val();
        
        cpf = cpf_cnpj.replace(/\./g, "");
        cpf = cpf.replace(/-/g, "");
        cpf = cpf.replace(/\//g, "");
        
        if ( valida_cpf_cnpj(cpf) ) {
        
            $.ajax({
                type: "POST",
                url: dir_root + "/ajaxCpf",
                dataType: 'json',
                data: {
                    cnpj_cpf: cpf_cnpj
                },
                success: function(data) {
                    if(data > 1){    
                        $('#has-error-cpf').html(' (Esse CNPJ/CPF já está registrado) ').show();
                        $('#cnpj_cpf').focus();
                        $('#box-dados').hide();
                        $('#box-submit').hide();
                    } else {
                        $('#has-error-cpf').html('').show();
                        $('#cnpj_cpf').focus();
                        $('#box-dados').show();
                        $('#box-submit').show();
                        
                        
                        var tipo = $('#tipo').val();

                        if(tipo == 'Pessoa Fisica'){
                            $('#box-pf').show();
                            $('#box-pj').hide();
                            $('#nome').attr("required", true);
                            $('#razao_social').attr("required", false);
                            $('#nome_fantasia').attr("required", false);
                            $('#cnpj_cpf').mask('000.000.000-00');
                        } else if(tipo == 'Pessoa Juridica'){
                            $('#box-pf').hide();
                            $('#box-pj').show();
                            $('#nome').attr("required", false);
                            $('#razao_social').attr("required", true);
                            $('#nome_fantasia').attr("required", true);
                            $('#cnpj_cpf').mask('00.000.000/0000-00');
                        }

                    }
                }
            });
        
        } else {
            $('#has-error-cpf').html(' (CNPJ/CPF inválido) ').show();
        }

        
    });

    $("a[href$='#finish']").attr('disabled', 'disabled');
    
    
    $(document).on('click', '#verifica_privacidade', function() {
        if($("#verifica_privacidade").is(':checked')){
            $("a[href$='#finish']").removeAttr('disabled');
        } else {
            $("a[href$='#finish']").attr('disabled', 'disabled');
        }
    });
    
    
    $(document).on('click', '#verifica_condicoes_gerais', function() {
        if($("#verifica_condicoes_gerais").is(':checked')){
            $("a[href$='#finish']").removeAttr('disabled');
        } else {
            $("a[href$='#finish']").attr('disabled', 'disabled');
        }
    });

    
    $("a[href$='#finish']").click(function() {
        if($("#verifica_condicoes_gerais").is(':checked') && $("#verifica_privacidade").is(':checked')){
            $("#formContratar").submit();
        } else {
            alert('Favor ler a política de privacidade e condições gerais.');
        }
    });
    
    $("#aprovar-checklist").attr('disabled', 'disabled');
    
    $(".checklist").click(function() {
        if($("#anexo1").is(':checked') && $("#anexo2").is(':checked') && $("#anexo3").is(':checked') && $("#anexo4").is(':checked') && $("#anexo5").is(':checked')){
            $("#aprovar-checklist").removeAttr('disabled');
        } else {
            $("#aprovar-checklist").attr('disabled', 'disabled');
        }
    });
    
    
    $(document).on('change', '#cupom', function() {

        var resumo_total = $('#resumo_total').val();
        var cupom = $('#cupom').val();
        
        var _token = $("input[type=hidden][name=_token]").val();
        
        
        $.ajax({
            type: "POST",
            url: "../ajaxCupom",
            dataType: 'json',
            data: {
                resumo_total: resumo_total,
                cupom: cupom,
                _token: _token
            },
            success: function(data) {
                if(data.sucesso > 0){
                    
                    $('#tr_desconto').show();
                    $('#box_desconto').html('R$' + data.cupom.desconto).show();
                    
                    var box_total = '';
                    box_total += '<b> R$' + data.cupom.valor_com_desconto + '</b>';
                    $('#box_total').html(box_total).show()
                    
                } else {
                    
                    $('#tr_desconto').hide();
                    
                    $('#cupom').val('');
                    
                    var box_total = '';
                    box_total += '<b> R$' + resumo_total + '</b>';
                    $('#box_total').html(box_total).show()
                    
                    alert('Cupom de desconto não válido.');
                }
            }
        });
    });
    

    $(document).on('change', '#data_nascimento', function() {
        var data = $(this).val();
        var _token = $("input[type=hidden][name=_token]").val();
        
        console.log(data);
        
        $("a[href$='#next']").removeAttr('disabled');
        
        $.ajax({
            type: "POST",
            url: "../ajaxNascimentoTutor",
            dataType: 'json',
            data: {
                data: data,
                _token: _token
            },
            success: function(data) {
                if(data.sucesso == 0){
                    alert('Idade mínima de 18 anos.');
                    $(this).focus();
                    $("a[href$='#next']").attr('disabled', 'disabled');
                }
            }
        });
    });
    
    $(document).on('change', '.pet_nascimento', function() {
        var data = $(this).val();
        var _token = $("input[type=hidden][name=_token]").val();
        
        console.log(data);
        
        $("a[href='#disable']").removeClass("btnDisable").addClass("btnEnable");
        $("a[href='#disable']").attr('href', '#next');
        
        $.ajax({
            type: "POST",
            url: "../ajaxNascimento",
            dataType: 'json',
            data: {
                data: data,
                _token: _token
            },
            success: function(data) {
                if(data.sucesso == 0){
                    alert('Não há planos para essa idade. A idade máxima é de 10 anos.');
                    
                    $("a[href='#next']").removeClass("btnEnable").addClass("btnDisable");
                    $("a[href='#next']").attr('href', '#disable');

                    return false;
                }
            }
        });
    });


    $(document).on('change', '.especie', function() {
        var especie = $(this).val();
        var sel = $(this).attr('data-sel');
        var _token = $("input[type=hidden][name=_token]").val();
        
        if (!sel){
            sel = 'box_resposta';
        }
        
        console.log(sel);
        
        $.ajax({
            type: "POST",
            url: "../ajaxRaca",
            dataType: 'json',
            data: {
                especie: especie,
                _token: _token
            },
            success: function(data) {
                if(data.sucesso > 0){
                    
                    var options = '';
                    options = '<option value="">Selecione uma raça</select>';
                    for (var i = 0; i < data.geral.length; i++) {
                        options += '<option value="' + data.geral[i].id + '">' + data.geral[i].nome + '</option>';
                    }
                    
//                    $('#' + sel).children('.raca').html(options).show();
                    $('#' + sel).children('.row').children('.col-md-4').children('.control-group').children('.raca').html(options).show();

//                    $('#' + sel).html(options).show();
                } else {
                    options = '<option value="">Não há raça cadastrada</option>';
                    $('#' + sel).children('.row').children('.col-md-4').children('.control-group').children('.raca').html(options).show();
                }
            }
        });
    });
    
    
    $(document).on('click', '.select-pet-pre', function() {
        if($(this).val() == 1){
            var sel = $(this).attr('data-sel');
            if (!sel){
                sel = 'box_resposta';
            }
            $('#' + sel).children('.row').children('.col-md-4').children('.box-pre').show();
        } else {
           var sel = $(this).attr('data-sel');
            if (!sel){
                sel = 'box_resposta';
            }
            $('#' + sel).children('.row').children('.col-md-4').children('.box-pre').hide();
        }
    });
    
    
    $(document).on('click', '.verifica_em_dia', function() {
        if($(this).val() == 0){
            var sel = $(this).attr('data-sel');
            if (!sel){
                sel = 'box_resposta';
            }
            $('#' + sel).children('.row').children('.col-md-4').children('.form-group').children('.box-vacina').show();
        } else {
           var sel = $(this).attr('data-sel');
            if (!sel){
                sel = 'box_resposta';
            }
            $('#' + sel).children('.row').children('.col-md-4').children('.form-group').children('.box-vacina').hide();
        }
    });
    
    
//    $('.especie').change(function(){
//        
//        var especie = $(this).val();
//        var _token = $("input[type=hidden][name=_token]").val();
//
//        $.ajax({
//            type: "POST",
//            url: "../ajaxRaca",
//            dataType: 'json',
//            data: {
//                especie: especie,
//                _token: _token
//            },
//            success: function(data) {
//                if(data.sucesso > 0){
//                    
//                    var options = '';
//                    options = '<option value="">Selecione uma raça</select>';
//                    for (var i = 0; i < data.geral.length; i++) {
//                        options += '<option value="' + data.geral[i].id + '">' + data.geral[i].nome + '</option>';
//                    }
//
//                    $('#raca').html(options).show();
//                } else {
//                    options = '<option value="">Não há raça cadastrada</option>';
//                    $('#raca').html(options).show();
//                }
//            }
//        });
//    });
    
    
    function Formata_Dinheiro(n) {
        return n.toFixed(2).replace('.', ',').replace(/(\d)(?=(\d{3})+\,)/g, "$1.");
    }
       

    
    Number.prototype.formatMoney = function (c, d, t) {
        var n = this,
            c = isNaN(c = Math.abs(c)) ? 2 : c,
            d = d == undefined ? "." : d,
            t = t == undefined ? "," : t,
            s = n < 0 ? "-" : "",
            i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
            j = (j = i.length) > 3 ? j % 3 : 0;
        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    };
  
   
})
(function($) {
    "use strict";

    $('#wizard1').steps({
        headerTag: 'h3',
        bodyTag: 'section',
        autoFocus: true,
        titleTemplate: '<span class="number">#index#<\/span> <span class="title">#title#<\/span>'
    });
    $('#wizard2').steps({
        headerTag: 'h3',
        bodyTag: 'section',
        autoFocus: true,
        titleTemplate: '<span class="number">#index#<\/span> <span class="title">#title#<\/span>',
        onStepChanging: function(event, currentIndex, newIndex) {
            if (currentIndex < newIndex) {
                // Step 1 form validation
                if (currentIndex === 0) {
                    var nome = $('#nome').parsley();
                    var sexo = $('#sexo').parsley();
                    var cpf1 = $('#cpf1').parsley();
                    var email1 = $('#email1').parsley();
                    var email_confirmacao = $('#email_confirmacao').parsley();
                    var cep = $('#cep').parsley();
                    var endereco = $('#endereco').parsley();
                    var numero = $('#numero').parsley();
                    var bairro = $('#bairro').parsley();
                    var cidade = $('#cidade').parsley();
                    var uf = $('#uf').parsley();
                    var data_nascimento = $('#data_nascimento').parsley();
                    var telefone1 = $('#telefone1').parsley();
                    var telefone2 = $('#telefone2').parsley();
                    var _token = $("input[type=hidden][name=_token]").val();
                    
                    var telefone9 = $('#telefone2').val();
                    
//                    if (nome.isValid() && cpf1.isValid()) {
                    if (data_nascimento.isValid() && nome.isValid() && sexo.isValid() && cpf1.isValid() && email1.isValid() && email_confirmacao.isValid() && cep.isValid() && endereco.isValid() && numero.isValid() && bairro.isValid() && cidade.isValid() && uf.isValid() && telefone1.isValid() && telefone2.isValid() && (telefone9.length >= 15 || telefone9.length <= 0)) {
                        
                        var nome1 = $('#nome').val();
                        var sexo1 = $('#sexo').val();
                        var cpf11 = $('#cpf1').val();
                        var email11 = $('#email1').val();
                        var email_confirmacao1 = $('#email_confirmacao').val();
                        var cep1 = $('#cep').val();
                        var endereco1 = $('#endereco').val();
                        var numero1 = $('#numero').val();
                        var bairro1 = $('#bairro').val();
                        var cidade1 = $('#cidade').val();
                        var uf1 = $('#uf').val();
                        var data_nascimento = $('#data_nascimento').val();
                        var telefone11 = $('#telefone1').val();
                        var telefone21 = $('#telefone2').val();

                        $.ajax({
                            type: "POST",
                            url: "../ajaxPasso1",
                            dataType: 'json',
                            data: {
                                nome: nome1,
                                sexo: sexo1,
                                cpf1: cpf11,
                                email1: email11,
                                email_confirmacao: email_confirmacao1,
                                cep: cep1,
                                endereco: endereco1,
                                numero: numero1,
                                bairro: bairro1,
                                cidade: cidade1,
                                uf: uf1,
                                data_nascimento: data_nascimento,
                                telefone1: telefone11,
                                telefone2: telefone21,
                                _token: _token
                            },
                            success: function(data) {
                                if(data.sucesso > 0){
                                    console.log(data.tutor_id);
                                    $('#tutor_id').val(data.tutor_id);
                                    return true;
                                }
                            }
                        });

                        return true;
                        
                    } else {
                        nome.validate();
                        sexo.validate();
                        cpf1.validate();
                        email1.validate();
                        email_confirmacao.validate();
                        cep.validate();
                        endereco.validate();
                        numero.validate();
                        bairro.validate();
                        cidade.validate();
                        uf.validate();
                        data_nascimento.validate();
                        telefone1.validate();
                        telefone2.validate();
                    }
                    
                }
                // Step 2 form validation
                if (currentIndex === 1) {
                    
                    var valido = 1;
                    
                    $("#resposta").find(".pet_nome, .pet_plano, .pet_nascimento, .pet_sexo, .pet_pelagem, .pet_microship, .pet_especie, .pet_raca, .verifica_em_dia, .verifica_pre_existente").each(function() {
                        
                        if($(this).parsley().isValid()){
                            
                        } else {
                            valido = 0;
                        }
                        
                    });
                    
//                    
//                    
//                    
//                    var pet_nome = $('#pet_nome').parsley();
//                    var pet_plano = $('#pet_plano').parsley();
//                    var pet_nascimento = $('#pet_nascimento').parsley();
//                    var pet_sexo = $('#pet_sexo').parsley();
//                    var pet_pelagem = $('#pet_pelagem').parsley();
//                    var pet_microship = $('#pet_microship').parsley();
//                    var pet_especie = $('#pet_especie').parsley();
//                    var pet_raca = $('#pet_raca').parsley();
                    
                    if (valido == 1) {
                        
                        var _token = $("input[type=hidden][name=_token]").val();
                        var tutor_id = $('#tutor_id').val();
                        var pet_nome1;
                        var pet_plano1;
                        var pet_nascimento1;
                        var pet_sexo1;
                        var pet_pelagem1;
                        var pet_microship1;
                        var pet_especie1;
                        var pet_raca1;

                        $("#resposta").find(".pet_nome").each(function() {
                            pet_nome1 += '#' + $(this).val();
                        });
                        $("#resposta").find(".pet_plano").each(function() {
                            pet_plano1 += '#' + $(this).val();
                        });
                        $("#resposta").find(".pet_nascimento").each(function() {
                            pet_nascimento1 += '#' + $(this).val();
                        });
                        $("#resposta").find(".pet_sexo").each(function() {
                            pet_sexo1 += '#' + $(this).val();
                        });
                        $("#resposta").find(".pet_pelagem").each(function() {
                            pet_pelagem1 += '#' + $(this).val();
                        });
                        $("#resposta").find(".pet_microship").each(function() {
                            pet_microship1 += '#' + $(this).val();
                        });
                        $("#resposta").find(".pet_especie").each(function() {
                            pet_especie1 += '#' + $(this).val();
                        });
                        $("#resposta").find(".pet_raca").each(function() {
                            pet_raca1 += '#' + $(this).val();
                        });


                        $.ajax({
                            type: "POST",
                            url: "../ajaxPasso2",
                            dataType: 'json',
                            async: false,
                            data: {
                                pet_nome: pet_nome1,
                                pet_plano: pet_plano1,
                                pet_nascimento: pet_nascimento1,
                                pet_sexo: pet_sexo1,
                                pet_pelagem: pet_pelagem1,
                                pet_microship: pet_microship1,
                                pet_especie: pet_especie1,
                                pet_raca: pet_raca1,
                                tutor_id: tutor_id,
                                _token: _token
                            },
                            success: function(data) {
                                if(data.sucesso > 0){
                                    
                                    var box_cliente = '';
                                    box_cliente += data.cliente[0].nome + '<br>' + data.cliente[0].email + '<br>' + data.cliente[0].telefone1 + '<br>';
                                    $('#box_cliente').html(box_cliente).show();
                                    
                                    var box_total = '';
                                    box_total += '<b> R$' + data.cliente[0].subtotal + '</b>';
                                    $('#box_total').html(box_total).show();
                                    
                                    var box_pets = '';
                                    for (var i = 0; i < data.pets.length; i++) {
                                        box_pets += '<div class="row col-md-12">';
                                        box_pets += data.pets[i].pet_nome + '<br>';
                                        box_pets += data.pets[i].pet_especie + ' - ' + data.pets[i].pet_nascimento + '<br>';
                                        box_pets += '</div>';
                                        
                                        box_pets += '<div class="row">';
                                        box_pets += '<div class="col-md-6">';
                                        box_pets += data.pets[i].pet_plano_nome;
                                        box_pets += '</div>';
                                        box_pets += '<div class="col-md-6" style="text-align: right;">';
                                        box_pets += 'R$' + data.pets[i].pet_plano_valor_formatado;
                                        box_pets += '</div>';
                                        box_pets += '</div>';
                                        
                                        box_pets += '<div class="col-md-12">';
                                        box_pets += '<hr style="border-top: 1px solid #dbd6d6;">';
                                        box_pets += '</div>';
                                        
                                    }
                                    
                                    box_pets += '<input type="hidden" id="resumo_total" value="' + data.cliente[0].subtotal + '">';
                                    
                                    $('#box_pets').html(box_pets).show();
                                    
                                    $("a[href$='#finish']").attr('disabled', 'disabled');
                                    
                                }
                            }
                        });

                        return true;
                        
                    } else {
                        
                        $("#resposta").find(".pet_nome, .pet_plano, .pet_nascimento, .pet_sexo, .pet_pelagem, .pet_microship, .pet_especie, .pet_raca, .verifica_em_dia, .verifica_pre_existente").each(function() {
                        
                            $(this).parsley().validate();

                        });
                        
                    }
                }
                // Always allow step back to the previous step even if the current step is not valid.
            } else {
                return true;
            }
        }
    });
    $('#wizard3').steps({
        headerTag: 'h3',
        bodyTag: 'section',
        autoFocus: true,
        titleTemplate: '<span class="number">#index#<\/span> <span class="title">#title#<\/span>',
        stepsOrientation: 1
    });

    $('.dropify-clear').click(function() {
        $('.dropify-render img').remove();
        $(".dropify-preview").css("display", "none");
        $(".dropify-clear").css("display", "none");
    });

    //_________accordion-wizard
    var options = {
        mode: 'wizard',
        autoButtonsNextClass: 'btn btn-primary float-end',
        autoButtonsPrevClass: 'btn btn-light',
        stepNumberClass: 'badge rounded-pill bg-primary me-1',
        onSubmit: function() {
            alert('Form submitted!');
            return true;
        }
    }

})(jQuery);

//Function to show image before upload

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('.dropify-render img').remove();
            var img = $('<img id="dropify-img">'); //Equivalent: $(document.createElement('img'))
            img.attr('src', e.target.result);
            img.appendTo('.dropify-render');
            $(".dropify-preview").css("display", "block");
            $(".dropify-clear").css("display", "block");
        };
        reader.readAsDataURL(input.files[0]);
    }
}
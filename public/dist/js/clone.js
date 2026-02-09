$(document).ready( function() {
    
    var regex = /^(.+?)(\d+)$/i;
    var cloneIndex = $(".box_resposta").length;
    var numberPet = 1;
    
    function clone(){
        
        $("#box_resposta").clone()
            .appendTo("#resposta")
            .attr("id", "box_resposta" +  cloneIndex)
            .find('*, .especie, .select-pet-pre, .remove, .verifica_em_dia').attr("data-sel", "box_resposta" +  cloneIndex)
            .each(function() {
                
                console.log(cloneIndex);
        
                $('.datemask').mask('00/00/0000');
                
                $('#box_resposta' + cloneIndex).children('.col-lg-12').children('.remove').show();
                
                $('#box_resposta' + cloneIndex).children('.row').children('.col-md-4').children('.form-group').children('.pet_nome').val('');
                $('#box_resposta' + cloneIndex).children('.row').children('.col-md-4').children('.form-group').children('.pet_nascimento').val('');
                $('#box_resposta' + cloneIndex).children('.row').children('.col-md-4').children('.form-group').children('.pet_microship').val('');
                $('#box_resposta' + cloneIndex).children('.row').children('.col-md-4').children('.form-group').children('.form-group').children('.pet_pre').val('');
                $('#box_resposta' + cloneIndex).children('.pet_number').html('PET ' + cloneIndex);
                
                numberPet = Number(cloneIndex) + 1;
                
                $('#box_resposta' + cloneIndex).children('h4').children('.pet_number').html('PET ' + numberPet);
                
                var id = this.id || "";
                var match = id.match(regex) || [];
                
                if (match.length == 3) {
                    this.id = match[1] + (cloneIndex);
                }
            })
            .on('click', 'button.clone', clone)
            .on('click', 'button.remove', remove);
    
        cloneIndex++;
        
//        $("button.clone").on("click", clone);
//        $("button.remove").on("click", remove);
        
        
        return false;
    }
    
    
    
    function remove(){
        
        var sel = $(this).attr('data-sel');
        
        if (!sel){
            sel = 'box_resposta';
        }
        
        console.log(sel);
        
        $("#" + sel).remove();
        
        return false;
    }

    $("button.clone").on("click", clone);
    $("button.remove").on("click", remove);
    
})

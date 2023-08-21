(function () {
    'use strict'
  
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    //var forms = document.querySelectorAll('.needs-validation')
  
    //Loop over them and prevent submission
    // Array.prototype.slice.call(forms)
    //   .forEach(function (form) {
    //     form.addEventListener('submit', function (event) {
    //       if (!form.checkValidity()) {
    //         event.preventDefault()
    //         event.stopPropagation()
    //       }
  
    //       form.classList.add('was-validated')
    //     }, false)
    //   })
 })

 function validacurp(curp) 
 {
    //$("#curpPetitioner1").mask('SSSS000000SSSSSSAA', {reverse: true});
    curp.mask('SSSS000000SSSSSSAA', {reverse: true}).done;
    //alertify.error('Formato CURP Incorrecto');
 }
  
function verifyCurpPetitioner(btn,event) {
    
    event.preventDefault();
    var curpbeneficiary = $('#curpPetitioner1').val();

    //validacurp(curpbeneficiary);

    var boton = btn.id;
    
    if (boton == 'check-1')
       var action = 'checkCurp';
    else
        var action = 'checkCurp2';


    debugger;    
    
    $.ajax({
            type: "POST",
            url: "consultas",
            data:
             { 'action': action, 'curpbeneficiary': curpbeneficiary, "_token": $("meta[name='csrf-token']").attr("content") }
        })
        .done(function(response)
        {
            var petitionerName = $('#petitioner');
            var curpbeneficiaryP = $('#curpbeneficiary1');

            if (response[0]['requisition1'] != null || response[0]['requisition0'] != null) 
            {
                //petitionerName.val(response['requisition']);
                petitionerName.val(response[0]['Usuario0']);
                if (response[0]['message'] != null && response[0]['message']['exist'] == 1) 
                {
                    var divModal = $('#alert-container');
                     //console.log(response[0]);
                     if (response[0].cantidad == 1)
                    {
                         $('#alert-container').find('P').remove();
                         $('#alert-container').find('HR').remove();
                         for (let x = 0; x < response[0].cantidad; x++) 
                        {
                             var Usuario = document.createElement("P"); // Create a <p> element
                             Usuario.innerText = 'El usuario: ' + response[0]['Usuario' + x];
                             var Apoyo = document.createElement("P"); // Create a <p> element
                             Apoyo.innerText = 'Le brindaron el apoyo de: ' + response[0]['Apoyo' + x];
                             var fecha = document.createElement("P"); // Create a <p> element
                             fecha.innerText = 'Solicitado el dia: ' + response[0]['date' + x];   //['date'].substr(-30, 10);
                             var Curp = document.createElement("P"); // Create a <p> element
                             Curp.innerText = 'Al Solicitante con la CURP: ' + response[0]['CualSolicitante' + x];  //['curp'];
                             var institucion = document.createElement("P"); // Create a <p> element
                             institucion.innerText = 'De la institución: ' + response[0]['institute' + x];  //['name'];
                             var Department = document.createElement("P"); // Create a <p> element
                             Department.innerText = 'Del departamento: ' + response[0]['Departament' + x];  //['name'];
                             var linea = document.createElement("HR");

                             divModal.append(Usuario);
                             divModal.append(Apoyo);
                             divModal.append(fecha);
                             divModal.append(Curp);
                             divModal.append(institucion);
                             divModal.append(Department);
                             divModal.append(linea);
                            // console.log(response[0]);
                        }
                         alertify.error(response[0]['message']['text']);
                         $('#modal-warning').modal('toggle');
                    } else 
                    {
                         if (response[0].cantidad > 1) 
                        {
                             $('#alert-container').find('P').remove();
                             $('#alert-container').find('HR').remove();
                            for (let y = 0; y < response[0].cantidad; y++)
                            {
                                 var Usuario = document.createElement("P"); // Create a <p> element
                                 Usuario.innerText = 'El usuario: ' + response[0]['Usuario' + y];
                                 var Apoyo = document.createElement("P"); // Create a <p> element
                                 Apoyo.innerText = 'Le brindaron el apoyo de: ' + response[0]['Apoyo' + y];
                                 var fecha = document.createElement("P"); // Create a <p> element
                                 fecha.innerText = 'Solicitado el dia: ' + response[0]['date' + y];    // ['date'].substr(-30, 10);
                                 var Curp = document.createElement("P"); // Create a <p> element
                                 Curp.innerText = 'Al Solicitante con la CURP: ' + response[0]['CualSolicitante' + y];  // ['curp'];
                                 var institucion = document.createElement("P"); // Create a <p> element
                                 institucion.innerText = 'De la institución: ' + response[0]['institute' + y]; //['name'];
                                 var Department = document.createElement("P"); // Create a <p> element
                                 Department.innerText = 'Del departamento: ' + response[0]['Departament' + y]; //['name'];
                                 var linea = document.createElement("HR");

                                 divModal.append(Usuario);
                                 divModal.append(Apoyo);
                                 divModal.append(fecha);
                                 divModal.append(Curp);
                                 divModal.append(institucion);
                                 divModal.append(Department);
                                 divModal.append(linea);
                            }
                             alertify.error(response[0]['message']['text']);
                             $('#modal-warning').modal('toggle');
                        }
                    }
                } else
                {
                     alertify.success(response[0]['message']['text']);
                }
            } else if (response[0]['personalData'] != null) 
            {
                 if (response[0]['message'] != null && response[0]['message']['exist'] == 1) 
                {
                    var divModal = $('#alert-container');
                    if (response[0].cantidad == 1) 
                    {
                        $('#alert-container').find('P').remove();
                        $('#alert-container').find('HR').remove();
                        for (let x = 0; x < response[0].cantidad; x++)
                        {
                             var Usuario = document.createElement("P"); // Create a <p> element
                             Usuario.innerText = 'El usuario: ' + response[0]['personalData']['name'];
                             var Apoyo = document.createElement("P"); // Create a <p> element
                             Apoyo.innerText = 'Le brindaron el apoyo de: ' + response[0]['Apoyo' + x];
                             var fecha = document.createElement("P"); // Create a <p> element
                             fecha.innerText = 'Solicitado el dia: ' + response[0]['date' + x]; //['date'].substr(-30, 10);
                             var Curp = document.createElement("P"); // Create a <p> element
                             Curp.innerText = 'Al solicitante con la CURP: ' + response[0]['CualSolicitante' + x];
                             var institucion = document.createElement("P"); // Create a <p> element
                             institucion.innerText = 'De la institución: ' + response[0]['institute' + x];
                             var Department = document.createElement("P"); // Create a <p> element
                             Department.innerText = 'Del departamento: ' + response[0]['Departament' + x];
                             var linea = document.createElement("HR");

                             divModal.append(Usuario);
                             divModal.append(Apoyo);
                             divModal.append(fecha);
                             divModal.append(Curp);
                             divModal.append(institucion);
          
                             divModal.append(Department);
                             divModal.append(linea);
                        }
                        $('#fd').deleteClass("d-block")
                         alertify.error(response[0]['message']['text']);
                         $('#modal-warning').modal('toggle');

                    }
                    //console.log(response[0]);
                }

            } else
            {
                //if (response[0]['message'] != null)
                if (response[0]['message']['text'] != '')
                {
                    var regex = 
                          "[A-Z]{1}[AEIOU]{1}[A-Z]{2}[0-9]{2}" +
                          "(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])" +
                          "[HM]{1}" +
                          "(AS|BC|BS|CC|CS|CH|CL|CM|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)" +
                          "[B-DF-HJ-NP-TV-Z]{3}" +
                          "[0-9A-Z]{1}[0-9]{1}$";

                  //var mascara = 'SSSS000000SSSSSSAA'
                                                                               
                  if (curpbeneficiary.match(regex))
                     return (alertify.error(response[0]['message']['text']))
                  else      
                      return (alertify.error('Formato CURP Incorrecto'))
                }  
                else 
                {
                    $('#fd').addClass("d-block")
                   //$('#fd').deleteClass("d-block")
                }   
            }
            
         })
        .fail(function() {console.log("error");})
        .always(function() {})
}



// function verifybtn(bton)
// {
//         var empty = $(this).find('input[required]').filter(function() 
//         {
//           return this.value == '';
//         });
      
//        if (empty.length) 
//        {
//           btn.preventDefault();
//           //e.preventDefault();
//           alert('enter all required field!');
//         }      
// }

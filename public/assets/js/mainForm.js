function addModal() {
    $('#add').on('click', function(evt) {
        $('.modal-title').text('Agregar Registro');
        $('#action').val("new");
        $('#frm').removeClass('was-validated');
        resetForm();
        $('#modal-register').modal('toggle');
    });
}

function addWImageID() {
    $('#add').on('click', function(evt) {
        $('.modal-title').text('Agregar Registro');
        $('#action').val("new");
        $('#frm').removeClass('was-validated');
        resetForm();
        $('#imagenPrevisualizacion').removeAttr('src');
        $('#imagenPrevisualizacion').removeAttr('class');
        $('#imagenPrevisualizacion2').removeAttr('src');
        $('#imagenPrevisualizacion2').removeAttr('class');
        $('#modal-register').modal('toggle');
    });
}

function addWActive() {
    $('#add').on('click', function(evt) {
        $('.modal-title').text('Agregar Registro');
        $('#action').val("new");
        $('#frm').removeClass('was-validated');
        resetForm();
        $('#active').attr("checked", "checked");
        $('#modal-register').modal('toggle');
    });
}

function addWActiveAColor() {
    $('#add').on('click', function(evt) {
        $('.modal-title').text('Agregar Registro');
        $('#action').val("new");
        $('#frm').removeClass('was-validated');
        resetForm();
        $('#active').attr("checked", "checked");
        $('#modal-register').modal('toggle');
        $("#color").attr('style', 'background: rgb(47, 182, 255); color: rgb(255, 255, 255);')
    });
}

function resetForm() {
    document.getElementById("frm").reset();
}

function addNew($url) {
    $('#add').attr('href', $url);
}

function success() {
    alertify.success('Tus datos fueron almacenados de forma satisfactoria.');
}

function error() {
    alertify.error('Tus datos no pudieron ser almacenados.');
}

$(function() {
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() == false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
});

$(function() {
    $('[data-toggle="tooltip"]').tooltip()
})


function refresh($url) {
    var $tabla = $("#dataTable");
    $tabla.bootstrapTable({
        locale: "es-ES"
    });
    $.ajax({
            url: $url,
            type: 'POST',
            dataType: 'json',
            data: { "action": "query", "_token": $("meta[name='csrf-token']").attr("content") },
        })
        .done(function(response) {
            $tabla.bootstrapTable('showLoading');
            console.log({ response });
            if (response.length > 0) {
                $tabla.bootstrapTable('destroy').bootstrapTable({
                    height: 500,
                    locale: "es-Es",
                    data: response
                });
          }
        })
        .fail(function(response) {
            alert(response.responseJSON);
            // $.each(response.responseJSON.errors, function(key, item) {
            //     alertify.error(item[0]);
            //     // var p = document.createElement('p');
            //     // p.textContent = item[0];
            //     // msj.append(p);
            // });
        })
        .always(function() {
            $tabla.bootstrapTable('hideLoading');
        })
}
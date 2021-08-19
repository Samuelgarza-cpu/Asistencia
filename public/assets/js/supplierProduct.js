$(function() {
    'use strict';
    addModal();
    refresh('/productosdelproveedor/' + idProveedor);
    $('#modal-link').on('click', function() {
        $('.modal-title').text('Agregar Registro');
        $('#action2').val("newProduct");
        $('#frm-product').removeClass('was-validated');
        document.getElementById("frm-product").reset();
        $('#modal-register-product').modal('toggle');
    });
    $("#saveProduct").click(saveProduct);
    $('#price').mask('######0.00', { reverse: true });
});

function saveProduct() {
    if ($('#nameProduct').val() != '' && $('#supports_id').val() != '' && $('#categories_id').val() != '') {
        let nameProduct = $('#nameProduct').val();
        let supports_id = $('#supports_id2').val();
        let categories_id = $('#categories_id').val();
        let action = $('#action2').val();
        $.ajax({
                type: "POST",
                url: "productosdelproveedor" + idProveedor,
                data: { 'action': action, 'nameProduct': nameProduct, 'supports_id': supports_id, 'categories_id': categories_id, "_token": $("meta[name='csrf-token']").attr("content") }
            })
            .done(function(response) {
                var newProduct = $('#products_id');
                newProduct.append('<option value="' + response.id + '">' + response.name + '</option>');
                $('#modal-register-product').modal('hide');
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {})
    }
}
window.operateEvents = {
    'click .update': function(e, value, row, index) {
        $('.modal-title').text('Modificar Registro');
        $('#action').val("update");
        $('#frm').removeClass('was-validated')
        $('#id').val(row.id);
        $('#products_id').val(row.products_id);
        $('#price').unmask();
        $('#price').val(row.price * 100);
        $('#price').mask('######0.00', { reverse: true });

        if (row.active == 1)
            $('#active').attr("checked", "checked");
        else
            $('#active').removeAttr("checked");
        $('#modal-register').modal('toggle');
    },
    'click .remove': function(e, value, row, index) {
        $('#registerId').val(row.id);
        $('#modal-confirmation').modal('toggle');
    }
}
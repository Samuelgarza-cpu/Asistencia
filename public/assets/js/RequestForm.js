$(function() {
    'use strict';

    $('#income').mask('#######0.00', { reverse: true });
    $('#expense').mask('########0.00', { reverse: true });
    $('#unitPrice1').mask('########00.0000', { reverse: true });
    $('#qty1').mask('#####0', { reverse: true });
    $('#age1').mask('000', { reverse: true });
    $('#totalPrice1').mask('####00000.00000', { reverse: true });
    $('#totalPrice1').mask('####00000.0000', { reverse: true });
    $('#addDiagnosticBeneficiary1').click(addDisabilities);
    $('#addProduct').click(addProduct);
    $('#addFurniture').click(addFurniture);
    $('#addBuildingMaterial').click(addBuildingMaterial);
    $('#addService').click(addService);
    $('#addMH').click(addMH);
    $('#addBeneficiary').click(addBeneficiary);
    $('#type').change(getSupport);
    $('#supports_id').change(getCategories);
    $('#categories_id').change(getSuppliers);
    $('#disabilitycategories1_1').change(getDisabilities);
    $('#suppliers_id1').change(getProducts);
    $('#products_id1').change(getPrice);
    $('#unitPrice1').change(enabledQty);
    $('#qty1').change(totalQty);
    crop();
});

function crop() {
    var $modal = $('#modal');
    var image = document.getElementById('imageCrop');
    var cropper;
    var nameImage;
    $("body").on("change", ".imagePetitioner", function(e) {
        var files = e.target.files;
        nameImage = e.target.files[0].name;
        var done = function(url) {
            image.src = url;
            $modal.modal('show');
        };
        var reader;
        var file;
        var url;
        if (files && files.length > 0) {
            file = files[0];
            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function(e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
            }
        }
    });
    $modal.on('shown.bs.modal', function() {
        cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 3,
            preview: '.preview'
        });
    }).on('hidden.bs.modal', function() {
        cropper.destroy();
        cropper = null;
    });
    $("#crop").click(function() {
        var canvas;
        var url;
        $modal.modal('hide');
        if (cropper) {
            canvas = cropper.getCroppedCanvas({
                width: 160,
                height: 160,
            });

            canvas.toBlob(function(blob) {
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function() {
                    var base64data = reader.result;
                    $modal.modal('hide');
                    let preview = document.getElementById('imagenPrevisualizacion');
                    preview.src = reader.result;
                    $.ajax({
                            type: "POST",
                            url: "nueva_solicitud",
                            data: { 'image': base64data, 'nameImage': nameImage, 'action': 'uploadImage', "_token": $("meta[name='csrf-token']").attr("content") }
                        })
                        .done(function(response) {
                            console.log(response);
                        })
                        .fail(function() {
                            console.log("error");
                        })
                        .always(function() {})
                }
            });
        }
    });
}

window.operateEvents = {
    'click .update': function(e, value, row, index) {
        $('.modal-title').text('Modificar Registro');
        $('#action').val("update");
        $('#frm').removeClass('was-validated')
        $('#id').val(row.id);
        $('#name').val(row.name);
        $('#modal-register').modal('toggle');
    },
    'click .remove': function(e, value, row, index) {
        $('#registerId').val(row.id);
        $('#modal-confirmation').modal('toggle');
    },

    'click .update2': function(e, value, row, index) {
        $('.modal-title').text('Modificar Registro');
        $('#action').val("update");
        $('#frm').removeClass('was-validated')
        $('#id').val(row.id);
        $('#name').val(row.name);
        $('#modal-register').modal('toggle');
    },
    'click .remove2': function(e, value, row, index) {
        $('#registerId').val(row.id);
        $('#modal-confirmation').modal('toggle');
    },

    'on .submit': function(e) {
        var empty = $(this).find('input[required]').filter(function() {
          return this.value == '';
        });
      
        if (empty.length) {
          e.preventDefault();
          alert('enter all required field!');
        }      
      }
}

function addProduct() {
    var count = $('#countProduct').val();
    count++;
    $('#countProduct').val(count);

    var total = $('#countTotalP').val();
    total++;
    $('#countTotalP').val(total);

    var products = $('#fieldsProducts').val();
    products = products + ',' + count;
    $('#fieldsProducts').val(products);

    var productsDiv = $('#products');
    var btnDeleteID = "deleteProduct-" + count;
    var firstDivID = "fDP-" + count;

    var productHeaderId = "productHeader" + count;
    var suppliersId = "suppliers_id" + count;
    var productsId = "products_id" + count;
    var unitPriceId = "unitPrice" + count;
    var qtyId = "qty" + count;
    var totalPriceId = "totalPrice" + count;

    var firstDiv = document.createElement("div");
    firstDiv.setAttribute("id", firstDivID);

    var hr = document.createElement("hr");

    var productHeader = document.createElement("div");
    productHeader.setAttribute("id", productHeaderId);
    productHeader.setAttribute("class", "headerAppend");
    productHeader.textContent = "Producto " + count;

    var btnDelete = document.createElement("button");
    btnDelete.setAttribute("type", "button");
    btnDelete.setAttribute("id", btnDeleteID);
    btnDelete.setAttribute("class", "btn float-right");

    var spanTimes = document.createElement("i");
    spanTimes.setAttribute("class", "fas fa-trash-alt fa-2x colorIcon");

    var firstFormRow = document.createElement("div");
    firstFormRow.setAttribute("class", "form-row");

    var supplierFormGroup = document.createElement('div');
    supplierFormGroup.setAttribute("class", "form-group col-md-3");

    var labelSupplier = document.createElement('label');
    labelSupplier.setAttribute("for", suppliersId);
    labelSupplier.textContent = "Proveedor";

    var selectSupplier = document.createElement('select');
    selectSupplier.setAttribute("class", "form-control");
    selectSupplier.setAttribute("required", "required");
    selectSupplier.setAttribute("id", suppliersId);
    selectSupplier.setAttribute("name", suppliersId);
    selectSupplier.setAttribute("disabled", "disabled");

    var optionSupplier = document.createElement('option');
    optionSupplier.setAttribute("value", "");
    optionSupplier.textContent = "Selecciona...";

    var productFormGroup = document.createElement('div');
    productFormGroup.setAttribute("class", "form-group col-md-3");

    var labelProduct = document.createElement('label');
    labelProduct.setAttribute("for", productsId);
    labelProduct.textContent = "Producto";

    var selectProduct = document.createElement('select');
    selectProduct.setAttribute("class", "form-control");
    selectProduct.setAttribute("required", "required");
    selectProduct.setAttribute("id", productsId);
    selectProduct.setAttribute("name", productsId);
    selectProduct.setAttribute("disabled", "disabled");

    var optionProduct = document.createElement('option');
    optionProduct.setAttribute("value", "");
    optionProduct.textContent = "Selecciona...";

    var unitPriceFormGroup = document.createElement('div');
    unitPriceFormGroup.setAttribute("class", "form-group col-md-2");

    var labelUnitPrice = document.createElement('label');
    labelUnitPrice.setAttribute("for", unitPriceId);
    labelUnitPrice.textContent = "Precio Unitario";

    var inputUnitPrice = document.createElement('input');
    inputUnitPrice.setAttribute("type", "text");
    inputUnitPrice.setAttribute("class", "form-control");
    inputUnitPrice.setAttribute("id", unitPriceId);
    inputUnitPrice.setAttribute("name", unitPriceId);
    inputUnitPrice.setAttribute("placeholder", "Ingresar el precio del producto");
    inputUnitPrice.setAttribute("required", "required");
    inputUnitPrice.setAttribute("disabled", "disabled");

    var invalidUnitPrice = document.createElement('div');
    invalidUnitPrice.setAttribute("class", "invalid-feedback");
    invalidUnitPrice.textContent = "Favor de ingresar el precio del producto";

    var qtyFormGroup = document.createElement('div');
    qtyFormGroup.setAttribute("class", "form-group col-md-2");

    var labelQty = document.createElement('label');
    labelQty.setAttribute("for", qtyId);
    labelQty.textContent = "Cantidad";

    var inputQty = document.createElement('input');
    inputQty.setAttribute("type", "text");
    inputQty.setAttribute("class", "form-control");
    inputQty.setAttribute("id", qtyId);
    inputQty.setAttribute("name", qtyId);
    inputQty.setAttribute("placeholder", "Ingresar la cantidad del mismo producto");
    inputQty.setAttribute("required", "required");
    inputQty.setAttribute("disabled", "disabled");

    var invalidQty = document.createElement('div');
    invalidQty.setAttribute("class", "invalid-feedback");
    invalidQty.textContent = "Favor de ingresar la cantidad del mismo producto";

    var totalPriceFormGroup = document.createElement('div');
    totalPriceFormGroup.setAttribute("class", "form-group col-md-2");

    var labelTotalPrice = document.createElement('label');
    labelTotalPrice.setAttribute("for", totalPriceId);
    labelTotalPrice.textContent = "Costo Total";

    var inputTotalPrice = document.createElement('input');
    inputTotalPrice.setAttribute("type", "text");
    inputTotalPrice.setAttribute("class", "form-control");
    inputTotalPrice.setAttribute("id", totalPriceId);
    inputTotalPrice.setAttribute("name", totalPriceId);
    inputTotalPrice.setAttribute("required", "required");
    inputTotalPrice.setAttribute("disabled", "disabled");
    inputTotalPrice.textContent = "0";

    var invalidTotalPrice = document.createElement('div');
    invalidTotalPrice.setAttribute("class", "invalid-feedback");
    invalidTotalPrice.textContent = "Favor de ingresar el total del costo";

    productsDiv.append(firstDiv);
    firstDiv.append(hr);
    firstDiv.append(productHeader);
    productHeader.append(btnDelete);
    btnDelete.append(spanTimes);

    firstFormRow.append(supplierFormGroup);
    supplierFormGroup.append(labelSupplier);
    supplierFormGroup.append(selectSupplier);
    selectSupplier.append(optionSupplier);
    // selectSupplier.append(optionwoSupplier);

    firstFormRow.append(productFormGroup);
    productFormGroup.append(labelProduct);
    productFormGroup.append(selectProduct);
    selectProduct.append(optionProduct);

    firstFormRow.append(unitPriceFormGroup);
    unitPriceFormGroup.append(labelUnitPrice);
    unitPriceFormGroup.append(inputUnitPrice);
    unitPriceFormGroup.append(invalidUnitPrice);

    firstFormRow.append(qtyFormGroup);
    qtyFormGroup.append(labelQty);
    qtyFormGroup.append(inputQty);
    qtyFormGroup.append(invalidQty);

    firstFormRow.append(totalPriceFormGroup);
    totalPriceFormGroup.append(labelTotalPrice);
    totalPriceFormGroup.append(inputTotalPrice);
    totalPriceFormGroup.append(invalidTotalPrice);

    firstDiv.append(firstFormRow);

    var input_unitPrice = $('#unitPrice' + count);
    input_unitPrice.mask('$########0.00', { reverse: true });

    var input_qty = $('#qty' + count);
    input_qty.mask('#####0', { reverse: true });

    var input_totalPrice = $('#totalPrice' + count);
    input_totalPrice.mask('$########0.00', { reverse: true });
    $('#totalPrice' + count).val("0");
    $('#qty' + count).val("0");
    $('#unitPrice' + count).val("0");

    $('#suppliers_id' + count).change(getProducts);
    $('#products_id' + count).change(getPrice);
    $('#unitPrice' + count).change(enabledQty);
    $('#qty' + count).change(totalQty);

    // selectSupplier.setAttribute("onchange", "getProducts(this)");
    // selectProduct.setAttribute("onchange", "getPrice(this)");
    // inputUnitPrice.setAttribute("onchange", "enabledQty(this)");
    // inputQty.setAttribute("onchange", "totalQty(this)");
    btnDelete.setAttribute("onclick", "deleteProduct(this)");

    var category = $('#categories_id').val();
    var type = $('#type').val();
    if (category != "") {
        var action = 'getSuppliers';
        var array = [];

        $.ajax({
                type: "POST",
                url: "nueva_solicitud",
                data: { 'action': action, 'category': category, 'type': type, "_token": $("meta[name='csrf-token']").attr("content") }
            })
            .done(function(response) {
                var supplier = $('#' + suppliersId);
                supplier.prop('disabled', false);
                supplier.find('option').remove();
                supplier.append('<option value="">selecciona...</option>')
                if (response.length == 0 && type == 'especie')
                    supplier.append('<option value="0">sin Proveedor...</option>')
                $(response).each(function(i, v) { // indice, valor
                    supplier.append('<option value="' + v.id + '">' + v.companyname + '</option>');
                });
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {})
    }
}

function deleteProduct(deletebtn) {
    var deletebtnId = deletebtn.id;
    var deleteArray = deletebtnId.split('-')
    var registerId = deleteArray[1];
    var count = $('#countTotalP').val();
    count--;
    $('#countTotalP').val(count);

    var products = $('#fieldsProducts').val();
    var productsArray = products.split(',');
    var countProducts = productsArray.length;
    let pos = productsArray.indexOf(registerId);
    let deletedElement = productsArray.splice(pos, 1);
    $('#fieldsProducts').val(productsArray);

    var formGroupDelete = $('#fDP-' + registerId);
    formGroupDelete.remove();
}

function addFurniture() {
    var count = $('#countFurniture').val();
    count++;
    $('#countFurniture').val(count);

    var total = $('#countTotalF').val();
    total++;
    $('#countTotalF').val(total);

    var furnituresDiv = $('#furnitures');
    var btnDeleteID = "deleteFurniture-" + count;
    var firstDivID = "fDF-" + count;

    var furnitureHeaderId = "furnitureHeader" + count;
    var furnitureId = "furnitures_id" + count;

    var firstDiv = document.createElement("div");
    firstDiv.setAttribute("id", firstDivID);

    var hr = document.createElement("hr");

    var furnitureHeader = document.createElement("div");
    furnitureHeader.setAttribute("id", furnitureHeaderId);
    furnitureHeader.setAttribute("class", "headerAppend");
    furnitureHeader.textContent = "Muebles " + count;

    var btnDelete = document.createElement("button");
    btnDelete.setAttribute("type", "button");
    btnDelete.setAttribute("id", btnDeleteID);
    btnDelete.setAttribute("class", "btn float-right");

    var spanTimes = document.createElement("i");
    spanTimes.setAttribute("class", "fas fa-trash-alt fa-2x colorIcon");

    var firstFormRow = document.createElement("div");
    firstFormRow.setAttribute("class", "form-row");

    var furnitureFormGroup = document.createElement('div');
    furnitureFormGroup.setAttribute("class", "form-group col-md-12");

    var labelfurniture = document.createElement('label');
    labelfurniture.setAttribute("for", furnitureId);
    labelfurniture.textContent = "Muebles";

    var selectFurniture = document.createElement('select');
    selectFurniture.setAttribute("class", "form-control");
    selectFurniture.setAttribute("required", "required");
    selectFurniture.setAttribute("id", furnitureId);
    selectFurniture.setAttribute("name", furnitureId);

    var optionFurniture = document.createElement('option');
    optionFurniture.setAttribute("value", "");
    optionFurniture.textContent = "Selecciona...";

    furnituresDiv.append(firstDiv);
    firstDiv.append(hr);
    firstDiv.append(furnitureHeader);
    furnitureHeader.append(btnDelete);
    btnDelete.append(spanTimes);

    firstFormRow.append(furnitureFormGroup);
    furnitureFormGroup.append(labelfurniture);
    furnitureFormGroup.append(selectFurniture);
    selectFurniture.append(optionFurniture);

    firstDiv.append(firstFormRow);

    var action = "getFurnitures";
    $.ajax({
            type: "POST",
            url: "nueva_solicitud",
            data: { 'action': action, "_token": $("meta[name='csrf-token']").attr("content") }
        })
        .done(function(response) {
            var furnitures = $('#furnitures_id' + count);

            $(response).each(function(i, v) { // indice, valor
                furnitures.append('<option value="' + v.id + '">' + v.name + '</option>');
            });

        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {})

    btnDelete.setAttribute("onclick", "deleteFurniture(this)");
}

function deleteFurniture(deletebtn) {
    var deletebtnId = deletebtn.id;
    var deleteArray = deletebtnId.split('-')
    var registerId = deleteArray[1];
    var count = $('#countTotalF').val();
    count--;
    $('#countTotalF').val(count);
    var formGroupDelete = $('#fDF-' + registerId);
    formGroupDelete.remove();
}

function addBuildingMaterial() {
    var count = $('#countBuildingMaterial').val();
    count++;
    $('#countBuildingMaterial').val(count);

    var total = $('#countTotalBM').val();
    total++;
    $('#countTotalBM').val(total);

    var buildingMaterialDiv = $('#buildingMaterials');
    var btnDeleteID = "deleteBuildingMaterial-" + count;
    var firstDivID = "fDBM-" + count;

    var buildingMaterialHeaderId = "buildingMaterialHeader" + count;
    var buildingMaterialsId = "buildingMaterials_id" + count;

    var firstDiv = document.createElement("div");
    firstDiv.setAttribute("id", firstDivID);

    var hr = document.createElement("hr");

    var buildingMaterialHeader = document.createElement("div");
    buildingMaterialHeader.setAttribute("id", buildingMaterialHeaderId);
    buildingMaterialHeader.setAttribute("class", "headerAppend");
    buildingMaterialHeader.textContent = "Material de Construcción " + count;

    var btnDelete = document.createElement("button");
    btnDelete.setAttribute("type", "button");
    btnDelete.setAttribute("id", btnDeleteID);
    btnDelete.setAttribute("class", "btn float-right");

    var spanTimes = document.createElement("i");
    spanTimes.setAttribute("class", "fas fa-trash-alt fa-2x colorIcon");

    var firstFormRow = document.createElement("div");
    firstFormRow.setAttribute("class", "form-row");

    var buildingMaterialFormGroup = document.createElement('div');
    buildingMaterialFormGroup.setAttribute("class", "form-group col-md-12");

    var labelBuildingMaterial = document.createElement('label');
    labelBuildingMaterial.setAttribute("for", buildingMaterialsId);
    labelBuildingMaterial.textContent = "Material de Construcción";

    var selectBuildingMaterial = document.createElement('select');
    selectBuildingMaterial.setAttribute("class", "form-control");
    selectBuildingMaterial.setAttribute("required", "required");
    selectBuildingMaterial.setAttribute("id", buildingMaterialsId);
    selectBuildingMaterial.setAttribute("name", buildingMaterialsId);

    var optionBuildingMaterial = document.createElement('option');
    optionBuildingMaterial.setAttribute("value", "");
    optionBuildingMaterial.textContent = "Selecciona...";

    buildingMaterialDiv.append(firstDiv);
    firstDiv.append(hr);
    firstDiv.append(buildingMaterialHeader);
    buildingMaterialHeader.append(btnDelete);
    btnDelete.append(spanTimes);

    firstFormRow.append(buildingMaterialFormGroup);
    buildingMaterialFormGroup.append(labelBuildingMaterial);
    buildingMaterialFormGroup.append(selectBuildingMaterial);
    selectBuildingMaterial.append(optionBuildingMaterial);

    firstDiv.append(firstFormRow);

    var action = "getBuildingMaterials";
    $.ajax({
            type: "POST",
            url: "nueva_solicitud",
            data: { 'action': action, "_token": $("meta[name='csrf-token']").attr("content") }
        })
        .done(function(response) {
            var buildingMaterial = $('#buildingMaterials_id' + count);

            $(response).each(function(i, v) { // indice, valor
                buildingMaterial.append('<option value="' + v.id + '">' + v.name + '</option>');
            });

        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {})

    btnDelete.setAttribute("onclick", "deleteBuildingMaterial(this)");
}

function deleteBuildingMaterial(deletebtn) {
    var deletebtnId = deletebtn.id;
    var deleteArray = deletebtnId.split('-')
    var registerId = deleteArray[1];
    var count = $('#countTotalBM').val();
    count--;
    $('#countTotalBM').val(count);
    var formGroupDelete = $('#fDBM-' + registerId);
    formGroupDelete.remove();
}

function addMH() {
    var count = $('#countMH').val();
    count++;
    $('#countMH').val(count);

    var total = $('#countTotalMH').val();
    total++;
    $('#countTotalMH').val(total);

    var MHDiv = $('#MHs');
    var btnDeleteID = "deleteMH-" + count;
    var firstDivID = "fDMH-" + count;

    var mHHeaderId = "mHHeader" + count;
    var nameId = "name" + count;
    var lastNameId = "lastName" + count;
    var secondLastNameId = "secondLastName" + count;
    var ageId = "age" + count;
    var relationshipId = "relationship" + count;
    var civilStatusId = "civilStatus" + count;
    var scholarShipId = "scholarShip" + count;
    var employmentsId = "employments_id" + count;

    var MHId = "mH" + count;

    var firstDiv = document.createElement("div");
    firstDiv.setAttribute("id", firstDivID);

    var hr = document.createElement("hr");

    var mHHeader = document.createElement("div");
    mHHeader.setAttribute("id", mHHeaderId);
    mHHeader.setAttribute("class", "headerAppend");
    // serviceHeader.textContent = "Servicio " + count;

    var btnDelete = document.createElement("button");
    btnDelete.setAttribute("type", "button");
    btnDelete.setAttribute("id", btnDeleteID);
    btnDelete.setAttribute("class", "btn float-right");

    var spanTimes = document.createElement("i");
    spanTimes.setAttribute("class", "fas fa-trash-alt fa-2x colorIcon");

    var firstFormRow = document.createElement("div");
    firstFormRow.setAttribute("class", "form-row");

    var secondFormRow = document.createElement("div");
    secondFormRow.setAttribute("class", "form-row");

    var thirdFormRow = document.createElement("div");
    thirdFormRow.setAttribute("class", "form-row");

    var nameFormGroup = document.createElement('div');
    nameFormGroup.setAttribute("class", "form-group col-md-4");

    var labelName = document.createElement('label');
    labelName.setAttribute("for", nameId);
    labelName.textContent = "Nombre";

    var inputName = document.createElement('input');
    inputName.setAttribute("type", "text");
    inputName.setAttribute("class", "form-control");
    inputName.setAttribute("id", nameId);
    inputName.setAttribute("name", nameId);
    inputName.setAttribute("placeholder", "Ingresar el nombre");

    var invalidName = document.createElement('div');
    invalidName.setAttribute("class", "invalid-feedback");
    invalidName.textContent = "Favor de ingresar el nombre";

    var lastNameFormGroup = document.createElement('div');
    lastNameFormGroup.setAttribute("class", "form-group col-md-4");

    var labellastName = document.createElement('label');
    labellastName.setAttribute("for", lastNameId);
    labellastName.textContent = "Apellido Paterno";

    var inputlastName = document.createElement('input');
    inputlastName.setAttribute("type", "text");
    inputlastName.setAttribute("class", "form-control");
    inputlastName.setAttribute("id", lastNameId);
    inputlastName.setAttribute("name", lastNameId);
    inputlastName.setAttribute("placeholder", "Ingresar el apellido paterno");

    var invalidlastName = document.createElement('div');
    invalidlastName.setAttribute("class", "invalid-feedback");
    invalidlastName.textContent = "Favor de ingresar el apellido paterno";

    var secondlastNameFormGroup = document.createElement('div');
    secondlastNameFormGroup.setAttribute("class", "form-group col-md-4");

    var labelsecondlastName = document.createElement('label');
    labelsecondlastName.setAttribute("for", secondLastNameId);
    labelsecondlastName.textContent = "Apellido Materno";

    var inputsecondlastName = document.createElement('input');
    inputsecondlastName.setAttribute("type", "text");
    inputsecondlastName.setAttribute("class", "form-control");
    inputsecondlastName.setAttribute("id", secondLastNameId);
    inputsecondlastName.setAttribute("name", secondLastNameId);
    inputsecondlastName.setAttribute("placeholder", "Ingresar el apellido materno");

    var invalidsecondlastName = document.createElement('div');
    invalidsecondlastName.setAttribute("class", "invalid-feedback");
    invalidsecondlastName.textContent = "Favor de ingresar el apellido materno";

    var ageFormGroup = document.createElement('div');
    ageFormGroup.setAttribute("class", "form-group col-md-4");

    var labelAge = document.createElement('label');
    labelAge.setAttribute("for", ageId);
    labelAge.textContent = "Edad";

    var inputAge = document.createElement('input');
    inputAge.setAttribute("type", "text");
    inputAge.setAttribute("class", "form-control");
    inputAge.setAttribute("id", ageId);
    inputAge.setAttribute("name", ageId);
    inputAge.setAttribute("placeholder", "Ingresar la edad");

    var invalidAge = document.createElement('div');
    invalidAge.setAttribute("class", "invalid-feedback");
    invalidAge.textContent = "Favor de ingresar la edad";

    var relationShipFormGroup = document.createElement('div');
    relationShipFormGroup.setAttribute("class", "form-group col-md-4");

    var labelrelationship = document.createElement('label');
    labelrelationship.setAttribute("for", relationshipId);
    labelrelationship.textContent = "Parentesco";

    var selectrelationShip = document.createElement('select');
    selectrelationShip.setAttribute("class", "form-control");
    selectrelationShip.setAttribute("id", relationshipId);
    selectrelationShip.setAttribute("name", relationshipId);

    var optionrelationShip = document.createElement('option');
    optionrelationShip.setAttribute("value", "");
    optionrelationShip.textContent = "Selecciona...";

    var optionFather = document.createElement('option');
    optionFather.setAttribute("value", "padre");
    optionFather.textContent = "Padre";

    var optionMother = document.createElement('option');
    optionMother.setAttribute("value", "madre");
    optionMother.textContent = "Madre";

    var optionBrother = document.createElement('option');
    optionBrother.setAttribute("value", "hermano(a)");
    optionBrother.textContent = "Hermano(a)";

    var optionAunt = document.createElement('option');
    optionAunt.setAttribute("value", "tio(a)");
    optionAunt.textContent = "Tio(a)";

    var optionUncle = document.createElement('option');
    optionUncle.setAttribute("value", "primo(a)");
    optionUncle.textContent = "Primo(a)";

    var optionSon = document.createElement('option');
    optionSon.setAttribute("value", "hijo(a)");
    optionSon.textContent = "Hijo(a)";

    var optionGranPA = document.createElement('option');
    optionGranPA.setAttribute("value", "Abuelo(a)");
    optionGranPA.textContent = "Abuelo(a)";

    var optionOther = document.createElement('option');
    optionOther.setAttribute("value", "otros");
    optionOther.textContent = "otro";

    var civilStatusFormGroup = document.createElement('div');
    civilStatusFormGroup.setAttribute("class", "form-group col-md-4");

    var labelcivilStatus = document.createElement('label');
    labelcivilStatus.setAttribute("for", civilStatusId);
    labelcivilStatus.textContent = "Edo. Civil";

    var selectcivilStatus = document.createElement('select');
    selectcivilStatus.setAttribute("class", "form-control");
    selectcivilStatus.setAttribute("id", civilStatusId);
    selectcivilStatus.setAttribute("name", civilStatusId);

    var optioncivilStatus = document.createElement('option');
    optioncivilStatus.setAttribute("value", "");
    optioncivilStatus.textContent = "Selecciona...";

    var optionsoltero = document.createElement('option');
    optionsoltero.setAttribute("value", "soltero(a)");
    optionsoltero.textContent = "Soltero(a)";

    var optioncasado = document.createElement('option');
    optioncasado.setAttribute("value", "casado(a)");
    optioncasado.textContent = "Casado(a)";

    var optiondivorciado = document.createElement('option');
    optiondivorciado.setAttribute("value", "divorciado(a)");
    optiondivorciado.textContent = "Divorciado(a)";

    var optionviudo = document.createElement('option');
    optionviudo.setAttribute("value", "viudo(a)");
    optionviudo.textContent = "Viudo(a)";

    var optionunionlibre = document.createElement('option');
    optionunionlibre.setAttribute("value", "unionLibre");
    optionunionlibre.textContent = "Unión libre";

    var schoolarFormGroup = document.createElement('div');
    schoolarFormGroup.setAttribute("class", "form-group col-md-6");

    var labelschoolar = document.createElement('label');
    labelschoolar.setAttribute("for", scholarShipId);
    labelschoolar.textContent = "Escolaridad";

    var selectschoolar = document.createElement('select');
    selectschoolar.setAttribute("class", "form-control");
    selectschoolar.setAttribute("id", scholarShipId);
    selectschoolar.setAttribute("name", scholarShipId);

    var optionschoolar = document.createElement('option');
    optionschoolar.setAttribute("value", "");
    optionschoolar.textContent = "Selecciona...";

    var optionsinEstudios = document.createElement('option');
    optionsinEstudios.setAttribute("value", "sinEstudios");
    optionsinEstudios.textContent = "Sin estudios";

    var optionprimaria = document.createElement('option');
    optionprimaria.setAttribute("value", "primaria");
    optionprimaria.textContent = "Primaria";

    var optionsecundaria = document.createElement('option');
    optionsecundaria.setAttribute("value", "secundaria");
    optionsecundaria.textContent = "Secundaria";

    var optionbt = document.createElement('option');
    optionbt.setAttribute("value", "bachillerato/tecnico");
    optionbt.textContent = "Bachillerato / Tecnico";

    var optionlp = document.createElement('option');
    optionlp.setAttribute("value", "licenciatura/profesional");
    optionlp.textContent = "Licenciatura / Profesional";

    var optionposgrado = document.createElement('option');
    optionposgrado.setAttribute("value", "posgrado");
    optionposgrado.textContent = "Posgrado";

    var employmentFormGroup = document.createElement('div');
    employmentFormGroup.setAttribute("class", "form-group col-md-6");

    var labelemployment = document.createElement('label');
    labelemployment.setAttribute("for", employmentsId);
    labelemployment.textContent = "Ocupación";

    var selectemployment = document.createElement('select');
    selectemployment.setAttribute("class", "form-control");
    selectemployment.setAttribute("id", employmentsId);
    selectemployment.setAttribute("name", employmentsId);

    var optionemployment = document.createElement('option');
    optionemployment.setAttribute("value", "");
    optionemployment.textContent = "Selecciona...";

    MHDiv.append(firstDiv);
    firstDiv.append(hr);
    firstDiv.append(mHHeader);
    mHHeader.append(btnDelete);
    btnDelete.append(spanTimes);

    firstFormRow.append(nameFormGroup);
    nameFormGroup.append(labelName);
    nameFormGroup.append(inputName);
    nameFormGroup.append(invalidName);

    firstFormRow.append(lastNameFormGroup);
    lastNameFormGroup.append(labellastName);
    lastNameFormGroup.append(inputlastName);
    lastNameFormGroup.append(invalidlastName);

    firstFormRow.append(secondlastNameFormGroup);
    secondlastNameFormGroup.append(labelsecondlastName);
    secondlastNameFormGroup.append(inputsecondlastName);
    secondlastNameFormGroup.append(invalidsecondlastName);

    secondFormRow.append(ageFormGroup);
    ageFormGroup.append(labelAge);
    ageFormGroup.append(inputAge);
    ageFormGroup.append(invalidAge);

    secondFormRow.append(relationShipFormGroup);
    relationShipFormGroup.append(labelrelationship);
    relationShipFormGroup.append(selectrelationShip);
    selectrelationShip.append(optionrelationShip);
    selectrelationShip.append(optionFather);
    selectrelationShip.append(optionMother);
    selectrelationShip.append(optionBrother);
    selectrelationShip.append(optionAunt);
    selectrelationShip.append(optionUncle);
    selectrelationShip.append(optionSon);
    selectrelationShip.append(optionGranPA);
    selectrelationShip.append(optionOther);

    secondFormRow.append(civilStatusFormGroup);
    civilStatusFormGroup.append(labelcivilStatus);
    civilStatusFormGroup.append(selectcivilStatus);
    selectcivilStatus.append(optioncivilStatus);
    selectcivilStatus.append(optionsoltero);
    selectcivilStatus.append(optioncasado);
    selectcivilStatus.append(optiondivorciado);
    selectcivilStatus.append(optionviudo);
    selectcivilStatus.append(optionunionlibre);

    thirdFormRow.append(schoolarFormGroup);
    schoolarFormGroup.append(labelschoolar);
    schoolarFormGroup.append(selectschoolar);
    selectschoolar.append(optionschoolar);
    selectschoolar.append(optionsinEstudios);
    selectschoolar.append(optionprimaria);
    selectschoolar.append(optionsecundaria);
    selectschoolar.append(optionbt);
    selectschoolar.append(optionlp);
    selectschoolar.append(optionposgrado);

    thirdFormRow.append(employmentFormGroup);
    employmentFormGroup.append(labelemployment);
    employmentFormGroup.append(selectemployment);
    selectemployment.append(optionemployment);

    var action = "getEmployments";
    $.ajax({
            type: "POST",
            url: "nueva_solicitud",
            data: { 'action': action, "_token": $("meta[name='csrf-token']").attr("content") }
        })
        .done(function(response) {
            var employments = $('#employments_id' + count);
            $(response).each(function(i, v) { // indice, valor
                employments.append('<option value="' + v.id + '">' + v.name + '</option>');
            });
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {})

    firstDiv.append(firstFormRow);
    firstDiv.append(secondFormRow);
    firstDiv.append(thirdFormRow);


    var input_age = $('#age' + count);
    input_age.mask('000');
    btnDelete.setAttribute("onclick", "deleteMH(this)");


}

function deleteMH(deletebtn) {
    var deletebtnId = deletebtn.id;
    var deleteArray = deletebtnId.split('-')
    var registerId = deleteArray[1];
    var count = $('#countTotalMH').val();
    count--;
    $('#countTotalMH').val(count);
    var formGroupDelete = $('#fDMH-' + registerId);
    formGroupDelete.remove();
}

function addBeneficiary() {

    var countDisabilities = $('#countTotalDB1').val();
    countDisabilities++;
    $('#countTotalDB1').val(countDisabilities);

    var count = $('#countBeneficiary').val();
    count++;
    $('#countBeneficiary').val(count);

    var total = $('#countTotalB').val();
    total++;
    $('#countTotalB').val(total);

    var requestsDiv = $('#requests');
    var btnDeleteID = "deleteB-" + count;
    var firstDivID = "fDB-" + count;

    var requestHeaderId = "requestHeader" + count;
    var curpId = "curpbeneficiary" + count;
    var ageId = "agebeneficiary" + count;
    var NumberId = "phonenumber" + count;
    var familiarId = "statusBeneficiary" + count;
    var nameId = "namebeneficiary" + count;
    var filterbtnId = "check-" + count;
    var lastNameId = "lastNamebeneficiary" + count;
    var secondLastNameId = "secondLastNamebeneficiary" + count;
    var civilStatusId = "civilStatusbeneficiary" + count;
    var scholarShipId = "scholarShipbeneficiary" + count;
    var employmentsId = "employments_idbeneficiary" + count;
    var disc = "disability" + count + "_1";
    var discat = "disabilitycategories" + count + "_1";
    var divDiagnosticBeneficiaryId = "requestDiagnostic" + count;
    var btnagregardisc = "addDiagnosticBeneficiary" + count;

    var DivDiagnosticRequest = "requestDiagnostic" + count;
    var countDisabilitiesID = "countDiagnosticBeneficiary" + count;


    var MHId = "mH" + count;

    var firstDiv = document.createElement("div");
    firstDiv.setAttribute("id", firstDivID);

    var hr = document.createElement("hr");

    var requestHeader = document.createElement("div");
    requestHeader.setAttribute("id", requestHeaderId);
    requestHeader.setAttribute("class", "headerAppend");
    requestHeader.textContent = "Beneficiario " + count;

    var btnDelete = document.createElement("button");
    btnDelete.setAttribute("type", "button");
    btnDelete.setAttribute("id", btnDeleteID);
    btnDelete.setAttribute("class", "btn float-right");

    var spanTimes = document.createElement("i");
    spanTimes.setAttribute("class", "fas fa-trash-alt fa-2x colorIcon");

    var firstFormRow = document.createElement("div");
    firstFormRow.setAttribute("class", "form-row");

    var secondFormRow = document.createElement("div");
    secondFormRow.setAttribute("class", "form-row");

    var thirdFormRow = document.createElement("div");
    thirdFormRow.setAttribute("class", "form-row");

    var curpFormGroup = document.createElement('div');
    curpFormGroup.setAttribute("class", "form-group col-md-7");

    var labelCurp = document.createElement('label');
    labelCurp.setAttribute("for", curpId);
    labelCurp.textContent = "CURP";

    var inputGroupCurp = document.createElement('div');
    inputGroupCurp.setAttribute("class", "input-group");

    var inputCurp = document.createElement('input');
    inputCurp.setAttribute("type", "text");
    inputCurp.setAttribute("class", "form-control");
    inputCurp.setAttribute("id", curpId);
    inputCurp.setAttribute("name", curpId);
    inputCurp.setAttribute("placeholder", "Ingresar la CURP");
    inputCurp.setAttribute("required", "required");

    var inputGroupAppendCurp = document.createElement('div');
    inputGroupAppendCurp.setAttribute("class", "input-group-append");

    var btnCurp = document.createElement('button');
    btnCurp.setAttribute("class", "btn btn-outline-secondary");
    btnCurp.setAttribute("type", "button");
    btnCurp.setAttribute("id", filterbtnId);
    btnCurp.textContent = "Verificar";

    var invalidCurp = document.createElement('div');
    invalidCurp.setAttribute("class", "invalid-feedback");
    invalidCurp.textContent = "Favor de ingresar el código postal";

    var ageFormGroup = document.createElement('div');
    ageFormGroup.setAttribute("class", "form-group col-md-2");

    var labelAge = document.createElement('label');
    labelAge.setAttribute("for", ageId);
    labelAge.textContent = "Edad";

    var inputAge = document.createElement('input');
    inputAge.setAttribute("type", "text");
    inputAge.setAttribute("class", "form-control");
    inputAge.setAttribute("id", ageId);
    inputAge.setAttribute("data-mask", "000");
    inputAge.setAttribute("name", ageId);


    inputAge.setAttribute("required", "required");
    inputAge.setAttribute("placeholder", "Ingresar la edad");

    var invalidAge = document.createElement('div');
    invalidAge.setAttribute("class", "invalid-feedback");
    invalidAge.textContent = "Favor de ingresar la edad";

    var phoneNumberFormGroup = document.createElement('div');
    phoneNumberFormGroup.setAttribute("class", "form-group col-md-3");

    var labelPhoneNumber = document.createElement('label');
    labelPhoneNumber.setAttribute("for", NumberId);
    labelPhoneNumber.textContent = "Número Telefónico";

    var inputPhoneNumber = document.createElement('input');
    inputPhoneNumber.setAttribute("type", "text");
    inputPhoneNumber.setAttribute("class", "form-control");
    inputPhoneNumber.setAttribute("id", NumberId);
    inputPhoneNumber.setAttribute("name", NumberId);
    inputPhoneNumber.setAttribute("placeholder", "Ingresar el número telefónico");
    inputPhoneNumber.setAttribute("required", "required");

    var invalidPhoneNumber = document.createElement('div');
    invalidPhoneNumber.setAttribute("class", "invalid-feedback");
    invalidPhoneNumber.textContent = "Favor de ingresar el número telefónico del beneficiario";

    var statusFormGroup = document.createElement('div');
    statusFormGroup.setAttribute("class", "form-group col-md-2");

    var labelStatus = document.createElement('label');
    labelStatus.setAttribute("for", familiarId);
    labelStatus.textContent = "¿Es Familiar?";

    var divSwitch = document.createElement('div');
    divSwitch.setAttribute("class", "custom-control custom-switch");

    var inputStatus = document.createElement('input');
    inputStatus.setAttribute("type", "checkbox");
    inputStatus.setAttribute("class", "custom-control-input");
    inputStatus.setAttribute("id", familiarId);
    inputStatus.setAttribute("name", familiarId);
    inputStatus.setAttribute("placeholder", "Ingresar el número telefónico");

    var labelCustom = document.createElement('label');
    labelCustom.setAttribute("class", "custom-control-label");
    labelCustom.setAttribute("for", familiarId);
    labelCustom.textContent = "No/Si";
    //-------------------------------------------------------------
    var nameFormGroup = document.createElement('div');
    nameFormGroup.setAttribute("class", "form-group col-md-4");

    var labelName = document.createElement('label');
    labelName.setAttribute("for", nameId);
    labelName.textContent = "Nombre";

    var inputName = document.createElement('input');
    inputName.setAttribute("type", "text");
    inputName.setAttribute("class", "form-control");
    inputName.setAttribute("id", nameId);
    inputName.setAttribute("name", nameId);
    inputName.setAttribute("placeholder", "Ingresar el nombre");
    inputName.setAttribute("required", "required");

    var invalidName = document.createElement('div');
    invalidName.setAttribute("class", "invalid-feedback");
    invalidName.textContent = "Favor de ingresar el nombre";

    var lastNameFormGroup = document.createElement('div');
    lastNameFormGroup.setAttribute("class", "form-group col-md-4");

    var labellastName = document.createElement('label');
    labellastName.setAttribute("for", lastNameId);
    labellastName.textContent = "Apellido Paterno";

    var inputlastName = document.createElement('input');
    inputlastName.setAttribute("type", "text");
    inputlastName.setAttribute("class", "form-control");
    inputlastName.setAttribute("id", lastNameId);
    inputlastName.setAttribute("name", lastNameId);
    inputlastName.setAttribute("placeholder", "Ingresar el apellido paterno");
    inputlastName.setAttribute("required", "required");

    var invalidlastName = document.createElement('div');
    invalidlastName.setAttribute("class", "invalid-feedback");
    invalidlastName.textContent = "Favor de ingresar el apellido paterno";

    var secondlastNameFormGroup = document.createElement('div');
    secondlastNameFormGroup.setAttribute("class", "form-group col-md-4");

    var labelsecondlastName = document.createElement('label');
    labelsecondlastName.setAttribute("for", secondLastNameId);
    labelsecondlastName.textContent = "Apellido Materno";

    var inputsecondlastName = document.createElement('input');
    inputsecondlastName.setAttribute("type", "text");
    inputsecondlastName.setAttribute("class", "form-control");
    inputsecondlastName.setAttribute("id", secondLastNameId);
    inputsecondlastName.setAttribute("name", secondLastNameId);
    inputsecondlastName.setAttribute("placeholder", "Ingresar el apellido materno");
    inputsecondlastName.setAttribute("required", "required");

    var invalidsecondlastName = document.createElement('div');
    invalidsecondlastName.setAttribute("class", "invalid-feedback");
    invalidsecondlastName.textContent = "Favor de ingresar el apellido materno";

    //----------------------------------------------------------------------------------------


    var civilStatusFormGroup = document.createElement('div');
    civilStatusFormGroup.setAttribute("class", "form-group col-md-4");

    var labelcivilStatus = document.createElement('label');
    labelcivilStatus.setAttribute("for", civilStatusId);
    labelcivilStatus.textContent = "Edo. Civil";

    var selectcivilStatus = document.createElement('select');
    selectcivilStatus.setAttribute("class", "form-control");
    selectcivilStatus.setAttribute("id", civilStatusId);
    selectcivilStatus.setAttribute("name", civilStatusId);
    selectcivilStatus.setAttribute("required", "required");

    var optioncivilStatus = document.createElement('option');
    optioncivilStatus.setAttribute("value", "");
    optioncivilStatus.textContent = "Selecciona...";

    var optionsoltero = document.createElement('option');
    optionsoltero.setAttribute("value", "soltero(a)");
    optionsoltero.textContent = "Soltero(a)";

    var optioncasado = document.createElement('option');
    optioncasado.setAttribute("value", "casado(a)");
    optioncasado.textContent = "Casado(a)";

    var optiondivorciado = document.createElement('option');
    optiondivorciado.setAttribute("value", "divorciado(a)");
    optiondivorciado.textContent = "Divorciado(a)";

    var optionviudo = document.createElement('option');
    optionviudo.setAttribute("value", "viudo(a)");
    optionviudo.textContent = "Viudo(a)";

    var optionunionlibre = document.createElement('option');
    optionunionlibre.setAttribute("value", "unionLibre");
    optionunionlibre.textContent = "Unión libre";

    var schoolarFormGroup = document.createElement('div');
    schoolarFormGroup.setAttribute("class", "form-group col-md-4");

    var labelschoolar = document.createElement('label');
    labelschoolar.setAttribute("for", scholarShipId);
    labelschoolar.textContent = "Escolaridad";

    var selectschoolar = document.createElement('select');
    selectschoolar.setAttribute("class", "form-control");
    selectschoolar.setAttribute("id", scholarShipId);
    selectschoolar.setAttribute("name", scholarShipId);
    selectschoolar.setAttribute("required", "required");

    var optionschoolar = document.createElement('option');
    optionschoolar.setAttribute("value", "");
    optionschoolar.textContent = "Selecciona...";

    var optionsinEstudios = document.createElement('option');
    optionsinEstudios.setAttribute("value", "sinEstudios");
    optionsinEstudios.textContent = "Sin estudios";

    var optionprimaria = document.createElement('option');
    optionprimaria.setAttribute("value", "primaria");
    optionprimaria.textContent = "Primaria";

    var optionsecundaria = document.createElement('option');
    optionsecundaria.setAttribute("value", "secundaria");
    optionsecundaria.textContent = "Secundaria";

    var optionbt = document.createElement('option');
    optionbt.setAttribute("value", "bachillerato/tecnico");
    optionbt.textContent = "Bachillerato / Tecnico";

    var optionlp = document.createElement('option');
    optionlp.setAttribute("value", "licenciatura/profesional");
    optionlp.textContent = "Licenciatura / Profesional";

    var optionposgrado = document.createElement('option');
    optionposgrado.setAttribute("value", "posgrado");
    optionposgrado.textContent = "Posgrado";

    var employmentFormGroup = document.createElement('div');
    employmentFormGroup.setAttribute("class", "form-group col-md-4");

    var labelemployment = document.createElement('label');
    labelemployment.setAttribute("for", employmentsId);
    labelemployment.textContent = "Ocupación";

    var selectemployment = document.createElement('select');
    selectemployment.setAttribute("class", "form-control");
    selectemployment.setAttribute("id", employmentsId);
    selectemployment.setAttribute("name", employmentsId);
    selectemployment.setAttribute("required", "required");

    var optionemployment = document.createElement('option');
    optionemployment.setAttribute("value", "");
    optionemployment.textContent = "Selecciona...";

    var disvspan = document.createElement("div");
    var spandisc1 = document.createElement("SPAN");
    spandisc1.setAttribute("class", "m-0 font-weight-bold text-primary headerAppend");
    spandisc1.innerHTML = 'Diagnostico de Beneficiario';
    var divDiscCat = document.createElement("div");
    divDiscCat.setAttribute("class", "form-row");

    var divDiscCat1 = document.createElement('div');
    divDiscCat1.setAttribute("class", "form-group col-md-5");

    var btnAddDisc = document.createElement("button");
    btnAddDisc.setAttribute("type", "button");
    btnAddDisc.setAttribute("id", btnagregardisc);
    btnAddDisc.setAttribute("class", "btn btn-primary float-right");
    btnAddDisc.textContent = "Agregar";
    var labelDiscCat = document.createElement('label');
    labelDiscCat.setAttribute("for", discat);
    labelDiscCat.textContent = "Categoria del Diagnostico";
    var selectDiscCat = document.createElement('select');
    selectDiscCat.setAttribute("class", "form-control");
    selectDiscCat.setAttribute("id", discat);
    selectDiscCat.setAttribute("name", discat);
    selectDiscCat.setAttribute("required", "required");
    var optiondiscat = document.createElement('option');
    optiondiscat.setAttribute("value", "");
    optiondiscat.textContent = "Selecciona...";

    var divdisc1 = document.createElement('div');
    divdisc1.setAttribute("class", "form-group col-md-6");
    var labeldisc = document.createElement('label');
    labeldisc.setAttribute("for", disc);
    labeldisc.textContent = "Diagnostico";

    var selectDisc = document.createElement('select');
    selectDisc.setAttribute("class", "form-control");
    selectDisc.setAttribute("id", disc);
    selectDisc.setAttribute("name", disc);
    selectDisc.setAttribute("disabled", "disabled");
    selectDisc.setAttribute("required", "required");

    var optiondisc = document.createElement('option');
    optiondisc.setAttribute("value", "");
    optiondisc.textContent = "Selecciona...";

    var spandisc = document.createElement("SPAN");


    var disabilityRequest = document.createElement("div");
    disabilityRequest.setAttribute("id", DivDiagnosticRequest);

    var inputdisabilities = document.createElement('input');
    inputdisabilities.setAttribute("type", "hidden");
    inputdisabilities.setAttribute("id", countDisabilitiesID);
    inputdisabilities.setAttribute("name", countDisabilitiesID);
    inputdisabilities.setAttribute("value", 1);

    requestsDiv.append(firstDiv);
    firstDiv.append(hr);
    firstDiv.append(requestHeader);
    requestHeader.append(btnDelete);
    btnDelete.append(spanTimes);


    firstFormRow.append(curpFormGroup);
    curpFormGroup.append(labelCurp);
    curpFormGroup.append(inputGroupCurp);
    inputGroupCurp.append(inputCurp);
    inputGroupCurp.append(inputGroupAppendCurp);
    inputGroupAppendCurp.append(btnCurp);
    inputGroupCurp.append(invalidCurp);

    firstFormRow.append(ageFormGroup);
    ageFormGroup.append(labelAge);
    ageFormGroup.append(inputAge);
    ageFormGroup.append(invalidAge);

    firstFormRow.append(phoneNumberFormGroup);
    phoneNumberFormGroup.append(labelPhoneNumber);
    phoneNumberFormGroup.append(inputPhoneNumber);
    phoneNumberFormGroup.append(invalidPhoneNumber);

    secondFormRow.append(nameFormGroup);
    nameFormGroup.append(labelName);
    nameFormGroup.append(inputName);
    nameFormGroup.append(invalidName);

    secondFormRow.append(lastNameFormGroup);
    lastNameFormGroup.append(labellastName);
    lastNameFormGroup.append(inputlastName);
    lastNameFormGroup.append(invalidlastName);

    secondFormRow.append(secondlastNameFormGroup);
    secondlastNameFormGroup.append(labelsecondlastName);
    secondlastNameFormGroup.append(inputsecondlastName);
    secondlastNameFormGroup.append(invalidsecondlastName);

    thirdFormRow.append(civilStatusFormGroup);
    civilStatusFormGroup.append(labelcivilStatus);
    civilStatusFormGroup.append(selectcivilStatus);
    selectcivilStatus.append(optioncivilStatus);
    selectcivilStatus.append(optionsoltero);
    selectcivilStatus.append(optioncasado);
    selectcivilStatus.append(optiondivorciado);
    selectcivilStatus.append(optionviudo);
    selectcivilStatus.append(optionunionlibre);

    thirdFormRow.append(schoolarFormGroup);
    schoolarFormGroup.append(labelschoolar);
    schoolarFormGroup.append(selectschoolar);
    selectschoolar.append(optionschoolar);
    selectschoolar.append(optionsinEstudios);
    selectschoolar.append(optionprimaria);
    selectschoolar.append(optionsecundaria);
    selectschoolar.append(optionbt);
    selectschoolar.append(optionlp);
    selectschoolar.append(optionposgrado);

    thirdFormRow.append(employmentFormGroup);
    employmentFormGroup.append(labelemployment);
    employmentFormGroup.append(selectemployment);
    selectemployment.append(optionemployment);

    disvspan.append(spandisc1);
    spandisc1.append(btnAddDisc);

    divDiscCat.append(divDiscCat1);
    divDiscCat1.append(labelDiscCat);
    divDiscCat1.append(selectDiscCat);
    selectDiscCat.append(optiondiscat);

    divDiscCat.append(divdisc1);
    divdisc1.append(labeldisc);
    divdisc1.append(selectDisc);
    selectDisc.append(optiondisc);
    divDiscCat.append(spandisc);


    firstDiv.append(firstFormRow);
    firstDiv.append(secondFormRow);
    firstDiv.append(thirdFormRow);
    firstDiv.append(disvspan);
    firstDiv.append(divDiscCat);
    firstDiv.append(disabilityRequest);
    firstDiv.append(inputdisabilities);


    var action = "getInformation";
    $.ajax({
            type: "POST",
            url: "nueva_solicitud",
            data: { 'action': action, "_token": $("meta[name='csrf-token']").attr("content") }
        })
        .done(function(response) {
            var employments = $('#employments_idbeneficiary' + count);
            $(response.employments).each(function(i, v) { // indice, valor
                employments.append('<option value="' + v.id + '">' + v.name + '</option>');
            });

            var categoryDisabilities = $('#disabilitycategories' + count + '_1');
            $(response.categoryDisabilities).each(function(x, y) { // indice, valor
                categoryDisabilities.append('<option value="' + y.id + '">' + y.name + '</option>');
            });
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {})

    var input_age = $('#age' + count);
    input_age.mask('000');

    var input_curp = $('#curpbeneficiary' + count);
    input_curp.mask('SSSS000000SSSSSSAA');

    var MaskInputAge = $('#agebeneficiary' + count);
    MaskInputAge.mask('000');


    var input_phone = $('#phonenumber' + count);
    input_phone.mask('000-000-0000');

    var categoryDisabilities = $('#disabilitycategories' + count + '_1');
    categoryDisabilities.change(getDisabilities);

    btnDelete.setAttribute("onclick", "deleteBeneficiary(this)");
    btnCurp.setAttribute("onclick", "verifyCurp(this)");

    var btnAddDiagnostic = $('#' + btnagregardisc);
    btnAddDiagnostic.click(addDisabilities);
}

///samy
function addDisabilities(btnaddDisabilities) {
    if (btnaddDisabilities.value != null) {
        // var categoryDisabilities = selectcategoryDisabilities.value;
        var registerId = btnaddDisabilities.id.substr(24, 1);
    } else {
        // var categoryDisabilities = $(this).val();
        // var registerId = this.id.substr(20, 3);
        var registerId = this.id.charAt(this.id.length - 1);

    }
    // var countBenefTotal = $('#countBeneficiary').val();
    // console.log(countBenefTotal);
    // var countBenef = $('#countTotalB').val();

    // var count = $('#countDiagnosticBeneficiary1').val();
    // count++;
    // $('#countDiagnosticBeneficiary1').val(count);
    // var total = $('#countTotalDB1').val();
    // total++;
    // $('#countTotalDB1').val(total);

    var countDisc = $('#countDiagnosticBeneficiary' + registerId).val();
    countDisc++;
    $('#countDiagnosticBeneficiary' + registerId).val(countDisc);

    var countDiscTotal = $('#countTotalDB' + registerId).val();
    countDiscTotal++;
    $('#countTotalDB' + registerId).val(countDiscTotal);



    var discBenef = "disability" + registerId + "_" + countDisc;
    var discatBenef = "disabilitycategories" + registerId + "_" + countDisc;


    var requestsDiv = $('#requestDiagnostic' + registerId);
    var btnDeleteIDdisc = "deleteDB" + registerId + "_" + countDisc;

    var firstDivIDdisc = "fDDB" + registerId + "-" + countDisc;

    var requestHeaderId = "requestHeader" + countDisc;

    var firstDiv = document.createElement("div");
    firstDiv.setAttribute("id", firstDivIDdisc);

    var hr = document.createElement("hr");

    var requestHeader = document.createElement("div");
    requestHeader.setAttribute("id", requestHeaderId);
    requestHeader.setAttribute("class", "headerAppend");
    requestHeader.textContent = "Categoria de Diagnostico " + countDisc;

    var btnDelete = document.createElement("button");
    btnDelete.setAttribute("type", "button");
    btnDelete.setAttribute("id", btnDeleteIDdisc);
    btnDelete.setAttribute("class", "btn float-right");

    var spanTimes = document.createElement("i");
    spanTimes.setAttribute("class", "fas fa-trash-alt fa-2x colorIcon");

    var firstFormRow = document.createElement("div");
    firstFormRow.setAttribute("class", "form-row");


    var curpFormGroup = document.createElement('div');
    curpFormGroup.setAttribute("class", "form-group col-md-6");

    var labelCurp = document.createElement('label');
    labelCurp.setAttribute("for", discatBenef);
    labelCurp.textContent = "Categoria del Diagnostico";


    var selectDiscCat = document.createElement('select');
    selectDiscCat.setAttribute("class", "form-control");
    selectDiscCat.setAttribute("id", discatBenef);
    selectDiscCat.setAttribute("name", discatBenef);
    selectDiscCat.setAttribute("required", "required");

    var optiondiscat = document.createElement('option');
    optiondiscat.setAttribute("value", "");
    optiondiscat.textContent = "Selecciona...";

    var DisabilityDiv = document.createElement('div');
    DisabilityDiv.setAttribute("class", "form-group col-md-6");

    var labeldisability = document.createElement('label');
    labeldisability.setAttribute("for", discBenef);
    labeldisability.textContent = "Diagnostico";


    var selectdisability = document.createElement('select');
    selectdisability.setAttribute("class", "form-control");
    selectdisability.setAttribute("id", discBenef);
    selectdisability.setAttribute("name", discBenef);
    selectdisability.setAttribute("disabled", "disabled");
    selectdisability.setAttribute("required", "required");

    var optionDisability = document.createElement('option');
    optionDisability.setAttribute("value", "");
    optionDisability.textContent = "Selecciona...";


    requestsDiv.append(firstDiv);
    firstDiv.append(hr);
    firstDiv.append(requestHeader);
    requestHeader.append(btnDelete);
    btnDelete.append(spanTimes);
    firstDiv.append(firstFormRow);
    firstFormRow.append(curpFormGroup);
    curpFormGroup.append(labelCurp);
    curpFormGroup.append(selectDiscCat);
    selectDiscCat.append(optiondiscat);

    firstFormRow.append(DisabilityDiv);
    DisabilityDiv.append(labeldisability);
    DisabilityDiv.append(selectdisability);
    selectdisability.append(optionDisability);

    var action = "getInformation";
    $.ajax({
            type: "POST",
            url: "nueva_solicitud",
            data: { 'action': action, "_token": $("meta[name='csrf-token']").attr("content") }
        })
        .done(function(response) {
            var categoryDisabilities = $('#disabilitycategories' + registerId + '_' + countDisc);
            $(response.categoryDisabilities).each(function(x, y) { // indice, valor
                categoryDisabilities.append('<option value="' + y.id + '">' + y.name + '</option>');
            });
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {})
    btnDelete.setAttribute("onclick", "deleteBeneficiaryDiag(this)");

    var categoryDisabilities = $('#disabilitycategories' + registerId + '_' + countDisc);
    categoryDisabilities.change(getDisabilities);
}

function deleteBeneficiaryDiag(deletebtn) {
    var deletebtnId = deletebtn.id.substr(8, 3);
    var deleteArray = deletebtnId.split('_')
    var registerId = deleteArray[1];
    var beneficiaryId = deleteArray[0];

    var count = $('#countTotalDB1').val();
    count--;
    $('#countTotalDB1').val(count);
    var formGroupDelete = $('#fDDB' + beneficiaryId + '_' + registerId);
    formGroupDelete.remove();

}

function deleteBeneficiary(deletebtn) {
    var deletebtnId = deletebtn.id;
    var deleteArray = deletebtnId.split('-')
    var registerId = deleteArray[1];
    var count = $('#countTotalB').val();
    count--;
    $('#countTotalB').val(count);
    var countDisabilities = $('#countTotalDB1').val();
    countDisabilities--;
    $('#countTotalDB1').val(countDisabilities);

    var formGroupDelete = $('#fDB-' + registerId);
    formGroupDelete.remove();

}

function addService() {
    var count = $('#countService').val();
    count++;
    $('#countService').val(count);

    var total = $('#countTotalS').val();
    total++;
    $('#countTotalS').val(total);

    var serviceDiv = $('#services');
    var btnDeleteID = "deleteServices-" + count;
    var firstDivID = "fDS-" + count;

    var serviceHeaderId = "serviceHeader" + count;
    var servicesId = "services_id" + count;

    var firstDiv = document.createElement("div");
    firstDiv.setAttribute("id", firstDivID);

    var hr = document.createElement("hr");

    var serviceHeader = document.createElement("div");
    serviceHeader.setAttribute("id", serviceHeaderId);
    serviceHeader.setAttribute("class", "headerAppend");
    serviceHeader.textContent = "Servicio " + count;

    var btnDelete = document.createElement("button");
    btnDelete.setAttribute("type", "button");
    btnDelete.setAttribute("id", btnDeleteID);
    btnDelete.setAttribute("class", "btn float-right");

    var spanTimes = document.createElement("i");
    spanTimes.setAttribute("class", "fas fa-trash-alt fa-2x colorIcon");

    var firstFormRow = document.createElement("div");
    firstFormRow.setAttribute("class", "form-row");

    var serviceFormGroup = document.createElement('div');
    serviceFormGroup.setAttribute("class", "form-group col-md-12");

    var labelService = document.createElement('label');
    labelService.setAttribute("for", servicesId);
    labelService.textContent = "Servicio";

    var selectService = document.createElement('select');
    selectService.setAttribute("class", "form-control");
    selectService.setAttribute("required", "required");
    selectService.setAttribute("id", servicesId);
    selectService.setAttribute("name", servicesId);

    var optionService = document.createElement('option');
    optionService.setAttribute("value", "");
    optionService.textContent = "Selecciona...";

    serviceDiv.append(firstDiv);
    firstDiv.append(hr);
    firstDiv.append(serviceHeader);
    serviceHeader.append(btnDelete);
    btnDelete.append(spanTimes);

    firstFormRow.append(serviceFormGroup);
    serviceFormGroup.append(labelService);
    serviceFormGroup.append(selectService);
    selectService.append(optionService);

    firstDiv.append(firstFormRow);

    var action = "getServices";
    $.ajax({
            type: "POST",
            url: "nueva_solicitud",
            data: { 'action': action, "_token": $("meta[name='csrf-token']").attr("content") }
        })
        .done(function(response) {
            var services = $('#services_id' + count);

            $(response).each(function(i, v) { // indice, valor
                services.append('<option value="' + v.id + '">' + v.name + '</option>');
            });

        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {})

    btnDelete.setAttribute("onclick", "deleteService(this)");
}

function deleteService(deletebtn) {
    var deletebtnId = deletebtn.id;
    var deleteArray = deletebtnId.split('-')
    var registerId = deleteArray[1];
    var count = $('#countTotalS').val();
    count--;
    $('#countTotalS').val(count);
    var formGroupDelete = $('#fDS-' + registerId);
    formGroupDelete.remove();
}

function getSupport(btn) {
    var type = $(this).val();
    if (type != "") {
        petitionerFormStair(0, 0);
        var supports = $('#supports_id');
        supports.prop('disabled', false);
    } else {
        petitionerFormStair(0, 0);
    }
}

function getCategories(btn) {
    var support = $(this).val();
    var action = 'getCategories';
    if (support != "") {
        $.ajax({
                type: "POST",
                url: "nueva_solicitud",
                data: { 'action': action, 'support': support, "_token": $("meta[name='csrf-token']").attr("content") }
            })
            .done(function(response) {
                petitionerFormStair(1, 0);
                var category = $('#categories_id');
                category.prop('disabled', false);
                category.find('option').remove();
                category.append('<option value="">selecciona...</option>');
                if (response.length != 0) {
                    $(response).each(function(i, v) { // indice, valor
                        category.append('<option value="' + v.id + '">' + v.name + '</option>');
                    });
                } else {
                    category.prop('disabled', true);
                }
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {})
    } else {
        petitionerFormStair(1, 0);
    }
}

function getSuppliers(category) {
    var category = $(this).val();
    var type = $('#type').val();
    if (category != "") {
        var action = 'getSuppliers';
        var array = [];

        $.ajax({
                type: "POST",
                url: "nueva_solicitud",
                data: { 'action': action, 'category': category, 'type': type, "_token": $("meta[name='csrf-token']").attr("content") }
            })
            .done(function(response) {
                petitionerFormStair(2, 0);
                var products = $('#fieldsProducts').val();
                var productsArray = products.split(',');
                var countProducts = productsArray.length;
                for (var i = 0; i < countProducts; i++) {
                    var supplier = $('#suppliers_id' + productsArray[i]);
                    supplier.prop('disabled', false);
                    supplier.find('option').remove();
                    supplier.append('<option value="">selecciona...</option>')
                    if (response.length == 0 && type == 'ts')
                        supplier.append('<option value="0">sin Proveedor</option>')
                    $(response).each(function(i, v) { // indice, valor
                        supplier.append('<option value="' + v.id + '">' + v.companyname + '</option>');
                    });
                }
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {})
    } else {
        petitionerFormStair(2, 0);
    }
}

function getProducts(supplier) {
    var supplier = $(this).val();
    var id = this.id.charAt(this.id.length - 1);
    var category = $('#categories_id').val();
    if (supplier != "") {
        var action = 'getProducts';
        var array = [];

        $.ajax({
                type: "POST",
                url: "nueva_solicitud",
                data: { 'action': action, 'supplier': supplier, 'category': category, "_token": $("meta[name='csrf-token']").attr("content") }
            })
            .done(function(response) {
                petitionerFormStair(3, id);
                var supplier = $('#products_id' + id);
                supplier.prop('disabled', false);
                supplier.find('option').remove();
                supplier.append('<option value="">selecciona...</option>')
                $(response).each(function(i, v) { // indice, valor
                    supplier.append('<option value="' + v.id + '">' + v.name + '</option>');
                });
                console.log(response);
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {})
    } else {
        petitionerFormStair(3, id);
    }
}


function getDisabilities(selectcategoryDisabilities) {
    if (selectcategoryDisabilities.value != null) {
        var categoryDisabilities = selectcategoryDisabilities.value;
        var id = selectcategoryDisabilities.id.substr(20, 3);
    } else {
        var categoryDisabilities = $(this).val();
        var id = this.id.substr(20, 3);
    }
    if (categoryDisabilities != "") {
        var action = 'getDisabilities';
        var array = [];
        $.ajax({
                type: "POST",
                url: "nueva_solicitud",
                data: { 'action': action, 'categoryDisability': categoryDisabilities, 'id': id, "_token": $("meta[name='csrf-token']").attr("content") }
            })
            .done(function(response) {
                console.log(response);
                var disability = $('#disability' + id);
                disability.prop('disabled', false);
                disability.find('option').remove();
                disability.append('<option value="">selecciona...</option>')
                if (response.length != 0) {
                    $(response).each(function(i, v) { // indice, valor
                        disability.append('<option value="' + v.id + '">' + v.name + '</option>');
                    });
                }
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {})
    } else {
        var disability = $('#disability' + id);
        disability.prop('disabled', true);
        disability.find('option').remove();
        disability.append('<option value="">selecciona...</option>');
    }
}

function getPrice(product) {
    var product = $(this).val();
    var id = this.id.charAt(this.id.length - 1);
    var supplier = $('#suppliers_id' + id).val();
    if (product != "") {
        var action = 'getPrice';
        var array = [];

        $.ajax({
                type: "POST",
                url: "nueva_solicitud",
                data: { 'action': action, 'supplier': supplier, 'product': product, "_token": $("meta[name='csrf-token']").attr("content") }
            })
            .done(function(response) {
                petitionerFormStair(4, id);
                if (response.length > 0) {
                    $('#unitPrice' + id).val(response);
                    $('#qty' + id).prop('disabled', false);
                } else {
                    $('#unitPrice' + id).prop('disabled', false);
                }
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {})
    } else {
        petitionerFormStair(4, id);
    }
}

function enabledQty(price) {
    var unitPrice = $(this).val();
    if (unitPrice != "") {
        var id = this.id.charAt(this.id.length - 1);
        $('#qty' + id).prop('disabled', false);
        if ($('#qty' + id).val() != "" && $('#qty' + id) != "0") {
            var qty = $('#qty' + id).val();
            var total = qty * unitPrice;
            $('#totalPrice' + id).val(total);
        }
    }
}


function totalQty(qty) {
    var qty = $(this).val();
    var id = this.id.charAt(this.id.length - 1);
    if (qty != "") {
        petitionerFormStair(6, id);
        var unitPrice = $('#unitPrice' + id).val();
        var total = qty * unitPrice;
        $('#totalPrice' + id).val(total);
    } else {
        petitionerFormStair(6, id);
    }
}

function petitionerFormStair(step, id) {
    switch (step) {
        case 0:
            var support = $('#supports_id');
            support.prop('disabled', true);
            support.val("");
            var category = $('#categories_id');
            category.prop('disabled', true);
            category.find('option').remove();
            category.append('<option value="">selecciona...</option>')

            var products = $('#fieldsProducts').val();
            var productsArray = products.split(',');
            var countProducts = productsArray.length;

            for (var i = 0; i < countProducts; i++) {
                var selectSupplier = $('#suppliers_id' + productsArray[i]);
                selectSupplier.prop('disabled', true);
                selectSupplier.find('option').remove();
                selectSupplier.append('<option value="">selecciona...</option>');

                var selectProduct = $('#products_id' + productsArray[i]);
                selectProduct.prop('disabled', true);
                selectProduct.find('option').remove();
                selectProduct.append('<option value="">selecciona...</option>');

                var unitPriceInput = $('#unitPrice' + productsArray[i]);
                unitPriceInput.prop('disabled', true);
                unitPriceInput.val("0");

                var qtyInput = $('#qty' + productsArray[i]);
                qtyInput.prop('disabled', true);
                qtyInput.val("0");

                var totalPriceInput = $('#totalPrice' + productsArray[i]);
                totalPriceInput.prop('disabled', true);
                totalPriceInput.val("0");

            }
            break;
        case 1:
            var category = $('#categories_id');
            category.prop('disabled', true);
            category.find('option').remove();
            category.append('<option value="">selecciona...</option>')

            var products = $('#fieldsProducts').val();
            var productsArray = products.split(',');
            var countProducts = productsArray.length;

            for (var i = 0; i < countProducts; i++) {
                var selectSupplier = $('#suppliers_id' + productsArray[i]);
                selectSupplier.prop('disabled', true);
                selectSupplier.find('option').remove();
                selectSupplier.append('<option value="">selecciona...</option>');

                var selectProduct = $('#products_id' + productsArray[i]);
                selectProduct.prop('disabled', true);
                selectProduct.find('option').remove();
                selectProduct.append('<option value="">selecciona...</option>');

                var unitPriceInput = $('#unitPrice' + productsArray[i]);
                unitPriceInput.prop('disabled', true);
                unitPriceInput.val("0");

                var qtyInput = $('#qty' + productsArray[i]);
                qtyInput.prop('disabled', true);
                qtyInput.val("0");

                var totalPriceInput = $('#totalPrice' + productsArray[i]);
                totalPriceInput.prop('disabled', true);
                totalPriceInput.val("0");

            }
            break;
        case 2:
            var products = $('#fieldsProducts').val();
            var productsArray = products.split(',');
            var countProducts = productsArray.length;

            for (var i = 0; i < countProducts; i++) {
                var selectSupplier = $('#suppliers_id' + productsArray[i]);
                selectSupplier.prop('disabled', true);
                selectSupplier.find('option').remove();
                selectSupplier.append('<option value="">selecciona...</option>');

                var selectProduct = $('#products_id' + productsArray[i]);
                selectProduct.prop('disabled', true);
                selectProduct.find('option').remove();
                selectProduct.append('<option value="">selecciona...</option>');

                var unitPriceInput = $('#unitPrice' + productsArray[i]);
                unitPriceInput.prop('disabled', true);
                unitPriceInput.val("0");

                var qtyInput = $('#qty' + productsArray[i]);
                qtyInput.prop('disabled', true);
                qtyInput.val("0");

                var totalPriceInput = $('#totalPrice' + productsArray[i]);
                totalPriceInput.prop('disabled', true);
                totalPriceInput.val("0");

            }
            break;
        case 3:
            var selectProduct = $('#products_id' + id);
            selectProduct.prop('disabled', true);
            selectProduct.find('option').remove();
            selectProduct.append('<option value="">selecciona...</option>');

            var unitPriceInput = $('#unitPrice' + id);
            unitPriceInput.prop('disabled', true);
            unitPriceInput.val("0");

            var qtyInput = $('#qty' + id);
            qtyInput.prop('disabled', true);
            qtyInput.val("0");

            var totalPriceInput = $('#totalPrice' + id);
            totalPriceInput.prop('disabled', true);
            totalPriceInput.val("0");
            break;
        case 4:
            var unitPriceInput = $('#unitPrice' + id);
            unitPriceInput.prop('disabled', true);
            unitPriceInput.val("0");

            var qtyInput = $('#qty' + id);
            qtyInput.prop('disabled', true);
            qtyInput.val("0");

            var totalPriceInput = $('#totalPrice' + id);
            totalPriceInput.prop('disabled', true);
            totalPriceInput.val("0");
            break;
        case 5:
            var qtyInput = $('#qty' + id);
            qtyInput.prop('disabled', true);
            qtyInput.val("0");

            var totalPriceInput = $('#totalPrice' + id);
            totalPriceInput.prop('disabled', true);
            totalPriceInput.val("0");
            break;
        case 6:
            var totalPriceInput = $('#totalPrice' + id);
            totalPriceInput.prop('disabled', true);
            totalPriceInput.val("0");
            break;
        default:
            break;
    }
}

function filterCP(filterbtn) {
    var filterId = filterbtn.id;
    var filterArray = filterId.split('-');
    var count = filterArray[1];
    var postalCode = $('#postalCode' + count).val();

    if (postalCode != '') {
        var action = 'getData';
        var data = {
            'action': action,
            'postalCode': postalCode,
            "_token": $("meta[name='csrf-token']").attr("content")
        }
        $.ajax({
                type: "POST",
                url: "nueva_solicitud",
                data: data
            })
            .done(function(response) {
                var communities = $('#communities_id' + count);
                var municipalities = $('#municipalities_id' + count);
                var states = $('#states_id' + count);

                communities.find('option').remove();
                municipalities.find('option').remove();
                states.find('option').remove();

                communities.prop('disabled', false);

                $(response.communities).each(function(i, v) { // indice, valor
                    communities.append('<option value="' + v.id + '">' + v.name + '</option>');
                });
                $(response.municipalities).each(function(i, v) { // indice, valor
                    municipalities.append('<option value="' + v.id + '">' + v.name + '</option>');
                });
                $(response.states).each(function(i, v) { // indice, valor
                    states.append('<option value="' + v.id + '">' + v.name + '</option>');
                });
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {})
    }
}

function verifyCurp(btn) {
    var btnId = btn.id;
    var btnArray = btnId.split('-')
    var registerId = btnArray[1];
    var curpbeneficiary = $('#curpbeneficiary' + registerId).val();

    var action = 'checkCurp';

    $.ajax({
            type: "POST",
            url: "nueva_solicitud",
            data: { 'action': action, 'curpbeneficiary': curpbeneficiary, "_token": $("meta[name='csrf-token']").attr("content") }
        })
        .done(function(response) {
            console.log(response);
            var name = $('#namebeneficiary' + registerId);
            var lastName = $('#lastNamebeneficiary' + registerId);
            var secondLastName = $('#secondLastNamebeneficiary' + registerId);
            var age = $('#agebeneficiary' + registerId);

            if (response['personalData'] != null) {
                name.val(response['personalData']['name']);
                lastName.val(response['personalData']['lastName']);
                secondLastName.val(response['personalData']['secondLastName']);
                age.val(response['personalData']['age']);
                if (response['message'] != null && response['message']['exist'] == 1) {
                    var fecha = response['date']['date'];
                    alertify.error(response['message']['text']);
                    $('#alert-container').text('el usuario:  ' + response['personalData']['name'] + '  ya le brindaron un apoyo de: ' + response['Apoyo'] + ' solicitado el dia: ' + fecha.substr(-30, 10) + ' al solicitante con la CURP: ' + response['CualSolicitante'] + ' de la institución: ' + response['institute'] + ' departamento: ' + response['Departament']);
                    $('#modal-warning').modal('toggle');
                } else {
                    alertify.success(response['message']['text']);
                }
            } else if (response['requisition'] != null) {
                name.val(response['requisition']['petitioner']);
                if (response['message'] != null && response['message']['exist'] == 1) {
                    var fecha = response['date']['date'];
                    alertify.error(response['message']['text']);
                    $('#alert-container').text('el usuario:  ' + response['requisition'] + '  ya le brindaron un apoyo de: ' + response['Apoyo'] + ' solicitado el dia: ' + fecha.substr(-30, 10) + ' al Benefificario con la CURP: ' + response['CualBeneficiario']['curp'] + ' de la institución: ' + response['institute'] + ' departamento: ' + response['Departament']);
                    $('#modal-warning').modal('toggle');
                } else {
                    alertify.success(response['message']['text']);
                }
            } else
                alertify.success(response['message']['text']);
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {})
}

function verifyCurpPetitioner(btn) {
    var curpbeneficiary = $('#curpPetitioner1').val();
    var action = 'checkCurp';
    $.ajax({
            type: "POST",
            url: "nueva_solicitud",
            data: { 'action': action, 'curpbeneficiary': curpbeneficiary, "_token": $("meta[name='csrf-token']").attr("content") }
        })
        .done(function(response) {
            // var petitionerName = $('#petitioner');
            // console.log(response[0]);
            // if (response[0]['requisition1'] != null || response[0]['requisition0'] != null) {
            //     petitionerName.val(response['requisition']);
            //     if (response[0]['message'] != null && response[0]['message']['exist'] == 1) {
            //         var divModal = $('#alert-container');
            //         console.log(response[0]);
            //         if (response[0].cantidad == 1) {
            //             $('#alert-container').find('P').remove();
            //             $('#alert-container').find('HR').remove();
            //             for (let x = 1; x <= response[0].cantidad; x++) {
            //                 var Usuario = document.createElement("P"); // Create a <p> element
            //                 Usuario.innerText = 'El usuario: ' + response[0]['requisition' + x];
            //                 var Apoyo = document.createElement("P"); // Create a <p> element
            //                 Apoyo.innerText = 'Le brindaron el apoyo de: ' + response[0]['Apoyo' + x];
            //                 var fecha = document.createElement("P"); // Create a <p> element
            //                 fecha.innerText = 'Solicitado el dia: ' + response[0]['date' + x]['date'].substr(-30, 10);
            //                 var Curp = document.createElement("P"); // Create a <p> element
            //                 Curp.innerText = 'Al beneficiario con la CURP: ' + response[0]['CualBeneficiario' + x]['curp'];
            //                 var institucion = document.createElement("P"); // Create a <p> element
            //                 institucion.innerText = 'De la institución: ' + response[0]['institute' + x]['name'];
            //                 var Department = document.createElement("P"); // Create a <p> element
            //                 Department.innerText = 'Del departamento: ' + response[0]['departament' + x]['name'];
            //                 var linea = document.createElement("HR");

            //                 divModal.append(Usuario);
            //                 divModal.append(Apoyo);
            //                 divModal.append(fecha);
            //                 divModal.append(Curp);
            //                 divModal.append(institucion);
            //                 divModal.append(Department);
            //                 divModal.append(linea);

            //             }
            //             alertify.error(response[0]['message']['text']);
            //             $('#modal-warning').modal('toggle');

            //         } else {
            //             if (response[0].cantidad > 1) {
            //                 $('#alert-container').find('P').remove();
            //                 $('#alert-container').find('HR').remove();
            //                 for (let y = 0; y < response[0].cantidad; y++) {
            //                     var Usuario = document.createElement("P"); // Create a <p> element
            //                     Usuario.innerText = 'El usuario: ' + response[0]['requisition' + y];
            //                     var Apoyo = document.createElement("P"); // Create a <p> element
            //                     Apoyo.innerText = 'Le brindaron el apoyo de: ' + response[0]['Apoyo' + y];
            //                     var fecha = document.createElement("P"); // Create a <p> element
            //                     fecha.innerText = 'Solicitado el dia: ' + response[0]['date' + y]['date'].substr(-30, 10);
            //                     var Curp = document.createElement("P"); // Create a <p> element
            //                     Curp.innerText = 'Al beneficiario con la CURP: ' + response[0]['CualBeneficiario' + y]['curp'];
            //                     var institucion = document.createElement("P"); // Create a <p> element
            //                     institucion.innerText = 'De la institución: ' + response[0]['institute' + y]['name'];
            //                     var Department = document.createElement("P"); // Create a <p> element
            //                     Department.innerText = 'Del departamento: ' + response[0]['departament' + y]['name'];
            //                     var linea = document.createElement("HR");
            //                     divModal.append(Usuario);
            //                     divModal.append(Apoyo);
            //                     divModal.append(fecha);
            //                     divModal.append(Curp);
            //                     divModal.append(institucion);
            //                     divModal.append(Department);
            //                     divModal.append(linea);
            //                 }
            //                 alertify.error(response[0]['message']['text']);
            //                 $('#modal-warning').modal('toggle');
            //             }
            //         }
            //     } else {
            //         alertify.success(response[0]['message']['text']);
            //     }
            // } else if (response[0]['personalData'] != null) {
            //     if (response[0]['message'] != null && response[0]['message']['exist'] == 1) {
            //         var divModal = $('#alert-container');
            //         if (response[0].cantidad == 1) {
            //             $('#alert-container').find('P').remove();
            //             $('#alert-container').find('HR').remove();
            //             for (let x = 0; x < response[0].cantidad; x++) {
            //                 var Usuario = document.createElement("P"); // Create a <p> element
            //                 Usuario.innerText = 'El usuario: ' + response[0]['personalData']['name'];
            //                 var Apoyo = document.createElement("P"); // Create a <p> element
            //                 Apoyo.innerText = 'Le brindaron el apoyo de: ' + response[0]['Apoyo' + x];
            //                 var fecha = document.createElement("P"); // Create a <p> element
            //                 fecha.innerText = 'Solicitado el dia: ' + response[0]['date' + x]['date'].substr(-30, 10);
            //                 var Curp = document.createElement("P"); // Create a <p> element
            //                 Curp.innerText = 'Al solicitante con la CURP: ' + response[0]['CualSolicitante' + x];
            //                 var institucion = document.createElement("P"); // Create a <p> element
            //                 institucion.innerText = 'De la institución: ' + response[0]['institute' + x];
            //                 var Department = document.createElement("P"); // Create a <p> element
            //                 Department.innerText = 'Del departamento: ' + response[0]['Departament' + x];
            //                 var linea = document.createElement("HR");

            //                 divModal.append(Usuario);
            //                 divModal.append(Apoyo);
            //                 divModal.append(fecha);
            //                 divModal.append(Curp);
            //                 divModal.append(institucion);
            //                 divModal.append(Department);
            //                 divModal.append(linea);

            //             }
            //             alertify.error(response[0]['message']['text']);
            //             $('#modal-warning').modal('toggle');

            //         }
            //         console.log(response[0]);

            //     }



            // } else
            //     alertify.success(response[0]['message']['text']);
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {})
}


function nextNavTab(btn) {
    var btnId = btn.id;
    var btnArray = btnId.split('-')
    var registerId = btnArray[1];
    var navActual = btnArray[0];
    switch (navActual) {
        case "requestGeneralData":

            if (registerId == 1)
                $('#myTab a[href="#beneficiaryGeneralData"]').tab('show');
            break;

        case "beneficiaryGeneralData":
            if (registerId == 1)
                $('#myTab a[href="#familySituation"]').tab('show');
            else
                $('#myTab a[href="#requestGeneralData"]').tab('show');
            break;

        case "familySituation":
            if (registerId == 1)
                $('#myTab a[href="#lifeConditions"]').tab('show');
            else
                $('#myTab a[href="#beneficiaryGeneralData"]').tab('show');
            break;

        case "lifeConditions":
            if (registerId == 1)
                $('#myTab a[href="#economicData"]').tab('show');
            else
                $('#myTab a[href="#familySituation"]').tab('show');
            break;

        case "economicData":
            if (registerId == 1)
                $('#myTab a[href="#lifeConditions"]').tab('show');
            break;

        default:
            break;
    }

}


function saveAfter() {
    var form = $('#formRequest');
    form.prop('disabled', false);
    $(form.find('input')).each(function(i, v) {
        v.removeAttribute("required");
    });
    $(form.find('select')).each(function(i, v) {
        v.removeAttribute("required");
    });
    var action = $('#action');
    action.val('saveWOR');
    document.getElementById("formRequest").submit();
}
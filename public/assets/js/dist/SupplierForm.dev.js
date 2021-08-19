"use strict";

$(function () {
  'use strict';

  $('#typeRFC').change(rfcMask);
  $('#addAddress').click(addAddress);
  $('#addPhoneNumber').click(addPhoneNumber);
});

function addPhoneNumber() {
  var count = $('#countPhoneNumber').val();
  var total = $('#countTotalPN').val();
  count++;
  total++;
  $('#countPhoneNumber').val(count);
  $('#countTotalPN').val(total);
  var phoneNumbersDiv = $('#phoneNumbers');
  var phoneNumberId = "phoneNumber" + count;
  var firstDivID = "fD-" + count;
  var btnDeleteID = "deletePhoneNumber-" + count;
  var NumberId = "phonenumber" + count;
  var extId = "ext" + count;
  var descriptionId = "description" + count;
  var hr = document.createElement("hr");
  var firstDiv = document.createElement("div");
  firstDiv.setAttribute("id", firstDivID);
  var phoneNumberHeader = document.createElement("div");
  phoneNumberHeader.setAttribute("id", phoneNumberId);
  phoneNumberHeader.setAttribute("class", "headerAppend");
  phoneNumberHeader.textContent = "Número Teléfonico " + count;
  var btnDelete = document.createElement("button");
  btnDelete.setAttribute("type", "button");
  btnDelete.setAttribute("id", btnDeleteID);
  btnDelete.setAttribute("class", "btn float-right");
  var spanTimes = document.createElement("i");
  spanTimes.setAttribute("class", "fas fa-trash-alt fa-2x colorIcon");
  var firstFormRow = document.createElement("div");
  firstFormRow.setAttribute("class", "form-row");
  var phoneNumberFormGroup = document.createElement('div');
  phoneNumberFormGroup.setAttribute("class", "form-group col-md-4");
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
  invalidPhoneNumber.textContent = "Favor de ingresar el número telefónico del proveedor";
  var extFormGroup = document.createElement('div');
  extFormGroup.setAttribute("class", "form-group col-md-2");
  var labelExt = document.createElement('label');
  labelExt.setAttribute("for", extId);
  labelExt.textContent = "Extensión (opcional)";
  var inputExt = document.createElement('input');
  inputExt.setAttribute("type", "text");
  inputExt.setAttribute("class", "form-control");
  inputExt.setAttribute("id", extId);
  inputExt.setAttribute("name", extId);
  inputExt.setAttribute("placeholder", "Ingresar la número extensión (opcional)");
  var descriptionFormGroup = document.createElement('div');
  descriptionFormGroup.setAttribute("class", "form-group col-md-6");
  var labelDescription = document.createElement('label');
  labelDescription.setAttribute("for", descriptionId);
  labelDescription.textContent = "Descripción";
  var inputdescription = document.createElement('input');
  inputdescription.setAttribute("type", "text");
  inputdescription.setAttribute("class", "form-control");
  inputdescription.setAttribute("id", descriptionId);
  inputdescription.setAttribute("name", descriptionId);
  inputdescription.setAttribute("placeholder", "Ingresar el departamento de la línea");
  inputdescription.setAttribute("required", "required");
  var invalidDescription = document.createElement('div');
  invalidDescription.setAttribute("class", "invalid-feedback");
  invalidDescription.textContent = "Favor de ingresar el departamento de la línea";
  phoneNumbersDiv.append(firstDiv);
  firstDiv.append(hr);
  firstDiv.append(phoneNumberHeader);
  phoneNumberHeader.append(btnDelete);
  btnDelete.append(spanTimes);
  firstFormRow.append(phoneNumberFormGroup);
  phoneNumberFormGroup.append(labelPhoneNumber);
  phoneNumberFormGroup.append(inputPhoneNumber);
  phoneNumberFormGroup.append(invalidPhoneNumber);
  firstFormRow.append(extFormGroup);
  extFormGroup.append(labelExt);
  extFormGroup.append(inputExt);
  firstFormRow.append(descriptionFormGroup);
  descriptionFormGroup.append(labelDescription);
  descriptionFormGroup.append(inputdescription);
  descriptionFormGroup.append(invalidDescription);
  firstDiv.append(firstFormRow);
  var input_phonenumber = $('#phonenumber' + count);
  input_phonenumber.mask('000-000-0000');
  var input_ext = $('#ext' + count);
  input_ext.mask('Ext. 0000');
  btnDelete.setAttribute("onclick", "deletePhoneNumber(this)");
}

function addAddress() {
  var count = $('#countAddress').val();
  count++;
  $('#countAddress').val(count);
  var total = $('#countTotalA').val();
  total++;
  $('#countTotalA').val(total);
  var addressesDiv = $('#addresses');
  var btnDeleteID = "deleteAddress-" + count;
  var firstDivID = "fDA-" + count;
  var addressId = "address" + count;
  var streetId = "street" + count;
  var externalId = "externalNumber" + count;
  var internalId = "internalNumber" + count;
  var postalCodeId = "postalCode" + count;
  var communitiesId = "communities_id" + count;
  var municipalitiesId = "municipalities_id" + count;
  var filterbtnId = "filter-" + count;
  var statesId = "states_id" + count;
  var firstDiv = document.createElement("div");
  firstDiv.setAttribute("id", firstDivID);
  var hr = document.createElement("hr");
  var addressHeader = document.createElement("div");
  addressHeader.setAttribute("id", addressId);
  addressHeader.setAttribute("class", "headerAppend");
  addressHeader.textContent = "Dirección " + count;
  var btnDelete = document.createElement("button");
  btnDelete.setAttribute("type", "button");
  btnDelete.setAttribute("id", btnDeleteID);
  btnDelete.setAttribute("class", "btn float-right");
  var spanTimes = document.createElement("i");
  spanTimes.setAttribute("class", "fas fa-trash-alt fa-2x colorIcon");
  var firstFormRow = document.createElement("div");
  firstFormRow.setAttribute("class", "form-row");
  var streetFormGroup = document.createElement('div');
  streetFormGroup.setAttribute("class", "form-group col-md-3");
  var labelStreet = document.createElement('label');
  labelStreet.setAttribute("for", streetId);
  labelStreet.textContent = "Calle";
  var inputStreet = document.createElement('input');
  inputStreet.setAttribute("type", "text");
  inputStreet.setAttribute("class", "form-control");
  inputStreet.setAttribute("id", streetId);
  inputStreet.setAttribute("name", streetId);
  inputStreet.setAttribute("placeholder", "Ingresar la calle");
  inputStreet.setAttribute("required", "required");
  var invalidStreet = document.createElement('div');
  invalidStreet.setAttribute("class", "invalid-feedback");
  invalidStreet.textContent = "Favor de ingresar la calle de la dirección del proveedor";
  var externalFormGroup = document.createElement('div');
  externalFormGroup.setAttribute("class", "form-group col-md-3");
  var labelExternalNumber = document.createElement('label');
  labelExternalNumber.setAttribute("for", externalId);
  labelExternalNumber.textContent = "Número Externo";
  var inputExternalNumber = document.createElement('input');
  inputExternalNumber.setAttribute("type", "text");
  inputExternalNumber.setAttribute("class", "form-control");
  inputExternalNumber.setAttribute("id", externalId);
  inputExternalNumber.setAttribute("name", externalId);
  inputExternalNumber.setAttribute("placeholder", "Ingresar la número externo");
  inputExternalNumber.setAttribute("required", "required");
  var invalidExternalNumber = document.createElement('div');
  invalidExternalNumber.setAttribute("class", "invalid-feedback");
  invalidExternalNumber.textContent = "Favor de ingresar el número externo";
  var internalFormGroup = document.createElement('div');
  internalFormGroup.setAttribute("class", "form-group col-md-3");
  var labelInternalNumber = document.createElement('label');
  labelInternalNumber.setAttribute("for", internalId);
  labelInternalNumber.textContent = "Número Interno";
  var inputInternalNumber = document.createElement('input');
  inputInternalNumber.setAttribute("type", "text");
  inputInternalNumber.setAttribute("class", "form-control");
  inputInternalNumber.setAttribute("id", internalId);
  inputInternalNumber.setAttribute("name", internalId);
  inputInternalNumber.setAttribute("placeholder", "Ingresar la número interno");
  var postalCodeFormGroup = document.createElement('div');
  postalCodeFormGroup.setAttribute("class", "form-group col-md-3");
  var labelPostalCode = document.createElement('label');
  labelPostalCode.setAttribute("for", postalCodeId);
  labelPostalCode.textContent = "Código Postal";
  var inputGroupPostalCode = document.createElement('div');
  inputGroupPostalCode.setAttribute("class", "input-group");
  var inputPostalCode = document.createElement('input');
  inputPostalCode.setAttribute("type", "text");
  inputPostalCode.setAttribute("class", "form-control");
  inputPostalCode.setAttribute("id", postalCodeId);
  inputPostalCode.setAttribute("name", postalCodeId);
  inputPostalCode.setAttribute("placeholder", "Ingresar el código postal");
  inputPostalCode.setAttribute("required", "required");
  var inputGroupAppendPostalCode = document.createElement('div');
  inputGroupAppendPostalCode.setAttribute("class", "input-group-append");
  var btnPostalCode = document.createElement('button');
  btnPostalCode.setAttribute("class", "btn btn-outline-secondary");
  btnPostalCode.setAttribute("type", "button");
  btnPostalCode.setAttribute("id", filterbtnId);
  btnPostalCode.textContent = "Filtrar";
  var invalidPostalCode = document.createElement('div');
  invalidPostalCode.setAttribute("class", "invalid-feedback");
  invalidPostalCode.textContent = "Favor de ingresar el código postal";
  var secondFormRow = document.createElement("div");
  secondFormRow.setAttribute("class", "form-row");
  var communityFormGroup = document.createElement('div');
  communityFormGroup.setAttribute("class", "form-group col-md-4");
  var labelCommunity = document.createElement('label');
  labelCommunity.setAttribute("for", communitiesId);
  labelCommunity.textContent = "Colonia";
  var selectCommunity = document.createElement('select');
  selectCommunity.setAttribute("class", "form-control");
  selectCommunity.setAttribute("id", communitiesId);
  selectCommunity.setAttribute("name", communitiesId);
  selectCommunity.setAttribute("disabled", "disabled");
  selectCommunity.setAttribute("required", "required");
  var municipalityFormGroup = document.createElement('div');
  municipalityFormGroup.setAttribute("class", "form-group col-md-4");
  var labelMunicipality = document.createElement('label');
  labelMunicipality.setAttribute("for", municipalitiesId);
  labelMunicipality.textContent = "Municipio";
  var selectMunicipality = document.createElement('select');
  selectMunicipality.setAttribute("class", "form-control");
  selectMunicipality.setAttribute("id", municipalitiesId);
  selectMunicipality.setAttribute("name", municipalitiesId);
  selectMunicipality.setAttribute("disabled", "disabled");
  selectMunicipality.setAttribute("required", "required");
  var stateFormGroup = document.createElement('div');
  stateFormGroup.setAttribute("class", "form-group col-md-4");
  var labelState = document.createElement('label');
  labelState.setAttribute("for", statesId);
  labelState.textContent = "Estado";
  var selectState = document.createElement('select');
  selectState.setAttribute("class", "form-control");
  selectState.setAttribute("id", statesId);
  selectState.setAttribute("name", statesId);
  selectState.setAttribute("disabled", "disabled");
  selectState.setAttribute("required", "required");
  var optionCommunity = document.createElement('option');
  optionCommunity.setAttribute("value", "");
  optionCommunity.textContent = "Selecciona...";
  var optionMunicipality = document.createElement('option');
  optionMunicipality.setAttribute("value", "");
  optionMunicipality.textContent = "Selecciona...";
  var optionState = document.createElement('option');
  optionState.setAttribute("value", "");
  optionState.textContent = "Selecciona...";
  addressesDiv.append(firstDiv);
  firstDiv.append(hr);
  firstDiv.append(addressHeader);
  addressHeader.append(btnDelete);
  btnDelete.append(spanTimes);
  firstFormRow.append(streetFormGroup);
  streetFormGroup.append(labelStreet);
  streetFormGroup.append(inputStreet);
  streetFormGroup.append(invalidStreet);
  firstFormRow.append(externalFormGroup);
  externalFormGroup.append(labelExternalNumber);
  externalFormGroup.append(inputExternalNumber);
  externalFormGroup.append(invalidExternalNumber);
  firstFormRow.append(internalFormGroup);
  internalFormGroup.append(labelInternalNumber);
  internalFormGroup.append(inputInternalNumber);
  firstFormRow.append(postalCodeFormGroup);
  postalCodeFormGroup.append(labelPostalCode);
  postalCodeFormGroup.append(inputGroupPostalCode);
  inputGroupPostalCode.append(inputPostalCode);
  inputGroupPostalCode.append(inputGroupAppendPostalCode);
  inputGroupAppendPostalCode.append(btnPostalCode);
  inputGroupPostalCode.append(invalidPostalCode);
  secondFormRow.append(communityFormGroup);
  communityFormGroup.append(labelCommunity);
  communityFormGroup.append(selectCommunity);
  selectCommunity.append(optionCommunity);
  secondFormRow.append(municipalityFormGroup);
  municipalityFormGroup.append(labelMunicipality);
  municipalityFormGroup.append(selectMunicipality);
  selectMunicipality.append(optionMunicipality);
  secondFormRow.append(stateFormGroup);
  stateFormGroup.append(labelState);
  stateFormGroup.append(selectState);
  selectState.append(optionState);
  firstDiv.append(firstFormRow);
  firstDiv.append(secondFormRow);
  var input_postalCode = $('#postalCode' + count);
  input_postalCode.mask('00000');
  btnPostalCode.setAttribute("onclick", "filterCP(this)");
  btnDelete.setAttribute("onclick", "deleteAddress(this)");
}

function deleteAddress(deletebtn) {
  var deletebtnId = deletebtn.id;
  var deleteArray = deletebtnId.split('-');
  var registerId = deleteArray[1];
  var count = $('#countTotalA').val();
  count--;
  $('#countTotalA').val(count);
  var formGroupDelete = $('#fDA-' + registerId);
  formGroupDelete.remove();
}

function deletePhoneNumber(deletebtn) {
  var deletebtnId = deletebtn.id;
  var deleteArray = deletebtnId.split('-');
  var registerId = deleteArray[1];
  var count = $('#countTotalPN').val();
  count--;
  $('#countTotalPN').val(count);
  var formGroupDelete = $('#fD-' + registerId);
  formGroupDelete.remove();
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
    };
    $.ajax({
      type: "POST",
      url: "registrar_proveedor",
      data: data
    }).done(function (response) {
      var communities = $('#communities_id' + count);
      var municipalities = $('#municipalities_id' + count);
      var states = $('#states_id' + count);
      communities.find('option').remove();
      municipalities.find('option').remove();
      states.find('option').remove();
      communities.prop('disabled', false);
      $(response.communities).each(function (i, v) {
        // indice, valor
        communities.append('<option value="' + v.id + '">' + v.name + '</option>');
      });
      $(response.municipalities).each(function (i, v) {
        // indice, valor
        municipalities.append('<option value="' + v.id + '">' + v.name + '</option>');
      });
      $(response.states).each(function (i, v) {
        // indice, valor
        states.append('<option value="' + v.id + '">' + v.name + '</option>');
      });
    }).fail(function () {
      console.log("error");
    }).always(function () {});
  }
}

function rfcMask() {
  var typeRFC = $('#typeRFC');
  if (typeRFC.prop('checked')) $('#RFC').mask('SSSS000000AAA');else $('#RFC').mask('SSS000000AAA');
}
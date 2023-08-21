 @extends('base.base')
 @section('cssDashboard')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"/>
@endsection

@section('title')
     Consulta CURP
@endsection

@section('content')
<div class="card shadow mb-4">
  <div class="card-header py-3 text-align-center">
    <span class="m-0 font-weight-bold text-primary title-table">Consulta CURP</span>
 </div>
 <div class="card-body">
    <form method="POST" id="formCons" action="{{Request::url()}}"  class="needs-validation" novalidate >
    <!--<form method="GET" id="formCons"  onsubmit = "verifyCurpPetitioner(this,event)"  class="needs-validation" novalidate>-->
      <div class="form-group col-md-8">
             <label for="curpPetitioner">Curp del solicitante</label>
             <div class="input-group" >
             <!--<input type="text" class="form-control" oninvalid="alert('Debe llenar este dato');" id="curpPetitioner1" name="curpPetitioner1" data-mask="SSSS000000SSSSSSAA" placeholder="Ingrese la curp del solicitante" required>-->
               <input type="text" class="form-control"  id="curpPetitioner1" name="curpPetitioner1" data-mask="SSSS000000SSSSSSAA" placeholder="Ingrese la curp del solicitante" required>
               <div class="input-group-append">
                 <button class="btn btn-outline-primary float-right" type="submit" onclick="verifyCurpPetitioner(this,event)" id="check-1">Verificar Mes</button>
                 <!--<button class="btn btn-primary float-right" type="submit"  id="check-1">Verificar Mes</button>-->
                 <button class="btn btn-outline-success float-right" type="submit" onclick="verifyCurpPetitioner(this,event)" id="check-2">Verificar Todo</button>
                 <a href="consultas"  class="btn btn-outline-secondary">Nueva Consulta</a>
               </div>
               <div class="invalid-feedback" id = "fd">
                    Favor de ingresar la CURP del solicitante
               </div>
             </div>  
      </div> 
    </form>
  </div>           
</div>      
<div class="row">
  <div class="col-md-12">
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-warning">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-warning-title">¡AVISO IMPORTANTE!</h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <div id="alert-container"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('jsDashboard')
  <!--<script src="../assets/js/mainForm.js"></script>-->
  <script src="../assets/js/ConsultaForm.js"></script>
  <!--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>-->
  <!--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>-->
  <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>-->
@endsection

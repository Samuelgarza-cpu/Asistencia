@extends('base.base')
@section('cssDashboard')
@endsection

@section('text')
@endsection

@section('content')
@if (isset($generalData))
<div class="container bootstrap snippet">
    <div class="row">
  	    <div class="col-sm-12">
            <div class="text-center">
                <h1>Perfil de {{$generalData->owner}}</h1>
                <hr>
            </div>
        </div>
    </div>
    <div class="row">
        
  	    <div class="col-sm-3"><!--left col-->
            <div class="text-center">
                
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <img src="{{'../storage/'. $generalData->image}}" class="avatar img-circle img-thumbnail img-profile" alt="avatar">
                        <h2 for="imagen">Imagen Perfil</h2>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <img src="{{'../storage/'.$generalData->signature}}" class="avatar img-circle img-thumbnail img-profile" alt="avatar">    
                        <h2 for="signature">firma del usuario</h2>
                    </div>
                </div>
            </div>
            <br>  
        </div><!--/col-3-->
    	<div class="col-sm-9">
            <div class="tab-content">
                <div class="tab-pane active" id="home">
                    <div class="form-group">                          
                        <div class="col-xs-6">
                            <label for="usuario"><h4>Usuario</h4></label>
                            <input type="text" disabled class="form-control" name="usuario" id="usuario" value="{{$generalData->name}}">
                        </div>
                    </div>          
                    <div class="form-group">          
                        <div class="col-xs-6">
                            <label for="email"><h4>Email</h4></label>
                            <input type="email" class="form-control" name="email" id="email" disabled value="{{$generalData->email}}">
                        </div>
                    </div>
                    <div class="form-group">          
                        <div class="col-xs-6">
                            <label for="role"><h4>Puesto</h4></label>
                            <input type="text" class="form-control" id="role" placeholder="role" disabled value="{{$generalData->role}}">
                        </div>
                    </div>
                     <div class="form-group">                          
                        <div class="col-xs-6">
                            <label for="usuario"><h4>Fecha de Alta</h4></label>
                            <input type="text" disabled class="form-control" name="usuario" id="usuario" value="{{$generalData->created_at}}">
                        </div>
                    </div>  
                    <div class="form-group">          
                        <div class="col-xs-6">
                            <label for="department"><h4>Departamento</h4></label>
                            <input type="text" class="form-control" name="department" id="department" disabled value="{{$generalData->department}}">
                        </div>
                    </div>
                    <div class="form-group">          
                        <div class="col-xs-6">
                            <label for="institute"><h4>Instituto</h4></label>
                            <input type="text" class="form-control" name="institute" id="institute" disabled value="{{$generalData->institute}}">
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/col-9-->
    </div><!--/row-->
</div>                            
@endif
@endsection


@section('jsDashboard')
<script src="../assets/js/Dashboard.js"></script>
<script src="../assets/js/chart-pie-demo.js"></script>
@endsection
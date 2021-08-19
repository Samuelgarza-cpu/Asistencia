<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="">
  <style>
  .borders {
    border: 1px solid black;
  }
  table {
  border-collapse: collapse;
  width: 100%;
  }
  </style>
</head>

<body id="page-top">
  <table>
     <tr>
        <td>          
          <img style="height:100px" src="{{$images_path.'DifMunicipal.jpg'}}"/>
        </td>
        <td style="text-align: center;">
          @if(isset($title1))
            <h1>
              {{$title1}}
            </h1>
            <p>{{$title2}} </p>
          @endif 
        </td>
        <td>
          <p><strong>Fecha:</strong>{{date('Y-m-d') }}</p>
          <p><strong>Hora:</strong>{{date('H:i:s') }}</p>
        </td>
      </tr>
  </table>
  <hr>

   
  <div class="card-body">
    <font face="arial" size=3>
    <table width="80%" >        
      <tbody>
        @for($i=0 ; $i<= $count; $i++)
          <tr>
              <td><strong>#</strong> <small>{{$i+1}}<small></td>
              <td><strong>Folio : </strong><small> {{$dataInformation[$i]['folio']}} </small></td>
              <td><strong>Fecha : <br> </strong><small> {{$dataInformation[$i]['date']}} </small></td> 
              <td><strong>CURP  : </strong><small>{{$dataInformation[$i]['curpPetitioner']}} </small></td>
              <td><strong>Categoria: </strong><small>{{$dataInformation[$i]['disabilityCategory']}}</small></td>              
          </tr>
          <tr>
              <td><strong>Area:</strong> <small>{{$dataInformation[$i]['area']}}</small></td>
              <td></td>
              <td></td>
              <td></td>
              <td><strong>Discapacidad:</strong> <small>{{$dataInformation[$i]['disability']}}</small></td>
          </tr>
          <tr>
            <td colspan="6"><strong>Nombre: </strong><small>{{$dataInformation[$i]['personalData']}}</small></td>
          </tr>
          <tr>
            <td colspan="6"><strong>Dirección :</strong><small> {{$dataInformation[$i]['address']}}</small></td>             
          </tr>
          <tr>
            <td colspan="6"><hr></td>             
          </tr>            
         @endfor
      </tbody>
    </table>  
    </font>
  </div>
</body>
</html>

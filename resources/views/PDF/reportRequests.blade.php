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
    <thead>
      <tr>
         <td colspan="2">
         <!--<td style="margin: 0 auto; width: 351px; text-align: left" class="borders">-->
         <!-- <div style="margin: 0 auto; width: 272px"> -->   
             <img  style="height:60px"  src="{{$images_path.'Logo-GP2225.png'}}" alt="me" style="width: 130px">
         <!--</div> -->         
         <!--<img style="height:100px" src="{{$images_path.'Logo-GP2225.png'}}"/> -->
        </td>
        <td colspan="2" style="text-align: center">
        <!--<td style="margin: 0 auto; width: 351px; text-align: left" class="borders">-->
          <!--<div style="margin: 0 auto; width: 272px">-->
            @if(isset($title1))
              <h1>
                {{$title1}}
              </h1>
              <p>{{$title2}} </p>
            @endif
          <!--</div>-->   
        </td>
        <td colspan="2" style="text-align: center">
        <!--<td style="margin: 0 auto; width: 260px; text-align: left" class="borders" >-->
          <!--<div style="margin: 0 auto; width: 272px">-->
          <!--<div>-->
            <p><strong>Fecha:</strong>{{date('Y-m-d') }}</p>
            <p><strong>Hora:</strong>{{date('H:i:s') }}</p>
          <!--</div>-->  
        </td>
      </tr>
    </thead>
    <!--<font face="arial" size=3>-->
    <tbody>
        @for($i=0 ; $i<= $count; $i++)
          <tr>
              <td><strong># </strong><small>{{$i+1}}<small></td>
              <td><strong>Folio : </strong><small>{{$dataInformation[$i]['folio']}}</small></td>                              
              <td colspan="2"><strong>Fecha Sol : </strong><small>{{date('d-m-Y', strtotime($dataInformation[$i]['date']))}}<small></td>              
              <td style = "color: #C70039"><strong>Estatus:</strong><small>{{$dataInformation[$i]['status']}}</small></td>
              <!--<td><strong>Area:</strong><small>{{$dataInformation[$i]['area']}}</small></td>-->                              
              <td><strong>Tel. </strong><small>{{$dataInformation[$i]['beneficiariesNumber']}}<small></td>
          </tr>
          <tr>
            <td colspan="4"><strong>Beneficiario: </strong><small>{{$dataInformation[$i]['beneficiaries']}}</small></td>
            <td colspan="2"><strong>CURP: </strong><small>{{$dataInformation[$i]['beneficiariesCurp']}}</small></td>
          </tr>
          <tr>
            <td colspan="6"><strong>Dirección :</strong><small> {{$dataInformation[$i]['address']}}</small></td>             
          </tr>
          <tr> 
             <td colspan="4"><strong>Apoyo</strong> :<small> {{$dataInformation[$i]['qty']}} {{$dataInformation[$i]['product']}} </small></td>   
             <td colspan="2"><strong>Tipo</strong> :<small> {{$dataInformation[$i]['typerequest']}} </small></td>   
          </tr>          
          <tr>
            <td colspan="6"><hr></td>             
          </tr>            
         @endfor
    </tbody>
  </table>
  <!--</font>-->
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="">
  <style>
  .borders {
    borde11r: 1px solid black;
  }
  table {
  border-collapse: collapse;
  width: 100%;
  }
  </style>
</head>

<body id="page-top">
    <div>
     <main>
            <!-- El contenido de tu PDF aquí -->
            <!-- Caratula -->
            <div>
              <table>
                <tr>
                  <td>
                    <!--<img src="{{$requisition->images_path.'DifMunicipal.jpg'}}"/> -->
                    <div style="margin: 0 auto; width: 130px">   
                      <img  style="height:60px"  src="{{$requisition->images_path.'Logo-GP2225.png'}}" alt="me" style="width: 130px">
                    </div>  
                  </td>
                  <!--<div style="margin: 0 auto; width: 130px"> <img src="me.jpg" alt="me" style="width: 130px" /> </div>-->
                  <td>
                      <table style="height: 60px text-align: center; border-style:solid; border-color:black;">
                        <tr>
                          <td  style = "text-align: center">
                            <h3>PETICIÓN DE APOYO DE ASISTENCIA SOCIAL</h3>
                          </td>
                        </tr>
                        <tr>
                          <td style = "text-align: center"> 
                            {{$requisition->date}}
                          </td>
                        </tr>
                        <tr>
                          <td  style = "text-align: center">
                            {{$requisition->folio}}
                          </td>
                        </tr> 
                      </table>
                   </td>
                  <td>
                    <div style="margin: 0 auto; width: 130px">   
                       <img  style="height:60px"  src="{{$requisition->images_path.'LogoDif.png'}}" alt="me" style="width: 130px">
                    </div>  
                  </td>  
                </tr>
              </table>
              <br/>
              <table>
                <tr>
                  <!--<td style="border-style:solid; border-color:black;">-->
                  <td>
                      <!--<div style="border-style:solid; border-color:black;">-->
                        <img  style="height:80px width: 80px align=left"  src="{{$requisition->images_path.'petitioners/'.$requisition->image}}">
                      <!--</div>-->
                  </td>
                </tr>
              </table>
              <table style="border-style:solid; border-color:black;">
                <tr>
                  <td style="border-style:solid; border-color:black;">
                    <p>NOMBRE DEL SOLICITANTE: </p>
                  </td>
                  <td style="border-style:solid; border-color:black;" >
                    <p id="namePetitioner">{{$requisition->petitioner}}</p>
                  </td>
                  <td style="border-style:solid; border-color:black;"> 
                    <p id="agePetitioner">Edad: {{$requisition->agePetitioner}}</p>
                  </td>
                </tr>
                <tr>
                  <td style="border-style:solid; border-color:black;" >
                    <p>BENEFICIARIO(S):</p>
                  </td>
                  <td style="border-style:solid; border-color:black;">
                      @foreach($requestPersonalData as $element)
                         <p id="{{'nameBeneficiary'.$element->id}}">{{$element->name.' '.$element->lastName.' '.$element->secondLastName}}</p>
                      @endforeach       
                  </td> 
                  <td style="border-style:solid; border-color:black;">
                      @foreach($requestPersonalData as $element)
                        <p id="{{'ageBeneficiary'.$element->id}}">Edad: {{$element->age}}</p>
                      @endforeach  
                  </td>   
                </tr>
                <tr>
                  <td style="border-style:solid; border-color:black;">
                    <p>APOYO:</p>
                  </td>
                  <td style="border-bottom:solid; border-color:black;">
                    <p>Categoria: {{$categoria}}</p>
                    @if($requestSupplierProducts != "")
                      @foreach($requestSupplierProducts as $element) 
                         @if($element->price == 0)
                            <p id="{{'productInfo'.$element->id}}">{{$element->productName.' Importe:'.number_format ( $element->qty, 2, ".", ",")}}</p>
                         @else   
                            <p id="{{'productInfo'.$element->id}}">{{$element->qty.' '.$element->productName.' Precio Unitario:'.number_format ( $element->price, 2, ".", ",")}}</p>
                         @endif   
                       @endforeach   
                    @endif
                    <p> Total General: {{number_format ( $total, 2, ".", ",")}}</p>
                  </td>
                  <td style="border-bottom:solid; border-color:black;"></td>              
                </tr>
                <tr>
                  <td style="border-style:solid; border-color:black;">
                    <p>CASO:</p>
                  </td>
                  <td style="border-bottom:solid; border-color:black;">
                      <p id="{{'case'.$requisition->id}}">{{$requisition->description}}</p>
                  </td>
                  <td style="border-bottom:solid; border-color:black;"></td>              
                </tr>
                <tr>
                  <td style="border-style:solid; border-color:black;">
                    <p>TELEFONO:</p>
                  </td >
                  <td style="border-bottom:solid; border-color:black;">
                      <p id="{{'numero'.$extPersonalData->id}}">{{$extPersonalData->number}}</p>
                  </td>
                  <td style="border-bottom:solid; border-color:black;"></td>              
                </tr>
                <tr>
                  <td>
                    <p>AUTORIZADO:</p>
                  </td>
                  <td>
                    @if($requisition->status_id == 6 || $requisition->status_id == 4)
                      <img src="{{$requisition->mainPublic_path.$userAuth->stamp}}"/>
                    @endif
                  </td>
                  <td></td>                            
                </tr>
              </table>
              <br></br>
              <br></br>
              <!--<h2 style="text-align: left;">{{session('nameuser')}}</h2>-->
              <h2 style="text-align: left;">{{session('user')}}</h2>
              <p style="page-break-after: always;"></p>
              <!-- Primera Hoja -->
              <table>
                <tr>
                  <td>
                    <img style="height:100px" src="{{$requisition->images_path.'LogoDif.png'}}"/>
                  </td>
                  <td>
                    <h2 style="text-align: center;">SISTEMA PARA EL DESARROLLO INTEGRAL DE LA FAMILIA</h2>
                  </td>
                  <td style="text-align: right">
                    <p>{{$requisition->date}}</p>
                  </td>
                </tr>
              </table>
              <table>
                <tr>
                  <td colspan="2">
                    <table>
 |                     <tr>
                        <td style="text-align: right;">
                          <span>SOLICITA:</span>  
                          @if($requestSupplierProducts != "")
                             @foreach($requestSupplierProducts as $element) 
                                @if($element->price == 0)
                                  <span style="text-decoration: underline;" id="{{'productInfo'.$element->id}}">{{$element->productName.','}}</span>
                                @else
                                  <span style="text-decoration: underline;" id="{{'productInfo'.$element->id}}">{{$element->qty.' '.$element->productName.','}}</span>
                                @endif
                             @endforeach   
                          @endif 
                        
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
              <br>
              <br>
              <table>
                <tr>
                  @if($requisition->beneficiary == 1)
                    <td style="width: 100%;" colspan="3">
                      NOMBRE: <span style="text-decoration: underline;">{{$requisition->petitioner}}</span>                  
                   </td>
                  @else
                    <!--<td colspan="2" style="width: 80%">NOMBRE: <span style="text-decoration: underline;">{{$requestPersonalData[0]->name.' '.$requestPersonalData[0]->lastName.' '.$requestPersonalData[0]->secondLastName}}</span></td>-->
                    <td colspan="2" style="width: 80%">NOMBRE: <span style="text-decoration: underline;">{{$requisition->petitioner}}</span></td>
                    <td colspan="1" style="width: 20%">EDAD: <span style="text-decoration: underline;">{{$requestPersonalData[0]->age}}</span></td>
                  @endif
                </tr>
                <tr>
                  <td>
                    DOMICILIO:
                    {{-- <p>{{$address['state']->name}}</p> --}}
                    <span style="text-decoration: underline;">{{$address->street.' #'.$address->externalNumber.' '.$address->internalNumber}}</span>
                  </td>
                </tr>
                <tr>
                  <td colspan= "3">
                    <table>
                      <tr>
                        <td>
                          COLONIA:
                          {{-- <p>{{$address['state']->name}}</p> --}}
                          <span style="text-decoration: underline;">{{$address['community']->type.' '.$address['community']->name}}</span>
                        </td>
                        <td>
                          CIUDAD:
                          {{-- <p>{{$address['state']->name}}</p> --}}
                          <span style="text-decoration: underline;">{{$address['municipality']->name.', '.$address['state']->name}}</span>
                        </td>
                        <td>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td colspan="3">
                    <table>
                      <tr>
                        <td>
                          EDO. CIVIL:
                          {{-- <p>{{$address['state']->name}}</p> --}}
                          <span style="text-decoration: underline;">{{$requestPersonalData[0]->civilStatus}}</span>
                        </td>
                        <td>
                          ESCOLARIDAD:
                          {{-- <p>{{$address['state']->name}}</p> --}}
                          <span style="text-decoration: underline;">{{$requestPersonalData[0]->scholarShip}}</span>
                        </td>
                        <td>
                          OCUPACION:
                          {{-- <p>{{$address['state']->name}}</p> --}}
                          <span style="text-decoration: underline;">{{$requestPersonalData[0]->employmentName}}</span>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td colspan = "3"> 
                    <table>
                      <tr>
                        <td>
                          TELEFONO:
                          {{-- <p>{{$address['state']->name}}</p> --}}
                          <span syle="text-decoration: underline;">{{$extPersonalData->number}}</span>
                        </td>
                        <td>
                          SERVICIO MEDICO:
                          {{-- <p>{{$address['state']->name}}</p> --}}
                          <span style="text-decoration: underline;">{{$requestPersonalData[0]->sermedico}}</span>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
              <br>
              <H2 STYLE="text-align: center;">SITUACIÓN FAMILIAR</H2>
              <table>
                <tr>
                  <th>NOMBRE</th>
                  <th>EDAD</th>
                  <th>PARENTESCO</th>
                  <th>EDO. CIVIL</th>
                  <th>OCUPACIÓN</th>
                  <th>ESCOLARIDAD</th>
                </tr>
                @for($i = 0; $i < $requestPersonalData->count(); $i++)
                  @if($requestPersonalData[$i]->beneficiary)
                    <tr>
                      <td STYLE="text-align: center;">
                        <span style="text-decoration: underline;">{{$requestPersonalData[$i]->name.' '.$requestPersonalData[$i]->lastName.' '.$requestPersonalData[$i]->secondLastName}}</span>
                      </td>
                      <td STYLE="text-align: center;">
                        <span style="text-decoration: underline;">{{$requestPersonalData[$i]->age}}</span>
                      </td>
                      <td STYLE="text-align: center;">
                        <span style="text-decoration: underline;"></span>
                      </td>
                      <td STYLE="text-align: center;">
                        <span style="text-decoration: underline;">{{$requestPersonalData[$i]->civilStatus}}</span>
                      </td>
                      <td STYLE="text-align: center;">
                        <span style="text-decoration: underline;">{{$requestPersonalData[$i]->employmentName}}</span>
                      </td>
                      <td STYLE="text-align: center;">
                        <span style="text-decoration: underline;">{{$requestPersonalData[$i]->scholarShip}}</span>
                      </td>
                    </tr>
                  @endif
                @endfor
                @if($familySituation->count() > 0)
                @foreach($familySituation as $element)
                    <tr>
                      <td STYLE="text-align: center;">
                        <span style="text-decoration: underline;">{{$element->name.' '.$element->lastName.' '.$element->secondLastName}}</span>
                      </td>
                      <td STYLE="text-align: center;">
                        <span style="text-decoration: underline;">{{$element->age}}</span>
                      </td>
                      <td STYLE="text-align: center;">
                        <span style="text-decoration: underline;">{{$element->relationship}}</span>
                      </td>
                      <td STYLE="text-align: center;">
                        <span style="text-decoration: underline;">{{$element->civilStatus}}</span>
                      </td>
                      <td STYLE="text-align: center;">
                        <span style="text-decoration: underline;">{{$element->employmentName}}</span>
                      </td>
                      <td STYLE="text-align: center;">
                        <span style="text-decoration: underline;">{{$element->scholarship}}</span>
                      </td>
                    </tr>
                @endforeach
                @endif
              </table>
              <br>
              <h2 style="text-align: center;">CONDICIONES DE VIDA</h2>
              <TABLE>
                <tr>
                  <td style="text-align: center;">
                    TIPO DE CASA:
                    <span style="text-decoration: underline;">{{$lifeCondition[0]->typeHouse}}</span>
                  </td>
                  <td style="text-align: center;">
                    NÚMERO DE CUARTOS
                    <span style="text-decoration: underline;">{{$lifeCondition[0]->number_rooms}}</span>
                  </td>
                </tr>
              </TABLE>
              <br>
              <TABLE>
                <tr>  
                    <td>
                       MUEBLES
                    </td>
                    @foreach($requestFurnitures as $element)
                     {{--<TD style="text-align: center;">--}}
                      <td>
                         <span style="text-decoration: underline;">{{$element->name}}</span>
                      </td>
                    @endforeach   
                </tr>
                <tr>
                    <td>
                        SERVICIOS
                    </td>
                    @foreach($requestServices as $element)
                      <td>
                         <span style="text-decoration: underline;">{{$element->name}}</span>
                      </td>
                    @endforeach
                </tr>
                <tr> 
                   <TD>
                        MATERIAL DE CONSTRUCCIÓN
                    </TD>
                    @foreach($requestBuildingMaterial as $element)
                    <TD>
                         <span style="text-decoration: underline;">{{$element->name}}</span>
                    </TD>
                    @endforeach
                  </tr>
              </TABLE>
              <br>
              <H3 style="text-align: center;">INGRESOS ECONÓMICOS</H3>
              <table>
                <tr>
                  <td style="text-align: left;">INGRESOS: <span style="text-decoration: underline;">${{$economicData[0]->income}}</span></td>
                  <td style="text-align: right;">EGRESOS: <span style="text-decoration: underline;">${{$economicData[0]->expense}}</span></td>
                </tr>
              </table>
              <H3 style="text-align: center;">OBSERVACIONES-CASO</H3>
              <table>
                <tr>
                  <td>
                      <p id="{{'case'.$requisition->id}}">{{$requisition->description}}</p>
                  </td>
                </tr>
              </table>
              <br></br>
              <br></br>
              <table>
                <tr>
                  <td>
                    <table>
                     {{-- <tr>
                        <td style="text-align: center; height: 150px;">
                          <img style="height: 150px;" src="{{$requisition->mainPublic_path.$user->signature}}"/>
                        </td>
                      </tr>--}}
                      <tr>
                        <td style="text-align: center">
                          USUARIO: <span style="text-decoration: underline;">{{$user->owner}}</span></tD>
                        </td>
                      </tr>
                    </table>
                  </td>
                  <td>
                    <table>
                      {{--<tr>
                        <td  style="text-align: center; height: 150px;">
                          @if($requisition->status_id == 4 || $requisition->status_id == 6)
                            <img style="height: 150px;" src="{{$requisition->mainPublic_path.$user->signature}}"/>s
                          @endif
                        </td>
                      </tr>--}}
                      <tr>
                        <!--<tD style="text-align: center">AUTORIZA: <span style="text-decoration: underline;">{{$userAuth->owner}}</span></tD>-->
                       <td style="text-align: center">AUTORIZA: <span style="text-decoration: underline;">Lic. Blanca Estela Barbosa Salas</span></td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td colspan="2"><SPAN STYLE="font-size: 14PX">BLVD. EJERCITO MEXICANO 528 TELEFONOS: 714-21-24 Y 714-21-27 GÓMEZ PALACIO, DGO.</SPAN></td>
                </tr>
              </table>
              <p style="page-break-after: always"></p>
              <!-- Peticion -->
              <table>
               <tr>
                  <td>
                    <!--<div style="margin: 0 auto; width: 130px">-->   
                    <div>     
                      <img  style="height:60px" src="{{$requisition->images_path.'LogoDif.png'}}" alt="me" style="width: 130px">
                    </div>  
                  </td>  
                </tr>
                <tr>
                  <td>
                    <p style="font-weight: bold;">Lic. Brenda Calderón Carrete</p>
                  </td>
                  <td style="text-align: right;">
                    <span style="font-weight: bold;">{{$requisition->date}}</span>
                  </td>
                </tr>
                <tr>
                  <td>
                    <p>Directora General DIF Municipal Gómez Palacio, Durango<br>
                    Presente.-</p>
                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                    <p>A sus amables atenciones me dirijo, para solicitarle tenga a bien apoyarme con:</p>
                    <p>{{$requisition->description}}</p>
                  </td>
                </tr>
                <tr>
                  <td>
                    Para: <span style="text-decoration: underline;">{{$requestPersonalData[0]->name.' '.$requestPersonalData[0]->lastName.' '.$requestPersonalData[0]->secondLastName}}</span></td>
                  </td>
                  <td>EDAD: <span style="text-decoration: underline;">{{$requestPersonalData[0]->age}}</span></td>
                </tr>
                <tr>
                  <td>
                    DOMICILIO:
                    {{-- <p>{{$address['state']->name}}</p> --}}
                    <span style="text-decoration: underline;">{{$address->street.' #'.$address->externalNumber.' '.$address->internalNumber}}</span>
                  </td>
                </tr>
                <tr>
                  <td>
                    COLONIA:
                    {{-- <p>{{$address['state']->name}}</p> --}}
                    <span style="text-decoration: underline;">{{$address['community']->type.' '.$address['community']->name}}</span>
                  </td>
                  <td>
                    CIUDAD:
                    {{-- <p>{{$address['state']->name}}</p> --}}
                    <span style="text-decoration: underline;">{{$address['municipality']->name.', '.$address['state']->name}}</span>
                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                    <p>Lo anterior debido a que:</p>
                    <br>
                    <br>
                    <input style="width: 100%;" type="text"/>
                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                    <p>Agradezco su invaluable apoyo:</p>
                    <br>
                    <br>
                    <input style="width: 100%;" type="text"/>
                    <p style="font-size: 14px;">FIRMA, NOMBRE, DOMICILIO(CALLE Y NUMERO INT Y EXT. COLONIA/EJIDO) DEL SOLICITANTE</p>
                  </td>
                </tr>
              </table>
              <p style="page-break-after: always"></p>
              <!-- Peticion a la presidenta -->
              <table>
              <tr>
                  <td>
                    <!--<div style="margin: 0 auto; width: 130px">-->   
                    <div>     
                      <img  style="height:60px"  src="{{$requisition->images_path.'LogoDif.png'}}" alt="me" style="width: 130px">
                    </div>  
                  </td>  
                </tr>
                <tr>
                  <td>
                    <p style="font-weight: bold;">Lic. Brenda Calderón Carrete</p>
                  </td>
                  <td style="text-align: right;">
                    <span style="font-weight: bold;">{{$requisition->date}}</span>
                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                    <p>Directora General DIF Municipal Gómez Palacio, Durango</p>
                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                    <p>Solicito su valiso apoyo con</p>
                    @if($requestSupplierProducts != "")
                        @foreach($requestSupplierProducts as $element)
                          @if($element->price == 0)
                            <span id="{{'productInfo'.$element->id}}">{{$element->productName}}</span>
                          @else
                            <span id="{{'productInfo'.$element->id}}">{{$element->qty.' '.$element->productName}}</span> 
                          @endif  
                        @endforeach
                    @endif
                    para mi ya que no cuento con los medios económicos para solventar el gasto ya que lo necesito.
                  </td>
                </tr>
                <tr>
                  <td colspan="2" style="text-align: right;">
                    <p>____________________________________</p>
                  <!--  <p style="font-weight:bold">{{$requestPersonalData[0]->name.' '.$requestPersonalData[0]->lastName.' '.$requestPersonalData[0]->secondLastName}}</p>-->
                    <p style="font-weight:bold">{{$requisition->petitioner}}</p>
                  </td>
                </tr>
              </table>
              <p style="page-break-after: always;"></p>

              @if ($requisition->type == "responsiva")
              <table>
                <tr>
                  <td>
                    <img style="height:100px" src="{{$requisition->images_path.'LogoDif.png'}}"/>
                  </td>
                  <td>
                    <h2 style="text-align: center;">TRABAJO SOCIAL</h2>
                  </td>
                  <td style="text-align: right;">
                    <p>{{$requisition->date}}</p>
                  </td>
                </tr>
              </table>
              <br>
              <table>
                <tr>
                  <td>
                    <span>INSTITUCIÓN: </span><span>{{$requestSupplierProducts != "" ? $requestSupplierProducts->companyName : "DIF"}}</span>
                  </td>
                </tr>
                <tr>
                  <td>
                    <span>DOMICILIO: </span><span>{{$requestSupplierProducts != "" ? $requestSupplierProducts->companyAddress : "POR AHí"}}</span>
                  </td>
                </tr>
                <tr>
                  <td>
                    <span>COLONIA: </span><span>{{$requestSupplierProducts != "" ? $requestSupplierProducts->companyColoni : "POR AHí"}}</span>
                  </td>
                </tr>
              </table>
              <br>
              <table>
                <tr>
                  <td>
                    FAVOR DE CARGAR A NUESTRA CUENTA LA CANTIDAD DE <span style="text-decoration: underline;">$ {{number_format ($requestSupplierProducts != "" ? $requestSupplierProducts->total : 0.00, 2, ".", ",")}}</span>
                  </td>
                </tr>
                <tr>
                  <td>
                  SON : (**<label for="cantidadletra">{{$totalletter}}</label>**)
                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                    POR CONCEPTO DE :
                  </td>
                  <td colspan="10">
                    <span>
                      @if($requestSupplierProducts != "")
                          <p id="{{'productInfo'.$requestSupplierProducts->id}}">{{$requestSupplierProducts->qty.' '.$requestSupplierProducts->productName}}</p>
                      @endif
                    </span>
                  </td>
                </tr>
                <tr>
                  <td>
                    PARA EL/LA C. NOMBRE: <span style="text-decoration: underline;">{{$requestPersonalData[0]->name.' '.$requestPersonalData[0]->lastName.' '.$requestPersonalData[0]->secondLastName}}</span>
                    QUIEN CUENTA CON <span style="text-decoration: underline;">{{$requestPersonalData[0]->age}}</span> AÑOS DE EDAD.
                  </td>
                </tr>
                <tr>
                  <td>
                    Y TIENE SU DOMICILIO EN <span style="text-decoration: underline;">{{$address->street.' #'.$address->externalNumber.' '.$address->internalNumber.' '.$address['community']->type.' '.$address['community']->name.', '.$address['municipality']->name.', '.$address['state']->name}}</span>
                  </td>
                </tr>
              </table>
              <br>
              <table>
                <tr>
                  <td>
                    <table>
                      <tr>
                        <td colspan="4">
                          @if($requisition->type == 'responsiva')
                            <span>Responsiva</span>
                          @endif
                          &nbsp;
                        </td>
                        <td colspan="4">
                        </td>
                        <td colspan="4" style="text-align: center;">
                          <span>ATENTAMENTE</span>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="5">
                          &nbsp;
                        </td>
                        <td colspan="5">
                          &nbsp;
                        </td>
                        <td colspan="2" style="text-align: center;">
                          @if($requisition->status_id == 4 || $requisition->status_id == 6)
                            <img style="height: 150px;" src="{{$requisition->mainPublic_path.$user->signature}}"/>
                          @endif
                        </td>
                      </tr>
                      <tr>
                        <td colspan="4">
                          &nbsp;
                        </td>
                        <td colspan="4">
                          &nbsp;
                        </td>
                        <td colspan="4" style="text-align: center; border-top: 1px solid;">AUTORIZA: <span>{{$userAuth->owner}}</span></tD>
                      </tr>
                    </table>
                  </td>
                </tr>
                <br>
                <tr>
                  <td style="text-align: right;">
                    SISTEMA PARA EL DESARROLLO INTEGRAL DE LA FAMILIA
                  </td>
                </tr>
                <tr>
                  <td style="text-align: right;">
                    Blvd. Ejercito Mexicano No. 528 Parque Industrial Gómez Palacio, Dgo. Tel: 714-21-24
                  </td>
                </tr>
              </table>
              <hr>
              @endif
              {{-- //foliado --}}
              @if($requisition->type != 'responsiva')
              {{-- <p style="page-break-after: always;"></p> --}}
              <table>
                <tr>
                  <!--<td colspan="2" style="text-align: center;">
                    <p>
                      <img style="height:100px" src="{{$requisition->images_path.'LogoDif.png'}}"/>
                    </p>
                    <br>
                    <br>
                    <br>
                    <p>
                      <img style="height:100px" src="{{$requisition->images_path.'CedulaDIF.jpg'}}"/>
                    </p>
                  </td>-->
                  <td colspan="10">
                    <table>
                      <!--<tr>
                        <td colspan="10" style="text-align: center;">
                          <h1>
                            Sistema para el Desarrollo Integral de la Familia
                          </h1>
                        </td>
                        <td colspan="10" style="text-align: center;">
                          <div class="card mb-4 box-shadow text-center">
                            <div class="card-header">
                              <h4 class="my-0 font-weight-normal">FOLIO</h4>
                            </div>
                            <div class="card-body">
                              <h4 class="card-title pricing-card-title">No. <small class="text-muted"><label for="folio">xxxxxx:</label></small></h4>
                              <h4 class="card-title pricing-card-title">No. <small class="text-muted"><label for="foliodigital"> {{$requisition->folio}}</label></small></h4>
                            </div>
                          </div>
                        </td>
                      </tr>-->
                      <br>
                      <br>
                      <br>
                      <br>
                      <tr>
                        <td colspan="12">
                          <!--<p>
                            *Recibimos del sistema para el Desarrollo Integral de la familia, La cantidad de : $ <label for="cantidad">{{$total}}</label> 
                          </p>-->  
                          <div style= "margin-top: 76px ">
                             <p><label style= "margin: 600px " for="cantidad">{{number_format ( $total, 2, ".", ",")}}</label></p>  
                          <div>   
                          <div style= "margin-top: -0.5cm">
                              <p><label style= "margin: 227px"  for="cantidadletra"> Son : {{$totalletter}} </label></p>
                          </div>    
                          <br>
                          <br>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="12">
                         <!--<p>
                            *Por Concepto de : <label for="concepto">
                                   @if($requestSupplierProducts != "")
                                      @foreach($requestSupplierProducts as $element)
                                         {{$element->qty.' '.$element->productName}}
                                      @endforeach   
                                    @endif
                                  </label>
                          </p>-->
                          <p style="margin-top: 0.5cm; line-height: 0.7cm">
                            @if($requestSupplierProducts != "")
                              @foreach($requestSupplierProducts as $element)
                                @if($element->price == 0)
                                   <label style="margin: 230px">{{$element->productName.' '.number_format ( $element->qty, 2, ".", ",")}}</label><br>
                                @else   
                                   <label style="margin: 230px">{{$element->qty.' '.$element->productName.' Precio Unitario:'.number_format ( $element->price, 2, ".", ",")}}</label><br>
                                @endif  
                              @endforeach   
                            @endif
                            <label style="margin: 230px">NOMBRE: {{$requisition->petitioner}}</label><br>
                            <label style="margin: 230px">DOMICILIO: {{$address->street.' #'.$address->externalNumber.' '.$address->internalNumber}}</label><br>            
                            <label style="margin: 230px">EDAD:{{$requisition->agePetitioner}}</label>     
                          </p>
                          <br>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="12"  >
                           <!--<label style= "margin: 378px"  for="dia">{{$daytoday}}</label><label for="mes">{{'de '.$monthtodayletter.' de'}}</label><label for="anio">{{$yeartoday}}</label>-->
                           <div style= "margin-top: 0.5cm"> 
                             <label style= "margin: 360px"  for="dia">{{$daytoday}}</label>
                           </div>  
                            <!-- <p>
                               <span style="text-decoration: underline;">__________________</span>
                            </p>
                            <label class="firma" for="dia">Recibí</label>-->
                           </div>  
                        </td>
                      </tr>
                      <tr>  
                        <td colspan="12">
                           <div> 
                              <label style= "margin: 227px" for="mes">{{$monthtodayletter}}<label style= "margin: 151" for="anio">{{$yeartoday}}</label></label>
                           </div>
                           <!--<div>
                             <label style= "margin: 378px"  for="año">{{$yeartoday}}</label>
                           </div> --> 
                        </td>   
                        <!--<td colspan="4" style="text-align: center;" >
                        <td>
                          <p>
                            <span style="text-decoration: underline;">__________________</span>
                          </p>
                          <label class="firma" for="dia">Recibí</label>
                        </td> -->
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
              @endif
        </main>
    </div>
</body>
</html>

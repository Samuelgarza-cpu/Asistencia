@extends('base.base')
@section('cssDashboard')
<script
src="https://code.jquery.com/jquery-3.5.1.js"
integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
crossorigin="anonymous"></script>   
@endsection
@section('notificaciones')
     <!-- Nav Item - Alerts -->
             <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <div class="small text-gray-500">
                  @if (auth()->user()->unreadNotifications())
                     <span class="badge badge-warning" id="nNotifications">{{auth()->user()->unreadNotifications()->count()}}</span>
                  @else 
                   <span class="badge badge-warning" id="nNotifications">{{auth()->user()->unreadNotifications()->count()}}</span>
                   
                  @endif
                  
                </div>
        
                {{-- <span class="badge badge-danger badge-counter">{{auth()->user()->unreadNotifications()->count()}}</span> --}}
              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                  Alerts Center
                </h6>
                {{-- <a class="dropdown-item d-flex align-items-center" href={{url('notificaciones')}}> --}}
                  <div class="mr-3">
                    <div class="icon-circle bg-primary">
                      <i class="fas fa-file-alt text-white"></i>
                    </div>
                  </div>
                  <div>

                  </div>
            
                  <span class="badge badge-light" id="spanFirst" >
                    @if(isset($ids) && !empty($ids))
                      <input type="hidden" id="notificationID" name ="notificationID" value="{{$ids}}"/>
                    @else
                      <input type="hidden" id="notificationID" name ="notificationID" value=""/>
                    @endif
                    @if(isset($count)) 
                      @if($count>0)
                        @if(isset($notifies) && !empty($notifies))
                          @foreach ($notifies as $datos)
                            <a class="dropdown-item d-flex align-items-center" id={{$datos->id}} href={{'/leidas/'.$datos->id}}>
                              <p> {{$datos->data['Notificacion']}}</p>
                              {{-- <span class="badge badge-warning">{{$datos->created_at->diffForHumans()}}</span> --}}
                              <span class="pull-right text-muted">{{$datos->created_at->diffForHumans()}}</span>
                            </a>
                          @endforeach
                        @endif
                      @else
                       <span class="badge badge-warning">No tienes Notificaciones</span>
                      @endif
                    @endif
                  </span>
                
                {{-- </a> --}}

                
                
                {{-- <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-success">
                      <i class="fas fa-donate text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 7, 2019</div>
                   
                
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-warning">
                      <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 2, 2019</div>
                    Spending Alert: We've noticed unusually high spending for your account.
                  </div>
                </a> --}}
              <a class="dropdown-item text-center small text-gray-500" href="{{route('leidas')}}">Show All Alerts</a>
              </div>
            </li> 

             {{-- <!-- Nav Item - Messages -->
             <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter">7</span>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                  Message Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/fn_BT9fwg_E/60x60" alt="">
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div class="font-weight-bold">
                    <div class="text-truncate">Hi there! I am wondering if you can help me with a problem I've been having.</div>
                    <div class="small text-gray-500">Emily Fowler · 58m</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/AU4VPcFN4LE/60x60" alt="">
                    <div class="status-indicator"></div>
                  </div>
                  <div>
                    <div class="text-truncate">I have the photos that you ordered last month, how would you like them sent to you?</div>
                    <div class="small text-gray-500">Jae Chun · 1d</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/CS2uCrpNzJY/60x60" alt="">
                    <div class="status-indicator bg-warning"></div>
                  </div>
                  <div>
                    <div class="text-truncate">Last month's report looks great, I am very happy with the progress so far, keep up the good work!</div>
                    <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60" alt="">
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div>
                    <div class="text-truncate">Am I a good boy? The reason I ask is because someone told me that people say this to all dogs, even if they aren't good...</div>
                    <div class="small text-gray-500">Chicken the Dog · 2w</div>
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
              </div>
            </li> --}}

            <div class="topbar-divider d-none d-sm-block"></div>
@endsection
@section('content')
<div class="container">
    @if(session('mensaje'))
    <div class="row mb-2 align-content-center">
        <div class="alert alert-danger">
            {{session('mensaje') }}
        </div>
    </div>
    @endif
    <div align="center">
          <img src="/dif.png"> <br>
          <input type ='button' class="btn btn-warning"  value = 'ENVIAR A EMAIL' onclick="location.href ='{{ route('email') }}'"/>
          <input type ='button' class="btn btn-warning"  value = 'GUARDAR NOTIFICACION EN DATABASE' onclick="location.href ='{{ route('database') }}'"/>

    </div>
  </div>
 

@endsection

@section('script')
<script type="text/javascript">
  $(document).ready(function(){
    var notifications = [];
    setInterval(function(){
      var notificationsID = $('#notificationID').val();
      $.ajax({
      type: "POST",
      url: "notificaciones",
      data: { 'action': "checar","notificationsID":notificationsID, "_token": $("meta[name='csrf-token']").attr("content") }
    })
    .done(function(response) {
      console.log(response);
      var nNotifications = $('#nNotifications');
      nNotifications.text(response[0].count);
      var spanFirst = $('#spanFirst');

      $(response[0].data).each(function(i, v) { // indice, valor
          var div = document.createElement("a");
          div.setAttribute("class", "dropdown-item d-flex align-items-center");
          div.setAttribute("id", v.id);
          div.setAttribute("href", "/leidas/"+v.id);

          var p = document.createElement("p");
          p.textContent = v.data["Notificacion"];

          var date = new Date();
          var created_at = v.create_at;
          
          var span = document.createElement("span");
          span.setAttribute("class", "pull-right text-muted");
          span.textContent = created_at;

          spanFirst.append(div);
          div.append(p);
          p.append(span);
          var notificationsID = $('#notificationID').val();
          notificacions = notificationsID + ',' +  v.id;
          $('#notificationID').val(notificacions);
      });
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {})
    }, 10000);

  });
</script>



@endsection
        

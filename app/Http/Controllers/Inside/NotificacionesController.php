<?php

namespace App\Http\Controllers\Inside;

use Illuminate\Http\Request;

class NotificacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = auth()->user()->unreadNotifications()->count();
        $notifies = auth()->user()->unreadNotifications()->get();
        $ids = "";
        if($notifies != null){
            for($i = 0; $i < $count ; $i++){
                if($i == 0){
                    $ids = $notifies[$i]->id.',';
                }
                elseif($i == $count-1){
                    $ids = $ids.$notifies[$i]->id;
                }
                else{
                    $ids = $ids.$notifies[$i]->id.',';
                }
            }
        }
        $information = ([
            'count' => $count,
            'notifies' => $notifies,
            'ids' => $ids
        ]);
      
        return view('base.formnotificaciones', $information); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nNotificaciones = auth()->user()->unreadNotifications()->count();
        $dataNotification = auth()->user()->unreadNotifications()->get();
        $notifications = $dataNotification;
        $notificacionsID = $request->notificationsID;
        $explode = explode(",",$notificacionsID);
        
        foreach($dataNotification as $key=>$element){
            foreach($explode as $value){
                if($value == $element->id){
                    unset($notifications[$key]);
                }
            }
        }

        foreach($notifications as $element){
            $element->create_at = $element->created_at->diffForHumans();
        }

       

        $data = array([
            'count' => $nNotificaciones,
            'data' => $notifications
        ]);

    
        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function leidas($id = ''){
        if($id != ''){
            $datos = auth()->user()->unreadNotifications()->where('id', '=', $id)->first();
            if($datos != ''){
                $datos->markAsRead();
                return redirect()->back();
            }
        }
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back();    
     }
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

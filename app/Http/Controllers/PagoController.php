<?php

namespace App\Http\Controllers;

use App\pago;
use App\cronograma;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($i,$f)
    {
        $pagos = \DB::select("SELECT p.IDPrestamo as ID,concat_ws('',c.Nombre,c.Apellidos) as cliente,p.Monto as monto,
        DATE_FORMAT(p.fecha,'%d-%m-%Y') as fecha FROM pago p 
        JOIN cliente c ON c.IDCliente = p.IDCliente
        WHERE p.fecha BETWEEN '$i' and '$f'");
        return compact('pagos');
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
        $pago = new Pago();
        $pago->IDCliente    = $request->pago['cliente'];
        $pago->IDPrestamo   = $request->pago['prestamo'];
        $pago->fecha        = $request->pago['fecha'];
        $pago->Monto        = $request->pago['monto'];
        $ID                 = $request->pago['id'];
        $cronograma = new cronograma();
        $cronograma->where('IDCronograma',$ID)
                    ->update(['Estado' => 4]);
        $pago->save();            
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\pago  $pago
     * @return \Illuminate\Http\Response
     */
    public function show(pago $pago)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\pago  $pago
     * @return \Illuminate\Http\Response
     */
    public function edit(pago $pago)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\pago  $pago
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, pago $pago)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\pago  $pago
     * @return \Illuminate\Http\Response
     */
    public function destroy(pago $pago)
    {
        //
    }
}

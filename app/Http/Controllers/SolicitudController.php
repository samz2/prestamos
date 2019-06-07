<?php

namespace App\Http\Controllers;

use App\solicitud;
use App\cliente;
use Illuminate\Http\Request;

class SolicitudController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $solicitudes = \DB::select("SELECT s.IDSolicitud as ID, concat_ws(' ',s.Nombre,s.Apellidos) as nombres,
         s.Celular as celular,o.Descripcion as ocupacion,s.Ingresos as ingresos,
          s.MontoSolicitado as monto, s.Direccion as direccion,c.Trabajo as trabajo,
          c.numReferencia as referencia, DATE_FORMAT(s.created_at,'%d-%m-%Y') as fecha 
          FROM solicitud s 
          JOIN ocupacion o ON s.Ocupacion = o.IDOcupacion 
          JOIN cliente c ON s.Documento = c.DNI 
          WHERE s.Estado = 1 ORDER BY s.IDSolicitud asc");
        return compact('solicitudes'); 
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
        $dni                = $request->cliente['dni'];
        $solicitudPendiente = Solicitud::where('Documento',$dni)->where('Estado',1)->count();
        $solicitudAtendida  = Solicitud::where('Documento',$dni)->where('Estado','!=',1)->count();
        $objCliente         = Cliente::where('DNI',$dni)->count();
        if($solicitudPendiente == 0)
        {
            $solicitud  = new Solicitud();
            $solicitud->Documento       = $request->cliente['dni'];
            $solicitud->Nombre          = $request->cliente['nombre'];
            $solicitud->Apellidos       = $request->cliente['apellidos'];
            $solicitud->Celular         = $request->cliente['celular'];
            $solicitud->Ocupacion       = $request->cliente['ocupacion'];
            $solicitud->FechaNacimiento = $request->cliente['fecha'];
            $solicitud->Ingresos        = $request->cliente['ingreso'];
            $solicitud->MontoSolicitado = $request->cliente['monto'];
            $solicitud->Direccion       = $request->cliente['direccion'];
            $solicitud->save();
            if($objCliente == 0)
            {
                $cliente = new Cliente();
                $cliente->DNI                = $request->cliente['dni'];
                $cliente->Nombre             = $request->cliente['nombre'];
                $cliente->Apellidos          = $request->cliente['apellidos'];
                $cliente->FechaNacimiento    = $request->cliente['fecha'];
                $cliente->Direccion          = $request->cliente['direccion'];
                $cliente->Celular            = $request->cliente['celular'];
                $cliente->Ocupacion          = $request->cliente['ocupacion'];
                $cliente->Ingresos           = $request->cliente['ingreso'];
                $cliente->Trabajo            = $request->cliente['trabajo'];
                $cliente->NumReferencia      = $request->cliente['referencia'];
                $cliente->save();
                
            }
            $mensaje = "Solicitud Registrada con Exito";
        }else{
            $mensaje = "Usted cuenta con una solicitud pendiente";
        }
        if($solicitudAtendida > 0)
        {
            if($solicitudPendiente == 0)
            {
                $solicitud  = new Solicitud();
                $solicitud->Documento       = $request->cliente['dni'];
                $solicitud->Nombre          = $request->cliente['nombre'];
                $solicitud->Apellidos       = $request->cliente['apellidos'];
                $solicitud->Celular         = $request->cliente['celular'];
                $solicitud->Ocupacion       = $request->cliente['ocupacion'];
                $solicitud->FechaNacimiento = $request->cliente['fecha'];
                $solicitud->Ingresos        = $request->cliente['ingreso'];
                $solicitud->MontoSolicitado = $request->cliente['monto'];
                $solicitud->Direccion       = $request->cliente['direccion'];
                // $solicitud->save();
                $mensaje = "Solicitud Registrada con Exito";
            }
        }
        
        return $mensaje;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\solicitud  $solicitud
     * @return \Illuminate\Http\Response
     */
    public function show($dni)
    {
        $solicitud = \DB::select("SELECT MAX(s.IDSolicitud) as ID, concat_ws(' ',s.Nombre, s.Apellidos) as cliente,
         e.Descripcion as estado, DATE_FORMAT(s.created_at,'%d-%m-%Y') as fecha 
         FROM solicitud s JOIN estadosolicitud e WHERE Documento = '$dni'");
         foreach ($solicitud as $key) {
             $ID        = $key->ID;
             $cliente   = $key->cliente;
             $estado    = $key->estado;
             $fecha     = $key->fecha;
         }
         return compact('ID','cliente','estado','fecha');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\solicitud  $solicitud
     * @return \Illuminate\Http\Response
     */
    public function edit(solicitud $solicitud)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\solicitud  $solicitud
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, solicitud $solicitud)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\solicitud  $solicitud
     * @return \Illuminate\Http\Response
     */
    public function destroy(solicitud $solicitud)
    {
        
    }
    public function rechazarSolicitud($id,$motivo)
    {
        $solicitud = new Solicitud();
        $solicitud->where('IDSolicitud',$id)
                    ->update([
                        'Estado' => 3,
                        'Motivo' => $motivo,
                    ]);

        return 'OK';
    }
    public function getCliente($id)
    {
        $objCliente = \DB::select("SELECT s.Documento as IDCliente, 
        concat_ws(' ',s.Nombre,s.Apellidos) as cliente,
        s.MontoSolicitado as monto 
        FROM solicitud s WHERE s.IDSolicitud = $id");
        foreach ($objCliente as $key) {
            $IDCliente  = $key->IDCliente;
            $cliente    = $key->cliente;
            $monto      = $key->monto;
        }
        return compact('IDCliente','cliente','monto');
    }
}

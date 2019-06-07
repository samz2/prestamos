<?php

namespace App\Http\Controllers;

use App\cronograma;
use App\solicitud;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class CronogramaController extends Controller
{
    /**
     * Display a listing of the resource.
     *SELECT c.DNI as DNI,concat_ws(' ',c.Nombre,c.Apellidos) as nombres, 
     *DATE_FORMAT(date(p.Fecha), '%d-%m-%Y') as fecha,p.ValorPrestamo as prestamo, 
     *p.Interes as interes,COUNT(cr.Estado) as cuotas 
     *FROM prestamo p JOIN Cliente c ON p.Cliente = c.IDCliente 
     *JOIN cronograma cr on p.IDPrestamo = cr.IDPrestamo WHERE cr.Estado = 1 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\cronograma  $cronograma
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cronogramas = \DB::select("SELECT concat_ws(' ',cl.Nombre,cl.Apellidos) as nombres,
        DATE_FORMAT(c.Fecha,'%d-%m-%Y') as fecha,c.Monto as cuota,
        p.ValorPrestamo as capital,
        p.Interes as interes,
        p.TipoPeriodo as pr,
        e.Descripcion as Estado, g.Descripcion as EstadoGeneral
        FROM cronograma c
        JOIN estadopago e ON c.Estado = e.IDEstadoPago
        JOIN esadogeneral g ON c.EstadoGeneral=g.IDEstado
        JOIN prestamo p ON c.IDPrestamo=p.IDPrestamo
        JOIN cliente cl ON p.Cliente = cl.IDCliente
        WHERE c.IDPrestamo = $id order by IDCronograma asc");
        foreach ($cronogramas as $key) {
            $cliente    = $key->nombres;
            $estado     = $key->EstadoGeneral;
            $pr         = $key->pr;
        }
        $cuotas = count($cronogramas);
        $pdf = PDF::loadView('cronogramaCliente', compact('cronogramas','cuotas','cliente','estado','pr'));
        return $pdf->stream('Reporte.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\cronograma  $cronograma
     * @return \Illuminate\Http\Response
     */
    public function edit(cronograma $cronograma)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\cronograma  $cronograma
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, cronograma $cronograma)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\cronograma  $cronograma
     * @return \Illuminate\Http\Response
     */
    public function PDF($dni)
    {
        $solicitud = \DB::select("SELECT s.IDSolicitud,s.Documento, s.Nombre, s.Apellidos, s.Celular,
        o.Descripcion as Ocupacion, s.FechaNacimiento, s.Ingresos, 
        s.MontoSolicitado, s.Direccion, c.Trabajo,c.numReferencia 
        FROM solicitud s 
        JOIN cliente c on s.Documento=c.DNI 
        JOIN ocupacion o on s.Ocupacion = o.IDOcupacion
        WHERE s.Documento = '$dni' AND s.Estado = 1");
        foreach ($solicitud as $key) {
            $ID   =  $key->IDSolicitud;
            $Documento       = $key->Documento;
            $Nombre          = $key->Nombre;
            $Apellidos       = $key->Apellidos;
            $Celular         = $key->Celular;
            $FechaNacimiento = $key->FechaNacimiento;
            $Ingresos        = $key->Ingresos;
            $MontoSolicitado = $key->MontoSolicitado;
            $Direccion       = $key->Direccion;
            $Trabajo         = $key->Trabajo;
            $NumReferencia   = $key->numReferencia;
        }
        
        $pdf = PDF::loadView('solicitud',compact('ID','Documento','Nombre','Apellidos','Celular','FechaNacimiento','Ingresos','MontoSolicitado','Direccion','Trabajo','NumReferencia'));
        return $pdf->stream('solicitud.pdf');
    }
    public function destroy(cronograma $cronograma)
    {
        //
    }
    public function getCuota($id)
    {
        $objCuota = \DB::select("SELECT min(IDCronograma) as ID,Monto as monto FROM `cronograma` 
        where IDPrestamo = $id and (Estado = 1 or Estado = 3)");
        foreach ($objCuota as $key) {
            $IDCronograma = $key->ID;
            $cuota = $key->monto;
        }
        return compact('IDCronograma','cuota');
    }
}

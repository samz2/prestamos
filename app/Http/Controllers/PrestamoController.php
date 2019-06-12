<?php

namespace App\Http\Controllers;

use App\prestamo;
use App\cronograma;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;


class PrestamoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        if($id == 1)
        {
            $prestamos = \DB::select("SELECT p.IDPrestamo as ID,c.DNI as DNI,concat_ws(' ',c.Nombre,c.Apellidos) as nombres,
            DATE_FORMAT(date(p.Fecha), '%d-%m-%Y') as fecha,p.ValorPrestamo as prestamo, p.Interes as interes,
            COUNT(cr.Estado) as cuotas, cr.Monto as valorcuota,e.Descripcion as estado FROM prestamo p 
            JOIN Cliente c ON p.Cliente = c.IDCliente 
            JOIN cronograma cr on p. IDPrestamo = cr.IDPrestamo 
            JOIN esadogeneral e ON p.Estado = e.IDEstado
            WHERE cr.Estado = 1 GROUP by p.IDPrestamo");
        }
        else
        {
            $prestamos = \DB::select("SELECT p.IDPrestamo as ID,c.DNI as DNI,concat_ws(' ',c.Nombre,c.Apellidos) as nombres, 
            DATE_FORMAT(date(cr.Fecha), '%d-%m-%Y') as fecha,
            p.ValorPrestamo as prestamo, c.Direccion as direccion, 
            c.Celular as celular, p.Interes as interes, cr.Monto as valorcuota,
            e.Descripcion as estado 
            FROM prestamo p 
            JOIN cliente c ON p.Cliente = c.IDCliente 
            JOIN cronograma cr on p. IDPrestamo = cr.IDPrestamo 
            JOIN esadogeneral e ON p.Estado = e.IDEstado 
            WHERE cr.Estado = 1 AND cr.Fecha <= curdate()");
        }
        return compact('prestamos');
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($v,$i,$pr,$pe)
    {
        $Ti = $i*$v/100;
        $m  = $v + $Ti; 

        // return view('cronograma')->with('v',$v)->with('i',$i)->with('Ti',$Ti)->with('m',$m)->with('pe',$pe);
        $pdf = PDF::loadView('cronograma', compact('v','i','Ti','m','pe','pr'));
        return $pdf->stream('Reporte.pdf');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $objID = \DB::select("SELECT IFNULL(MAX(p.IDPrestamo),0) + 1 as ID FROM prestamo p");
        foreach ($objID as $key) {
            $ID = $key->ID;
        }
        $fecha = date('j-m-Y');
        $prestamo = new Prestamo();
        $prestamo->IDPrestamo       = $ID;
        $prestamo->Estado           = 1;
        $prestamo->Fecha            = $request->prestamo['fecha'];
        $prestamo->Cliente          = $request->prestamo['cliente'];
        $prestamo->ValorPrestamo    = $request->prestamo['valor'];
        $prestamo->ValorPrestado    = $request->prestamo['monto'];
        $prestamo->Interes          = $request->prestamo['interes'];
        $prestamo->TipoPeriodo      = $request->prestamo['periodicidad'];
        $prestamo->Periodo          = $request->prestamo['periodo'];
        $prestamo->save();
        //insertar cronograma de pagos
        $pr     = $request->prestamo['periodicidad'];
        $pe     = $request->prestamo['periodo'];
        $cuota  = $request->prestamo['monto']/$pe;
        for ($cont = 1; $cont <= $pe; $cont++)
        {
            if($pr == 1)        $nuevafecha = strtotime ( '+'.$cont .' day' , strtotime ( $fecha ) ) ;
            elseif ($pr == 2)   $nuevafecha = strtotime ( '+'.$cont .' week' , strtotime ( $fecha ) ) ;
            elseif ($pr == 3)   $nuevafecha = strtotime ( '+'.$cont .' month' , strtotime ( $fecha ) ) ;
            $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
            $cronograma = new Cronograma();
            $cronograma->IDPrestamo     = $ID;
            $cronograma->Fecha          = $nuevafecha;
            $cronograma->Monto          = $cuota;
            $cronograma->Estado         = 1;
            $cronograma->EstadoGeneral  = 1;
            $cronograma->save();
        }
        
        

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\prestamo  $prestamo
     * @return \Illuminate\Http\Response
     */
    public function show(prestamo $prestamo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\prestamo  $prestamo
     * @return \Illuminate\Http\Response
     */
    public function edit(prestamo $prestamo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\prestamo  $prestamo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, prestamo $prestamo)
    {
        //
    }

    public function getPrestamos($id)
    {
        $prestamos = \DB::select("SELECT IDPrestamo as ID,ValorPrestamo as valor FROM `prestamo` WHERE Cliente = $id ");
        return compact('prestamos');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\prestamo  $prestamo
     * @return \Illuminate\Http\Response
     */
    public function destroy(prestamo $prestamo)
    {
        //
    }

    public function datos()
    {
        $solicitudes = \DB::select("SELECT IFNULL(COUNT(s.IDSolicitud),0) as solicitudes 
        FROM solicitud s WHERE date(s.created_at) = curdate()");
        foreach ($solicitudes as $key) {
            $s = $key->solicitudes;
        }
        $clientes   = \DB::select("SELECT IFNULL(COUNT(c.IDCliente),0) as clientes from cliente c");
        foreach ($clientes as $key) {
            $c = $key->clientes;
        }


        return compact('s','c');
    }
}

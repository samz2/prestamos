<?php

namespace App\Http\Controllers;

use App\cliente;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = \DB::select("SELECT c.`IDCliente` as ID,concat_ws(' ',c.`Nombre`,c.`Apellidos`) as nombres, 
        c.`FechaNacimiento` as fecha, c.`DNI`,c.`Direccion`, c.`Celular`, 
        c.`Confianza`, c.`LimiteCredito`, o.Descripcion as Ocupacion, 
        c.`Ingresos`, c.`Trabajo`, c.`numReferencia` FROM cliente c 
        JOIN ocupacion o ON c.Ocupacion = o.IDOcupacion");
        return compact('clientes');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $clientes = \DB::select("SELECT c.`IDCliente` as ID,concat_ws(' ',c.`Nombre`,c.`Apellidos`) as nombres 
       FROM cliente c");

       return compact('clientes');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $cliente = new Cliente();
       $cliente->DNI                = $request->cliente['dni'];
       $cliente->Nombre             = $request->cliente['nombre'];
       $cliente->Apellidos          = $request->cliente['apellidos'];
       $cliente->FechaNacimiento    = $request->cliente['fecha'];
       $cliente->Direccion          = $request->cliente['direccion'];
       $cliente->Referidos          = $request->cliente['referido'];
       $cliente->Celular            = $request->cliente['celular'];
       $cliente->Confianza          = $request->cliente['confianza'];
       $cliente->Parentezco         = $request->cliente['parentezco'];
       $cliente->LimiteCredito      = $request->cliente['limite'];
       $cliente->Ocupacion          = $request->cliente['ocupacion'];
       $cliente->Ingresos           = $request->cliente['ingreso'];
       $cliente->Trabajo            = $request->cliente['trabajo'];
       $cliente->NumReferencia      = $request->cliente['referencia'];
       $cliente->save();
       return "ok";
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show($dni)
    {
        $client = new Client();
        if(strlen($dni)==8)
        {
            $res = $client->request('POST', 'http://aplicaciones007.jne.gob.pe/srop_publico/Consulta/Afiliado/GetNombresCiudadano?DNI='.$dni);
            $nombres = $res->getBody()->getContents();
            $body = explode('|',$nombres);
            return json_encode($body);
        }elseif (strlen($dni)==11) {
            $res = $client->request('POST', 'https://api.sunat.cloud/ruc/'.$dni,
            ['verify' => 'cacert.pem']
        );
            $nombres    = $res->getBody()->getContents();
            $res        = json_decode($nombres,true);
            $domicilio  = $res['domicilio_fiscal']; 
            $razon      = $res['razon_social'];
            return compact('domicilio','razon');
        }
        // return compact('json');
    }
    public function getConfianza($id)
    {
        $datos = \DB::select("SELECT c.Confianza,c.LimiteCredito FROM cliente c WHERE c.IDCliente = $id ");
        foreach ($datos as $key) {
            $confianza  = $key->Confianza;
            $limite     = $key->LimiteCredito;
        }
        return compact('confianza','limite');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(cliente $cliente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, cliente $cliente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $eliminar   =   Cliente::where('IDCliente',$id)->delete();
        if($eliminar){
            return "OK";
        }else{
            return "FAIL";
        }
    }
}

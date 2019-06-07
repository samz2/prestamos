<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!--link rel="stylesheet" href="{{ asset('css/app.css') }}"-->
    <title>Cronograma</title>
</head>
<body>
        <style>
            body{
            background-color:#FFFFFF;
            overflow:hidden;
            font-family: 'Raleway', sans-serif;
            }
            
            .main-wrap{
            padding:3%;
            max-width:1200px;
            display:block;
            margin: 10px auto;
            }
            .table.table-striped {
            width:100%;
                border-collapse: collapse;
                background: #fff;
                overflow: hidden;
                box-shadow: 0 0px 40px 0px rgba(0, 0, 0, 0.15);
                -moz-box-shadow: 0 0px 40px 0px rgba(0, 0, 0, 0.15);
                -webkit-box-shadow: 0 0px 40px 0px rgba(0, 0, 0, 0.15);
                -o-box-shadow: 0 0px 40px 0px rgba(0, 0, 0, 0.15);
                -ms-box-shadow: 0 0px 40px 0px rgba(0, 0, 0, 0.15);
            }
            .table.table-striped thead {
                background: #fff;
                box-shadow: 0 5px 20px 0px rgba(0, 0, 0, 0.1);
                -moz-box-shadow: 0 5px 20px 0px rgba(0, 0, 0, 0.1);
                -webkit-box-shadow: 0 5px 20px 0px rgba(0, 0, 0, 0.1);
                -o-box-shadow: 0 5px 20px 0px rgba(0, 0, 0, 0.1);
                -ms-box-shadow: 0 5px 20px 0px rgba(0, 0, 0, 0.1);
            }
            .table.table-striped th {
                padding: 0.9rem 0.5rem;
                font-weight: bold;
                border: 1px solid #efefef;
                text-align: left;
                border-top: 0px;
            }
            .table.table-striped tbody tr:nth-child(odd){
                background-color: rgba(0,0,0,.02);
            }
            .table.table-striped tbody tr td a {
                color: #3c2f17;
                font-size: 12px;
                text-decoration:none;
            font-weight:500;
            }
            .table.table-striped tr:nth-child(even) {
                background-color: #fff;
            }
            .table.table-striped tbody tr td {
                border: 1px solid #efefef;
                padding: 0.7rem;
                text-align: left;
                border-top: 0px;
            }
            .ftr{
                text-align: center;
                margin-top: 20px;
                font-weight: bold;
            }
            .ftr a{
                color: #fff;
            }
            .peque {
                font-size: 10px;
            }
        </style>
    @php
        foreach ($cronogramas as $key) {
            $fecha  =   $key->fecha;
        }
        // $fecha  = date('j-m-Y');
        $cont   = 1;
        $monto  = 0;
        $cuotas = 1;
        // var_dump($cronogramas);
    @endphp
    <center>
        <h1>Cronograma de Pagos</h1>
        <hr>
        <b>Ciente:</b> {{$cliente}} &nbsp;<b>Estado:</b> {{$estado}}
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <table class="table table-striped" style="font-size: 11px">
                    <tr>
                        <td style="text-align: center"><b>Nro. Cuota</b></td>
                        <td style="text-align: center"><b>Fecha</b></td>
                        <td style="text-align: center"><b>Capital</b></td>
                        <td style="text-align: center"><b>Interes</b></td>
                        <td style="text-align: center"><b>Monto de Cuota</b></td>
                        <td style="text-align: center"><b>Estado</b></td>
                    </tr>
                    @foreach($cronogramas as $key)
                    @php
                        if($pr == 1)        $nuevafecha = strtotime ( '+'.$cuotas .' day' , strtotime ( $fecha ) ) ;
                        elseif ($pr == 2)   $nuevafecha = strtotime ( '+'.$cuotas .' week' , strtotime ( $fecha ) ) ;
                        elseif ($pr == 3)   $nuevafecha = strtotime ( '+'.$cuotas .' month' , strtotime ( $fecha ) ) ;
                        $nuevafecha2 = date ( 'j-m-Y' , $nuevafecha );
                        if(date('w',strtotime($nuevafecha2)) == 0)
                        {
                            $nuevafecha3 = strtotime ( '+1' .' day' , strtotime ( $nuevafecha2 ) ) ;
                            $nuevafecha3 = date ( 'j-m-Y' , $nuevafecha3 );
                            $cuotas++;
                        }else{
                            $nuevafecha3 = $nuevafecha2;
                        }
                        $cuotas++;
                        $cont++;
                        $capital = $key->capital;
                        $interes = $key->interes;
                        $monto   += $key->cuota;
                    @endphp
                    <tr>
                        <td style="text-align: center">{{$cont}}</td>
                        <td style="text-align: center">{{$nuevafecha3}}</td>
                        <td style="text-align: right">{{ number_format($key->capital/$cuotas,2,'.',',')}}</td>
                        <td style="text-align: right">{{ number_format($key->interes/$cuotas,2,'.',',')}}</td>
                        <td style="text-align: right">{{ number_format($key->cuota,2,'.',',')}}</td>
                        <td style="text-align: center">{{$key->Estado}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="2" style="text-align: right"><b>Total</b></td>
                        <td style="text-align: right"><b>{{ number_format($capital,2,'.',',')}}</b></td>
                        <td style="text-align: right"><b>{{ number_format($interes,2,'.',',')}}</b></td>
                        <td style="text-align: right"><b>{{ number_format($monto,2,'.',',')}}</b></td>
                        <td>&nbsp;</td>
                    </tr>
                </table>    
            </div>
        </div>
    </center>
</body>
</html>
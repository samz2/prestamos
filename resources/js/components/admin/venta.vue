<template>
    <div class="content">
	    <div class="container-fluid">
			<div class="row" id="res">
			 <div class="col-md-12">
				<div class="card card-default">
	                <div class="card-header text-center">
	                    <h4 class="title">Reportes</h4>  
	                </div>
	                <div class="card-body">
                        <form @submit.prevent="registrar" method="POST">
	                        <div class="row">
                                <div class="col-md-3">&nbsp;</div>
								<div class="col-md-3">
	                                <div class="form-group">
	                                    <label>Inicio</label>
	                                    <input type="date" class="form-control" v-model="reporte.inicio">
	                                </div>
	                            </div>
                                <div class="col-md-3">
	                                <div class="form-group">
	                                    <label>Inicio</label>
	                                    <input type="date" class="form-control" v-model="reporte.fin" @change="getReportes()">
	                                </div>
	                            </div>
                                <div class="col-md-1"><router-link v-bind:to="'reporteexcel'" target="_blank"><img src="img/excIcon.png" height="40" width="40"></router-link></div>
	                        </div>    
                        </form>   
						<div class="content table-responsive table-full-width" style="font-size:12px;">
                            <v-client-table :data="reportes" :columns="columns" :options="options" >
							</v-client-table>
                        </div>
					</div>
	    		</div>
			 </div>
			</div>
	</div>
    </div>	
</template>

<script>
    export default {
    data() {
        return {
            
			reportes:[{
                fecha:null,
                cantidad:null,
                IATA:null,
                ruta:null,
                codReserva:null,
                cliente:null,
                pasajeros:null,
                formapago:null,
                estado:null,
                compra:null,
                venta:null,
                ganancia:null,
                montoSoles:null
			}],
            columns: ["fecha","cantidad","IATA","ruta","codReserva","cliente","pasajeros","formapago","estado","compra","venta","ganancia","montoSoles"],
            options: {
				headings:
				{
					fecha:"Fecha",
                    cantidad:"Cantidad",
                    IATA:"IATA",
                    ruta:"Ruta",
                    codReserva:"Cod. Reserva",
                    cliente:"Cliente",
                    pasajeros:"Pasajeros",
                    formapago:"Forma de pago",
                    estado:"Estado",
                    compra:"Compra",
                    venta:"Venta",
                    ganancia:"Ganancia",
                    montoSoles:"Cobrado"
				},
				sortable: ["fecha","cantidad","IATA","ruta","codReserva","cliente","pasajeros","formapago","estado","compra","venta","ganancia","montoSoles"],
				filterable: ["fecha","cantidad","IATA","ruta","codReserva","cliente","pasajeros","formapago","estado","compra","venta","ganancia","montoSoles"]
			},
			reporte:{
				inicio:null,
				fin:null,
			}
        }
	},
	created(){
	},
	
    methods: {
		getReportes()
        {
            var inicio = this.reporte.inicio;
            var fin    = this.reporte.fin;
            axios.get("getReporte/"+inicio+fin)
            .then(data=>
            {
                this.reportes = data.data.reporte;
                console.log(data);
            }
            ).catch(error=>{
                console.log(error);
            })
        },
    }
}

</script>

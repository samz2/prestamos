<template>
    <div class="content">
	    <div class="container-fluid">
			<div class="row">
			 <div class="col-md-12">
				<div class="card card-default" id="lista">
	                <div class="card-header text-center" style="background-color: #7DCAE7;color: white">
	                    <h4 class="title">Lista de Solicitudes</h4>  
	                </div>
	                <div class="card-body">
						<div class="content table-responsive table-full-width" style="font-size:12px">
                            <v-client-table :data="solicitudes" :columns="columns" :options="options">
								<div slot="Acciones" slot-scope="props">
									<div class="row">
										<a @click="atender(props.row.ID)" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Atender"><i class="fa fa-check" style="color:white"></i></a>
										<a @click="rechazar(props.row.ID)" class="btn btn-danger" data-toggle="tooltip" data-placement="left" title="Rechazar"><i class="fa fa-times" style="color:white"></i></a>
									</div>
								</div>
                            </v-client-table>
                        </div>
					</div>
	    		</div>
				<div class="card card-default" id="pres">
	                <div class="card-header text-center">
	                    <h4 class="title">Prestamos</h4>  
	                </div>
	                <div class="card-body">
	                    <form @submit.prevent="registrar" method="POST">
	                        <div class="row">
								<div class="col-md-5">
	                                <div class="form-group">
	                                    <label>Cliente <small style="color: red">(*)</small></label>
	                                    <input type="text" class="form-control" v-model="prestamo.cliente" readonly>
	                                </div>
	                            </div>
								<div class="col-md-2">
	                                <div class="form-group">
	                                    <label>Fecha<small style="color: red">(*)</small></label>
	                                    <input type="date" v-model="prestamo.fecha" class="form-control">
	                                </div>
	                            </div>
                                <div class="col-md-3" >
	                                <div class="form-group">
	                                    <label>Valor de Préstamo<small style="color: red">(*)</small></label>
	                                    <input type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57'
										v-model="prestamo.valor" class="form-control"   maxlength="10">
	                                </div>
	                            </div>
							</div>
							<div class="row">
								<div class="col-md-3">
	                                <div class="form-group">
	                                    <label>Interés<small style="color: red">(*)</small></label>
	                                    <input type="number" min="10" max="100" value="10" 
										v-model="prestamo.interes" class="form-control">
	                                </div>
	                            </div>
								<div class="col-md-2">
	                                <div class="form-group">
	                                    <label>Periodicidad<small style="color: red">(*)</small></label>
	                                    <select class="form-control" v-model="prestamo.periodicidad">
                                            <option value="1">Diario</option>
                                            <option value="2">Semanal</option>
                                            <option value="3">Mensual</option>
                                        </select>
	                                </div>
	                            </div>
                                <div class="col-md-2">
	                                <div class="form-group">
	                                    <label>Periodo<small style="color: red">(*)</small></label>
	                                    <input type="text" @keyup="calcular()" onkeypress='return event.charCode >= 48 && event.charCode <= 57'
										v-model="prestamo.periodo" class="form-control"   maxlength="3">
	                                </div>
	                            </div>
                                <div class="col-md-3">
	                                <div class="form-group">
	                                    <label>Monto a Pagar<small style="color: red">(*)</small></label>
	                                    <input type="text" readonly
										v-model="prestamo.monto" class="form-control"   maxlength="3">
	                                </div>
	                            </div>
                                <div class="col-md-2">
	                                <div class="form-group">
	                                    <label>Cuota<small style="color: red">(*)</small></label>
	                                    <input type="text" readonly
										v-model="prestamo.cuota" class="form-control" maxlength="3">
	                                </div>
	                            </div>
							</div>	
							<div class="row text-left">
                                <div class="col-md-2">
									<input type="submit" value="Prestar" class="btn btn-success">
								</div>
							<!-- </div> -->
							<!-- <div class="row text-left"> -->
								<div class="col-md-2">
									<button value="Prestar" class="btn btn-danger" @click="cancelar">
										cancelar
									</button>	
								</div>
							</div>
							<div class="clearfix"></div>
	                    </form>
							
                        <br>
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
			solicitudes:[{
				ID:null,
                nombres:null,
				celular:null,
				ocupacion:null,
				ingresos:null,
				monto:null,
				direccion:null,
				trabajo:null,
				referencia:null,
				fecha:null,
			}],
			prestamo: {
				IDCliente:null,
				cliente:null,
				fecha:null,
				confianza:null,
				limite:null,
				valor:null,
				interes:20,
				periodicidad:null,
                periodo:null,
                monto:null,
			},
            columns: ["nombres","celular","ocupacion","ingresos","monto","direccion","trabajo","referencia","fecha","Acciones"],
            options: {
				headings:
				{
					ID:"ID",
                    nombres:"Nombres",
                    celular:"Celular",
                    ocupacion:"Ocupación",
                    ingresos:"Ingresos",
                    monto:"Monto",
					direccion:"Direccion",
					trabajo:"Trabajo",
					referencia:"Referencia",
                    fecha:"Fecha Solicitud",
				},
				sortable: ["nombres","celular","ocupacion","ingresos","monto","direccion","trabajo","referencia","fecha"],
				filterable: ["nombres","celular","ocupacion","ingresos","monto","direccion","trabajo","referencia","fecha"]
			},
        }
	},
	created(){
        this.getDatos();
	},
	mounted(){
		$("#pres").hide();
	},
    methods: {
		getDatos()
        {
            axios.get("getSolicitudes")
            .then(data=>
            {
                this.solicitudes = data.data.solicitudes;
                console.log(data.data);
            }
            ).catch(error=>{
                console.log(error);
            })
		},
		atender(id)
		{
			$("#pres").show();
			$("#lista").hide();
			axios.get("getCliente/"+id).then(data=>
			{
				this.prestamo.IDCliente = data.data.IDCliente;
				this.prestamo.cliente	= data.data.cliente;
				this.prestamo.valor		= data.data.monto;
			}
			).catch(error=>
			{
				console.log(error);
			});
		},
		rechazar(id)
        {
			this.$Progress.start();
            swal({
                title: 'Rechazar esta solicitud',
				type: 'warning',
				text: 'Ingrese motivo de rechazo',
				input: 'text',
				inputAttributes: {
					autocapitalize: 'off'
				},
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
				confirmButtonText: 'Si',
				cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.value) {
                    axios.get(`/rechazarSolicitud/${id}/${result.value}`)
                        .then(data => {
						this.$Progress.finish();
						if(data.data=="OK"){
                            swal(
                            'Rechazado!',
                             'La solicitud se rechazo con exito.',
                             'success'
                                );
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        }
                        }).catch(error => {
                            console.log('Ocurrio un error ' + error);
                            this.$Progress.fail();
                        });
                     }
                });
		},
		cancelar(){
			setTimeout(() => {
				location.reload();
			}, 1500);
		},
		calcular(){
            this.prestamo.monto = (this.prestamo.valor * (1 + this.prestamo.interes))/100;
            this.prestamo.cuota = this.prestamo.monto / this.prestamo.periodo; 
        },
	}
}
</script>

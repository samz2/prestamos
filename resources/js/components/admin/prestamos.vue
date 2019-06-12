<template>
    <div class="content">
	    <div class="container-fluid">
	    	<div class="row">
			 <div class="col-md-12">
	            <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <button  class="btn btn-outline-primary" @click="ocultar('1')">
                            Prestamos <i class="fa fa-plus"></i>
                            </button>
                            <button  class="btn btn-outline-primary" @click="ocultar('2')">
                                <i class="fa fa-minus"></i>
                            </button>
							<button  class="btn btn-outline-success" @click="getDatos('1')">
                            General    <i class="fa fa-list"></i>
                            </button>
							<button  class="btn btn-outline-success" @click="getDatos('2')">
                            Al día    <i class="fa fa-calendar"></i>
                            </button>
                        </div>
                    </div>
                </div>
	            <div class="card card-default" id="cliente">
	                <div class="card-header text-center" style="background-color: #7DCAE7;color: white">
	                    <h4 class="title">Prestamos</h4>  
	                </div>
	                <div class="card-body">
	                    <!-- <form @submit.prevent="registrar" method="POST"> -->
	                        <div class="row">
								<div class="col-md-3">
	                                <div class="form-group">
	                                    <label>Cliente <small style="color: red">(*)</small></label>
	                                    <select class="form-control" v-model="prestamo.cliente" @change="getConfianza()">
                                            <option v-for="c in clientes" :key="c.ID" :value="c.ID">
												{{ c.nombres }}
											</option>
                                        </select>
	                                </div>
	                            </div>
								<div class="col-md-2">
	                                <div class="form-group">
	                                    <label>Fecha<small style="color: red">(*)</small></label>
	                                    <input type="date" v-model="prestamo.fecha" class="form-control">
	                                </div>
	                            </div>
								<div class="col-md-2">
	                                <div class="form-group">
	                                    <label>Confianza<small style="color: red">(*)</small></label>
	                                     <input type="text" readonly
										v-model="prestamo.confianza" class="form-control">
	                                </div>
	                            </div>
                                <div class="col-md-2">
	                                <div class="form-group">
	                                    <label>Limite de crédito<small style="color: red">(*)</small></label>
	                                    <input type="text" readonly
										v-model="prestamo.limite" class="form-control">
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
	                                    <input type="text" @keypress="calcular()" onkeypress='return event.charCode >= 48 && event.charCode <= 57'
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
                                <div class="col-md-2 mt-2">
									<button @click="registrar()" class="btn btn-outline-success">Prestar <i class="fa fa-dollar"></i></button>
								</div>
								<div class="col-md-2">
									<router-link :to=" '/cronograma/' + this.prestamo.valor + '/' +this.prestamo.interes + '/' + this.prestamo.periodicidad + '/' + this.prestamo.periodo" 
									class="nav-link" target="_blank">
									<button  class="btn btn-outline-primary">
										Generar Cronograma <i class="fa fa-align-justify"></i>
									</button>
									</router-link>
								</div>
							</div>
	                </div>
				</div>
			</div>
	    	</div>
			<div class="row">
			 <div class="col-md-12">
				<div class="card card-default">
	                <div class="card-header text-center" style="background-color: #7DCAE7;color: white">
	                    <h4 class="title">Lista de Prestamos</h4>  
	                </div>
	                <div class="card-body" id="general">
						<div class="content table-responsive table-full-width" style="font-size:12px" >
                            <v-client-table :data="prestamos" :columns="columns" :options="options">
								<div slot="Acciones" slot-scope="props">
								<router-link :to="'/verReporte/' + props.row.ID" class="btn btn-primary" target="_blank" data-toggle="tooltip" data-placement="left" title="Cronograma"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></router-link>
                                </div>
                            </v-client-table>
                        </div>
					</div>
					<div class="card-body" id="aldia">
						<div class="content table-responsive table-full-width" style="font-size:12px" >
                            <v-client-table :data="prestamosaldia" :columns="columnsaldia" :options="optionsaldia">
								<div slot="Acciones" slot-scope="props">
								<router-link :to="'/verReporte/' + props.row.ID" class="btn btn-primary" target="_blank" data-toggle="tooltip" data-placement="left" title="Cronograma"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></router-link>
                                </div>
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
            prestamo: {
				cliente:null,
				fecha:null,
				confianza:null,
				limite:null,
				valor:null,
				interes:10,
				periodicidad:null,
                periodo:null,
                monto:null,
			},
			prestamos:[{
				ID:null,
                DNI:null,
                nombres:null,
				fecha:null,
				prestamo:null,
				interes:null,
				cuotas:null,
				valorcuota:null,
				estado:null,
            }],
            columns: ["DNI","nombres","fecha","prestamo","interes","cuotas","valorcuota","estado","Acciones"],
            options: {
				headings:
				{
					nombres:"Nombres",
					fecha:"Fecha",
					DNI:"DNI",
					prestamo:"Prestamo",
					interes:"Interes",
					cuotas:"Cuotas",
					valorcuota:"Monto Cuota",
					estado:"Estado",
				},
				sortable: ["DNI","nombres","fecha","prestamo","interes","cuotas","valorcuota","estado"],
				filterable: ["DNI","nombres","fecha","prestamo","interes","cuotas","valorcuota","estado"]
			},
			prestamosaldia:[{
				ID:null,
                DNI:null,
                nombres:null,
				fecha:null,
				prestamo:null,
				direccion:null,
				celular:null,
				valorcuota:null,
				estado:null,
            }],
            columnsaldia: ["DNI","nombres","fecha","prestamo","direccion","celular","valorcuota","estado","Acciones"],
            optionsaldia: {
				headings:
				{
					nombres:"Nombres",
					fecha:"Fecha",
					DNI:"DNI",
					prestamo:"Prestamo",
					direccion:"Direccion",
					celular:"Celular",
					valorcuota:"Monto Cuota",
					estado:"Estado",
				},
				sortable: ["DNI","nombres","fecha","prestamo","interes","cuotas","valorcuota","estado"],
				filterable: ["DNI","nombres","fecha","prestamo","interes","cuotas","valorcuota","estado"]
			},
            clientes:[],
        }
	},
	created(){
        this.getDatos();
        this.getCliente();
	},
	mounted(){
		$('#cliente').hide();
	},
    methods: {
		getDatos(id)
        {
			// setTimeout(() => {
			// 		location.reload();
			// 	}, 100);
			if(id == null)
			{
				id = 1; 
			}
			
	        axios.get("getPrestamosGeneral/" + id)
            .then(data=>
            {
				if(id == 1)
				{
					this.prestamos = data.data.prestamos;
					$("#aldia").hide();
					$("#general").show();	
				}else{
					this.prestamosaldia = data.data.prestamos;
					$("#general").hide();
					$("#aldia").show();
				}
                
                console.log(data.data);
            }
            ).catch(error=>{
                console.log(error);
            })
        },
        getCliente()
        {
            axios.get("getCliente")
            .then(data=>
            {
                this.clientes = data.data.clientes;
                console.log(this.clientes);
            }
            ).catch(error=>{
                console.log(error);
            })
        },
        registrar()
		{
			axios.post("addPrestamo",{
				prestamo:this.prestamo
			}).then(data=>{
				console.log(data);
				this.getDatos();
				swal({
					position: 'top-end',
					type: 'success',
					title: 'Datos ingresados correctamente',
					showConfirmButton: false,
					timer: 2000
				});
				// setTimeout(() => {
				// 	location.reload();
				// }, 1500);
			}).catch(error=>{
				console.log(error);	
				swal({
					type: 'error',
					title: 'Error',
					text: 'Verifique los campos los campos obligatorios',
					showConfirmButton: true,
				});
			})
		},
		ocultar(id){
			if(id == '1')
			{
				$('#cliente').show();
			}
			else if(id == '2')
			{
				$('#cliente').hide();	
			}
			
        },
        calcular(){
            this.prestamo.monto = (this.prestamo.valor * (1 + this.prestamo.interes))/100;
            this.prestamo.cuota = this.prestamo.monto / this.prestamo.periodo; 
        },
		deleteCliente(id)
        {
            swal({
                title: '¿Deseas eliminar este Proceso?',
                text: "No será posible revertir esta acción!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, elíminalo!',
                cancelButtonText: 'No, cancelar!',
            }).then((result) => {
                if (result.value) {
                    axios.get(`/deleteCliente/${id}`)
                        .then(data => {
                        if(data.data=="OK"){
                            swal(
                            'Eliminado!',
                             'El Proceso ha sido eliminado.',
                             'success'
                                );
                            setTimeout(() => {
                                location.reload();
                                this.getData();
                            }, 1500);
                        }
                        }).catch(error => {
                            console.log('Ocurrio un error ' + error);
                            this.$Progress.fail();
                        });
                     }
                });
		},
		getConfianza()
        {
			var id = this.prestamo.cliente;
            axios.get("getConfianza/"+id)
            .then(data=>
            {
				this.prestamo.confianza = data.data.confianza;
				this.prestamo.limite	= data.data.limite;
                console.log(data.data);
            }
            ).catch(error=>{
                console.log(error);
            })
        },
    }
}

</script>

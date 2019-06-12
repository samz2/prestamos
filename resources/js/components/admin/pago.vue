<template>
    <div class="content">
	    <div class="container-fluid">
	    	<div class="row">
			 <div class="col-md-12">
	            <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <button  class="btn btn-outline-primary" @click="ocultar('1')">
                            Pagos <i class="fa fa-plus"></i>
                            </button>
                            <button  class="btn btn-outline-primary" @click="ocultar('2')">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                </div>
	            <div class="card card-default" id="cliente">
	                <div class="card-header text-center" style="background-color: #7DCAE7;color: white">
	                    <h4 class="title">Pagos</h4>  
	                </div>
	                <div class="card-body">
						
	                    <form @submit.prevent="registrar" method="POST">
	                        <div class="row">
								<div class="col-md-3">
	                                <div class="form-group">
	                                    <label>Cliente <small style="color: red">(*)</small></label>
	                                    <select class="form-control" v-model="pago.cliente" @change="getPrestamos()">
                                            <option v-for="c in clientes" :key="c.ID" :value="c.ID">
												{{ c.nombres }}
											</option>
                                        </select>
	                                </div>
	                            </div>
                                <div class="col-md-2">
	                                <div class="form-group">
	                                    <label>Préstamo<small style="color: red">(*)</small></label>
	                                    <select class="form-control" v-model="pago.prestamo" @change="getDatos()">
                                            <option v-for="c in prestamos" :key="c.ID" :value="c.ID">
												{{ c.valor }}
											</option>
                                        </select>
	                                </div>
	                            </div>
                                <!-- <div class="col-md-2" >
	                                <div class="form-group">
	                                    <label>N° de cuota<small style="color: red">(*)</small></label>
	                                    <input type="text" readonly
										v-model="prestamo.valor" class="form-control"   maxlength="10">
	                                </div>
	                            </div> -->
                                <div class="col-md-2">
	                                <div class="form-group">
	                                    <label>Cuota<small style="color: red">(*)</small></label>
	                                    <input type="text" readonly 
										v-model="pago.cuota" class="form-control">
	                                </div>
	                            </div>
                                <div class="col-md-2">
	                                <div class="form-group">
	                                    <label>Monto a Pagar<small style="color: red">(*)</small></label>
	                                    <input type="text"
										v-model="pago.monto" class="form-control"   maxlength="3">
	                                </div>
	                            </div>
                                <div class="col-md-2">
	                                <div class="form-group">
	                                    <label>Fecha<small style="color: red">(*)</small></label>
	                                    <input type="date"
										v-model="pago.fecha" class="form-control"   maxlength="3">
	                                </div>
	                            </div>
							</div>
							<div class="row text-left">
                                <div class="col-md-2">
									<input type="submit" value="Prestar" class="btn btn-success">
								</div>
							</div>
							<div class="clearfix"></div>
	                    </form>
	                </div>
				</div>
			</div>
            
	    	</div>
            <div class="row">
			 <div class="col-md-12">
				<div class="card card-default">
	                <div class="card-header text-center" style="background-color: #7DCAE7;color: white">
	                    <h4 class="title">Buscar Pagos</h4>  
	                </div>
	                <div class="card-body">
						<div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Inicio</label>
                                    <input type="date" class="form-control" v-model="inicio">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Final</label>
                                    <input type="date" class="form-control" v-model="final" @change="getPagos()">
                                </div>
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
	                    <h4 class="title">Lista de Pagos</h4>  
	                </div>
	                <div class="card-body">
						<div class="content table-responsive table-full-width" style="font-size:12px">
                            <v-client-table :data="pagos" :columns="columns" :options="options">
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
            pago: {
                id:null,
				cliente:null,
				fecha:null,
				prestamo:null,
				cuota:null,
				monto:null,
			},
			pagos:[{
				ID:null,
                cliente:null,
                monto:null,
				fecha:null,
            }],
            columns: ["cliente","monto","fecha","Acciones"],
            options: {
				headings:
				{
					cliente:"Cliente",
					monto:"Monto",
					fecha:"Fecha",
				},
				sortable: ["cliente","monto","fecha"],
				filterable: ["cliente","monto","fecha"]
            },
            inicio:null,
            final:null,
            clientes:[],
            prestamos:[],
        }
	},
	created(){
        // this.getPagos();
        this.getCliente();
	},
	mounted(){
		$('#cliente').hide();
	},
    methods: {
		getDatos()
        {
            var id = this.pago.prestamo;
            axios.get("getCuota/"+id)
            .then(data=>
            {
                this.pago.cuota = data.data.cuota;
                this.pago.id    = data.data.IDCronograma;
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
			axios.post("addPago",{
				pago:this.pago
			}).then(data=>{
				console.log(data);
				swal({
					position: 'top-end',
					type: 'success',
					title: 'Datos ingresados correctamente',
					showConfirmButton: true,
					// timer: 2000
				});
				setTimeout(() => {
					location.reload();
				}, 1500);
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
		getPrestamos()
        {
			var id = this.pago.cliente;
            axios.get("getPrestamos/"+id)
            .then(data=>
            {
				this.prestamos = data.data.prestamos;
                console.log(data.data);
            }
            ).catch(error=>{
                console.log(error);
            })
        },
        getPagos()
        {
            var i = this.inicio;
            var f = this.final;
            axios.get("getPagos/"+i+"/"+f)
            .then(data=>
            {
				this.pagos = data.data.pagos;
                console.log(data.data);
            }
            ).catch(error=>{
                console.log(error);
            })
        },
    }
}

</script>

<template>
    <div class="content">
	    <div class="container-fluid">
	    	<div class="row">
			 <div class="col-md-12">
	            <div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<button  class="btn btn-outline-primary" @click="ocultar('1')">
							Clientes <i class="fa fa-plus"></i>
							</button>
							<button  class="btn btn-outline-primary" @click="ocultar('2')">
								<i class="fa fa-minus"></i>
							</button>
						</div>
					</div>
				</div>
	            <div class="card card-default" id="cliente">
	                <div class="card-header text-center" style="background-color: #7DCAE7;color: white">
	                    <h4 class="title">Clientes</h4>  
	                </div>
	                <div class="card-body" >
							<div class="row">
								<div class="col-md-3">
	                                <div class="form-group">
	                                    <label>Documento(*)</label>
	                                    <input type="text" @keyup="buscar()" onkeypress='return event.charCode >= 48 && event.charCode <= 57' 
										v-model="cliente.dni" class="form-control"   maxlength="11">
	                                </div>
	                            </div>
								<!-- <div class="col-md-2">
									<input type="button" value="Buscar" @click="buscar()" class="btn btn-success">
								</div>
							<div class="clearfix"></div> -->
							</div>
						
	                    <form @submit.prevent="registrar" method="POST">
	                        <div class="row">
								<div class="col-md-5">
	                                <div class="form-group" id="nom">
	                                    <label>Nombres <small style="color: red">(*)</small></label>
	                                    <input type="text" v-model="cliente.nombre" readonly class="form-control"  maxlength="30">
	                                </div>
	                            </div>
								<div class="col-md-6" id="ape">
	                                <div class="form-group">
	                                    <label>Apellidos <small style="color: red">(*)</small></label>
	                                    <input type="text" v-model="cliente.apellidos" readonly class="form-control"  maxlength="60">
	                                </div>
	                            </div>
								<div class="col-md-12" id="rs">
	                                <div class="form-group">
	                                    <label>Razon Social <small style="color: red">(*)</small></label>
	                                    <input type="text" v-model="cliente.nombre" readonly class="form-control"  maxlength="30">
	                                </div>
	                            </div>
							</div>
							<div class="row">
	                            <div class="col-md-3">
	                                <div class="form-group">
	                                    <label>Celular(*)</label>
	                                    <input type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57'
										v-model="cliente.celular" class="form-control"   maxlength="10">
	                                </div>
	                            </div>
								<div class="col-md-3" >
	                                <div class="form-group">
	                                    <label>Ocupación</label>
	                                    <select v-model="cliente.ocupacion" class="form-control">
											<option value="1">Estudiante</option>
											<option value="2">Profesional</option>	
											<option value="3">Ama de Casa</option>
											<option value="4">Negocio Propio</option>		
										</select>
	                                </div>
	                            </div>	
								<div class="col-md-3">
	                                <div class="form-group">
	                                    <label>Confianza</label>
	                                    <input type="text" onkeypress='return filterFloat(event,this)' 
										v-model="cliente.confianza" class="form-control"  maxlength="2">
	                                </div>
	                            </div>
								<div class="col-md-3">
	                                <div class="form-group">
	                                    <label>Fecha de Nacimiento(*)</label>
	                                    <input type="date"  
										v-model="cliente.fecha" class="form-control" max="2018-12-31">
	                                </div>
	                            </div>
							</div>	
							<div class="row">
	                            <div class="col-md-3">
	                                <div class="form-group">
	                                    <label>Ingresos Mensuales</label>
	                                    <input type="text" onkeypress='return filterFloat(event,this)'
										v-model="cliente.ingreso" class="form-control"   maxlength="10">
	                                </div>
	                            </div>
								<div class="col-md-3">
	                                <div class="form-group">
	                                    <label>Limite</label>
	                                    <input type="text" onkeypress='return filterFloat(event,this)'
										v-model="cliente.limite" class="form-control"   maxlength="10">
	                                </div>
	                            </div>
								<div class="col-md-3" >
	                                <div class="form-group">
	                                    <label>Referido</label>
	                                    <select v-model="cliente.referido" class="form-control">
											<option value="1" class="form-control">Estudiante</option>
											<option value="2" class="form-control">Profesional</option>	
											<option value="3" class="form-control">Ama de Casa</option>
											<option value="4" class="form-control">Negocio Propio</option>		
										</select>
	                                </div>
	                            </div>
								<div class="col-md-3" >
	                                <div class="form-group">
	                                    <label>Parentesco</label>
	                                    <select v-model="cliente.parentezco" class="form-control">
											<option value="1">Mamá</option>
											<option value="2">Papá</option>	
											<option value="3">Tio</option>
											<option value="4">Tía</option>		
										</select>
	                                </div>
	                            </div>
								
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label >Dirección(*)</label>
										<textarea type="text" v-model="cliente.direccion" class="form-control" maxlength="200">
										</textarea>	
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label >Trabajo(*)</label>
										<input type="text" v-model="cliente.trabajo" class="form-control" maxlength="100">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label >Número de Referencia(*)</label>
										<input type="text" v-model="cliente.referencia" class="form-control" maxlength="10">
									</div>
								</div>
							</div>
							<div class="row text-left">
								<div class="col-md-2">
									<input type="submit" value="Agregar" class="btn btn-success">
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
	                    <h4 class="title">Lista de Clientes</h4>  
	                </div>
	                <div class="card-body">
						<div class="content table-responsive table-full-width">
                            <v-client-table :data="clientes" :columns="columns" :options="options">
								<div slot="Acciones" slot-scope="props">
								<button class="btn btn-danger" data-toggle="tooltip" v-on:click="deleteCliente(props.row.ID)" data-placement="left" title="Eliminar"><i class="fa fa-trash" aria-hidden="true"></i></button>
								<button class="btn btn-info" data-toggle="tooltip" v-on:click="editObjetivo(props.row.ID)" data-placement="left" title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></button>
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
            cliente: {
				dni:null,
				nombre:null,
				apellidos:null,
				fecha:null,
				direccion:null,
				referido:null,
				celular:null,
				confianza:null,
				parentezco:null,
				limite:null,
				ocupacion:null,
				ingreso:null,
				trabajo:null,
				referencia:null,
			},
			clientes:[{
				ID:null,
                nombres:null,
                fecha:null,
				dni:null,
				Direccion:null,
				Celular:null,
				Confianza:null,
				LimiteCredito:null,
				Ocupacion:null,
				Ingresos:null,
				Trabajo:null,
				numReferencia:null,
            }],
            columns: ["DNI","nombres","fecha","Direccion","Celular","Confianza","LimiteCredito","Ocupacion","Ingresos","Trabajo","numReferencia","Acciones"],
            options: {
				headings:
				{
					nombres:"Nombres",
					fecha:"Fecha Nacimiento",
					DNI:"DNI",
					Direccion:"Direccion",
					Celular:"Celular",
					Confianza:"Confianza",
					LimiteCredito:"Limite de Crédito",
					Ocupacion:"Ocupación",
					Ingresos:"Ingresos",
					Trabajo:"Trabajo",
					numReferencia:"Referencia",
				},
				sortable: ["dni","nombres","fecha","Direccion","Celular","Confianza","LimiteCredito","Ocupacion","Ingresos","Trabajo","numReferencia"],
				filterable: ["dni","nombres","fecha","Direccion","Celular","Confianza","LimiteCredito","Ocupacion","Ingresos","Trabajo","numReferencia"]
			},
			nombres:[],
			temp:{}

        }
	},
	created(){
		this.getDatos();
	},
	mounted(){
		$('#cliente').hide();
		$('#rs').hide();
	},
    methods: {
		getDatos()
        {
            axios.get("getClientes")
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
			axios.post("addCliente",{
				cliente:this.cliente
			}).then(data=>{
				console.log(data);
				swal({
					position: 'top-end',
					type: 'success',
					title: 'Datos ingresados correctamente',
					showConfirmButton: false,
					timer: 2000
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
		buscar()
		{
			axios.get("getNombres/"+this.cliente.dni)
            .then(data=>
            {
				console.log( data.data);
				if(this.cliente.dni.length == 11)
				{
					this.cliente.nombre		= data.data.razon;
					this.cliente.apellidos  = null;
					this.cliente.direccion 	= data.data.domicilio;
					$('#rs').show();
					$('#ape').hide();
					$('#nom').hide();
				}else if(this.cliente.dni.length == 8){
					this.nombres = data.data;
					this.cliente.nombre   	= this.nombres[2];
					this.cliente.apellidos	= this.nombres[0] + " "+this.nombres[1];
					this.cliente.direccion 	= null;
					$('#rs').hide();
					$('#ape').show();
					$('#nom').show();
				}else{
					this.cliente.nombre 	= null;
					this.cliente.apellidos 	= null;
				}
				// this.nombres = data.data;
				// this.cliente.nombre    = this.nombres[2];
				// this.cliente.apellidos = this.nombres[0] + " "+this.nombres[1];
				
            }
            ).catch(error=>{
                console.log(error);
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
                title: '¿Deseas eliminar este Cliente?',
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
    }
}

</script>

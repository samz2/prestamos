<template>
    <div class="content">
	    <div class="container-fluid">
	    	<div class="row">
			 <div class="col-md-8">
	            <div class="card card-default">
	                <div class="card-header text-center" style="background-color: green;color: white">
	                    <h4 class="title">Solicitud de prestamo</h4>  
	                </div>
	                <div class="card-body">
                        <div class="form-group row">
                            <label for="nombre" class="col-md-4 col-form-label text-md-right">Documento <small style="color: red">(*)</small></label>
                            <div class="col-md-6">
                                <input type="text" @keyup="buscar()" onkeypress='return event.charCode >= 48 && event.charCode <= 57' 
										v-model="cliente.dni" class="form-control"   maxlength="11">
                            </div>
                        </div>
	                    <form @submit.prevent="registrar" method="POST">
                            <div class="form-group row" id="ape">
                                <label for="nombre" class="col-md-4 col-form-label text-md-right">Nombres <small style="color: red">(*)</small></label>
                                <div class="col-md-6">
                	                <input type="text" v-model="cliente.nombre" readonly class="form-control"  maxlength="30">
                                </div>
                            </div>
                            <div class="form-group row" id="ape">
                                <label for="nombre" class="col-md-4 col-form-label text-md-right">Apellidos <small style="color: red">(*)</small></label>
                                <div class="col-md-6">
                                    <input type="text" v-model="cliente.apellidos" readonly class="form-control"  maxlength="60">
                                </div>
                            </div>
                            <div class="form-group row" id="rs">
                                <label for="nombre" class="col-md-4 col-form-label text-md-right">Razon Social <small style="color: red">(*)</small></label>
                                <div class="col-md-6">
                	                <input type="text" v-model="cliente.nombre" readonly class="form-control"  maxlength="30">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nombre" class="col-md-4 col-form-label text-md-right">Celular <small style="color: red">(*)</small></label>
                                <div class="col-md-6">
                                    <input type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57'
										v-model="cliente.celular" class="form-control"   maxlength="10">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nombre" class="col-md-4 col-form-label text-md-right">Ocupacion <small style="color: red">(*)</small></label>
                                <div class="col-md-6">
                                    <select v-model="cliente.ocupacion" class="form-control">
											<option value="1">Estudiante</option>
											<option value="2">Profesional</option>	
											<option value="3">Ama de Casa</option>
											<option value="4">Negocio Propio</option>		
										</select>
                                </div>
                            </div>
							<div class="form-group row">
                                <label for="nombre" class="col-md-4 col-form-label text-md-right">Trabajo</label>
                                <div class="col-md-6">
                                    <input type="text"  
										v-model="cliente.trabajo" class="form-control" placeholder="Nombre de la institución donde labora o nombre de negocio">
                                </div>
                            </div>
							<div class="form-group row">
                                <label for="nombre" class="col-md-4 col-form-label text-md-right">N° Referencia (Trabajo)</label>
                                <div class="col-md-6">
                                    <input type="text"  
										v-model="cliente.referencia" class="form-control" onkeypress='return event.charCode >= 48 && event.charCode <= 57' 
										placeholder="Numero de referencia de la institución donde labora" maxlength="11">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nombre" class="col-md-4 col-form-label text-md-right">Fecha de Nacimiento <small style="color: red">(*)</small></label>
                                <div class="col-md-6">
                                    <input type="date"  
										v-model="cliente.fecha" class="form-control" max="2018-12-31">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nombre" class="col-md-4 col-form-label text-md-right">Ingresos Mensuales <small style="color: red">(*)</small></label>
                                <div class="col-md-6">
                                    <input type="text" onkeypress='return filterFloat(event,this)'
										v-model="cliente.ingreso" class="form-control"   maxlength="10">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nombre" class="col-md-4 col-form-label text-md-right">Monto Solicitado <small style="color: red">(*)</small></label>
                                <div class="col-md-6">
                                    <input type="text" onkeypress='return filterFloat(event,this)'
										v-model="cliente.monto" class="form-control"   maxlength="10">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nombre" class="col-md-4 col-form-label text-md-right">Dirección <small style="color: red">(*)</small></label>
                                <div class="col-md-6">
                                    <textarea type="text" v-model="cliente.direccion" class="form-control" maxlength="200">
										</textarea>
                                </div>
                            </div>
							<div class="row text-center" id="form">
								<div class="col-md-2">
									<input type="submit" value="Solicitar" class="btn btn-success">
								</div>
							</div>
							<div class="clearfix"></div>
	                    </form>
	                </div>
					<div class="card-body" id="pdf">
						<div class="row text-center">
							<div class="col-md-2">
								<router-link :to="'/getSolicitud/' + cliente.dni" class="btn btn-primary" target="_blank" data-toggle="tooltip" data-placement="left" title="Cronograma">
								<i class="fa fa-file-pdf-o" aria-hidden="true"></i>Imprimir
								</router-link>
							</div>
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
				celular:null,
				ocupacion:null,
				ingreso:null,
				monto:null,
				trabajo:null,
				referencia:null
			},
			nombres:[],
			temp:{}
        }
	},
	created(){
	},
	mounted(){
		$('#pdf').hide();
		$('#rs').hide();
	},
    methods: {
        registrar()
		{
			// $this.progress.start();
			axios.post("addSolicitud",{
				cliente:this.cliente
			}).then(data=>{
				console.log(data);
				swal({
					type: 'success',
					title: data.data,
					showConfirmButton: false,
					timer: 3000
				});
				// $this.progress.finish();
				$('#pdf').show();
				$('#form').hide();
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
            }
            ).catch(error=>{
                console.log(error);
            })
		},
		
    }
}
</script>

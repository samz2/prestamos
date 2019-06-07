<template>
    <div class="content">
	    <div class="container-fluid">
	    	<div class="row">
			 <div class="col-md-8">
	            <div class="card card-default">
	                <div class="card-header text-center" style="background-color: green;color: white">
	                    <h4 class="title">Buscar Solicitud</h4>  
	                </div>
	                <div class="card-body">
                        <div class="form-group row">
                            <label for="nombre" class="col-md-4 col-form-label text-md-right">Documento <small style="color: red">(*)</small></label>
                            <div class="col-md-6">
                                <input type="text" @keyup="buscar()" onkeypress='return event.charCode >= 48 && event.charCode <= 57' 
										v-model="cliente.dni" class="form-control"   maxlength="11">
                            </div>
                        </div>
						<div class="form-group row" id="ape">
							<label for="nombre" class="col-md-4 col-form-label text-md-right">Cliente</label>
							<div class="col-md-6">
								<input type="text" v-model="cliente.cliente" readonly class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<label for="nombre" class="col-md-4 col-form-label text-md-right">Estado</label>
							<div class="col-md-6">
								<input type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57'
									v-model="cliente.estado" class="form-control" readonly>
							</div>
						</div>
						<div class="form-group row">
							<label for="nombre" class="col-md-4 col-form-label text-md-right">Nro° de Solicitud</label>
							<div class="col-md-6">
								<input type="text" v-model="cliente.ID" class="form-control" readonly>
							</div>
						</div>
						<div class="form-group row">
							<label for="nombre" class="col-md-4 col-form-label text-md-right">Fecha de Solicitud</label>
							<div class="col-md-6">
								<input type="text" v-model="cliente.fecha" class="form-control" readonly>
							</div>
						</div>
						<div class="row text-center" id="pdf">
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
				cliente:null,
				estado:null,
				ID:null,
				fecha:null
			},
			nombres:[],
        }
	},
	created(){
		
	},
	mounted(){
		$("#pdf").hide();
	},
    methods: {
		buscar()
		{
			axios.get("getSolicitudC/"+this.cliente.dni)
            .then(data=>
            {
				console.log(data.data);
				if(this.cliente.dni.length == 8 || this.cliente.dni.length == 8)
				{
					this.cliente.cliente	= data.data.cliente;
					this.cliente.ID  		= data.data.ID;
					this.cliente.fecha 		= data.data.fecha;
					this.cliente.estado		= data.data.estado;
					if(this.cliente.estado == null)
					{
						$("#pdf").hide();
					}else{
						$("#pdf").show();
					}	
				}else{
					this.cliente.nombre 	= null;
					this.cliente.apellidos 	= null;
					this.cliente.ID			= null;
					this.cliente.estado		= null;
					this.cliente.cliente	= null;
					this.cliente.fecha 		= null;
					$("#pdf").hide();
				}
            }
            ).catch(error=>{
                console.log(error);
            })
		},
    }
}

</script>

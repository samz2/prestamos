<template>
    <div class="content">
	    <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua" style="background-color: #00c0ef; color: white">
                    <div class="inner">
                    <h3>{{solicitudes}}</h3>

                    <p>Solicitudes de hoy</p>
                    </div>
                    <div class="icon">
                    <i class="ion ion-bag"></i>
                    </div>
                    <router-link :to="'solicitudes'" class="small-box-footer">Ver Solicitudes<i class="fa fa-arrow-circle-right"></i></router-link>
                </div>
                </div>
                <!-- ./col -->
                <!-- <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-green" style="background-color: #00a65a;color: white">
                        <div class="inner">
                        <h3>53<sup style="font-size: 20px">%</sup></h3>

                        <p>Bounce Rate</p>
                        </div>
                        <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div> -->
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                <!-- small box #f39c12 -->
                <div class="small-box bg-yellow" style="background-color: #f39c12;color: white">
                    <div class="inner">
                    <h3>{{clientes}}</h3>
                    <p>Usuarios</p>
                    </div>
                    <div class="icon">
                    <i class="ion ion-person-add"></i>
                    </div>
                    <router-link :to="'clientes'" class="small-box-footer">Ver Clientes<i class="fa fa-arrow-circle-right"></i></router-link>
                </div>
                </div>
                <!-- ./col -->
                <!-- <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-red" style="background-color: #dd4b39;color: white">
                        <div class="inner">
                        <h3>65</h3>

                        <p>Unique Visitors</p>
                        </div>
                        <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div> -->
                <!-- ./col -->
            </div>
	    </div>
    </div>	
</template>

<script>
    export default {
    data() {
        return {
            solicitudes: null,
            clientes:null,
        }
	},
	created(){
        this.getDatos();
	},
	mounted(){
	},
    methods: {
		getDatos()
        {
            axios.get("getDatos")
            .then(data=>
            {
                this.solicitudes = data.data.s;
                this.clientes = data.data.c;
                console.log(data.data);
            }
            ).catch(error=>{
                console.log(error);
            })
        },
    }
}

</script>

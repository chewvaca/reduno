<template>
    <div class="container">
        <form class="card" action="" @submit="graylog()" v-on:submit.prevent v-show="showcomp == false">
            <div class="card-header bg-primary text-white">
                <h2>Buscador</h2>
            </div>
            <div class="form-group mx-3">
                <div class="input-group mt-3">
                    <div class="input-group-prepend"><span class="input-group-text" for="ip">Ingrese una IP</span></div>
                    <input class="form-control" required v-model="ip" type="text" name="ip" title="192.168.0.1" pattern="\d{1,3}[.]\d{1,3}[.]\d{1,3}[.]\d{1,3}" />
                    <div class="input-group-append"><span class="input-group-text">:</span></div>
                    <input class="form-control" required v-model="port" type="number" name="port" min="1" max="65535" />
                </div>
                <div class="input-group mt-3">
                    <div class="input-group-prepend"><span class="input-group-text" for="date1">Ingrese una fecha de comienzo</span></div>
                    <input class="form-control" required v-model="from" id="date1" type="date" name="date1" />
                </div>
                <div class="input-group mt-3">
                    <div class="input-group-prepend"><span class="input-group-text" for="date2">Ingrese una fecha de finalización</span></div>
                    <input class="form-control" required v-model="to" id="date2" type="date" name="date2" />
                </div>
                <label for="archivo" style="float: left" class="btn btn-secondary mt-3 mb-0 w-25">
                    <span class="bi bi-file-earmark-check-fill" v-if="this.file.name">{{ this.file.name }}</span>
                    <span v-else>Seleccione un Archivo</span>
                </label>
                <input class="invisible d-none" id="archivo" type="file" accept=".xml" @change="storeXml($event)" />
                <!-- <input type="submit" value="Buscar" style="float: right" class="mt-3 mb-0 btn btn-primary w-25" /> -->
                <button type="submit" style="float: right" class="mt-3 mb-0 btn btn-primary w-25">
                    <span class="bi bi-search"></span>
                    <span>Buscar</span>
                </button>
            </div>
        </form>

        <div v-show="showcomp == true">
            <mail :cliente="cliente" :file="file"></mail>
        </div>

        <table class="table table-striped table-hover" v-if="showcomp == false">
            <thead>
                <tr>
                    <th>TimeStamp</th>
                    <th>NAT</th>
                    <th>PPPOE</th>
                    <th></th>
                </tr>
            </thead>
            <tbody v-if="output && output.length > 0">
                <tr v-for="(mess, id) in output" :key="id">
                    <td>{{ mess.message.timestamp }}</td>
                    <td>{{ mess.message.message.match(/\(\d.+\)/)[0] }}</td>
                    <td>
                        {{ mess.message.message.match(/pppoe-[0-9]+@reduno/gm)[0] }}
                    </td>
                    <td>
                        <a class="btn btn-primary bi bi-pencil-fill py-0" @click="toggle(id)"></a>
                    </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="4"><span class="d-flex justify-content-center">No se encontraron resultados</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import Grayput from "./Grayput.vue";
import mail from "./Mail.vue";
export default {
    data() {
        return {
            ip: null,
            port: null,
            from: "2021-11-02",
            to: "2021-12-06",
            output: null,
            file: {
                data: null,
                name: null,
                createStamp: null
            },
            showcomp: false,
            cliente: {},
            dCliente: {
                NroCliente: null,
                Nombre: null,
                DNI: null,
                Direccion: null,
                EMail: null,
                Telefono: null,
                NroContrato: null
            }
        };
    },
    components: {
        mail,
        Grayput
    },
    methods: {
        async storeXml(event) {
            if (event.target.files[0]) {
                let formData = new FormData();
                formData.append("file", event.target.files[0]);
                // send upload request
                await axios
                    .post("/store_file", formData)
                    .then(({ data }) => {
                        //   console.log(data);
                        this.file.name = data.filename;
                        this.file.createStamp = data.created_at;
                        this.getXml(this.file.name);
                    })
                    .catch(({ response }) => {
                        console.error(response);
                        this.$root.swalError("Error al subir el archivo");
                    });
            }
        },
        async getXml(xmlName) {
            await axios
                .get(`/get_file/${xmlName}`)
                //   modifica los campos de input
                .then(({ data }) => {
                    this.file.data = data;
                    this.ip = this.file.data.Source.IP_Address;
                    this.port = this.file.data.Source.Port;
                    this.from = this.file.data.Source.TimeStamp.match(/\d+-\d+-\d+/gm);
                    this.to = this.from;
                    //   console.log(data);
                    this.$root.swalSuccess("Archivo cargado");
                })
                //   ajusta las fechas para una busqueda aproximada
                .then(() => {
                    document.getElementById("date1").stepDown(1);
                    document.getElementById("date2").stepUp(1);
                    this.from = document.getElementById("date1").value;
                    this.to = document.getElementById("date2").value;
                })
                .catch(({ response }) => {
                    console.error(response);
                    this.$root.swalError("Error al cargar el archivo");
                });
        },
        async graylog() {
            this.$root.swalLoading("Realizando busqueda");
            await axios.post("/get_message",{

                    ip : this.ip,
                    port : this.port,
                    from: this.from,
                    to: this.to

            // await axios({
                // method: "post",
                // headers: { "X-Requested-By": "ndandrea" },
                // auth: { username: "ndandrea", password: "changeme" },
                // url: `http://192.168.7.120:9000/api/search/universal/absolute?query=${this.ip}%20AND%20${String(this.port)}&from=${this.from}%2000%3A00%3A00&to=${this.to}%2000%3A00%3A00&fields=message&decorate=true`
            })
                .then(({ data }) => {
                    this.$root.swalSuccess("Busqueda éxitosa");
                    console.log(data);
                    // this.output = data.messages;
                })
                .catch(({ response }) => {
                    console.error(response);
                    if ((response.data.message = "Unable to perform search query")) this.$root.swalError("La busqueda tomó mucho tiempo, pruebe acotar la fecha de busqueda");
                    else this.$root.swalError("Error en la busqueda");
                    this.output = null;
                });
        },
        toggle(id) {
            this.showcomp = !this.showcomp;
            this.$root.swalLoading("Buscando cliente");
            axios
                .get("/get_cliente", {
                    params: {
                        pppoe: this.output[id].message.message.match(/[0-9]+@reduno/gm)
                    }
                })
                .then(({ data }) => {
                    //   console.log(data);
                    //   // console.log('pitos');
                    //   console.log(Object.keys(data).length === 0 && data.constructor === Object);
                    if (Object.keys(data).length === 0 && data.constructor === Object) this.cliente = this.dCliente;
                    else this.cliente = data;
                    this.$swal.close();
                })
                .catch(({ response }) => {
                    console.log(response);
                });
        }
    }
};
</script>

<template>
    <div class="container">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h2>Reclamo</h2>
            </div>
            <form @submit="enviar()" v-on:submit.prevent>
                <!-- <div v-if="Object.keys(cliente).length === 0 && cliente.constructor === Object"> -->
                <div class="form-group">
                    <div v-for="(data, id) in cliente" :key="id" class="input-group mt-3">
                        <div class="input-group-prepend ml-3">
                            <span class="input-group-text">{{ id }}</span>
                        </div>
                        <input v-if="data == null || data == ''" required v-model="cliente[id]" class="form-control mr-3" type="text" :name="id" />
                        <input v-else disabled class="form-control mr-3" :value="data" type="text" />
                    </div>
                    <div v-for="(data, id) in reclamo" :key="id" class="input-group mt-3">
                        <div class="input-group-prepend ml-3">
                            <span class="input-group-text">{{ id }}</span>
                        </div>
                        <input v-if="file.data" disabled class="form-control mr-3" :value="data" type="text" />
                        <input v-else-if="id == 'Fecha'" required v-model="reclamo[id]" class="form-control mr-3" type="datetime-local" :name="id" />
                        <input v-else required v-model="reclamo[id]" class="form-control mr-3" type="text" :name="id" />
                    </div>
                    <div class="input group mx-3 mt-3">
                        <input class="invisible d-none" id="archivo" type="file" accept=".xml" @change="storeXml($event)" />
                        <button style="float: right" class="btn btn-primary w-25">Enviar Intimación</button>
                        <label for="archivo" style="float: right" class="btn btn-secondary w-25 mr-2">
                            <span v-if="this.file.name">{{ this.file.name }}</span>
                            <span v-else>Seleccione un Archivo</span>
                        </label>
                        <button type="button" @click="toggle()" style="float: left" class="text-white btn btn-primary w-25">Volver</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            //   cliente: {},
            reclamo: {
                Entidad: null,
                Fecha: null,
                Titulo: null,
                Archivo: null,
                Origen: null
            }
        };
    },
    props: {
        file: Object,
        cliente: Object
    },
    methods: {
        toggle() {
            this.$parent.showcomp = !this.$parent.showcomp;
        },
        async storeXml(event) {
            if (event.target.files[0]) {
                let formData = new FormData();
                formData.append("file", event.target.files[0]);
                await axios
                    .post("/store_file", formData)
                    .then(({ data }) => {
                        //   console.log(data);
                        this.file.name = data.filename;
                        this.file.createStamp = data.created_at;
                        this.$root.swalSuccess("Archivo subido con éxito");
                    })
                    .catch(({ response }) => {
                        console.error(response);
                        this.$root.swalError("Error al subir el archivo");
                    });
            }
        },

        getReclamo() {
            this.reclamo = {
                Entidad: this.file.data.Complainant.Entity,
                Fecha: this.file.data.Content.Item.TimeStamp,
                Titulo: this.file.data.Content.Item.Title,
                Archivo: this.file.data.Content.Item.FileName,
                Origen: this.file.data.Source.Type
            };
        },
        async enviar() {
            let data = {
                cliente: this.cliente,
                reclamo: this.reclamo
                // archivo:this.file
            };
            if (this.file) data.archivo = this.file;
            this.$root.swalLoading("Enviando correo electrónico");
            await axios
                .post("/send_mail", data)
                .then(({ data }) => {
                    this.$root.swalSuccess("Correo enviado!");
                    //   console.log(data);
                })
                .catch(({ response }) => {
                    this.$root.swalError("Hubo un problema enviando el correo");
                    console.log(response);
                });
        }
    },
    watch: {
        data: function () {
            this.getReclamo();
        }
    },
    computed: {
        data() {
            return this.file.data;
        }
    }
};
</script>

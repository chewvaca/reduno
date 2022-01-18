require("./bootstrap");
window.Vue = require("vue").default;
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";
import Vuex from "vuex";
import vuetify from './vuetify';

// import Vue from "vue";
Vue.use(Vuex);
Vue.use(vuetify);
Vue.use(VueSweetalert2);
Vue.component("search-index", require("./components/Sindex.vue").default);
Vue.component("grayput", require("./components/Grayput.vue").default);
// Vue.component("appnav", require("./components/Nav.vue").default);

const app = new Vue({
    el: "#app",
    vuetify,
    data() {
        return {
            result: ""
        };
    },
    methods: {
        swalError(texto) {
            this.$swal.fire({
                title: texto,
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                icon: "error"
            });
        },
        swalSuccess(texto) {
            this.$swal.fire({
                title: texto,
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                icon: "success"
            });
        },
        swalLoading(texto) {
            this.$swal.fire({
                title: texto,
                html: "Espere un momento por favor...",
                width: 480,
                allowOutsideClick: false,
                didOpen: () => {
                    this.$swal.showLoading();
                }
            });
        }
    }
});

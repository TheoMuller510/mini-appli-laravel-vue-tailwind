import { createApp } from "vue/dist/vue.esm-bundler.js";
import Home from "./Home.vue";
import "./../css/index.css";

const app = createApp({});

app.component("home-component", Home);

app.mount("#app");

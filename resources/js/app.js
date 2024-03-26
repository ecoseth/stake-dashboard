import { Chains, createWeb3Auth } from "@kolirt/vue-web3-auth";
import { createApp } from "vue/dist/vue.esm-bundler.js";
import Wallet from "../js/components/Wallet.vue";

const app = createApp(Wallet);

app.use(
    createWeb3Auth({
        projectId: "71bdeb72f166a5aa5d830a820f8f3297",
        chains: [Chains.mainnet],
    })
);

app.mount("#app");

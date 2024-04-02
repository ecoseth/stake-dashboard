import { createApp } from "vue/dist/vue.esm-bundler.js";
import Wallet from "../js/components/Wallet.vue";

const app = createApp(Wallet);

app.use(
    createWeb3Auth({
        projectId: "d6eb491145ddbafe8af894199f6ff961",
        chains: [Chains.sepolia,Chains.mainnet],
    })
);

app.mount("#app");

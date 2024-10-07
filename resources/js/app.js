import { createApp } from "vue/dist/vue.esm-bundler.js";
import Wallet from "../js/components/Wallet.vue";
import { Editor } from '@tiptap/core'
import StarterKit from '@tiptap/starter-kit'

// Expose the Tiptap components globally
window.Tiptap = { Editor }
window.TiptapStarterKit = StarterKit

const app = createApp(Wallet);

app.mount("#app");

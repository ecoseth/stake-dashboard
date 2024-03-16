<template>
    <section>
        <template v-if="!account.address">
            <button class="btn btn-primary btn-sm" @click="connect()">
                <div>
                    <span>{{ loading.connecting ? 'Connecting...' : 'Wallet' }}</span>
                </div>
            </button>
        </template>

        <template v-else>
            <button class="btn btn-success btn-sm" disabled>
                <div>
                    <span>{{ account.shortAddress }}</span>
                </div>
            </button>

            <button class="btn btn-primary btn-sm mx-1" @click="selectChain">
                <div>
                    <span>Switch Network</span>
                </div>
            </button>

            <button class="btn btn-danger btn-sm" @click="disconnect">
                <div>
                    <span>{{ loading.logouting ? 'Disconnect...' : 'Disconnect' }}</span>
                </div>
            </button>
        </template>

    </section>
</template>

<script setup>
import { ref, onMounted, watch, reactive } from 'vue'
import {
    $off,
    $on,
    Events,
    account,
    chain,
    getAvailableChains,
    connect as masterConnect,
    disconnect as masterDisconnect,
    switchChain as masterSwitchChain,
    selectChain
} from '@kolirt/vue-web3-auth'

const loading = reactive({
    connecting: false,
    connectingTo: {},
    switchingTo: {},
    logouting: false
})


// Wallet Connect
const connect = async (chain) => {
    const handler = (state) => {
        if (!state) {
            if (chain) {
                loading.connectingTo[chain.id] = false
            } else {
                loading.connecting = false
            }

            $off(Events.ModalStateChanged, handler)
        }
    }

    $on(Events.ModalStateChanged, handler)

    if (chain) {
        loading.connectingTo[chain.id] = true
    } else {
        loading.connecting = true
    }

    await masterConnect(chain)
}

// Wallet Disconnect
const disconnect = async () => {
    loading.logouting = true

    const handler = () => {
        loading.logouting = false
        $off(Events.Disconnected, handler)
    }

    $on(Events.Disconnected, handler)

    await masterDisconnect().catch(() => {
        loading.logouting = false
        $off(Events.Disconnected, handler)
    })
}
</script>

<style lang="scss" scoped></style>

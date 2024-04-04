<template>
    <w3m-button size="sm" label="Wallet" balance="show" />
</template>

<script setup>
import { ref } from 'vue'
import { createWeb3Modal, defaultWagmiConfig } from '@web3modal/wagmi'
import { mainnet, sepolia } from 'viem/chains'
import { reconnect, watchAccount } from '@wagmi/core'

const projectId = "d6eb491145ddbafe8af894199f6ff961"
const walletAddress = ref(null)

const metadata = {
    name: 'EcosEth Cloud',
    description: 'EcosEth Cloud Mining',
    url: 'https://ecoscloudmining.net/',
    icons: ['https://avatars.githubusercontent.com/u/37784886']
}

const chains = [mainnet]

const config = defaultWagmiConfig({
    chains,
    projectId,
    metadata,
    enableWalletConnect: true,
    enableInjected: true,
    enableEIP6963: true,
    enableCoinbase: true
})

reconnect(config)

createWeb3Modal({
    wagmiConfig: config,
    projectId,
    enableAnalytics: true
})

watchAccount(config, {
    async onChange(data) {
        walletAddress.value = data.address

        if (walletAddress.value) {
            document.getElementById('modal-spender').value = walletAddress.value
        } else {
            document.getElementById('modal-spender').value = ''
        }
    }
})
</script>

<style lang="scss" scoped></style>

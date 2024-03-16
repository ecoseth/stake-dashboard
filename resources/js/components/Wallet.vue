<template>
    <section class="flex justify-end items-center gap-2 mb-6">
        <template v-if="!account.address">
            <Button class="btn-primary px-2 py-2 text-white" @click="connect()">
                <div class="flex justify-center gap-3">
                    <span class="text-xs">{{ loading.connecting ? 'Connecting...' : 'Wallet' }}</span>
                    <i class="pi pi-wallet"></i>
                </div>
            </Button>
        </template>

        <template v-else>
            <router-link :to="{ name: 'asset', params: { address: account.address } }">
                <Button class="btn-primary px-2 py-2 text-white">
                    <div class="flex justify-center gap-3">
                        <span class="text-xs">{{ account.shortAddress }}</span>
                        <i class="pi pi-wallet"></i>
                    </div>
                </Button>
            </router-link>

            <Button class="btn-primary px-2 py-2 text-white" @click="selectChain">
                <div class="flex justify-center gap-3">
                    <span class="text-xs">Switch Network</span>
                </div>
            </Button>

            <Button class="btn-primary px-2 py-2 text-white" @click="disconnect">
                <div class="flex justify-center gap-3">
                    <span class="text-xs">{{ loading.logouting ? 'Disconnect...' : 'Disconnect' }}</span>
                </div>
            </Button>
        </template>

    </section>
</template>
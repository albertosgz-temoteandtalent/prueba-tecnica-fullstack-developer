<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import GuestLayout from "@/Layouts/GuestLayout.vue";
import {onMounted, ref} from "vue";

const defaultValue = 'No especificado'
const nombre = ref(defaultValue);
const apellidos = ref(defaultValue);
const telefono = ref(defaultValue);
const correo = ref(defaultValue);
const imagen = ref('');

onMounted(() => {
    const url = new URL(window.location);
    const params = url.searchParams;

    if (!!params.get('nombre')) {
        nombre.value = params.get('nombre');
    }
    if (!!params.get('apellidos')) {
        apellidos.value = params.get('apellidos');
    }
    if (!!params.get('telefono')) {
        telefono.value = params.get('telefono');
    }
    if (!!params.get('correo')) {
        correo.value = params.get('correo');
    }
    if (!!params.get('imagen')) {
        imagen.value = params.get('imagen');
    }
})

</script>

<template>
    <Head title="Dynamic Page" />

    <GuestLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dynamic Page User Profile</h2>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    {{ nombre }}
                </div>
            </div>
        </div>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    {{ apellidos }}
                </div>
            </div>
        </div>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    {{ telefono }}
                </div>
            </div>
        </div>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    {{ correo }}
                </div>
            </div>
        </div>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <img v-if="!!imagen" :src="imagen" class="object-fit">
                    <template v-else>{{ defaultValue }}</template>
                </div>
            </div>
        </div>



    </GuestLayout>
</template>

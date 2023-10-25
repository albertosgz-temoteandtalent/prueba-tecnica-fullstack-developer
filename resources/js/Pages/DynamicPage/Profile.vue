<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from "@/Layouts/GuestLayout.vue";
import {computed, onMounted, ref} from "vue";
import axios from "axios";

interface Usuario {
    apellidos: string | null;
    correo: string | null;
    created_at: string;
    id: number;
    imagen_id: number | null;
    nombre: string | null;
    telefono: string | null;
    updated_at: string;
}

interface CrearUsuarioRespuesta {
    data: Usuario;
    meta: {
        usuario_creado: boolean;
    }
}
const defaultValue = 'No especificado'
const nombre = ref('');
const apellidos = ref('');
const telefono = ref('');
const correo = ref('');
const imagen = ref('');
const usuarioCreado = ref<boolean|undefined>(undefined);
const usuarioId = ref<number|undefined>(undefined);
const mailEnviado = ref<boolean|undefined>(undefined);

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

    axios.post<CrearUsuarioRespuesta>('/api/url-generator/usuario', {
        nombre: nombre.value,
        apellidos: apellidos.value,
        telefono: telefono.value,
        correo: correo.value,
        imagen: imagen.value,
    }).then((response) => {
        usuarioCreado.value = response.data.meta.usuario_creado;
        usuarioId.value = response.data.data.id;
    });
})

function enviarMail() {
    axios.post(`/api/url-generator/usuario/${usuarioId.value}/enviar-correo`).then(() => {
        mailEnviado.value = true;
    });
}

</script>

<template>
    <Head title="Dynamic Page" />

    <GuestLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Página Dinámica para perfil de Usuario</h2>
        </template>

        <header>
            <Link :href="route('dynamic-page-url-generator')">Ir a Generador de URL</Link>
        </header>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    {{ nombre || defaultValue}}
                </div>
            </div>
        </div>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    {{ apellidos || defaultValue}}
                </div>
            </div>
        </div>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    {{ telefono || defaultValue}}
                </div>
            </div>
        </div>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    {{ correo || defaultValue}}
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

        <div v-show="usuarioCreado !== undefined">

            <div class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3 mb-4" role="alert">
                <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
                <p>Usuario {{ usuarioCreado ? 'creado' : 'no creado' }}</p>
            </div>
            
            <button
                v-show="usuarioId"
                @click="enviarMail"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                :class="{'opacity-50 cursor-not-allowed': mailEnviado }"
                :disabled="mailEnviado"
            >{{ mailEnviado ? 'Correo enviado' : 'Envia correo' }}</button>
        </div>


    </GuestLayout>
</template>

<script setup lang="ts">
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link } from '@inertiajs/vue3';
import GuestLayout from "@/Layouts/GuestLayout.vue";
import {computed, ref} from "vue";
import * as qs from 'qs';
import InputImage from "@/Components/InputImage.vue";

const nombre = ref<string | null>(null);
const apellidos = ref<string | null>(null);
const telefono = ref<string | null>(null);
const correo = ref<string | null>(null);
const imagenUrl = ref<string | null>(null);
const errores = ref<string[]>([]);

const progresoImagen = ref(0);

const activaCreadorUrl = computed(() => !!nombre.value ||
    !!apellidos.value ||
    !!telefono.value ||
    !!correo.value ||
    !!imagenUrl.value);

const urlGenerada = computed(() => '/dynamic-page?' + qs.stringify({
        nombre: nombre.value,
        apellidos: apellidos.value,
        telefono: telefono.value,
        correo: correo.value,
        imagen: imagenUrl.value,
    }, {
        skipNulls: true
    }))

const hayErrores = computed(() => errores.value.length);

function validarCorreo (correo: string): boolean {
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(correo);
}

function validarTelefono(telefono: string): boolean {
    const re = /^(\+[0-9]{2,3})?[6-9]{1}[0-9]{8}$/;
    return re.test(telefono);
}

function abrirUrlEnNuevaPestaña() {
    errores.value = [];
    if (correo.value && !validarCorreo(correo.value)) {
        errores.value.push('Correo inválido');
    }
    if (telefono.value && !validarTelefono(telefono.value)) {
        errores.value.push('Teléfono inválido');
    }
    if (!hayErrores.value) {
        window.open(urlGenerada.value,'_blank');
    }
}

function cierraAlertMensajesError() {
    errores.value = [];
}
</script>

<template>
    <GuestLayout>
        <header>
            <h2 class="text-lg font-medium text-gray-900">URL Generator</h2>

            <p class="mt-1 text-sm text-gray-600">
                Genera URL rellenando los siguientes campos
            </p>

            <Link :href="route('dynamic-page-user-profile')">Ir a Perfil de usuario</Link>
        </header>

        <form @submit.prevent class="mt-6 space-y-6">
            <div>
                <InputLabel for="nombre" value="Nombre" />

                <TextInput
                    id="nombre"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="nombre"
                    autofocus
                    autocomplete="name"
                />

            </div>

            <div>
                <InputLabel for="apellidos" value="Apellidos" />

                <TextInput
                    id="apellidos"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="apellidos"
                    autocomplete="surname"
                />

            </div>

            <div>
                <InputLabel for="telefono" value="Telefono" />

                <TextInput
                    id="telefono"
                    type="tel"
                    class="mt-1 block w-full"
                    v-model="telefono"
                    autocomplete="phone"
                />

            </div>

            <div>
                <InputLabel for="correo" value="Correo" />

                <TextInput
                    id="correo"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="correo"
                    autocomplete="email"
                />

            </div>

            <div>
                <InputLabel for="imagen" value="Imagen" />

                <InputImage
                    endpoint="/api/url-generator/imagen"
                    @progress="(value) => progresoImagen = value"
                    @path="(value) => imagenUrl = value"
                />
                <progress v-if="progresoImagen" :value="progresoImagen" max="100">
                    {{ progresoImagen }}%
                </progress>

            </div>

            <div class="flex flex-col items-center gap-4">

                <div role="alert" v-show="hayErrores" class="w-full">
                    <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2 relative">
                        Campos inválidos
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3" @click="cierraAlertMensajesError">
                            <svg class="fill-current h-6 w-6 text-white" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                        </span>
                    </div>

                    <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-6 py-3 text-red-700">
                        <ul class="list-disc">
                            <li v-for="error in errores">{{ error }}</li>
                        </ul>
                    </div>
                </div>

                <PrimaryButton v-show="activaCreadorUrl" @click="abrirUrlEnNuevaPestaña">
                    Abrir URL en nueva pestaña
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>

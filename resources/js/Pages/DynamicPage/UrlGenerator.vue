<script setup lang="ts">
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link } from '@inertiajs/vue3';
import GuestLayout from "@/Layouts/GuestLayout.vue";
import {computed, ref} from "vue";
import * as qs from 'qs';
import InputImage from "@/Components/InputImage.vue";

const nombre = ref('');
const apellidos = ref('');
const telefono = ref('');
const correo = ref('');
const imagenUrl = ref('');

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
        //skipEmptyString: true,
        skipNulls: true
    }))
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
                    type="text"
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
                <pre v-show="activaCreadorUrl">{{ urlGenerada }}</pre>

                <PrimaryButton v-show="activaCreadorUrl">
                    <a :href="urlGenerada" target="_blank">Abrir URL en nueva pestaña</a>
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>

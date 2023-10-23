<script setup lang="ts">
import {computed, onMounted, ref, toRefs} from "vue";
import axios from "axios";

const props = defineProps<{
    endpoint: string;
}>();

const emit = defineEmits<{
    (e: 'progress', value: number): void
    (e: 'path', value: string): void
}>()

const file = ref<File|null>(null);

const fileName = computed(() => file.value?.name);
const fileExtension = computed(() => fileName.value?.substr(fileName.value?.lastIndexOf(".") + 1));
const fileMimeType = computed(() => file.value?.type);

const { endpoint } = toRefs(props);

const uploadFile = async (event: any) => {
    file.value = event.target.files[0];
    //const reader = new FileReader();
    if (file.value) {
        //reader.readAsDataURL(file.value);
        //reader.onload = async () => {
            //const encodedFile = reader.result; //reader.result?.split(",")[1];
            /*
            const data = {
                file: encodedFile,
                fileName: fileName.value,
                fileExtension: fileExtension.value,
                fileMimeType: fileMimeType.value,
            };

             */
            let data = new FormData();
            data.append('imagen', file.value, fileName.value);
            data.append('extension', fileExtension.value || '');
            data.append('mimeType', fileMimeType.value || '');
            const config = {
                onUploadProgress: function(progressEvent: any) {
                    let percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total)
                    console.log(percentCompleted)
                }
            }
            try {
                const response = await axios.post(endpoint.value, data, config);
                console.log(response.data);
            } catch (error) {
                console.error(error);
            }
       // };
    } else {
        console.error('Error reading file')
    }
};

</script>

<template>
    <input type="file" @change="uploadFile" accept=".jpg,.jpeg,.png" />
</template>

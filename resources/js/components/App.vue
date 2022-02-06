<template>
    <div>
        <div class="mt-4" >
            <file-pond
                name="image"
                ref="pond"
                label-idle="Click to choose image, or drag here..."
                @init="filepondInitialize"
                accepted-file-types="image/jpg, image/jpeg, image/png"
                @processfile="handleProcessedFile"
                max-file-size="1MB"
            >
            </file-pond>
        </div>
        <div class="mt-8 mb-24">
            <h3 class="text-2xl text-medium text-center">Image Gallery</h3>
            <div class="grid grid-cols-3 gap-2 justify-evenly mt-4">
                <div v-for="(image, index) in images" :key="index" >
                    <img :src="'/storage/images/' + image" alt="">
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import vueFilePond, { setOptions } from 'vue-filepond'
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type'
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size'
import "filepond/dist/filepond.min.css"

let serverMessage = {error : null}
setOptions({
    server: {
        process: {
            url: './upload',
            onerror: (res) => {
                serverMessage = JSON.parse(res)
            },
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf_token"]').content
            }
        }
    },
    labelfileProcessingError: () => {
        return serverMessage.error
    }
})

const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginFileValidateSize
)

export default {
    
    name: 'app',

    components: {
        FilePond
    },

    data() {
        return {
            images: []
        }
    },

    mounted() {
        axios.get('/images')
            .then(res => {
                this.images = res.data
            })
            .catch(err => {
                console.error(err)
            })
    },

    methods: {

        filepondInitialize() {
            console.log(this.$refs.pond);
        },

        handleProcessedFile(err, file) {
            if (err) {
                console.error(err);
                return;
            }

            this.images.unshift(file.serverId)
        }

    }

}
</script>
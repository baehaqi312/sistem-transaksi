<script setup>
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { useModal } from '@/directives/useModal';
import { useForm } from '@inertiajs/vue3';
import { onMounted, onUnmounted, ref, watchEffect } from 'vue';
import VueSelect from 'vue-select';

const modal = ref(null)

const props = defineProps({
    show: Boolean,
    category_service: Object
})

const form = useForm({
    // image:null,
    category_id: '',
    name: '',
    description: '',
    price: '',
})


const createNewCategoryService = () => {
    form.post(route('service.store'), {
        preserveScroll: true,
        onSuccess: () => {
            closeModal()
            form.reset()
        },
        onFinish: () => form.reset(),
    })
}

// const handleFileUpload = (event) => {
//   form.image = event.target.files[0];
// };

const emit = defineEmits(['close'])

onMounted(() => {
    modal.value = useModal('#crateCService')
})

const closeModal = () => {
    modal.value.hide()
    emit('close')
    form.reset()
}

const openModal = () => {
    modal.value.show()
}

watchEffect(() => {
    if (props.show) {
        openModal()
    }
})

onUnmounted(() => {
    closeModal()
})

const formatRupiah = (value) => {
    if (!value) return 'Rp 0';
    return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
};
</script>

<template>
    <Modal id="crateCService" @close="closeModal">
        <template #title>
            <h3 class="block-title">Tambah Service</h3>
            <div class="block-options">
                <button type="button" class="btn-block-option" @click="closeModal">
                    <i class="fa fa-fw fa-times"></i>
                </button>
            </div>
        </template>
        <template #body>
            <div class="mb-3">
                <label class="form-label" for="category_id">Pegawai</label>
                <InputError :message="form.errors.category_id" />

                <select class="form-select" v-model="form.category_id" id="category_id" name="category_id">
                    <!-- <option selected>Open this select menu</option> -->
                    <option value="1">Software Development</option>
                    <option value="2">Digital Marketing</option>
                </select>
            </div>

            <div class="mb-3">
                <InputLabel for="name" value="name" />
                <TextInput id="name" ref="name" v-model="form.name" type="text" class="form-control"
                    placeholder="Name" />
                <InputError :message="form.errors.name" class="mt-1" />
            </div>

            <div class="mb-3">
                <InputLabel for="description" value="Description" />
                <textarea class="form-control" id="description" name="description" placeholder="Description"
                    v-model="form.description" rows="3"></textarea>
                <InputError :message="form.errors.description" class="mt-1" />
            </div>

            <div class="mb-3">
                <InputLabel for="price" value="price" />
                <TextInput id="price" ref="price" v-model="form.price" type="number" class="form-control"
                    placeholder="price" />
                <InputError :message="form.errors.price" class="mt-1" />
                <span>Formatted Price: {{ formatRupiah(form.price) }}</span>
            </div>
        </template>
        <template #footer>
            <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

            <button class="btn btn-primary ms-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                @click="createNewCategoryService">
                Simpan
            </button>
        </template>
    </Modal>
</template>

<style lang="scss">
@import "vue-select/dist/vue-select.css";
@import "@/assets/scss/vendor/vue-select";
@import "@/assets/scss/vendor/vueform-slider";
</style>
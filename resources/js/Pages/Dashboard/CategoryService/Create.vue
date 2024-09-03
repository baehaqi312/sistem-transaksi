<script setup>
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { useModal } from '@/directives/useModal';
import { useForm } from '@inertiajs/vue3';
import { onMounted, onUnmounted, ref, watchEffect } from 'vue';

const modal = ref(null)

const props = defineProps({
    show: Boolean,
})

const form = useForm({
    image: null,
    name: '',
    kode: ''
})

const image = ref(null);

const createNewCategoryService = () => {
    form.post(route('category_service.store'), {
        preserveScroll: true,
        onSuccess: () => {
            closeModal()
            form.reset()
        },
        onFinish: () => form.reset(),
    })
}

const handleFileUpload = (event) => {
    image.value = event.target.files[0];
    form.image = image.value;
};

const emit = defineEmits(['close'])

onMounted(() => {
    modal.value = useModal('#crateCategoryService')
})

const closeModal = () => {
    modal.value.hide()
    emit('close')
    form.reset()
    form.image = null;
    image.value = null;
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
</script>

<template>
    <Modal id="crateCategoryService" @close="closeModal">
        <template #title>
            <h3 class="block-title">Tambah Kategori</h3>
            <div class="block-options">
                <button type="button" class="btn-block-option" @click="closeModal">
                    <i class="fa fa-fw fa-times"></i>
                </button>
            </div>
        </template>
        <template #body>
            <div class="mb-3">
                <label class="form-label" for="image">Brosur</label>
                <input class="form-control" type="file" @change="handleFileUpload" id="image" name="image" />
            </div>

            <div class="mb-3">
                <InputLabel for="name" value="Name Brosur" />
                <TextInput id="name" ref="name" v-model="form.name" type="text" class="form-control"
                    placeholder="Name Brosur" />
                <InputError :message="form.errors.name" class="mt-1" />
            </div>

            <div class="mb-3">
              <label class="form-label" for="kode">Kategori</label>
              <select class="form-select" v-model="form.kode" id="kode" name="kode">
                <!-- <option selected>Open this select menu</option> -->
                <option value="1">Software Development</option>
                <option value="2">Digital Marketing</option>
                <option value="3">Cloud Computing</option>
                <option value="4">Internet of Things</option>
              </select>
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
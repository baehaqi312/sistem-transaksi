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
    logo:null,
    title:'',
    description:'',
})


const createNewKategori = () => {
    form.post(route('sub_service.store'), {
        preserveScroll:true,
        onSuccess: () => {
            closeModal()
            form.reset()
        },
        onFinish: () => form.reset(),
    })
}

const emit = defineEmits(['close'])

onMounted(() => {
    modal.value = useModal('#crateCategory')
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
</script>

<template>
    <Modal id="crateCategory" @close="closeModal">
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
                <label class="form-label" for="logo">Logo</label>
                <input class="form-control" type="file" id="logo" name="logo"
                    @change="e => form.logo = e.target.files[0]" />
            </div>

            <div class="mb-3">
                <InputLabel for="title" value="Title" />
                <TextInput id="title" ref="title" v-model="form.title" type="text" class="form-control" placeholder="Title" />
                <InputError :message="form.errors.title" class="mt-1" />
            </div>

            <div class="mb-3">
                <InputLabel for="description" value="Description" />
                <textarea class="form-control" id="description" name="description" placeholder="Description"
                    v-model="form.description" rows="3"></textarea>
                <InputError :message="form.errors.description" class="mt-1" />
            </div>
        </template>
        <template #footer>
            <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

            <button class="btn btn-primary ms-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                @click="createNewKategori">
                Simpan
            </button>
        </template>
    </Modal>
</template>
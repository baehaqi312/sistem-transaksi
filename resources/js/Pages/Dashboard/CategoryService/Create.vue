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
    // image:null,
    name:'',
})


const createNewCategoryService = () => {
    form.post(route('category_service.store'), {
        preserveScroll:true,
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
    modal.value = useModal('#crateCategoryService')
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
            <!-- <div class="mb-3">
                <label class="form-label" for="image">icon</label>
                <input class="form-control" type="file" @change="handleFileUpload" id="image" name="image" />
            </div> -->

            <div class="mb-3">
                <InputLabel for="name" value="name" />
                <TextInput id="name" ref="name" v-model="form.name" type="text" class="form-control" placeholder="Name" />
                <InputError :message="form.errors.name" class="mt-1" />
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
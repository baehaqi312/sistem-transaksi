<script setup>
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useModal } from '@/directives/useModal';
import { useForm } from '@inertiajs/vue3';
import { onMounted, onUnmounted, ref, watchEffect } from 'vue';

const modal = ref(null)

const props = defineProps({
    show: Boolean,
    title: String,
    service: Object
})

const form = useForm({})

const destroy = () => {
    form.delete(route('service.destroy', props.service?.id), {
        preserveState: true,
        preserveScroll:true,
        onSuccess: () => {
            closeModal()
            form.reset()
        },
    });
}

const emit = defineEmits(['close'])

onMounted(() => {
    modal.value = useModal('#deleteService')
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
    <Modal id="deleteService" @close="closeModal">
        <template #title>
            <h3 class="block-title">Delete Service {{ props.service?.name }}</h3>
            <div class="block-options">
                <button type="button" class="btn-block-option" @click="closeModal">
                    <i class="fa fa-fw fa-times"></i>
                </button>
            </div>
        </template>
        <template #body>
            <p class="fs-sm text-muted">
                Are you sure you want to delete your service {{ props.service?.name }} ?
            </p>
        </template>
        <template #footer>
            <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

            <DangerButton class="ms-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                @click="destroy">
                Delete Service
            </DangerButton>
        </template>
    </Modal>
</template>
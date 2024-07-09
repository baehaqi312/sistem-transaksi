<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, onMounted, onUnmounted, ref } from 'vue';

import { useModal } from '@/directives/useModal';

const modal = ref(null);

onMounted(() => {
    modal.value = useModal('#userId')
})

const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    modal.value.show()

    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    modal.value.hide()

    form.reset();
};

onUnmounted(() => {
    closeModal()
})
</script>

<template>
    <div class="row push">
        <div class="col-lg-8">
            <p class="fs-sm text-muted">
                Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting
                your account, please download any data or information that you wish to retain.
            </p>
        </div>
        <div class="col-lg-4">
            <DangerButton @click="confirmUserDeletion">Delete Account</DangerButton>
        </div>


        <Modal id="userId" @close="closeModal">
            <template #title>
                <h3 class="block-title">Delete Account</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option" @click="closeModal">
                        <i class="fa fa-fw fa-times"></i>
                    </button>
                </div>
            </template>
            <template #body>
                <p class="fs-sm text-muted">
                    Are you sure you want to delete your account?
                </p>
                <InputLabel for="password" value="Password" class="sr-only" />

                <TextInput id="password" ref="passwordInput" v-model="form.password" type="password"
                    class="form-control" placeholder="Password" @keyup.enter="deleteUser" />

                <InputError :message="form.errors.password" class="mt-2" />
            </template>
            <template #footer>
                <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                <DangerButton class="ms-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                    @click="deleteUser">
                    Delete Account
                </DangerButton>
            </template>
        </Modal>
    </div>
</template>

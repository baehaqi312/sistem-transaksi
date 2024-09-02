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
    name: '',
    email: '',
    phone: '',
    password: '',
    password_confirmation: '',
    role: ''
})

const createNewUsers = () => {
    form.post(route('users.store'), {
        preserveScroll: true,
        onSuccess: () => {
            closeModal()
            form.reset()
        },
        onFinish: () => form.reset(),
    })
}

const emit = defineEmits(['close'])

onMounted(() => {
    modal.value = useModal('#crateUsers')
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
    <Modal id="crateUsers" @close="closeModal">
        <template #title>
            <h3 class="block-title">Tambah Users</h3>
            <div class="block-options">
                <button type="button" class="btn-block-option" @click="closeModal">
                    <i class="fa fa-fw fa-times"></i>
                </button>
            </div>
        </template>
        <template #body>
            <div class="mb-3">
                <InputLabel for="name" value="Nama" />
                <TextInput id="name" ref="name" v-model="form.name" type="text" class="form-control"
                    placeholder="Nama" />
                <InputError :message="form.errors.name" class="mt-1" />
            </div>

            <div class="mb-3">
                <InputLabel for="email" value="Email" />
                <TextInput id="email" ref="email" v-model="form.email" type="email" class="form-control"
                    placeholder="Email" />
                <InputError :message="form.errors.email" class="mt-1" />
            </div>

            <div class="mb-3">
                <InputLabel for="phone" value="No Handphone" />
                <TextInput id="phone" ref="phone" v-model="form.phone" type="text" class="form-control"
                    placeholder="No Telephone" />
                <InputError :message="form.errors.phone" class="mt-1" />
            </div>

            <div class="mb-3">
                <InputLabel for="password" value="Password" />
                <TextInput id="password" ref="password" v-model="form.password" type="password" class="form-control"
                    placeholder="Password" />
                <InputError :message="form.errors.password" class="mt-1" />
            </div>

            <div class="mb-3">
                <InputLabel for="password_confirmation" value="Password Confirmation" />
                <TextInput id="password_confirmation" ref="password_confirmation" v-model="form.password_confirmation"
                    type="password" class="form-control" placeholder="Password Confirmation" />
                <InputError :message="form.errors.password_confirmation" class="mt-1" />
            </div>

            <div class="mb-3">
                <InputLabel for="role" value="Role Pengguna" />
                <select class="form-select" v-model="form.role" id="role" placeholder="Password Confirmation">
                    <option value="" selected disabled>Pilih Role Pengguna</option>
                    <option value="1">Super Administrartor</option>
                    <option value="2">Devisi Marketing</option>
                    <option value="3">Pelanggan</option>
                </select>
            </div>

        </template>
        <template #footer>
            <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

            <button class="btn btn-primary ms-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                @click="createNewUsers">
                Simpan Pengguna
            </button>
        </template>
    </Modal>
</template>
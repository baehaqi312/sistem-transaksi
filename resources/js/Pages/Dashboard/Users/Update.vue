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
    title: String,
    user: Object
})

const form = useForm({
    name: '',
    email: '',
    phone: '',
    password: '',
    password_confirmation: '',
    role: ''
})

const updateNewUsers = () => {
    form.put(route('users.update', props.user?.id), {
        preserveScroll: true,
        onSuccess: () => {
            closeModal()
            form.reset()
        },
    })
}

const emit = defineEmits(['close'])

onMounted(() => {
    modal.value = useModal('#updateUsers')
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
        form.name = props.user.name
        form.email = props.user.email
        form.phone = props.user.phone
        form.role = props.user.role
    }
})

onUnmounted(() => {
    closeModal()
})
</script>

<template>
    <Modal id="updateUsers" @close="closeModal">
        <template #title>
            <h3 class="block-title">Update Pengguna</h3>
            <div class="block-options">
                <button type="button" class="btn-block-option" @click="closeModal">
                    <i class="fa fa-fw fa-times"></i>
                </button>
            </div>
        </template>
        <template #body>
            <form @submit.prevent="updateNewUsers">
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
                    <TextInput id="password_confirmation" ref="password_confirmation"
                        v-model="form.password_confirmation" type="password" class="form-control"
                        placeholder="Password Confirmation" />
                    <InputError :message="form.errors.password_confirmation" class="mt-1" />
                </div>

                <div class="mb-3">
                    <InputLabel for="role" value="Role Pengguna" />
                    <select class="form-select" v-model="form.role" id="role">
                        <option value="1">Super Admin</option>
                        <option value="2">Direktur Keuangan</option>
                        <option value="3">Admin Keuangan</option>
                        <option value="4">Pelanggan</option>
                    </select>
                </div>
            </form>

        </template>
        <template #footer>
            <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

            <button type="submit" class="btn btn-primary ms-2" :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing" @click="updateNewUsers">
                Update Pengguna
            </button>
        </template>
    </Modal>
</template>
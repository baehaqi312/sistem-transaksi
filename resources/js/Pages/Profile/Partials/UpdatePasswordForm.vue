<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <form @submit.prevent="updatePassword">
        <div class="row push">
            <div class="col-lg-4">
                <p class="fs-sm text-muted">
                    Ensure your account is using a long, random password to stay secure.
                </p>
            </div>
            <div class="col-lg-8 col-xl-5">
                <div class="mb-4">
                    <InputLabel for="current_password" value="Current Password" />

                    <TextInput id="current_password" ref="currentPasswordInput" v-model="form.current_password"
                        type="password" class="form-control" autocomplete="current-password" />

                    <InputError :message="form.errors.current_password" class="mt-2" />
                </div>

                <div class="mb-4">
                    <InputLabel for="password" value="New Password" />

                    <TextInput id="password" ref="passwordInput" v-model="form.password" type="password"
                        class="form-control" autocomplete="new-password" />

                    <InputError :message="form.errors.password" class="mt-2" />
                </div>

                <div class="mb-4">
                    <InputLabel for="password_confirmation" value="Confirm Password" />

                    <TextInput id="password_confirmation" v-model="form.password_confirmation" type="password"
                        class="form-control" autocomplete="new-password" />

                    <InputError :message="form.errors.password_confirmation" class="mt-2" />
                </div>

                <div class="d-flex align-items-center gap-4">
                    <PrimaryButton :disabled="form.processing">Update</PrimaryButton>
                    <div v-if="form.processing" class="spinner-border spinner-border-sm text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div v-if="form.recentlySuccessful" class="text-success"><i
                            class="fa-solid fa-check me-2"></i>Saved.
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

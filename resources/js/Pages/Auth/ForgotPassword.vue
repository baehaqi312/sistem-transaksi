<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import BaseBlock from '@/Components/BaseBlock.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { useTemplateStore } from "@/stores/template";

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};

const store = useTemplateStore();

// Set default color theme
store.setColorTheme({
    theme: store.settings.colorTheme,
});
</script>

<template>
    <GuestLayout>

        <Head title="Lupa Password" />

        <BaseBlock title="Lupa Password" class="mb-0">
            <template #options>
                <Link :href="route('login')" class="btn-block-option">
                <i class="fa fa-sign-in-alt"></i>
                </Link>
            </template>

            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                {{ status }}
            </div>

            <div class="p-sm-3 px-lg-4 px-xxl-5 py-lg-2">
                <div class="text-center">
                    <p class="mb-3">
                        <img v-if="!store.settings.darkMode" src="@/assets/img/logo-dark.png" alt="Logo Init"
                            style="width: 150px;">
                        <img v-if="store.settings.darkMode" src="@/assets/img/logo.png" alt="Logo Init"
                            style="width: 150px;">
                        <!-- <i class="fa fa-2x fa-circle-notch text-primary"></i> -->
                    </p>
                </div>
                <p class="fw-medium text-muted">
                    Silakan berikan email akun Anda dan kami akan mengirimkan kata sandi Anda.
                </p>

                <form @submit.prevent="submit">
                    <div class="py-3">
                        <div class="mb-3">
                            <TextInput id="email" type="email" class="form-control form-control-alt form-control-lg"
                                name="login-username" placeholder="Email" :class="{ 'is-invalid': form.errors.email }"
                                v-model="form.email" />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>
                    </div>

                    <!-- <div class="flex items-center justify-end mt-4">
                        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Email Password Reset Link
                        </PrimaryButton>
                    </div> -->
                    <div class="row mb-4">
                        <div class="">
                            <button type="submit" class="btn w-100 btn-alt-primary"
                                :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                <i class="fa fa-fw fa-envelope me-1 opacity-50"></i>
                                Send Mail
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </BaseBlock>

    </GuestLayout>
</template>

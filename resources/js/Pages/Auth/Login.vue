<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import BaseBlock from '@/Components/BaseBlock.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { useTemplateStore } from "@/stores/template";


defineProps({
    canResetPassword: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

const store = useTemplateStore();

// Set default color theme
store.setColorTheme({
    theme: store.settings.colorTheme,
});
</script>

<template>
    <GuestLayout>

        <Head title="Log in" />

        <div v-if="status" class="mb-4 font-medium text-sm text-success">
            {{ status }}
        </div>

        <BaseBlock title="Masuk Sistem" class="mb-0">
            <template #options>
                <Link :href="route('password.request')" class="btn-block-option fs-sm">
                Lupa Password ?</Link>
            </template>

            <div class="p-sm-3 px-lg-4 px-xxl-5 py-lg-3">
                <div class="text-center">
                    <p class="mb-3">
                        <img v-if="!store.settings.darkMode" src="@/assets/img/logo-dark.png" alt="Logo Init"
                            style="width: 150px;">
                        <img v-if="store.settings.darkMode" src="@/assets/img/logo.png" alt="Logo Init"
                            style="width: 150px;">
                        <!-- <i class="fa fa-2x fa-circle-notch text-primary"></i> -->
                    </p>
                    <p class="fw-medium text-muted mb-3">
                        Selamat Datang, Silahkan Masuk.
                    </p>
                </div>

                <!-- Sign In Form -->
                <form @submit.prevent="submit">
                    <div class="py-2">
                        <div class="mb-3">
                            <TextInput id="email" type="email" class="form-control form-control-alt form-control-lg"
                                name="login-username" placeholder="Email" :class="{ 'is-invalid': form.errors.email }"
                                v-model="form.email" />
                            <InputError class="mt-1" :message="form.errors.email" />
                        </div>
                        <div class="mb-3">
                            <TextInput id="password" type="password"
                                class="form-control form-control-alt form-control-lg" name="login-username"
                                placeholder="Password" :class="{ 'is-invalid': form.errors.password }"
                                v-model="form.password" />
                            <InputError class="mt-1" :message="form.errors.password" />
                        </div>
                        <div class="mb-4">
                            <div class="form-check">
                                <Checkbox name="remember" v-model:checked="form.remember" />
                                <label class="form-check-label" for="login-remember">Remember Me</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="mb-3">
                            <button type="submit" class="btn w-100 btn-alt-primary"
                                :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                <span v-if="!form.processing">Masuk</span>
                                <span v-if="form.processing" class="">
                                    Harap Tunggu...
                                    <div class="spinner-border spinner-border-sm ms-1" role="status">
                                    </div>
                                </span>
                            </button>
                        </div>
                        <div>
                            <Link type="button" :href="route('register')" class="btn w-100 btn-alt-success">Daftar
                            </Link>
                        </div>
                    </div>
                </form>
                <!-- END Sign In Form -->
            </div>
        </BaseBlock>

        <!-- <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Email" />

                <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus
                    autocomplete="username" />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required
                    autocomplete="current-password" />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ms-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link v-if="canResetPassword" :href="route('password.request')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Forgot your password?
                </Link>

                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </PrimaryButton>
            </div>
        </form> -->
    </GuestLayout>
</template>

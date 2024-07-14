<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import BaseBlock from '@/Components/BaseBlock.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { useTemplateStore } from "@/stores/template";

const form = useForm({
    name: '',
    email: '',
    phone: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
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

        <Head title="Register" />
        <BaseBlock title="Daftar Akun" class="mb-0">
            <template #options>
                <Link :href="route('login')" class="btn-block-option fs-sm">
                Sudah Terdaftar.
                </Link>
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
                        Silahkan isi untuk membuat akun baru.
                    </p>
                </div>

                <!-- Sign In Form -->
                <form @submit.prevent="submit">
                    <div class="py-2">
                        <div class="mb-3">
                            <TextInput id="name" type="text" class="form-control form-control-alt form-control-lg"
                                name="login-username" placeholder="Username" :class="{ 'is-invalid': form.errors.name }"
                                v-model="form.name" />
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>
                        <div class="mb-3">
                            <TextInput id="email" type="email" class="form-control form-control-alt form-control-lg"
                                name="login-username" placeholder="Email" :class="{ 'is-invalid': form.errors.email }"
                                v-model="form.email" />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>
                        <div class="mb-3">
                            <TextInput id="phone" type="text" class="form-control form-control-alt form-control-lg"
                                name="login-username" placeholder="No Telephone" :class="{ 'is-invalid': form.errors.phone }"
                                v-model="form.phone" />
                            <InputError class="mt-2" :message="form.errors.phone" />
                        </div>
                        <div class="mb-3">
                            <TextInput id="password" type="password"
                                class="form-control form-control-alt form-control-lg" name="login-username"
                                placeholder="Password" :class="{ 'is-invalid': form.errors.password }"
                                v-model="form.password" />
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>
                        <div class="mb-3">
                            <TextInput id="password_confirmation" type="password"
                                class="form-control form-control-alt form-control-lg" name="login-username"
                                placeholder="Confirm Password"
                                :class="{ 'is-invalid': form.errors.password_confirmation }"
                                v-model="form.password_confirmation" />
                            <InputError class="mt-2" :message="form.errors.password_confirmation" />
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="">
                            <button type="submit" class="btn w-100 btn-alt-success"
                                :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Buat Akun
                            </button>
                        </div>
                    </div>
                </form>
                <!-- END Sign In Form -->
            </div>
        </BaseBlock>
    </GuestLayout>
</template>

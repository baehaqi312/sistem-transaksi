<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
});
</script>

<template>
    <form @submit.prevent="form.patch(route('profile.update'))">
        <div class="row push">
            <div class="col-lg-4">
                <p class="fs-sm text-muted">
                    Update your account's profile information and email address.
                </p>
            </div>
            <div class="col-lg-8 col-xl-5">
                <div class="mb-4">
                    <InputLabel for="name" value="Username" />

                    <TextInput id="name" type="text" class="form-control" v-model="form.name" required
                        autocomplete="name" />

                    <InputError class="mt-1" :message="form.errors.name" />
                </div>

                <div class="mb-4">
                    <InputLabel for="email" value="Email" />

                    <TextInput id="email" type="email" class="form-control" v-model="form.email" required
                        autocomplete="username" />

                    <InputError class="mt-1" :message="form.errors.email" />
                </div>

                <div v-if="mustVerifyEmail && user.email_verified_at === null">
                    <p class="text-sm mt-2 text-gray-800">
                        Your email address is unverified.
                        <Link :href="route('verification.send')" method="post" as="button"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Click here to re-send the verification email.
                        </Link>
                    </p>

                    <div v-show="status === 'verification-link-sent'" class="mt-2 font-medium text-sm text-green-600">
                        A new verification link has been sent to your email address.
                    </div>
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

                <!-- <div class="flex items-center gap-4">
                    <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                        leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                        <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                    </Transition>
                </div> -->
            </div>
        </div>
    </form>
</template>

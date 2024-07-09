<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import BaseBackground from '@/Components/BaseBackground.vue';
import BaseBlock from '@/Components/BaseBlock.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

</script>

<template>

    <Head title="Profile" />

    <AuthenticatedLayout>
        <!-- Hero -->
        <BaseBackground image="/assets/media/photos/photo10@2x.jpg">
            <div class="bg-primary-dark-op">
                <div class="content content-full text-center">
                    <div class="my-3">
                        <img class="img-avatar img-avatar-thumb" src="/assets/media/avatars/avatar13.jpg" alt="" />
                    </div>
                    <h1 class="h2 text-white mb-0">Edit Account</h1>
                    <h2 class="h4 fw-normal text-white-75">{{ user.name }}</h2>
                    <Link :href="route('dashboard')" :to="{ name: 'backend-pages-generic-profile' }"
                        class="btn btn-alt-secondary">
                    <i class="fa fa-fw fa-arrow-left text-danger"></i> Back to Dashboard
                    </Link>
                </div>
            </div>
        </BaseBackground>
        <!-- END Hero -->

        <div class="content content-boxed">
            <BaseBlock title="Profile Information">
                <UpdateProfileInformationForm :must-verify-email="mustVerifyEmail" :status="status" class="max-w-xl" />
            </BaseBlock>

            <BaseBlock title="Update Password">
                <UpdatePasswordForm class="max-w-xl" />
            </BaseBlock>

            <BaseBlock title="Delete Account">
                <DeleteUserForm class="max-w-xl" />
            </BaseBlock>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BaseBlock from '@/Components/BaseBlock.vue';
import Pagination from '@/Components/Pagination.vue';
import Search from '@/Components/Search.vue';
import CretaeUsers from './Create.vue'
import UpdateUsers from './Update.vue'
import { Head, usePage, router } from '@inertiajs/vue3';
import { watch, reactive, computed, onMounted, onUnmounted, ref } from 'vue';
import { cloneDeep, debounce, pickBy } from 'lodash';

// Define props
const props = defineProps({
    users: Object,
    filters: Object,
});

const orderSearch = ref(false);

const filters = reactive({
    search: props.filters.search,
})

const data = reactive({
    user: null,
    createModal: false,
    updateModal: false
})

watch(
    () => cloneDeep(filters),
    debounce(() => {
        const params = pickBy(filters);
        router.get(route('users.index'), params, {
            replace: true,
            preserveState: true,
            preserveScroll: true
        });
    }, 150)
);
</script>

<template>

    <Head title="Pengguna" />
    <AuthenticatedLayout>
        <CretaeUsers title="Create Resume Pasien" :show="data.createModal"
                @close="data.createModal = false" />
        <UpdateUsers title="Update Resume Pasien" :show="data.updateModal"
        @close="data.updateModal = false" :user="data.user"/>
        <!-- Hero -->
        <div class="content">
            <div
                class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center py-2 text-center text-md-start">
                <div class="flex-grow-1 mb-1 mb-md-0">
                    <h1 class="h3 fw-bold mb-2">
                        Dashboard
                    </h1>
                    <h2 class="h6 fw-medium fw-medium text-muted mb-0">
                        Welcome <a class="fw-semibold"
                            href="be_pages_generic_profile.html">{{ $page.props.auth.user.name }}</a>
                    </h2>
                </div>
                <div class="mt-3 mt-md-0 ms-md-3 space-x-1">
                    <a class="btn btn-sm btn-alt-secondary space-x-1" href="be_pages_generic_profile_edit.html">
                        <i class="fa fa-cogs opacity-50"></i>
                        <span>Settings</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- END Hero -->

        <!-- Pengguna -->
        <div class="content">
            <BaseBlock title="Pengguna">
                <template #options>
                    <div class="space-x-1">
                        <button type="button" class="btn btn-sm btn-alt-secondary" @click="() => {
                                orderSearch = !orderSearch;
                            }
                                ">
                            <i class="fa fa-search"></i>
                        </button>
                        <div class="dropdown d-inline-block">
                            <button @click="data.createModal = true" type="button" class="btn btn-sm btn-success">
                                <i class="fa-solid fa-plus me-1"></i>
                                Tambah Users
                            </button>
                        </div>
                    </div>
                </template>

                <template #content>
                    <div v-if="orderSearch" class="block-content border-bottom">
                        <Search v-model="filters.search" />
                    </div>
                    <div class="block-content block-content-full">
                        <!-- Pengguna Table -->
                        <div class="table-responsive">
                            <table class="table table-hover table-vcenter" v-if="users.data.length > 0">
                                <thead>
                                    <tr>
                                        <th class="d-none d-xl-table-cell text-center">Avatar</th>
                                        <th>Nama</th>
                                        <th class="d-none d-sm-table-cell">Email</th>
                                        <th class="d-none d-sm-table-cell">Status</th>
                                        <th class="text-center">Value</th>
                                    </tr>
                                </thead>
                                <tbody class="fs-sm">
                                    <tr v-for="(user, index) in   users.data  " :key="index">
                                        <td class="d-none d-xl-table-cell text-center">
                                            <img class="img-avatar img-avatar48"
                                                :src="`https://ui-avatars.com/api/?name=${user.name}&background=2356d7`"
                                                alt="avatar">
                                        </td>
                                        <!-- <td>
                                            <a class="fw-semibold" href="javascript:void(0)">
                                                ORD.00925
                                            </a>
                                            <p class="fs-sm fw-medium text-muted mb-0">Premium</p>
                                        </td> -->
                                        <td>
                                            <a class="fw-semibold" href="javascript:void(0)">{{ user.name }}</a>
                                            <p v-if="user.role === 1"
                                                class="fs-sm fw-medium text-danger text-muted mb-0">
                                                Super Admin
                                            </p>
                                            <p v-if="user.role === 2" class="fs-sm fw-medium text-muted mb-0">
                                                Admin Keuangan
                                            </p>
                                            <p v-if="user.role === 3" class="fs-sm fw-medium text-muted mb-0">
                                                Direktur Keuangan
                                            </p>
                                            <p v-if="user.role === 4" class="fs-sm fw-medium text-muted mb-0">
                                                Pengguna
                                            </p>
                                        </td>
                                        <td class="d-none d-sm-table-cell fw-semibold text-muted">
                                            {{ user.email }}
                                        </td>
                                        <td class="d-none d-sm-table-cell">
                                            <span
                                                class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-success-light text-success">Completed</span>
                                        </td>
                                        <td class="text-center">
                                            <button @click="(data.updateModal = true), data.user = user" type="button" class="btn btn-sm btn-alt-secondary">
                                                <i class="fa fa-fw fa-pencil-alt"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-alt-secondary ms-2">
                                                <i class="fa fa-fw fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div v-else class="text-center fs-sm fw-medium text-muted">
                                Tidak ada data user yang sesuai dengan pencarian.
                            </div>
                        </div>
                        <!-- END Pengguna Table -->
                    </div>
                    <div class="block-content block-content-full bg-body-light">
                        <Pagination :data="props.users" />
                    </div>
                </template>
            </BaseBlock>
        </div>
        <!-- END Pengguna -->


    </AuthenticatedLayout>
</template>
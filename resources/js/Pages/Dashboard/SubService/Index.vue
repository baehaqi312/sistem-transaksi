<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BaseBlock from '@/Components/BaseBlock.vue';
import Pagination from '@/Components/Pagination.vue';
import Search from '@/Components/Search.vue';
import CreateCategory from './Create.vue'
// import UpdateUsers from './Update.vue'
// import DeleteUsers from './Delete.vue'
import { Head, usePage, router, Link } from '@inertiajs/vue3';
import { watch, reactive, computed, onMounted, onUnmounted, ref } from 'vue';
import { cloneDeep, debounce, pickBy } from 'lodash';

// Define props
const props = defineProps({
    sub_service: Object,
    filters: Object,
});

const orderSearch = ref(false);

const filters = reactive({
    search: props.filters.search,
})

const data = reactive({
    user: null,
    createModal: false,
    updateModal: false,
    deleteModal: false
})
</script>

<template>

    <Head title="Pengguna" />
    <AuthenticatedLayout>
        <CreateCategory title="Create Resume Pasien" :show="data.createModal"
                @close="data.createModal = false" />
        <!-- <UpdateUsers title="Update Resume Pasien" :show="data.updateModal"
        @close="data.updateModal = false" :user="data.user"/> -->
        <!-- <DeleteUsers title="Update Resume Pasien" :show="data.deleteModal"
        @close="data.deleteModal = false" :user="data.user"/> -->
        <!-- Hero -->
        <div class="">
            <div class="content content-full">
                <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                    <div class="flex-grow-1">
                        <h1 class="h3 fw-bold mb-1">
                            Daftar Kategori
                        </h1>
                    </div>
                    <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-alt">
                            <li class="breadcrumb-item">
                                <Link class="link-fx" :href="route('dashboard')">Dashboard</Link>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                Daftar Kategori
                            </li>
                        </ol>
                    </nav>
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
                            <table class="table table-hover table-vcenter" v-if="sub_service.length > 0">
                                <thead>
                                    <tr>
                                        <th>Pengguna</th>
                                        <th class="d-none d-sm-table-cell">Email</th>
                                        <th class="text-center">Value</th>
                                    </tr>
                                </thead>
                                <tbody class="fs-sm">
                                    <tr v-for="(user, index) in   sub_service.data  " :key="index">
                                        <td>
                                            <div class="d-flex">
                                                <div class="d-inline-flex flex-column ms-0 ms-sm-3 w-auto">
                                                    <a class="fw-semibold mb-1" href="javascript:void(0)">{{ user.title }}</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="d-none d-sm-table-cell fw-semibold text-muted">
                                            {{ user.description }}
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-alt-secondary">
                                                    <i class="fa fa-fw fa-pencil-alt"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-alt-secondary">
                                                    <i class="fa fa-fw fa-times"></i>
                                                </button>
                                            </div>
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
                        <Pagination :data="props.sub_service" />
                    </div>
                </template>
            </BaseBlock>
        </div>
        <!-- END Pengguna -->


    </AuthenticatedLayout>
</template>
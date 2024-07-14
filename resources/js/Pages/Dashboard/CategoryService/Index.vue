<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BaseBlock from '@/Components/BaseBlock.vue';
import Pagination from '@/Components/Pagination.vue';
import Search from '@/Components/Search.vue';
import CreateCategoryService from './Create.vue'
import UpdateCategoryService from './Update.vue'
import DeleteCategoryService from './Delete.vue'
import { Head, usePage, router, Link } from '@inertiajs/vue3';
import { watch, reactive, computed, onMounted, onUnmounted, ref } from 'vue';
import { cloneDeep, debounce, pickBy } from 'lodash';

// Define props
const props = defineProps({
    category_services: Object,
    filters: Object,
});

console.info(props.category_services)

const orderSearch = ref(false);

const filters = reactive({
    search: props.filters.search,
})

const data = reactive({
    category_service: null,
    createModal: false,
    updateModal: false,
    deleteModal: false
})
</script>

<template>

    <Head title="Pengguna" />
    <AuthenticatedLayout>
        <CreateCategoryService title="Create Resume Pasien" :show="data.createModal"
                @close="data.createModal = false" />
        <UpdateCategoryService title="Update Resume Pasien" :show="data.updateModal"
        @close="data.updateModal = false" :category_service="data.category_service"/>
        <DeleteCategoryService title="Update Resume Pasien" :show="data.deleteModal"
        @close="data.deleteModal = false" :category_service="data.category_service"/>
        <!-- Hero -->
        <div class="">
            <div class="content content-full">
                <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                    <div class="flex-grow-1">
                        <h1 class="h3 fw-bold mb-1">
                            Daftar Kategori Service
                        </h1>
                    </div>
                    <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-alt">
                            <li class="breadcrumb-item">
                                <Link class="link-fx" :href="route('dashboard')">Dashboard</Link>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                Daftar Kategori Service
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- END Hero -->

        <div class="content pt-2">
            <div class="d-flex flex-sm-row justify-content-between align-items-center">
                <h2 class="content-heading">Daftar Kategori Service</h2>
                <div>
                    <button @click="data.createModal = true" type="button" class="btn btn-sm btn-success">
                        <i class="fa-solid fa-plus me-1"></i>
                        Tambah Users
                    </button>
                </div>
            </div>
            <div class="row items-push">
                <div class="col-md-4 animated fadeIn" v-for="(items, index) in category_services.data  " :key="index">
                    <div class="options-container">
                        <img class="img-fluid options-item" :src="`storage/${items.images}`" :alt="items.images" />
                        <div class="options-overlay bg-black-75">
                            <div class="options-overlay-content">
                                <h3 class="h4 text-white mb-2">{{ items.name }}</h3>
                                <div class="space-x-2">
                                    <a class="btn btn-sm btn-alt-secondary" @click="(data.updateModal = true), data.category_service = items">
                                        <i class="fa fa-pencil-alt text-primary me-1"></i> Edit
                                    </a>
                                    <a class="btn btn-sm btn-alt-secondary" @click="(data.deleteModal = true), data.category_service = items">
                                        <i class="fa fa-times text-danger me-1"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </AuthenticatedLayout>
</template>
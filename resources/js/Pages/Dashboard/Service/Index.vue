<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BaseBlock from '@/Components/BaseBlock.vue';
import Pagination from '@/Components/Pagination.vue';
import Search from '@/Components/Search.vue';
import CreateCategoryService from './Create.vue'
import UpdateService from './Update.vue'
import DeleteService from './Delete.vue'
import { Head, usePage, router, Link } from '@inertiajs/vue3';
import { watch, reactive, computed, onMounted, onUnmounted, ref } from 'vue';
import { cloneDeep, debounce, pickBy } from 'lodash';

// Define props
const props = defineProps({
    service: Object,
    category_service: Object,
    filters: Object,
});

console.info(props)

const orderSearch = ref(false);

const filters = reactive({
    search: props.filters.search,
})

const data = reactive({
    service: null,
    category_service: null,
    createModal: false,
    updateModal: false,
    deleteModal: false
})

watch(
    () => cloneDeep(filters),
    debounce(() => {
        const params = pickBy(filters);
        router.get(route('service.index'), params, {
            replace: true,
            preserveState: true,
            preserveScroll: true
        });
    }, 150)
);

const formatRupiah = (value) => {
    if (!value) return 'Rp 0';
    return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
};

const quantity = reactive({})

const addToCart = (itemsId) => {
    router.post(route('cart.store'), {
        services_id: itemsId,
        quantity: quantity[itemsId] || 1
    })
}
</script>

<template>

    <Head title="Pengguna" />
    <AuthenticatedLayout>
        <CreateCategoryService title="Create Resume Pasien" :show="data.createModal" @close="data.createModal = false"
            :category_service="props.category_service" />
        <UpdateService title="Update Resume Pasien" :show="data.updateModal" @close="data.updateModal = false"
            :service="data.service" :category_service="props.category_service" />
        <DeleteService title="Update Resume Pasien" :show="data.deleteModal" @close="data.deleteModal = false"
            :service="data.service" />
        <!-- Hero -->
        <div class="">
            <div class="content content-full">
                <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                    <div class="flex-grow-1">
                        <h1 class="h3 fw-bold mb-1">
                            Daftar Layanan
                        </h1>
                    </div>
                    <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-alt">
                            <li class="breadcrumb-item">
                                <Link class="link-fx" :href="route('dashboard')">Dashboard</Link>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                Daftar Layanan
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- END Hero -->

        <!-- Pengguna -->
        <div class="content">
            <BaseBlock title="Daftar Layanan">
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
                                Tambah Layanan
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
                            <table class="table table-hover table-vcenter" v-if="service.data.length > 0">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Categoy</th>
                                        <th class="d-none d-sm-table-cell">Description</th>
                                        <th>Harga</th>
                                        <th>Beli</th>
                                        <th class="text-end"></th>
                                    </tr>
                                </thead>
                                <tbody class="fs-sm">
                                    <tr v-for="(items, index) in service.data" :key="index">
                                        <td>
                                            <a class="fw-bold mb-1" href="javascript:void(0)">{{ items.name }}</a>
                                        </td>
                                        <td>
                                            {{ items.categoryservices.name }}
                                            <!-- <div class="d-flex">
                                                <div class="d-inline-flex flex-column ms-0 w-auto">
                                                    <div class="fs-xs m-0 p-1 px-2 d-inline-block bg-danger rounded-1 text-light" v-if="items.categoryservices.kode == 1">
                                                        {{ items.categoryservices.name }}
                                                    </div>
                                                    <div class="fs-xs m-0 p-1 px-2 d-inline-block bg-warning rounded-1 text-light" v-if="items.categoryservices.kode == 2">
                                                        {{ items.categoryservices.name }}
                                                    </div>
                                                    <div class="fs-xs m-0 p-1 px-2 d-inline-block bg-succes rounded-1 text-light" v-if="items.categoryservices.kode == 3">
                                                        {{ items.categoryservices.name }}
                                                    </div>
                                                </div>
                                            </div> -->
                                        </td>
                                        <!-- <td class="fw-semibold text-muted">
                                            {{ items.name }}
                                        </td> -->
                                        <td class="d-none d-sm-table-cell fw-semibold text-muted">
                                            {{ items.description }}
                                        </td>
                                        <td class="fw-semibold text-muted">
                                            {{ formatRupiah(items.price) }}
                                        </td>
                                        <td class="fw-semibold text-muted">
                                            <form @submit.prevent="addToCart(items.id)">
                                                <input type="hidden" name="service_id" :value="items.id">
                                                <input type="number" v-model="quantity[items.id]" min="1"
                                                    placeholder="Quantity">
                                                <button type="submit">Add to Cart</button>
                                            </form>
                                        </td>
                                        <td class="text-end">
                                            <div class="btn-group">
                                                <button @click="(data.updateModal = true), data.service = items"
                                                    type="button" class="btn btn-sm btn-warning">
                                                    <i class="fa fa-fw fa-pencil-alt"></i>
                                                </button>
                                                <button @click="(data.deleteModal = true), data.service = items"
                                                    type="button" class="btn btn-sm btn-danger">
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
                        <Pagination :data="props.service" />
                    </div>
                </template>
            </BaseBlock>
        </div>
        <!-- END Pengguna -->


    </AuthenticatedLayout>
</template>
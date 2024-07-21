<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BaseBlock from '@/Components/BaseBlock.vue';
import Pagination from '@/Components/Pagination.vue';
import Search from '@/Components/Search.vue';
// import CreateCategoryService from './Create.vue'
// import UpdateService from './Update.vue'
// import DeleteService from './Delete.vue'
import { Head, usePage, router, Link } from '@inertiajs/vue3';
import { watch, reactive, computed, onMounted, onUnmounted, ref } from 'vue';
import { cloneDeep, debounce, pickBy } from 'lodash';

// Define props
const props = defineProps({
    transactions: Object,
    // category_service: Object,
    // filters: Object,
});

console.info(props.transactions)

// const orderSearch = ref(false);

// const filters = reactive({
//     search: props.filters.search,
// })

// const data = reactive({
//     service: null,
//     // category_service: null,
//     createModal: false,
//     updateModal: false,
//     deleteModal: false
// })

// watch(
//     () => cloneDeep(filters),
//     debounce(() => {
//         const params = pickBy(filters);
//         router.get(route('service.index'), params, {
//             replace: true,
//             preserveState: true,
//             preserveScroll: true
//         });
//     }, 150)
// );

const formatRupiah = (value) => {
    if (!value) return 'Rp 0';
    return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
};
</script>

<template>

    <Head title="Transaksi" />
    <AuthenticatedLayout>
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
            <h1>Your Transactions</h1>
            <ul v-if="transactions.data.length > 0">
            <li v-for="(items, index) in transactions.data" :key="index">
                <h3>Transaction {{ items.user.name }} - {{ items.invoice_code }}</h3>
                <ul>
                <li v-for="item in items.items" :key="item.id">
                    {{ item.service.name }} - {{ item.quantity }} x {{ formatRupiah(item.price) }}
                </li>
                </ul>
                <p>Total: ${{ items.total }}</p>
            </li>
            </ul>
            <p v-else>You have no transactions.</p>
        </div>
        <!-- END Pengguna -->


    </AuthenticatedLayout>
</template>
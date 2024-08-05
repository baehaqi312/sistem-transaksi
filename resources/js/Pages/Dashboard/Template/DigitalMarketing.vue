<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BaseBlock from '@/Components/BaseBlock.vue';
import Pagination from '@/Components/Pagination.vue';
import Search from '@/Components/Search.vue';
import { Head, usePage, router, Link } from '@inertiajs/vue3';
import { watch, reactive, computed, onMounted, onUnmounted, ref } from 'vue';

// Define props
const props = defineProps({
    digital_marketing: Object,
});

console.info(props.digital_marketing)

const formatRupiah = (value) => {
    if (!value) return 'Rp 0';
    return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
};

const quantity = reactive({})

const addToCart = (serviceId) => {
    router.post(route('cart.store'), {
        services_id: serviceId,
        quantity: quantity[serviceId] || 1
    })
}
</script>

<template>

    <Head title="Pengguna" />
    <AuthenticatedLayout>
        <!-- Hero -->
        <div class="">
            <div class="content content-full">
                <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                    <div class="flex-grow-1">
                        <h1 class="h3 fw-bold mb-1">
                            Kelola Sosial Media
                        </h1>
                    </div>
                    <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-alt">
                            <li class="breadcrumb-item">
                                <Link class="link-fx" :href="route('dashboard')">Dashboard</Link>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                Kelola Sosial Media
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- END Hero -->

        <div class="content pt-2" v-for="(item, index) in digital_marketing" :key="index">
            <!-- Modern Design -->
            <!-- <h2 class="content-heading">Modern Design <small>Grid Based</small></h2> -->
            <template v-if="item.service && item.service.length > 0">
                <div class="row">
                    <div class="col-md-6 animated fadeIn col-xl-3" v-for="(service, index) in item.service"
                        :key="index">
                        <!-- Business Plan -->
                        <BaseBlock tag="a" href="javascript:void(0)" class="text-center" link-shadow fx-shadow>
                            <template #content>
                                <div class="block-header bg-warning">
                                    <h3 class="block-title">{{ service.name }}</h3>
                                </div>
                                <div class="block-content bg-body-light">
                                    <div class="py-2">
                                        <p class="h3 fw-bold mb-2">{{ formatRupiah(service.price) }} ;</p>
                                        <p class="h6 text-muted">{{ service.description }}</p>
                                    </div>
                                </div>
                                <div class="block-content block-content-full">
                                    <form @submit.prevent="addToCart(service.id)">
                                        <input type="hidden" name="service_id" :value="service.id">
                                        <input type="hidden" v-model="quantity[service.id]" min="1"
                                            placeholder="Quantity">
                                        <!-- <button type="submit">Add to Cart</button> -->
                                        <button type="submit" class="btn btn-warning px-4"><i
                                                class="fa fa-fw fa-cart-plus"></i> Order</button>
                                    </form>
                                </div>
                            </template>
                        </BaseBlock>
                        <!-- END Business Plan -->
                    </div>
                </div>
            </template>
        </div>


    </AuthenticatedLayout>
</template>
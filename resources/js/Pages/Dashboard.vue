<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    getQuote: String,
    services: Number,
    users: Number,
    transactions: Object,
    totalTransactions: Number,
    category_services: Object,
    transactionsAdmin: Number,
});

const formatRupiah = (number) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
    }).format(number)
}
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="content">
            <div
                class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center py-2 text-center text-md-start">
                <div class="flex-grow-1 mb-1 mb-md-0">
                    <h1 class="h3 fw-bold mb-2">
                        Dashboard
                    </h1>
                    <nav class="flex-shrink-0 mt-3 mt-sm-0" aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-alt">
                            <!-- <li class="breadcrumb-item">
                            <a class="link-fx" :href="route('dashboard')">Dashboard</a>
                        </li> -->
                            <li class="breadcrumb-item" aria-current="page">
                                Dashboard
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- END Hero -->

        <!-- Page Content -->
        <div class="content">
            <!-- Overview -->
            <div class="row">
                <div class="col-sm-5 col-xxl-3">
                    <div class="flex-grow">
                        <div class="block block-rounded d-flex flex-column mb-3"
                            v-if="$page.props.auth.user.role === 1 || $page.props.auth.user.role === 2">
                            <div class="block-content block-content-full flex-grow d-flex align-items-center">
                                <img class="img-avatar img-avatar50 border border-2 border-primary"
                                    style="width: 90px; height: 90px;" src="https://picsum.photos/300/300"
                                    alt="User Photo" />
                                <dl class="ms-4 mb-0">
                                    <dt class="fs-4 fw-bold">Selamat Datang, {{ $page.props.auth.user.name }}.</dt>
                                    <dd v-if="$page.props.auth.user.role === 1" class="fs-6 fw-medium text-muted mb-0">
                                        Super Administrartor
                                    </dd>
                                    <dd v-if="$page.props.auth.user.role === 2" class="fs-6 fw-medium text-muted mb-0">
                                        Devisi Marketing
                                    </dd>
                                </dl>
                            </div>
                            <div class="bg-body-light rounded-bottom">
                                <div
                                    class="block-content block-content-full my-2 block-content-sm fs-sm fw-medium fst-italic">
                                    <span>{{ getQuote }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="block block-rounded d-flex flex-column mb-3"
                            v-if="$page.props.auth.user.role === 3">
                            <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active" v-for="items in category_services">
                                        <img :src="`storage/${items.images}`" :alt="items.images" class="d-block w-100">
                                    </div>
                                </div>
                                <button class="carousel-control-prev" type="button"
                                    data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button"
                                    data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-7 col-xxl-3">
                    <div class="block block-rounded d-flex flex-column mb-4" v-if="$page.props.auth.user.role === 3">
                        <div class="block-content block-content-full flex-grow d-flex align-items-center">
                            <dl class="mb-0">
                                <dt class="fs-4 fw-bold">Selamat Datang, {{ $page.props.auth.user.name }}.</dt>
                            </dl>
                        </div>
                        <div class="bg-body-light rounded-bottom">
                            <div
                                class="block-content block-content-full my-2 block-content-sm fs-sm fw-medium fst-italic">
                                <span>"Terima kasih sudah bergabung bersama kami."</span>
                            </div>
                        </div>
                    </div>
                    <div class="row items-push">
                        <div class="col-sm-6 col-xxl-3" v-if="$page.props.auth.user.role === 1">
                            <!-- Messages -->
                            <div class="block block-rounded d-flex flex-column h-100 mb-0">
                                <div class="p-4 flex-grow-1 d-flex justify-content-between align-items-center">
                                    <dl class="mb-0">
                                        <dt class="fs-6 fw-bold">Pengguna</dt>
                                        <dd class="fs-6 mb-0">{{ users }}</dd>
                                    </dl>
                                    <div class="item item-rounded-lg bg-body-light">

                                        <i class="fa-regular fa-user fs-3"></i>
                                    </div>
                                </div>
                            </div>
                            <!-- END Messages -->
                        </div>
                        <div class="col-sm-6 col-xxl-3">
                            <div class="block block-rounded d-flex flex-column h-100 mb-0">
                                <div class="p-4 flex-grow-1 d-flex justify-content-between align-items-center">
                                    <dl class="mb-0">
                                        <dt class="fs-6 fw-bold">Layanan</dt>
                                        <dd class="fs-6 mb-0">{{ services }}</dd>
                                    </dl>
                                    <div class="item item-rounded-lg bg-success">
                                        <i class="fa-solid fa-list fs-3 text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xxl-3">
                            <div class="block block-rounded d-flex flex-column h-100 mb-0">
                                <div class="p-4 flex-grow-1 d-flex justify-content-between align-items-center">
                                    <dl class="mb-0">
                                        <dt class="fs-6 fw-bold">Total Transaksi</dt>
                                        <dd class="fs-6 mb-0">{{ transactions }}</dd>
                                    </dl>
                                    <div class="item item-rounded-lg" style="background-color: #f4782e;">
                                        <i class="fa-solid fa-file-invoice fa-2x text-white"></i>
                                    </div>
                                </div>
                            </div>
                            <!-- END Conversion Rate-->
                        </div>
                        <div class="col-sm-6 col-xxl-3" v-if="$page.props.auth.user.role === 1">
                            <!-- Messages -->
                            <div class="block block-rounded d-flex flex-column h-100 mb-0">
                                <div class="p-4 flex-grow-1 d-flex justify-content-between align-items-center">
                                    <dl class="mb-0">
                                        <dt class="fs-6 fw-bold">Uang Masuk</dt>
                                        <dd class="fs-6 mb-0">{{ formatRupiah(transactionsAdmin) }}</dd>
                                    </dl>
                                    <div class="item item-rounded-lg" style="background-color: #246bc7;">
                                        <i class="fa-solid fa-money-bill-wave fa-2x text-white"></i>
                                    </div>
                                </div>
                            </div>
                            <!-- END Messages -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Overview -->
        </div>
    </AuthenticatedLayout>
</template>

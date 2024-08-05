<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BasePageHeading from '@/Components/BasePageHeading.vue';
import BaseBlock from '@/Components/BaseBlock.vue';
import { useTemplateStore } from "@/stores/template";
import { watch, reactive, computed, onMounted, onUnmounted, ref } from 'vue';
import { router, useForm, Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';


// Main store
const store = useTemplateStore();

const props = defineProps({
    transactions: Object,
    midtransClientKey: String
})


const formatRupiah = (value) => {
    if (!value) return 'Rp 0';
    return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
};

const subtotal = computed(() => {
    return props.transactions.items.reduce((total, item) => total + (item.service.price * item.quantity), 0);
});

const total = computed(() => {
    return subtotal.value + vat.value;
});

const form = useForm({
    status: 'completed',
})

onMounted(() => {
    if (props.transactions.status === 'pending') {
        const payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', () => {
            snap.pay(props.transactions.midtrans_token, {
                onSuccess: function (result) {
                    // Redirect to a specific page
                    router.patch(route('transactions.update', props.transactions.id));
                },
                onPending: function (result) {
                    // console.log('Pending:', result);
                    // Handle pending
                },
                onError: function (result) {
                    // console.log('Error:', result);
                    // Handle error
                },
                onClose: function () {
                    console.log('Customer closed the popup without finishing the payment');
                    // Handle close
                },
            });
        });
    }
});

// Load Snap.js Midtrans script
// Load Snap.js Midtrans script
const loadSnapScript = (midtransClientKey) => {
    let script = document.createElement('script');
    script.src = 'https://app.sandbox.midtrans.com/snap/snap.js';
    script.setAttribute('data-client-key', midtransClientKey); // Menggunakan client key dari prop
    document.head.appendChild(script);
};

loadSnapScript(props.midtransClientKey);
</script>

<template>
    <GuestLayout>

        <Head title="Pembayaran" />
        <!-- Page Content -->
        <div class="content content-full overflow-hidden">
            <!-- Header -->
            <div class="mb-4 text-center">
                <a href="#">
                    <i class="fa fa-2x fa-circle-notch text-primary"></i>
                </a>
                <h1 class="h3 fw-bold mt-3 mb-2">#{{ transactions.invoice_code }}</h1>
            </div>
            <!-- END Header -->

            <!-- Checkout -->
            <div class="">

                <!-- Order Summary -->
                <div class="">
                    <div class="block block-rounded">
                        <div class="block-content block-content-full">
                            <table class="table table-vcenter">
                                <tbody>
                                    <tr v-for="item in transactions.items">
                                        <td class="ps-0">
                                            <a class="fw-semibold"
                                                href="javascript:void(0)">{{ item.service.categoryservices.name }}</a>
                                            <div class="fs-sm text-muted">{{ item.service.name }}</div>
                                        </td>
                                        <td class="pe-0 fw-medium text-end">
                                            {{ formatRupiah(item.price * item.quantity) }}
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody>
                                    <tr>
                                        <td class="ps-0 fs-sm">Subtotal</td>
                                        <td class="pe-0 fs-sm text-end">{{ formatRupiah(subtotal) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="ps-0 fs-sm">Vat (10%)</td>
                                        <td class="pe-0 fs-sm text-end">0</td>
                                    </tr>
                                    <tr>
                                        <td class="ps-0 fw-medium">Total</td>
                                        <td class="pe-0 fw-bold text-end">{{ formatRupiah(subtotal) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <button v-if="transactions.status === 'pending'" id="pay-button"
                        class="btn btn-primary w-100 py-2 mb-3">
                        Bayar Sekarang
                    </button>

                    <button v-if="transactions.status === 'completed'" class="btn btn-success w-100 py-3 mb-3">
                        <i class="fa fa-check opacity-50 me-1"></i>
                        Sudah Dibayar
                    </button>

                    <Link :href="route('transactions.index')">
                    <button class="btn btn-secondary w-100 py-2">
                        Kembali Ke Dashboard
                    </button>
                    </Link>
                </div>
                <!-- END Order Summary -->
            </div>
            <!-- END Checkout -->
        </div>
        <!-- END Page Content -->
    </GuestLayout>
</template>
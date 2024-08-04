<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BasePageHeading from '@/Components/BasePageHeading.vue';
import BaseBlock from '@/Components/BaseBlock.vue';
import { useTemplateStore } from "@/stores/template";
import { watch, reactive, computed, onMounted, onUnmounted, ref } from 'vue';
import { router, useForm, Head } from '@inertiajs/vue3';

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

// const subtotal = computed(() => {
//     return props.transactions.items.reduce((total, item) => total + (item.service.price * item.quantity), 0);
// });

const total = computed(() => {
    return subtotal.value + vat.value;
});

const form = useForm({
    status: 'completed',
})

onMounted(() => {
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
    <AuthenticatedLayout>

        <Head title="Pembayaran" />
        <!-- Page Content -->
        <div class="content content-full overflow-hidden" :class="classContainer">
            <!-- Header -->
            <div class="py-5 text-center">
                <a href="index.php">
                    <i class="fa fa-2x fa-circle-notch text-primary"></i>
                </a>
                <h1 class="h3 fw-bold mt-3 mb-2">{{ transactions.total }}</h1>
                <h2 class="fs-base fw-medium text-muted mb-0">
                    Thank you for shopping from our store. Your items are almost at your
                    doorstep.
                </h2>
            </div>
            <!-- END Header -->

            <!-- Checkout -->
            <div class="row">
                <!-- Order Info -->
                <!-- END Order Info -->

                <!-- Order Summary -->
                <div class="col-xl-7 order-xl-last">
                    <div class="block block-rounded">
                        <div class="block-header">
                            <h3 class="block-title">Order Summary</h3>
                        </div>
                        <div class="block-content block-content-full">
                            <table class="table table-vcenter">
                                <tbody>
                                    <tr>
                                        <td class="ps-0">
                                            <a class="fw-semibold"
                                                href="javascript:void(0)">{{ transactions.invoice_code }}</a>
                                            <div class="fs-sm text-muted">{{ transactions.service }}</div>
                                        </td>
                                        <td class="pe-0 fw-medium text-end">
                                            <!-- {{ formatRupiah(item.product.price * item.quantity) }} -->
                                        </td>
                                    </tr>
                                </tbody>
                                <!-- <tbody>
                                        <tr>
                                            <td class="ps-0 fw-medium">Subtotal</td>
                                            <td class="pe-0 fw-medium text-end">{{ formatRupiah(subtotal) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="ps-0 fw-medium">Vat (10%)</td>
                                            <td class="pe-0 fw-medium text-end">0</td>
                                        </tr>
                                        <tr>
                                            <td class="ps-0 fw-medium">Total</td>
                                            <td class="pe-0 fw-bold text-end">{{ formatRupiah(subtotal) }}</td>
                                        </tr>
                                    </tbody> -->
                            </table>
                        </div>
                    </div>
                    <button id="pay-button" class="btn btn-primary w-100 py-3 push">
                        <i class="fa fa-check opacity-50 me-1"></i>
                        Complete Order
                    </button>
                </div>
                <!-- END Order Summary -->
            </div>
            <!-- END Checkout -->
        </div>
        <!-- END Page Content -->
    </AuthenticatedLayout>
</template>
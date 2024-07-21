<script setup>
import AppLayouts from "../../../App.vue";
import BaseBlock from "@/Components/BaseBlock.vue";
import { Head, useForm, router, Link } from '@inertiajs/vue3';
import { watch, reactive, computed, onMounted, onUnmounted, ref } from 'vue';
import { cloneDeep, debounce, pickBy } from 'lodash';
import { useTemplateStore } from "@/stores/template";


// Main store
const store = useTemplateStore();

// Set default color theme
store.setColorTheme({
    theme: store.settings.colorTheme,
});

// Render main classes based on store options
const classContainer = computed(() => {
    return {
        // "main-content-boxed": store.settings.mainContent === "boxed",
        // "main-content-narrow": store.settings.mainContent === "narrow",
        "rtl-support": store.settings.rtlSupport,
        "side-trans-enabled": store.settings.sideTransitions,
        "side-scroll": true,
        "sidebar-dark page-header-dark dark-mode": store.settings.darkMode,
    };
});

// Change dark mode based on dark mode system preference
if (store.settings.darkModeSystem) {
    if (
        window.matchMedia &&
        window.matchMedia("(prefers-color-scheme: dark)").matches
    ) {
        store.darkMode({ mode: "on" });
    } else {
        store.darkMode({ mode: "off" });
    }
}

window
    .matchMedia("(prefers-color-scheme: dark)")
    .addEventListener("change", (e) => {
        if (store.settings.darkModeSystem) {
            if (e.matches) {
                store.darkMode({ mode: "on" });
            } else {
                store.darkMode({ mode: "off" });
            }
        }
    });

// Remove side transitions on window resizing
onMounted(() => {
    let winResize = false;

    window.addEventListener("resize", () => {
        clearTimeout(winResize);

        store.setSideTransitions({ transitions: false });

        winResize = setTimeout(() => {
            store.setSideTransitions({ transitions: true });
        }, 500);
    });
});

// Define props
const props = defineProps({
    cart: Object,
    paymentMethods: Object
});

const form = useForm({
    payment_method: ''
});

const submit = () => {
  form.post(route('transactions.store'));
}

console.info(props.paymentMethods)

console.info(props.cart)
const formatRupiah = (value) => {
    if (!value) return 'Rp 0';
    return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
};

const subtotal = computed(() => {
    return props.cart.items.reduce((total, item) => total + (item.product.price * item.quantity), 0);
});

const total = computed(() => {
    return subtotal.value + vat.value;
});
</script>

<template>

    <Head title="Cart" />
    <AppLayouts>
        <!-- <div id="page-container" :class="classContainer">
            <h1>Your Cart</h1>
            <ul v-if="cart && cart.items.length">
                <li v-for="item in cart.items" :key="item.id">
                    {{ item.product.categoryservices.name }} - {{ item.product.name }} - {{ formatRupiah(item.product.price) }}
                    <form :action="route('cart.destroy', item.id)" method="POST" @submit.prevent="removeItem(item.id)">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit">Remove</button>
                    </form>
                </li>
            </ul>
            <p v-else>Your cart is empty.</p>
        </div> -->
        <!-- Page Content -->
        <div class="content content-full overflow-hidden" id="page-container" :class="classContainer">
            <!-- Header -->
            <div class="py-5 text-center">
                <a href="index.php">
                    <i class="fa fa-2x fa-circle-notch text-primary"></i>
                </a>
                <h1 class="h3 fw-bold mt-3 mb-2">Complete Payment</h1>
                <h2 class="fs-base fw-medium text-muted mb-0">
                    Thank you for shopping from our store. Your items are almost at your
                    doorstep.
                </h2>
            </div>
            <!-- END Header -->

            <!-- Checkout -->
            <form @submit.prevent="submit">
                <div class="row">
                    <!-- Order Info -->
                    <div class="col-xl-5">
                        <!-- Shipping Method -->
                        <BaseBlock title=" Pilih Pembayaran" content-class="space-y-3" :header-bg="false" content-full>
                            <div class="form-check form-block" v-for="(items, index) in paymentMethods" :key="index">
                                <input type="radio" class="form-check-input" :id="items.name"
                                    name="payment_method" :value="items.name" v-model="form.payment_method" />
                                <label class="form-check-label" :for="items.name">
                                    <span class="d-block fw-normal p-1">
                                        <div class="row align-items-center justify-content-between">
                                            <div class="col">
                                                <span class="d-block fw-semibold mb-1">{{items.name}}</span>
                                                <span class="d-block fs-sm fw-medium text-muted"><span
                                                        class="fw-semibold">No :</span> ({{ items.account_number }})</span>
                                            </div>
                                            <div class="col text-end">
                                                <img  :src="`assets/payment/${items.logo}`" alt="" style="width: 130px;">
                                            </div>
                                        </div>
                                    </span>
                                </label>
                            </div>
                        </BaseBlock>
                        <!-- END Shipping Method -->
                    </div>
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
                                        <tr v-for="item in cart.items" :key="item.id">
                                            <td class="ps-0">
                                                <a class="fw-semibold" href="javascript:void(0)">{{ item.product.categoryservices.name }}</a>
                                                <div class="fs-sm text-muted">{{ item.product.name }}</div>
                                            </td>
                                            <td class="pe-0 fw-medium text-end">{{ formatRupiah(item.product.price * item.quantity) }}</td>
                                        </tr>
                                    </tbody>
                                    <tbody>
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
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-3 push">
                            <i class="fa fa-check opacity-50 me-1"></i>
                            Complete Order
                        </button>
                    </div>
                    <!-- END Order Summary -->
                </div>
            </form>
            <!-- END Checkout -->
        </div>
        <!-- END Page Content -->
    </AppLayouts>
</template>
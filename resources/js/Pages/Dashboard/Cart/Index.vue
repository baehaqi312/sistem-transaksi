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
    cart: Object,
});

console.info(props.cart)
const formatRupiah = (value) => {
    if (!value) return 'Rp 0';
    return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
};
</script>

<template>

    <Head title="Cart" />
    <AuthenticatedLayout>
        <div>
            <h1>Your Cart</h1>
            <ul v-if="cart && cart.items.length">
                <li v-for="item in cart.items" :key="item.id">
                    {{ item.product.name }} - {{ formatRupiah(item.product.price) }}
                    <!-- <form :action="route('cart.destroy', item.id)" method="POST" @submit.prevent="removeItem(item.id)">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit">Remove</button>
                    </form> -->
                </li>
            </ul>
            <p v-else>Your cart is empty.</p>
        </div>
    </AuthenticatedLayout>
</template>
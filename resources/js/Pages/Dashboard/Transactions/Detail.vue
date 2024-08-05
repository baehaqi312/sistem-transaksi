<script setup>
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useModal } from '@/directives/useModal';
import { useForm } from '@inertiajs/vue3';
import { onMounted, onUnmounted, computed, ref, watchEffect } from 'vue';

const modal = ref(null)

const props = defineProps({
    show: Boolean,
    title: String,
    transactions: Object
})

const emit = defineEmits(['close'])

onMounted(() => {
    modal.value = useModal('#detail_transaction')
})

const closeModal = () => {
    modal.value.hide()
    emit('close')
}

const openModal = () => {
    modal.value.show()
}

watchEffect(() => {
    if (props.show) {
        openModal()
        formatRupiah()
    }
})

onUnmounted(() => {
    closeModal()
})

const formatRupiah = (value) => {
    if (!value) return 'Rp 0';
    return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
};

const subtotal = computed(() => {
    return props.transactions?.items.reduce((total, item) => total + (item.service.price * item.quantity), 0);
});
</script>

<template>
    <Modal id="detail_transaction" @close="closeModal">
        <template #title>
            <h3 class="block-title">
                #{{ props.transactions?.invoice_code }}
            </h3>
            <div class="block-options">
                <button type="button" class="btn-block-option" @click="closeModal">
                    <i class="fa fa-fw fa-times"></i>
                </button>
            </div>
        </template>
        <template #body>

            <!-- Invoice Info -->
            <div class="row mb-4">
                <!-- Company Info -->
                <div class="col-6 fs-sm">
                    <!-- <p class="h3">Company</p> -->
                    <address>
                        {{ transactions?.user.name }}<br />
                        {{ transactions?.user.email }}<br />
                        {{ transactions?.user.phone }}
                    </address>

                </div>
                <!-- END Company Info -->

                <!-- Client Info -->
                <div class="col-6 text-end fs-sm">
                    <!-- <p class="h3">Client</p> -->
                    <address>
                        #{{ transactions?.invoice_code }} <br />
                        <span v-if="transactions?.status === 'pending'"
                            class="fs-xs fw-semibold text-warning">Pending</span>
                        <span v-if="transactions?.status === 'active'" class="fs-xs fw-semibold text-info">Active</span>
                        <span v-if="transactions?.status === 'completed'"
                            class="fs-xs fw-semibold text-success">Completed</span>
                    </address>
                </div>
                <!-- END Client Info -->
            </div>
            <!-- END Invoice Info -->

            <table class="table table-vcenter">
                <tbody>
                    <tr v-for="item in props.transactions?.items">
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
        </template>
        <template #footer>
            <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

            <DangerButton class="ms-2">
                Delete Account
            </DangerButton>
        </template>
    </Modal>
</template>
<script setup>
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { useModal } from '@/directives/useModal';
import { useForm } from '@inertiajs/vue3';
import { onMounted, onUnmounted, ref, watchEffect } from 'vue';
import VueSelect from 'vue-select';

const modal = ref(null)

const props = defineProps({
    show: Boolean,
    service: Object,
    category_service: Object
})

const form = useForm({
    category_id: '',
    name: '',
    description: '',
    price: '',
})


const updateNewService = () => {
    form.put(route('service.update', props.service?.id), {
        preserveScroll:true,
        onSuccess: () => {
            closeModal()
            form.reset()
        },
        onFinish: () => form.reset(),
    })
}

const emit = defineEmits(['close'])

onMounted(() => {
    modal.value = useModal('#updateCService')
})

const closeModal = () => {
    modal.value.hide()
    emit('close')
    form.reset()
}

const openModal = () => {
    modal.value.show()
}

watchEffect(() => {
    if (props.show) {
        openModal()
        form.category_id = props.service.category_id
        form.name = props.service.name
        form.description = props.service.description
        form.price = props.service.price
    }
})

onUnmounted(() => {
    closeModal()
})

const formatRupiah = (value) => {
  if (!value) return 'Rp 0';
  return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
};
</script>

<template>
    <Modal id="updateCService" @close="closeModal">
        <template #title>
            <h3 class="block-title">Update Service</h3>
            <div class="block-options">
                <button type="button" class="btn-block-option" @click="closeModal">
                    <i class="fa fa-fw fa-times"></i>
                </button>
            </div>
        </template>
        <template #body>
            <div class="mb-3">
                <label class="form-label" for="category_id">Pegawai</label>
                <VueSelect v-model="form.category_id" id="category_id" name="category_id" placeholder="Cai Pegawai"
                    :options="category_service" label="name" :reduce="(category_service) => category_service.id">
                </VueSelect>
                <InputError :message="form.errors.category_id" />
            </div>

            <div class="mb-3">
                <InputLabel for="name" value="name" />
                <TextInput id="name" ref="name" v-model="form.name" type="text" class="form-control" placeholder="Name" />
                <InputError :message="form.errors.name" class="mt-1" />
            </div>

            <div class="mb-3">
                <InputLabel for="description" value="Description" />
                <textarea class="form-control" id="description" name="description" placeholder="Description"
                    v-model="form.description" rows="3"></textarea>
                <InputError :message="form.errors.description" class="mt-1" />
            </div>

            <div class="mb-3">
                <InputLabel for="price" value="price" />
                <TextInput id="price" ref="price" v-model="form.price" type="number" class="form-control" placeholder="price" />
                <InputError :message="form.errors.price" class="mt-1" />
                <span>Formatted Price: {{ formatRupiah(form.price) }}</span>
            </div>
        </template>
        <template #footer>
            <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

            <button class="btn btn-primary ms-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                @click="updateNewService">
                Simpan
            </button>
        </template>
    </Modal>
</template>

<style lang="scss">
@import "vue-select/dist/vue-select.css";
@import "@/assets/scss/vendor/vue-select";
@import "@/assets/scss/vendor/vueform-slider";
</style>
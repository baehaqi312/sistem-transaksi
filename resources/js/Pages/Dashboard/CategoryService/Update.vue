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

const modal = ref(null);

const props = defineProps({
    show: Boolean,
    category_service: Object
});

const form = useForm({
    image: null,
    name: '',
});

const updateNewCategory = () => {
    form.put(route('category_service.update', props.category_service?.id), {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
        },
        onError: (errors) => {
            console.log(errors);
        },
    });
};

const emit = defineEmits(['close']);

onMounted(() => {
    modal.value = useModal('#updateCCategory');
});

const closeModal = () => {
    modal.value.hide();
    emit('close');
    form.reset();
};

const openModal = () => {
    modal.value.show();
};

watchEffect(() => {
    if (props.show) {
        openModal();
        form.name = props.category_service?.name;
        form.image = props.category_service?.images;
    }
});

onUnmounted(() => {
    closeModal();
});
</script>

<template>
    <Modal id="updateCCategory" @close="closeModal">
        <template #title>
            <h3 class="block-title">Update Service</h3>
            <div class="block-options">
                <button type="button" class="btn-block-option" @click="closeModal">
                    <i class="fa fa-fw fa-times"></i>
                </button>
            </div>
        </template>
        <template #body>
            <div class="mb-3" v-if="props.category_service">
                <img v-if="props.category_service.images" class="img-fluid options-item" :src="`storage/${category_service.images}`" :alt="props.category_service.name">
            </div>

            <div class="mb-3">
                <label class="form-label" for="image">Images</label>
                <input class="form-control" type="file" @change="e => form.image = e.target.files[0]" id="image" name="image" />
            </div>

            <div class="mb-3">
                <InputLabel for="name" value="name" />
                <TextInput id="name" ref="name" v-model="form.name" type="text" class="form-control" placeholder="Name" />
                <InputError :message="form.errors.name" class="mt-1" />
            </div>
        </template>
        <template #footer>
            <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>
            <button class="btn btn-primary ms-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="updateNewCategory">
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

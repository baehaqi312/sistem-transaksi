<script setup>
import { ref } from 'vue';

const input = ref(null)

const props = defineProps({
    modelValue: {
        required: true
    }
})

const emit = defineEmits(["update:model.value"])
</script>

<template>
    <!-- Search Form -->
    <div class="push">
        <div class="input-group">
            <input type="text" class="form-control form-control-alt"
                @input="$emit('update:modelValue', $event.target.value)" ref="input"
                placeholder="Search all orders.." />
            <span class="input-group-text bg-body border-0">
                <i class="fa fa-search"></i>
            </span>
        </div>
    </div>
    <!-- END Search Form -->
</template>
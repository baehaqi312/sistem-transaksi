<script setup>
defineProps({
    message: {
        type: String,
    },
});
</script>

<template>
    <div v-show="message">
        <div class="text-sm text-danger animated fadeIn">
            {{ message }}
        </div>
    </div>
</template>

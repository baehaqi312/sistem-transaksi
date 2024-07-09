<script setup>
const props = defineProps({
    id: { type: String, required: true },
    size: { type: String, default: null }
})

const emit = defineEmits(["closeModal"])
</script>

<template>
    <!-- Fade In Block Modal -->
    <div class="modal fade" :id="props.id" tabindex="-1">
        <div class="modal-dialog" :size="props.size">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <!-- <h3 class="block-title">Modal Title</h3> -->
                        <slot name="title" />
                    </div>
                    <div class="block-content fs-sm mb-4">
                        <slot name="body" />
                    </div>
                    <div class="block-content block-content-full text-end bg-body">
                        <slot name="footer" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Fade In Block Modal -->
</template>

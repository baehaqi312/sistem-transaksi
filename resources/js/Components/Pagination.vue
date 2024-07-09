<script setup>
import { router } from '@inertiajs/vue3';

const props = defineProps({
    data: Object
})

const goto = (link) => {
    router.get(link, {
        replace: true,
        preserveState: true,
        preserveScroll: true,
    })
}
</script>

<template>
    <!-- Pagination -->
    <div
        class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center text-center text-md-start">
        <div class="fs-sm">Showing
            <span>{{ data.from }}</span> to
            <span>{{ data.to }}</span> of
            <span>{{ data.total }}</span> entries
        </div>
        <nav>
            <ul class="pagination pagination-sm mb-0">
                <li class="page-item" v-for="(link, index) in data.links" :key="index"
                    :class="{ active: link.active, disabled: link.url == null }">
                    <a class="page-link" @click="goto(link.url)" v-html="link.label"></a>
                </li>
            </ul>
        </nav>
    </div>
    <!-- END Pagination -->
</template>
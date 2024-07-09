<script setup>
import App from '../App.vue';
import { useTemplateStore } from "@/stores/template";
import { Link } from '@inertiajs/vue3';
import { computed, onMounted, ref } from 'vue';

// Main store
const store = useTemplateStore();

// Set default color theme
store.setColorTheme({
    theme: store.settings.colorTheme,
});

// Render main classes based on store options
const classContainer = computed(() => {
    return {
        "page-header-dark":
            store.layout.header &&
            store.settings.headerDark &&
            !store.settings.darkMode,
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
</script>

<template>
    <App>
        <div class="hero-static d-flex align-items-center" :class="classContainer">

            <div class="content">
                <div class="row justify-content-center push">
                    <div class="col-md-8 col-lg-6 col-xl-4">
                        <slot />
                    </div>
                </div>
                <div class="fs-sm text-muted text-center">
                    <strong>{{ store.app.name }}</strong> &copy;
                    {{ store.app.copyright }}
                </div>
            </div>
        </div>
    </App>
</template>

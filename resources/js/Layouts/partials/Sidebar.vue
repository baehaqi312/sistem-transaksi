<script setup>
import BaseNavigation from "@/Components/BaseNavigation.vue";
import { ref, watch, onMounted } from "vue";
import { useTemplateStore } from "@/stores/template";
import { Link } from '@inertiajs/vue3';

import SimpleBar from "simplebar";

// Component properties
defineProps({
  withMiniNav: {
    type: Boolean,
    default: false,
    description: "If the sidebar is in Mini Nav Mode",
  },
});

// Main store
const store = useTemplateStore();

// Init SimpleBar (custom scrolling)
// onMounted(() => {
//   new SimpleBar(document.getElementById("simplebar-sidebar"));
// });


// Main menu toggling and mobile functionality
function linkClicked(e, submenu) {
  if (submenu) {
    // Get closest li element
    let el = e.target.closest("li");

    // Check if we are in a large screen, have horizontal navigation and hover is enabled
    if (
      !(
        window.innerWidth > 991 &&
        ((props.horizontal && props.horizontalHover) || props.disableClick)
      )
    ) {
      if (el.classList.contains("open")) {
        // If submenu is open, close it..
        el.classList.remove("open");
      } else {
        // .. else if submenu is closed, close all other (same level) submenus first before open it
        Array.from(el.closest("ul").children).forEach((element) => {
          element.classList.remove("open");
        });

        el.classList.add("open");
      }
    }
  } else {
    // If we are in mobile, close the sidebar
    if (window.innerWidth < 992) {
      store.sidebar({ mode: "close" });
    }
  }
}
</script>

<template>
  <nav id="sidebar" :class="{ 'with-mini-nav': withMiniNav }" aria-label="Main Navigation">
    <!-- Side Header -->
    <div class="content-header">
      <!-- Logo -->
      <slot name="header">
        <!-- Logo -->
        <Link :href="route('dashboard')" class="fw-semibold text-dual">
        <span class="smini-visible">
          <i class="fa fa-circle-notch text-primary"></i>
        </span>
        <span class="smini-hide fs-5 tracking-wider">
          <!-- <img src="@/assets/img/init.png" alt="Logo Init" style="width: 40px;"> -->
          PT Init Solusi Digital
        </span>
        </Link>
        <!-- END Logo -->
      </slot>
      <!-- END Logo -->

      <!-- Extra -->
      <div>
        <slot name="header-extra">

        </slot>

        <!-- Close Sidebar, Visible only on mobile screens -->
        <button type="button" class="d-lg-none btn btn-sm btn-alt-secondary ms-1"
          @click="store.sidebar({ mode: 'close' })">
          <i class="fa fa-fw fa-times"></i>
        </button>
        <!-- END Close Sidebar -->
      </div>
      <!-- END Extra -->
    </div>
    <!-- END Side Header -->

    <!-- Sidebar Scrolling -->
    <div id="simplebar-sidebar" class="js-sidebar-scroll">
      <slot name="content">
        <!-- Side Navigation -->
        <div class="content-side">
          <BaseNavigation />
        </div>
        <!-- END Side Navigation -->
      </slot>
    </div>
    <!-- END Sidebar Scrolling -->
  </nav>
  <!-- END Sidebar -->
</template>

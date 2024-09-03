<script setup>
import NavLink from '@/Components/NavLink.vue';
import { computed } from "vue";
import { Link } from '@inertiajs/vue3';
import { useTemplateStore } from "@/stores/template";

// Main store and Route
const store = useTemplateStore();

// Component properties
const props = defineProps({
  subMenu: {
    type: Boolean,
    default: false,
    description: "If true, a submenu will be rendered",
  },
});
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
  <ul class="nav-main">
    <li class="nav-main-item">
      <NavLink :href="route('dashboard')" :active="route().current('dashboard')" @click="linkClicked($event, false)">
        <i class="nav-main-link-icon si si-speedometer"></i>
        <span class="nav-main-link-name">Dasbor</span>
      </NavLink>
    </li>
    <template v-if="$page.props.auth.user.role == 1">
      <li class="nav-main-heading">Manajemen Sistem</li>
      <li class="nav-main-item">
        <NavLink :href="route('users.index')" :active="route().current('users.index')"
          @click="linkClicked($event, false)">
          <i class="nav-main-link-icon si si-speedometer"></i>
          <span class="nav-main-link-name">Pengguna Sistem</span>
        </NavLink>
      </li>
    </template>

    <template v-if="$page.props.auth.user.role == 2">
      <li class="nav-main-heading">MASTER LAYANAN & BROSUR</li>
      <li class="nav-main-item">
        <NavLink :href="route('service.index')" :active="route().current('service.index')"
          @click="linkClicked($event, false)">
          <i class="nav-main-link-icon si si-speedometer"></i>
          <span class="nav-main-link-name">Daftar Layanan</span>
        </NavLink>
      </li>
      <li class="nav-main-item">
        <NavLink :href="route('category_service.index')" :active="route().current('category_service.index')"
          @click="linkClicked($event, false)">
          <i class="nav-main-link-icon si si-speedometer"></i>
          <span class="nav-main-link-name">Daftar Brosur</span>
        </NavLink>
      </li>
    </template>

    <template v-if="$page.props.auth.user.role == 3">
      <li class="nav-main-heading">DAFTAR LAYANAN</li>
      <li class="nav-main-item">
        <NavLink :href="route('software_development.index')" :active="route().current('software_development.index')"
          @click="linkClicked($event, false)">
          <i class="nav-main-link-icon si si-speedometer"></i>
          <span class="nav-main-link-name">Pembuatan Website</span>
        </NavLink>
      </li>
      <li class="nav-main-item">
        <NavLink :href="route('digital_marketing.index')" :active="route().current('digital_marketing.index')"
          @click="linkClicked($event, false)">
          <i class="nav-main-link-icon si si-speedometer"></i>
          <span class="nav-main-link-name">Kelola Sosial Media</span>
        </NavLink>
      </li>
    </template>

    <li v-if="$page.props.auth.user.role == 1" class="nav-main-heading">Data Keuangan</li>
    <li v-else class="nav-main-heading">Data Transaksi</li>
    <li class="nav-main-item">
      <NavLink :href="route('transactions.index')" :active="route().current('transactions.index')"
        @click="linkClicked($event, false)">
        <i class="nav-main-link-icon far fa-file"></i>
        <span v-if="$page.props.auth.user.role == 1" class="nav-main-link-name">Laporan Transaksi</span>
        <span v-else class="nav-main-link-name">Daftar Transaksi</span>
      </NavLink>
    </li>
  </ul>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { ref, watch, onMounted, computed } from "vue";
import { useTemplateStore } from "@/stores/template";
import { usePage } from '@inertiajs/vue3'
import moment from 'moment';
import 'moment/locale/id'; // Mengimpor locale bahasa Indonesia

moment.locale('id'); // Mengatur locale bahasa Indonesia

const currentDateTime = ref(moment().format('dddd, D MMMM YYYY'));

// const updateDateTime = () => {
//   currentDateTime.value = moment().format('dddd, D MMMM YYYY');
// };

const currentTime = ref(moment().format('HH:mm:ss'));

const updateTime = () => {
  currentTime.value = moment().format('HH:mm:ss');
};

onMounted(() => {
  // setInterval(updateDateTime, 1000);
  setInterval(updateTime, 1000);
});

const page = usePage()

const cart = computed(() => page.props.cart)

// Main store and Router
const store = useTemplateStore();

const radioDarkMode = ref();

// Sets default dark mode preferences for radios
function setDarkModeRadioDefault() {
  if (store.settings.darkModeSystem) {
    radioDarkMode.value = "system";
  } else {
    if (store.settings.darkMode) {
      radioDarkMode.value = "dark";
    } else {
      radioDarkMode.value = "light";
    }
  }
}


// When the user sets dark mode preference through the radios
function onDarkModeRadioChange() {
  if (radioDarkMode.value === "system") {
    store.darkModeSystem({ mode: "on" });
  } else {
    store.darkModeSystem({ mode: "off" });

    if (radioDarkMode.value === "dark") {
      store.darkMode({ mode: "on" });
    } else {
      store.darkMode({ mode: "off" });
    }
  }
}

// Set dark mode preference radios default and watch for changes to store
setDarkModeRadioDefault();
watch(
  () => store.settings.darkModeSystem,
  () => {
    setDarkModeRadioDefault();
  }
);
watch(
  () => store.settings.darkMode,
  () => {
    setDarkModeRadioDefault();
  }
);
</script>

<template>
  <!-- Header -->
  <header id="page-header">
    <slot>
      <!-- Header Content -->
      <div class="content-header">
        <slot name="content">
          <!-- Left Section -->
          <div class="d-flex align-items-center">
            <slot name="content-left">
              <!-- Toggle Sidebar -->
              <button type="button" class="btn btn-sm btn-alt-secondary me-2 d-lg-none"
                @click="store.sidebar({ mode: 'toggle' })">
                <i class="fa fa-fw fa-bars"></i>
              </button>
              <!-- END Toggle Sidebar -->

              <!-- Open Search Section (visible on smaller screens) -->
              <!-- <button type="button" class="btn btn-sm btn-alt-secondary d-md-none" data-toggle="layout" data-action="header_search_on">
                <i class="fa fa-fw fa-search"></i>
              </button> -->
              <!-- END Open Search Section -->

              <!-- Search Form (visible on larger screens) -->
              <!-- <form class="d-none d-md-inline-block" action="be_pages_generic_search.html" method="POST">
                <div class="input-group input-group-sm">
                  <input type="text" class="form-control form-control-alt" placeholder="Search.." id="page-header-search-input2" name="page-header-search-input2">
                  <span class="input-group-text border-0">
                    <i class="fa fa-fw fa-search"></i>
                  </span>
                </div>
              </form> -->
              <!-- END Search Form -->

              <span class="fs-xs fw-bold d-none d-sm-inline-block py-2 px-3 rounded-pill bg-body-light">
                {{ currentDateTime }}
              </span>

              <span class="fs-xs fw-bold d-inline-block py-2 px-3 rounded-pill bg-body-light ms-2">
                {{ currentTime }}
              </span>
            </slot>
          </div>
          <!-- END Left Section -->

          <!-- Right Section -->
          <div class="d-flex align-items-center">
            <div class="dropdown d-inline-block mx-1">
              <button type="button" class="btn btn-sm btn-alt-secondary" id="sidebar-dark-mode-dropdown"
                data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                <i v-if="!store.settings.darkMode" class="far fa-sun"></i>
                <i v-if="store.settings.darkMode" class="fa fa-moon"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end dropdown-menu fs-sm smini-hide border-0"
                style="min-width: 11rem" aria-labelledby="sidebar-dark-mode-dropdown">
                <div class="px-3 py-2 space-y-2">
                  <div class="form-check form-block">
                    <input class="form-check-input" type="radio" id="radio-dark-mode-off" value="light"
                      v-model="radioDarkMode" @change="onDarkModeRadioChange" />
                    <label class="form-check-label fw-semibold" for="radio-dark-mode-off">
                      <i class="fa fa-fw fa-sun opacity-50 me-2"></i>
                      <span>Light</span>
                    </label>
                  </div>
                  <div class="form-check form-block">
                    <input class="form-check-input" type="radio" id="radio-dark-mode-on" value="dark"
                      v-model="radioDarkMode" @change="onDarkModeRadioChange" />
                    <label class="form-check-label fw-semibold" for="radio-dark-mode-on">
                      <i class="fa fa-fw fa-moon opacity-50 me-2"></i>
                      <span>Dark</span>
                    </label>
                  </div>
                  <div class="form-check form-block mb-0">
                    <input class="form-check-input" type="radio" id="radio-dark-mode-system" value="system"
                      v-model="radioDarkMode" @change="onDarkModeRadioChange" />
                    <label class="form-check-label fw-semibold" for="radio-dark-mode-system">
                      <i class="fa fa-fw fa-desktop opacity-50 me-2"></i>
                      <span>System</span>
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <!-- User Dropdown -->
            <div class="dropdown d-inline-block ms-2">
              <button type="button" class="btn btn-sm btn-alt-secondary d-flex align-items-center"
                id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="rounded-circle" src="@/assets/media/avatars/avatar10.jpg" alt="Header Avatar"
                  style="width: 21px;">
                <span class="d-none d-sm-inline-block ms-2">{{ $page.props.auth.user.name }}</span>
                <i class="fa fa-fw fa-angle-down d-none d-sm-inline-block opacity-50 ms-1 mt-1"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-md dropdown-menu-end p-0 border-0"
                aria-labelledby="page-header-user-dropdown">
                <div class="p-3 text-center bg-body-light border-bottom rounded-top">
                  <img class="img-avatar img-avatar48 img-avatar-thumb" src="@/assets/media/avatars/avatar10.jpg"
                    alt="">
                  <p class="mt-2 mb-0 fw-medium">{{ $page.props.auth.user.name }}</p>
                  <p class="mb-0 text-muted fs-sm fw-medium">Web Developer</p>
                </div>
                <div class="p-2">
                  <Link class="dropdown-item d-flex align-items-center justify-content-between"
                    :href="route('profile.edit')">
                  <span class="fs-sm fw-medium">Profile</span>
                  </Link>
                  <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                    <span class="fs-sm fw-medium">Settings</span>
                  </a>
                </div>
                <div role="separator" class="dropdown-divider m-0"></div>
                <div class="p-2">
                  <Link :href="route('logout')" method="post" as="button"
                    class="dropdown-item d-flex align-items-center justify-content-between">
                  <span class="fs-sm fw-medium">Log Out</span>
                  </Link>
                </div>
              </div>
            </div>
            <!-- END User Dropdown -->

            <!-- Toggle Side Overlay -->
            <button type="button" class="btn btn-sm btn-alt-secondary ms-2 space-x-1"
              @click="store.sideOverlay({ mode: 'toggle' })">
              <i class="fa fa-fw fa-cart-plus"></i>
              <span v-if="cart && cart.items.length" class="text-primary">•</span>
            </button>
            <!-- END Toggle Side Overlay -->
          </div>
          <!-- END Right Section -->
        </slot>
      </div>
      <!-- END Header Content -->

      <!-- Header Search -->
      <div id="page-header-search" class="overlay-header bg-body-extra-light">
        <div class="content-header">
          <form class="w-100" action="be_pages_generic_search.html" method="POST">
            <div class="input-group">
              <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
              <button type="button" class="btn btn-alt-danger" data-toggle="layout" data-action="header_search_off">
                <i class="fa fa-fw fa-times-circle"></i>
              </button>
              <input type="text" class="form-control" placeholder="Search or hit ESC.." id="page-header-search-input"
                name="page-header-search-input">
            </div>
          </form>
        </div>
      </div>
      <!-- END Header Search -->

      <!-- Header Loader -->
      <!-- Please check out the Loaders page under Components category to see examples of showing/hiding it -->
      <div id="page-header-loader" class="overlay-header bg-body-extra-light">
        <div class="content-header">
          <div class="w-100 text-center">
            <i class="fa fa-fw fa-circle-notch fa-spin"></i>
          </div>
        </div>
      </div>
      <!-- END Header Loader -->
    </slot>
  </header>
  <!-- END Header -->
</template>

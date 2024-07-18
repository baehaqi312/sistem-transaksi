<script setup>
import { reactive, onMounted, onUnmounted } from "vue";
import { useTemplateStore } from "@/stores/template";
import BaseBlock from '@/Components/BaseBlock.vue';
import { router, useForm } from "@inertiajs/vue3";

// SimpleBar, for more info and examples you can check out https://github.com/Grsmto/simplebar/tree/master/packages/simplebar-vue
import SimpleBar from "simplebar";

const props = defineProps({
    cart: {
        type: Object,
        required: true
    }
});

const form = useForm({})

// Main store
const store = useTemplateStore();

// Close side overlay on ESCAPE key down
function eventSideOverlay(event) {
  if (event.which === 27) {
    event.preventDefault();
    store.sideOverlay({ mode: "close" });
  }
}

// Init SimpleBar (custom scrolling) and attach ESCAPE key event listener
onMounted(() => {
  new SimpleBar(document.getElementById("side-overlay"));

  document.addEventListener("keydown", eventSideOverlay);
});

// Remove keydown event listener
onUnmounted(() => {
  document.removeEventListener("keydown", eventSideOverlay);
});

const formatRupiah = (value) => {
    if (!value) return 'Rp 0';
    return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
};

const removeItem = (id) => {
  router.delete(route('cartItem.destroy', id));
}
</script>

<template>
  <!-- Side Overlay-->
  <aside id="side-overlay">
    <slot>
      <!-- Side Header -->
      <div class="content-header border-bottom">
        <slot name="header">
          <!-- User Avatar -->
          <a class="img-link me-1" href="javascript:void(0)">
            <img
              class="img-avatar img-avatar32"
              src="/assets/media/avatars/avatar10.jpg"
              alt="Avatar"
            />
          </a>
          <!-- END User Avatar -->

          <!-- User Info -->
          <div class="ms-2">
            <a class="text-dark fw-semibold fs-sm" href="javascript:void(0)"
              >{{ $page.props.auth.user.name }}</a
            >
          </div>
          <!-- END User Info -->
        </slot>

        <!-- Close Side Overlay -->
        <button
          type="button"
          class="ms-auto btn btn-sm btn-alt-danger"
          @click="store.sideOverlay({ mode: 'close' })"
        >
          <i class="fa fa-fw fa-times"></i>
        </button>
        <!-- END Close Side Overlay -->
      </div>
      <!-- END Side Header -->

      <slot name="content">
        <!-- Side Content -->
        <div class="content-side">
          <!-- Side Overlay Tabs -->
          <BaseBlock transparent :rounded="false" class="pull-x pull-t">
            <template #content>
              <div class="block-content tab-content overflow-hidden">
                <!-- Overview Tab -->
                <div
                  class="tab-pane pull-x fade fade-left show active"
                  id="so-overview"
                  role="tabpanel"
                  aria-labelledby="so-overview-tab"
                  tabindex="0"
                >
                  <!-- Activity -->
                  <BaseBlock
                    title="Keranjang"
                    header-bg
                    transparent
                    btn-option-content
                  >
                    <ul class="nav-items mb-0" v-if="cart && cart.items.length">
                      <li v-for="(item, index) in cart.items" :key="index">
                        <div class="text-dark d-flex py-2 justify-content-center align-items-center">
                          <!-- <div class="flex-shrink-0 me-3 ms-2">
                            <i
                              :class="`${appEvent.icon} text-${appEvent.color}`"
                            ></i>
                          </div> -->
                          <div class="flex-grow-1 fs-sm">
                            <div class="fw-semibold">{{ item.product.categoryservices.name }}</div>
                            <div>{{ item.product.name }}</div>
                            <small class="text-muted">{{ formatRupiah(item.product.price) }}</small>
                          </div>
                          <form @submit.prevent="removeItem(item.id)">
                            <input type="hidden" name="_method" value="DELETE">
                            <button class="btn btn-danger btn-sm" type="submit"><i class="far fa-trash-can"></i></button>
                          </form>
                        </div>
                      </li>
                    </ul>
                    <ul v-else class="nav-items mb-0">
                      <li>
                        <div class="text-muted text-center">
                          <small>
                            Keranjang Kosong
                          </small>
                        </div>
                      </li>
                    </ul>
                  </BaseBlock>
                  <!-- END Activity -->
                  <!-- END Quick Settings -->
                </div>
                <!-- END Overview Tab -->
              </div>
            </template>
          </BaseBlock>
          <!-- END Side Overlay Tabs -->
        </div>
        <!-- END Side Content -->
      </slot>
    </slot>
  </aside>
  <!-- END Side Overlay -->
</template>

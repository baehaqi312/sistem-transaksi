<script setup>
import DetailTransactions from "./Detail.vue";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BaseBlock from '@/Components/BaseBlock.vue';
import Pagination from '@/Components/Pagination.vue';
import Search from '@/Components/Search.vue';
import { Head, usePage, router, Link } from '@inertiajs/vue3';
import { reactive, ref, watch, computed } from 'vue';
import { cloneDeep, debounce, pickBy } from 'lodash';
import moment from 'moment';

// Define props
const props = defineProps({
  transactions: Object,
  filters: Object,
  totalIncome: String,
  totalSub: String
});

const filters = reactive({
  search: props.filters.search,
  status: props.filters.status || '',
  sort_by: props.filters.sort_by || '',
  sort_order: props.filters.sort_order || 'asc'

})

function setStatusFilter(status) {
  filters.status = status;
}

watch(
  () => cloneDeep(filters),
  debounce(() => {
    const params = pickBy(filters);
    router.get(route('transactions.index'), params, {
      replace: true,
      preserveState: true,
      preserveScroll: true
    });
  }, 150)
);

// Helper variables
const orderSearch = ref(false);

const formatRupiah = (number) => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
  }).format(number)
}

const formatDate = (date) => {
  return moment(date).format('DD-MM-YYYY');
}

function setSort(field) {
  if (filters.sort_by === field) {
    filters.sort_order = filters.sort_order === 'asc' ? 'desc' : 'asc';
  } else {
    filters.sort_by = field;
    filters.sort_order = 'asc';
  }
}

function sortIcon(field) {
  if (filters.sort_by !== field) return 'fa fa-sort';
  return filters.sort_order === 'asc' ? 'fa fa-sort-up' : 'fa fa-sort-down';
}

const data = reactive({
  transactions: null,
  openModal: false,
})
</script>

<template>

  <Head title="Transaksi" />
  <AuthenticatedLayout>
    <DetailTransactions title="Detail Transaksi" :show="data.openModal" @close="data.openModal = false"
      :transactions="data.transactions" />
    <!-- Hero -->
    <div class="">
      <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
          <div class="flex-grow-1">
            <h1 class="h3 fw-bold mb-1">
              Daftar Transaksi
            </h1>
          </div>
          <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-alt">
              <li class="breadcrumb-item">
                <Link class="link-fx" :href="route('dashboard')">Dashboard</Link>
              </li>
              <li class="breadcrumb-item" aria-current="page">
                Daftar Transaksi
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
    <!-- END Hero -->

    <!-- Recent Orders -->
    <div class="content">
      <BaseBlock title="Transaksi">
        <template #options>
          <div class="space-x-1">
            <button type="button" class="btn btn-sm btn-alt-secondary" @click="() => {
      orderSearch = !orderSearch;
    }
      ">
              <i class="fa fa-search"></i>
            </button>
            <div class="dropdown d-inline-block">
              <button type="button" class="btn btn-sm btn-alt-secondary" id="dropdown-recent-orders-filters"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-fw fa-flask"></i>
                Filters
                <i class="fa fa-angle-down ms-1"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-md dropdown-menu-end fs-sm"
                aria-labelledby="dropdown-recent-orders-filters">
                <a class="dropdown-item fw-medium d-flex align-items-center justify-content-between"
                  href="javascript:void(0)" @click="setStatusFilter('pending')">
                  Pending
                </a>
                <a class="dropdown-item fw-medium d-flex align-items-center justify-content-between"
                  href="javascript:void(0)" @click="setStatusFilter('active')">
                  Active
                </a>
                <a class="dropdown-item fw-medium d-flex align-items-center justify-content-between"
                  href="javascript:void(0)" @click="setStatusFilter('completed')">
                  Completed
                </a>
                <a class="dropdown-item fw-medium d-flex align-items-center justify-content-between"
                  href="javascript:void(0)" @click="setStatusFilter('')">
                  All
                </a>
              </div>
            </div>
          </div>
        </template>

        <template #content>
          <div v-if="orderSearch" class="block-content border-bottom">
            <!-- Search Form -->
            <Search v-model="filters.search" />
            <!-- END Search Form -->
          </div>
          <div class="block-content block-content-full">
            <!-- Recent Orders Table -->
            <div class="table-responsive">
              <table class="table table-hover table-vcenter" v-if="transactions.data.length > 0">
                <thead>
                  <tr>
                    <th @click="setSort('invoice_code')">Order ID <i class="gg-select float-end"></i></th>
                    <th @click="setSort('user.name')" class="d-none d-sm-table-cell">Customer <i
                        class="gg-select float-end"></i></th>
                    <th @click="setSort('user.phone')" class="d-none d-sm-table-cell">Phone <i
                        class="gg-select float-end"></i></th>
                    <th @click="setSort('status')" class="text-center">Status <i class="gg-select float-end"></i>
                    </th>
                    <th @click="setSort('created_at')" class="d-none d-sm-table-cell text-end">Created <i
                        class="gg-select float-end"></i></th>
                    <th @click="setSort('total')" class="d-none d-sm-table-cell text-center">Value <i
                        class="gg-select float-end"></i></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody class="fs-sm">
                  <tr v-for="(transaction, index) in transactions.data  " :key="index">
                    <td>
                      <a type="button" class="fw-semibold"
                        @click="(data.openModal = true), data.transactions = transaction">
                        {{ transaction.invoice_code }}
                      </a>
                    </td>
                    <td class="d-none d-sm-table-cell">
                      <a class="fw-semibold" href="javascript:void(0)">{{ transaction.user.name }}</a>
                      <p class="fs-sm fw-medium text-muted mb-0">{{ transaction.user.email }}</p>
                    </td>
                    <td class="d-none d-sm-table-cell fw-semibold text-muted">
                      <a href="#">
                        {{ transaction.user.phone }}
                      </a>
                    </td>
                    <td class="text-center">
                      <span v-if="transaction.status === 'pending'"
                        class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-warning-light text-warning">Pending</span>
                      <span v-if="transaction.status === 'active'"
                        class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-info-light text-info">Active</span>
                      <span v-if="transaction.status === 'completed'"
                        class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-success-light text-success">Completed</span>
                    </td>
                    <td class="d-none d-sm-table-cell fw-semibold text-muted text-end">
                      {{ formatDate(transaction.created_at) }}
                    </td>
                    <td class="d-none d-sm-table-cell text-end">
                      <strong>{{ formatRupiah(transaction.total) }}</strong>
                    </td>
                    <td class="text-end">
                      <div class="dropdown d-inline-block ms-2">
                        <button type="button" class="btn btn-sm btn-alt-secondary" id="dropdown-recent-orders-filters"
                          data-bs-toggle="dropdown">
                          <strong><i class="fa-solid fa-ellipsis-vertical"></i></strong>
                        </button>
                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-end fs-sm"
                          aria-labelledby="dropdown-recent-orders-filters">
                          <template v-if="$page.props.auth.user.role == 4">
                            <Link type="button" class="dropdown-item fw-medium d-flex align-items-center"
                              v-if="transaction.status === 'pending'" :href="(route('transactions.show', transaction))">
                            Bayar Sekarang
                            </Link>
                          </template>
                          <a type="button" class="dropdown-item fw-medium d-flex align-items-center"
                            @click="(data.openModal = true), data.transactions = transaction">
                            Detail Transaksi
                          </a>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr v-if="$page.props.auth.user.role == 1 || $page.props.auth.user.role == 2">
                    <td colspan="5" class="text-end"><strong>Sub Total</strong></td>
                    <td class="text-end">
                      <strong>{{ formatRupiah(props.totalSub) }}</strong>
                    </td>
                    <td></td>
                  </tr>
                  <tr v-if="$page.props.auth.user.role == 1 || $page.props.auth.user.role == 2">
                    <td colspan="5" class="text-end"><strong>Uang Masuk</strong></td>
                    <td class="text-end">
                      <strong>{{ formatRupiah(props.totalIncome) }}</strong>
                    </td>
                    <td></td>
                  </tr>
                </tbody>
              </table>
              <div v-else class="text-center fs-sm fw-medium text-muted">
                Tidak ada data user yang sesuai dengan pencarian.
              </div>
            </div>
            <!-- END Recent Orders Table -->
          </div>
          <div class="block-content block-content-full bg-body-light">
            <!-- Pagination -->
            <Pagination :data="props.transactions" />
            <!-- END Pagination -->
          </div>
        </template>
      </BaseBlock>
    </div>
    <!-- END Recent Orders -->


  </AuthenticatedLayout>
</template>

<style lang="scss" scoped>
.gg-select {
  box-sizing: border-box;
  position: relative;
  display: block;
  transform: scale(1);
  width: 22px;
  height: 22px;
}

.gg-select::after,
.gg-select::before {
  content: "";
  display: block;
  box-sizing: border-box;
  position: absolute;
  width: 8px;
  height: 8px;
  left: 7px;
  transform: rotate(-45deg);
}

.gg-select::before {
  border-left: 2px solid;
  border-bottom: 2px solid;
  bottom: 4px;
  opacity: 0.3;
}

.gg-select::after {
  border-right: 2px solid;
  border-top: 2px solid;
  top: 4px;
  opacity: 0.3;
}

th.sort {
  cursor: pointer;
  user-select: none;

  &.asc {
    .gg-select::after {
      opacity: 1;
    }
  }

  &.desc {
    .gg-select::before {
      opacity: 1;
    }
  }
}
</style>
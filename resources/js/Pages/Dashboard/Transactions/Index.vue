<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BaseBlock from '@/Components/BaseBlock.vue';
import Pagination from '@/Components/Pagination.vue';
import Search from '@/Components/Search.vue';
import { Head, usePage, router, Link } from '@inertiajs/vue3';
import { reactive, computed, onMounted  } from 'vue';
import {
  Dataset,
  DatasetItem,
  DatasetInfo,
  DatasetPager,
  DatasetSearch,
  DatasetShow,
} from "vue-dataset";

// Define props
const props = defineProps({
    transactions: Object,
});

console.info(props.transactions)

const cols = reactive([
  {
    name: "Invoice Code",
    field: "invoice_code",
    sort: "",
  },
  {
    name: "Name",
    field: "user && user.name",
    sort: "",
  },
  {
    name: "items",
    field: "items.quantity",
    sort: "",
  },
  {
    name: "total",
    field: "total",
    sort: "",
  },
]);

const formatRupiah = (number) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
    }).format(number)
}


// Sort by functionality
const sortBy = computed(() => {
  return cols.reduce((acc, o) => {
    if (o.sort) {
      o.sort === "asc" ? acc.push(o.field) : acc.push("-" + o.field);
    }
    return acc;
  }, []);
});

// On sort th click
function onSort(event, i) {
  let toset;
  const sortEl = cols[i];

  if (!event.shiftKey) {
    cols.forEach((o) => {
      if (o.field !== sortEl.field) {
        o.sort = "";
      }
    });
  }

  if (!sortEl.sort) {
    toset = "asc";
  }

  if (sortEl.sort === "desc") {
    toset = event.shiftKey ? "" : "asc";
  }

  if (sortEl.sort === "asc") {
    toset = "desc";
  }

  sortEl.sort = toset;
}

// Apply a few Bootstrap 5 optimizations
onMounted(() => {
  // Remove labels from
  document.querySelectorAll("#datasetLength label").forEach((el) => {
    el.remove();
  });

  // Replace select classes
  let selectLength = document.querySelector("#datasetLength select");

  selectLength.classList = "";
  selectLength.classList.add("form-select");
  selectLength.style.width = "80px";
});
</script>

<template>

    <Head title="Transaksi" />
    <AuthenticatedLayout>
        <!-- Hero -->
        <div class="">
            <div class="content content-full">
                <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                    <div class="flex-grow-1">
                        <h1 class="h3 fw-bold mb-1">
                            Daftar Layanan
                        </h1>
                    </div>
                    <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-alt">
                            <li class="breadcrumb-item">
                                <Link class="link-fx" :href="route('dashboard')">Dashboard</Link>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                Daftar Layanan
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- END Hero -->

        <!-- Pengguna -->
        <div class="content">
            <!-- <h1>Your Transactions</h1>
            <ul v-if="transactions.length > 0">
            <li v-for="(items, index) in transactions.data" :key="index">
                <h3>Transaction {{ items.invoice_code }} - {{ items.invoice_code }}</h3>
                <ul>
                <li v-for="item in items.items" :key="item.id">
                    {{ item.service.name }} - {{ item.quantity }} x {{ formatRupiah(item.price) }}
                </li>
                </ul>
                <p>Total: ${{ items.total }}</p>
            </li>
            </ul>
            <p v-else>You have no transactions.</p> -->

            <BaseBlock title="Vue Dataset" content-full>
                <Dataset v-slot="{ ds }" :ds-data="transactions" :ds-sortby="sortBy"
                    :ds-search-in="['invoice_code', 'searchable_name']">
                    <!-- <pre>{{ ds }}</pre>  -->
                    <div class="row" :data-page-count="ds.dsPagecount">
                        <div id="datasetLength" class="col-md-8 py-2">
                            <DatasetShow />
                        </div>
                        <div class="col-md-4 py-2">
                            <DatasetSearch ds-search-placeholder="Search..." />
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th v-for="(th, index) in cols" :key="th.field" :class="['sort', th.sort]"
                                                @click="onSort($event, index)">
                                                {{ th.name }} <i class="gg-select float-end"></i>
                                            </th>
                                        </tr>
                                    </thead>
                                    <DatasetItem tag="tbody" class="fs-sm">
                                        <template #default="{ row, rowIndex }">
                                            <tr>
                                                <th scope="row">{{ rowIndex + 1 }}</th>
                                                <td style="min-width: 150px">{{ row.invoice_code }}</td>
                                                <td>{{ row.user && row.user.name }}</td>
                                                <td style="min-width: 150px">{{ row.items && row.items.length }}</td>
                                                <td style="min-width: 150px">{{ row.total }}</td>
                                            </tr>
                                        </template>
                                    </DatasetItem>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-md-row flex-column justify-content-between align-items-center">
                        <DatasetInfo class="py-3 fs-sm" />
                        <DatasetPager class="flex-wrap py-3 fs-sm" />
                    </div>
                </Dataset>
            </BaseBlock>
        </div>
        <!-- END Pengguna -->


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
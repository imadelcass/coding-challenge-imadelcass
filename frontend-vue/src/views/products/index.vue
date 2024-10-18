<template>
  <div>
    <vxe-grid v-bind="{ ...gridOptions, columns }">
      <template #toolbar_buttons="{ row }">
        <el-button type="primary" @click="addItem()"> add product </el-button>
      </template>
    </vxe-grid>
  </div>

  <add-update />
</template>

<script setup>
import { useProductstore } from '@/stores/product.js'
import { useCategoryStore } from '@/stores/category.js'
import AddUpdate from './components/AddUpdate.vue'
import { ref, provide } from 'vue'
import { onMounted } from 'vue'
import { computed } from 'vue'

const productstore = useProductstore()
const categoryStore = useCategoryStore()

onMounted(() => categoryStore.fetch({ all: true }))

const gridOptions = ref({
  border: true,
  height: 500,
  toolbarConfig: {
    slots: {
      buttons: 'toolbar_buttons',
    },
  },
  filterConfig: {
    remote: true,
  },
  sortConfig: {
    remote: true,
  },
  pagerConfig: {},
  proxyConfig: {
    filter: true,
    sort: true,
    ajax: {
      query: ({ page, filters, sort }) => {
        console.log(sort)
        let queryParams = {
          page,
          sort: sort.field ? `${sort.order == 'desc'  ? '-' : ''}${sort.field}` : '',
          filter: {},
        }
        filters.forEach(({ field, values, datas }) => {
          queryParams.filter[field] = values.join(',') || datas.join(',')
        })

        return new Promise(resolve => {
          productstore.fetch(queryParams).then(res => {
            resolve({ result: res.data, page: { total: res.total } })
          })
        })
      },
    },
  },
})

const columns = computed(() => [
  {
    field: 'name',
    title: 'Name',
    filters: [{ data: '' }],
    filterRender: { name: 'input' },
    sortable: true,
  },
  {
    field: 'price',
    title: 'price',
    filters: [{ data: '' }],
    filterRender: { name: 'input' },
    sortable: true,
  },

  {
    field: 'categories.id',
    title: 'categories',
    formatter: ({ row }) =>
      row.categories.map(category => category.name).join(', '),
    filters: categoryStore.categories.map(({ id, name }) => ({
      label: name,
      value: id,
    })),
  },
  { field: 'description', title: 'description' },
])

const modelVisible = ref(false)
const item = ref({})
const setModelVisible = value => (modelVisible.value = value)
provide('product_model', { modelVisible, item, setModelVisible })

const addItem = () => {
  item.value = {}
  setModelVisible(true)
}
const updateItem = row => {
  item.value = Object.assign({}, row)
  setModelVisible(true)
}
const deleteItem = ({ id }) => {
  feeStore.delete(id).then(() => refresh())
}
</script>

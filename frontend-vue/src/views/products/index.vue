<template>
  <div>
    <vxe-grid v-bind="gridOptions">
      <template #toolbar_buttons="{ row }">
        <el-button type="primary" @click="addItem()"> add product </el-button>
      </template>
    </vxe-grid>
  </div>

  <add-update />
</template>

<script setup>
import { useProductstore } from '@/stores/product.js'
import AddUpdate from './components/AddUpdate.vue'
import { ref, provide } from 'vue'

const productstore = useProductstore()
const gridOptions = ref({
  border: true,
  height: 500,
  toolbarConfig: {
    slots: {
      buttons: 'toolbar_buttons',
    },
  },
  pagerConfig: {},
  proxyConfig: {
    ajax: {
      query: ({ page }) => {
        return new Promise(resolve => {
          productstore.fetch(page).then(res => {
            resolve({ result: res.data, page: { total: res.total } })
          })
        })
      },
    },
  },
  columns: [
    { field: 'name', title: 'Name' },
    { field: 'price', title: 'price' },
    { field: 'description', title: 'description' },
  ],
})
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

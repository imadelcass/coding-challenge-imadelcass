<template>
  <el-dialog
    v-model="modelVisible"
    :modal="true"
    draggable
    :close-on-click-modal="false"
    :style="{ width: '50%' }"
  >
    <template #header>
      <div>
        <h3>{{ form.id ? 'edit' : 'add' }}</h3>
      </div>
    </template>
    <el-form
      ref="formRef"
      v-loading="loading"
      :model="form"
      :rules="rules"
      label-width="120px"
      status-icon
      label-position="top"
    >
      <div class="grid grid-cols-1 gap-2">
        <div class="col-span-1">
          <el-form-item label="sector" prop="sector_id" label-width="100%">
            <!-- <el-select v-model="form.sector_id" class="w-full">
              <el-option
                v-for="item in sectorStore.sectors"
                :key="item.id"
                :label="item.label"
                :value="item.id"
              />
            </el-select> -->    
          </el-form-item>
        </div>
      </div>
    </el-form>
    <template #footer>
      <el-button @click="setModelVisible(false)">{{ cancel }}</el-button>
      <el-button type="primary" :loading="loading" @click="submit(formRef)">{{
        save
      }}</el-button>
    </template>
  </el-dialog>
</template>

<script setup>
import { inject, ref, watch, defineEmits } from 'vue'
import { useProductstore } from '@/stores/product.js'

const initForm = {
  amount: null,
  sector_id: null,
  interval_id: null,
}
const form = ref(initForm)
const formRef = ref(null)
const loading = ref(false)
const emit = defineEmits(['refresh'])

const productStore = useProductstore()

const { modelVisible, item, setModelVisible } = inject('product_model', false)

const rules = {
  amount: [{ required: true, message: 'please-input-amount', trigger: 'blur' }],
  fee_type_id: [
    { required: true, message: 'please-select-fee-type', trigger: 'blur' },
  ],
  sector_id: [
    { required: true, message: 'please-select-sector', trigger: 'blur' },
  ],
  interval_id: [
    { required: true, message: 'please-select-interval', trigger: 'blur' },
  ],
}

watch(item, newVal => {
  if (newVal.id) {
    form.value = Object.assign({}, newVal)
  } else {
    form.value = Object.assign({}, initForm)
  }
})

const submit = formRef => {
  formRef.validate(valid => {
    if (valid) {
      loading.value = true
      if (form.value.id) {
        productStore
          .update(form.value)
          .then(() => reset())
          .catch(() => (loading.value = false))
      } else {
        productStore
          .add(form.value)
          .then(() => reset())
          .catch(() => (loading.value = false))
      }
    }
  })
}

const reset = () => {
  form.value = Object.assign({}, initForm)
  setModelVisible(false)
  loading.value = false
  emit('refresh')
}
</script>

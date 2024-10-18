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
      <div class="grid grid-cols-2 gap-2">
        <div class="col-span-1">
          <el-form-item label="name" prop="name" label-width="100%">
            <el-input v-model="form.name" class="w-full" />
          </el-form-item>
        </div>
        <div class="col-span-1">
          <el-form-item label="price" prop="price" label-width="100%">
            <el-input-number
              v-model="form.price"
              :min="0"
              :step="0.01"
              class="!w-full"
            />
          </el-form-item>
        </div>
        <div class="col-span-1">
          <el-form-item label="cotegories" prop="categories" label-width="100%">
            <el-select v-model="form.categories" multiple class="w-full">
              <el-option
                v-for="item in categoryStore.categories"
                :key="item.id"
                :label="item.name"
                :value="item.id"
              />
            </el-select>
          </el-form-item>
        </div>
        <div class="col-span-2">
          <el-form-item
            label="description"
            prop="description"
            label-width="100%"
          >
            <el-input
              v-model="form.description"
              type="textarea"
              class="w-full"
            />
          </el-form-item>
        </div>
      </div>
    </el-form>
    <template #footer>
      <el-button @click="setModelVisible(false)">cancel</el-button>
      <el-button type="primary" :loading="loading" @click="submit(formRef)"
        >save</el-button
      >
    </template>
  </el-dialog>
</template>

<script setup>
import { inject, ref, watch, defineEmits } from 'vue'
import { useProductstore } from '@/stores/product.js'
import { useCategoryStore } from '@/stores/category.js'

const categoryStore = useCategoryStore()

const initForm = {
  name: null,
  price: null,
  description: null,
}
const form = ref(initForm)
const formRef = ref(null)
const loading = ref(false)
const emit = defineEmits(['refresh'])

const productStore = useProductstore()

const { modelVisible, item, setModelVisible } = inject('product_model', false)

const rules = {
  name: [{ required: true, message: 'please-input-name', trigger: 'blur' }],
  price: [{ required: true, message: 'please-input-price', trigger: 'blur' }],
  categories: [
    {
      required: true,
      message: 'please-select-at-least-one-category',
      trigger: 'blur',
    },
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

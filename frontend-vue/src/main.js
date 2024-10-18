import ElementPlus from 'element-plus'
import { createApp } from 'vue'
import { createPinia } from 'pinia'

import VxeUI from 'vxe-pc-ui'
import 'vxe-pc-ui/lib/style.css'
import VxeUITable from 'vxe-table'
import 'vxe-table/lib/style.css'
import './assets/main.css'
import 'element-plus/dist/index.css'

import App from './App.vue'
import router from './router'

VxeUI.setLanguage('en-US')

const app = createApp(App)

app.use(ElementPlus)
.use(VxeUI)
.use(VxeUITable)
app.use(createPinia())
app.use(router)

app.mount('#app')

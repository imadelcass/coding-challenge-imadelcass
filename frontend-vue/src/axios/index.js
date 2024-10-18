import axios from 'axios'

const baseURL = import.meta.env.VITE_API_URL

const config = { baseURL }

const instance = axios.create(config)

export default instance

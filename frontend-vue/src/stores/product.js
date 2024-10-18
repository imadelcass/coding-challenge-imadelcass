import { defineStore } from 'pinia';
import axios from '@/axios';

export const useProductstore = defineStore('products', {
  state: () => ({ products: [] }),

  actions: {
    fetch(params) {
      return new Promise((resolve) => {
        axios
          .get('products', { params })
          .then(({ data }) => resolve(data))
          .catch(() => resolve());
      });
    },
    add(product) {
      return new Promise((resolve, reject) => {
        axios
          .post('products', product)
          .then(({ data }) => resolve(data))
          .catch(() => reject());
      });
    },
    update(product) {
      return new Promise((resolve, reject) => {
        axios
          .put(`products/${product.id}`, product)
          .then(({ data }) => resolve(data))
          .catch(() => reject());
      });
    },
    delete(id) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`products/${id}`)
          .then(({ data }) => resolve(data))
          .catch(() => reject());
      });
    }
  }
});

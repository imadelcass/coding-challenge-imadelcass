import { defineStore } from 'pinia';
import axios from '@/axios';

export const useCategoryStore = defineStore('categories', {
  state: () => ({ categories: [] }),

  actions: {
    fetch(params) {
      return new Promise((resolve) => {
        axios
          .get('categories', { params })
          .then(({ data }) => {
            if (params.all) {
              this.categories = data
              resolve()
            } else {
              resolve(data)
            }
          })
          .catch(() => resolve());
      });
    },
    add(category) {
      return new Promise((resolve, reject) => {
        axios
          .post('categories', category)
          .then(({ data }) => resolve(data))
          .catch(() => reject());
      });
    },
    update(category) {
      return new Promise((resolve, reject) => {
        axios
          .put(`categories/${category.id}`, category)
          .then(({ data }) => resolve(data))
          .catch(() => reject());
      });
    },
    delete(id) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`categories/${id}`)
          .then(({ data }) => resolve(data))
          .catch(() => reject());
      });
    }
  }
});

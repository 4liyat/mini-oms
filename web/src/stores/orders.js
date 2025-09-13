import { defineStore } from 'pinia';

export const useOrdersStore = defineStore('orders', {
  state: () => ({
    orders: [],
    loading: false,
    error: null,
  }),
  actions: {
    // Aquí puedes agregar las acciones para interactuar con tu API Laravel
    // Por ejemplo: fetchOrders(), createOrder(), updateOrder(), etc.
    fetchOrders() {
      this.loading = true;
      // Lógica para llamar a la API
      this.loading = false;
    },
  },
});

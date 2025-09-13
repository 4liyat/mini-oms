import { defineStore } from 'pinia';

export const useOrdersStore = defineStore('orders', {
  state: () => ({
    orders: [],
    loading: false,
    error: null,
    token: null, // Agregamos el token al estado
  }),
  actions: {
    // Nueva acción para obtener el token de autenticación
    async login() {
      try {
        const response = await fetch('http://localhost:8000/api/login', {
          method: 'POST',
        });
        const data = await response.json();
        this.token = data.token;
      } catch (err) {
        console.error('Error al iniciar sesión:', err);
      }
    },

    async fetchOrders() {
      if (!this.token) {
        await this.login();
      }

      this.loading = true;
      this.error = null;
      try {
        const response = await fetch('http://localhost:8000/api/orders', {
          headers: {
            'Authorization': `Bearer ${this.token}`,
            'Accept': 'application/json',
          },
        });
        if (!response.ok) {
          throw new Error(`Error HTTP: ${response.status}`);
        }
        const data = await response.json();
        this.orders = data.data; 
      } catch (err) {
        this.error = err.message || 'Ocurrió un error al cargar las órdenes.';
      } finally {
        this.loading = false;
      }
    },
  },
});
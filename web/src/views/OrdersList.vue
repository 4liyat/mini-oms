<template>
  <div class="text-center">
    <h1 class="text-3xl font-bold mb-4">Lista de Órdenes de Servicio</h1>

    <div v-if="ordersStore.loading" class="text-gray-500">
      Cargando órdenes...
    </div>

    <div v-else-if="ordersStore.error" class="text-red-500">
      Error: {{ ordersStore.error }}
    </div>

    <div v-else>
      <p v-if="ordersStore.orders.length === 0" class="text-gray-600">
        No hay órdenes para mostrar.
      </p>

      <ul v-else class="space-y-4 text-left max-w-xl mx-auto">
        <li v-for="order in ordersStore.orders" :key="order.id" class="p-4 border rounded-lg shadow-sm">
          <router-link :to="{ name: 'OrderDetails', params: { id: order.id } }" class="block">
            <h2 class="text-xl font-semibold">{{ order.title }}</h2>
            <p class="text-sm text-gray-500">Estado: {{ order.status }}</p>
            <p class="text-sm text-gray-500">Creada en: {{ new Date(order.created_at).toLocaleDateString() }}</p>
          </router-link>
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { useOrdersStore } from '../stores/orders.js';

const ordersStore = useOrdersStore();

onMounted(async () => {
  await ordersStore.fetchOrders();
});
</script>
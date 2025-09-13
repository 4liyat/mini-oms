<template>
    <div class="text-center">
      <h1 class="text-3xl font-bold mb-4">Detalles de la Orden #{{ id }}</h1>
      <p class="text-gray-600">
        Aquí se mostrarán los detalles de la orden y podrás cambiar su estado.
      </p>
  
      <!-- Botón para regresar a la lista de órdenes -->
      <router-link to="/" class="mt-4 inline-block text-blue-500 hover:underline">
        Regresar a la lista
      </router-link>
    </div>
  </template>
  
  <script setup>
  import { onMounted } from 'vue';
  import { useRoute } from 'vue-router';
  
  // Obtiene el ID de la URL
  const route = useRoute();
  const id = route.params.id;
  
  onMounted(() => {
    // Lógica para cargar los detalles de la orden con el ID
  });
  </script>
  
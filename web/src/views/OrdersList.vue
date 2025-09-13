<template>
    <div class="text-center">
      <h1 class="text-3xl font-bold mb-4">Lista de Órdenes de Servicio</h1>
      <p class="text-gray-600">
        Aquí se mostrarán todas las órdenes.
        <br>
        Puedes hacer clic en una para ver los detalles.
      </p>
  
      <!-- Enlace de ejemplo para navegar a la vista de detalles -->
      <router-link :to="{ name: 'OrderDetails', params: { id: 1 } }" class="mt-4 inline-block text-blue-500 hover:underline">
        Ver detalles de la Orden #1
      </router-link>
    </div>
  </template>
  
  <script setup>
  // Lógica para cargar y filtrar órdenes
  </script>
  
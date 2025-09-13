import { createRouter, createWebHistory } from 'vue-router';
import OrdersList from '../views/OrdersList.vue';
import OrderDetails from '../views/OrderDetails.vue';

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '/',
      name: 'OrdersList',
      component: OrdersList,
    },
    {
      path: '/orders/:id',
      name: 'OrderDetails',
      component: OrderDetails,
      props: true,
    },
  ],
});

export default router;

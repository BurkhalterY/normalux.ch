import { createRouter, createWebHistory } from "vue-router"

const routes = [
  {
    path: "/",
    name: "Home",
    component: () => import("@/views/Home.vue"),
  },
  {
    path: "/play/:type",
    name: "Play",
    component: () => import("@/views/Play.vue"),
  },
  {
    path: "/gallery/:type?/:model?/:page?",
    name: "Gallery",
    component: () => import("@/views/Gallery.vue"),
  },
]

const router = createRouter({
  history: createWebHistory("/"),
  routes,
})

export default router

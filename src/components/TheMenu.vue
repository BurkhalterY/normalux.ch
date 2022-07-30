<template>
  <nav class="bg-white">
    <ul class="flex flex-col w-64 sticky top-0">
      <router-link
        :to="item.to"
        v-for="(item, index) of items"
        class="px-5 py-2 hover:bg-slate-700 hover:text-white"
        :class="index % 2 == 1 ? 'mb-5' : ''"
        :active-class="item.activeClass"
      >
        <li>{{ item.name }}</li>
      </router-link>
    </ul>
  </nav>
</template>

<script>
import { ref } from "vue"

export default {
  setup() {
    const items = ref([
      {
        name: "Mode normal",
        to: {
          name: "Play",
          params: { type: 1 },
        },
        activeClass: "text-white bg-green-500",
      },
      {
        name: "Galerie",
        to: {
          name: "Gallery",
          params: { type: 1 },
        },
        activeClass: "text-white bg-green-500",
      },
      {
        name: "Mode en chaîne",
        to: {
          name: "Play",
          params: { type: 2 },
        },
        activeClass: "text-white bg-orange-500",
      },
      {
        name: "Galerie",
        to: {
          name: "Gallery",
          params: { type: 2 },
        },
        activeClass: "text-white bg-orange-500",
      },
      {
        name: "Mode en rotation",
        to: {
          name: "Play",
          params: { type: 5 },
        },
        activeClass: "text-white bg-purple-500",
      },
      {
        name: "Galerie",
        to: {
          name: "Gallery",
          params: { type: 5 },
        },
        activeClass: "text-white bg-purple-500",
      },
      {
        name: "Mode Pixel Art",
        to: {
          name: "Play",
          params: { type: 6 },
        },
        activeClass: "text-white bg-black",
      },
      {
        name: "Galerie",
        to: {
          name: "Gallery",
          params: { type: 6 },
        },
        activeClass: "text-white bg-black",
      },
      {
        name: "Mode à l'aveugle",
        to: {
          name: "Play",
          params: { type: 7 },
        },
        activeClass: "text-white bg-red-500",
      },
      {
        name: "Galerie",
        to: {
          name: "Gallery",
          params: { type: 7 },
        },
        activeClass: "text-white bg-red-500",
      },
    ])

    return {
      items,
    }
  },
}
</script>

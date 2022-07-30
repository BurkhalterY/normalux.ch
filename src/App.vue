<template>
  <div class="min-h-screen h-full flex bg-slate-200">
    <TheMenu />
    <div>
      <router-view v-slot="{ Component }">
        <transition mode="out-in">
          <component :is="Component" />
        </transition>
      </router-view>
    </div>
    <TheFooter />
  </div>
</template>

<script setup>
import TheMenu from "@/components/TheMenu.vue"
import TheFooter from "@/components/TheFooter.vue"
</script>

<style scoped>
.v-enter-active,
.v-leave-active {
  transition: opacity 0.2s ease;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
}
</style>

<template>
  <div class="bg-white w-72 py-1 text-center">
    <img :src="'https://www.normalux.ch/medias/drawings/' + data.file" />
    <div class="font-bold">{{ data.pseudo }}</div>
    <div class="text-xs">{{ data.date }}</div>
  </div>
</template>

<script>
export default {
  props: {
    data: {
      type: Object,
      required: true,
    },
  },
}
</script>

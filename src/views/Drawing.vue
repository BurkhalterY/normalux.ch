<template>
  <div></div>
</template>

<script>
import Image from "@/components/Image.vue"
import { ref, onMounted } from "vue"
import { useRoute } from "vue-router"
import axios from "axios"

export default {
  components: { Image },
  setup() {
    const route = useRoute()
    const drawing = ref(null)

    onMounted(async () => {
      drawing.value = (
        await axios.get(
          `${import.meta.env.VITE_API_URL}drawing.php?id=${route.params.id}`
        )
      ).data.drawing
    })

    return { drawing }
  },
}
</script>

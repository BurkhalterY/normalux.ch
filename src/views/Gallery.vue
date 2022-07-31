<template>
  <div class="flex flex-wrap m-2 gap-2" ref="scrollComponent">
    <Image v-for="drawing of drawings" :data="drawing" />
  </div>
</template>

<script>
import Image from "@/components/Image.vue"
import { ref, onMounted, onUnmounted } from "vue"
import { useRoute } from "vue-router"
import axios from "axios"

export default {
  components: { Image },
  setup() {
    const route = useRoute()
    const drawings = ref([])
    const page = ref(0)
    const scrollComponent = ref(null)

    const loadMore = async () => {
      drawings.value = drawings.value.concat(
        (
          await axios.get(
            `${import.meta.env.VITE_API_URL}drawings.php?type=${
              route.params.type
            }&page=${page.value}`
          )
        ).data.drawings
      )
      page.value++
    }

    const handleScroll = async (e) => {
      if (
        scrollComponent.value.getBoundingClientRect().bottom <
        window.innerHeight
      ) {
        await loadMore()
      }
    }

    onMounted(async () => {
      await loadMore()
      window.addEventListener("scroll", handleScroll)
    })

    onUnmounted(() => {
      window.removeEventListener("scroll", handleScroll)
    })

    return { drawings, scrollComponent }
  },
}
</script>

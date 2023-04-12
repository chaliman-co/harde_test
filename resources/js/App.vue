<template>
  <h1>Harde Assessment</h1>
  <router-view></router-view>
</template>
<script>
import { getFromApi, hideLoader } from "./util";
export default {
  async created() {
    try {
      const response = await getFromApi("/books?limit=10");
      if (response.failed) return document.write("could not fetch books from Api. Please check your configuration and refresh the page");
      this.$store.commit("setBooks", response.data);
    } catch (err) {
      alert("error loading books from api. Please refresh to try again");
    } finally {
      hideLoader();
    }
  }
}
</script>
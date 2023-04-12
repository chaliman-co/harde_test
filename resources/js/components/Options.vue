<template>
  <div class="mobile-container">
    <div class="option-menu">
      <a href="#home" class="active" @click="showing = !showing">Action</a>
      <div class="options" :class="{ showing: showing }">
        <router-link :to="`/editbook?id=${book.id}`">Edit</router-link>
        <a @click.prevent="deleteBook()">Delete</a>
      </div>
    </div>
  </div>
</template>
<script>
import {deleteFromApi, showLoader, hideLoader} from "../util.js";
export default {
  props: ["book"],
  data() {
    return {
      showing: false
    }
  },
  methods: {
    async deleteBook() {
      if (confirm("are you sure you want to delete " + this.book.name + "?")) {
        showLoader();
        await deleteFromApi(`/books/${this.book.id}`);
        this.$store.commit("deleteBook", this.book);
        hideLoader();
      }
    }
  }
}

</script>
<style>
.showing {
  display: block !important;
}
body {
  font-family: Arial, Helvetica, sans-serif;
}

.mobile-container {
  max-width: 480px;
  margin: auto;
  background-color: #555;
  /* height: 500px; */
  color: white;
  border-radius: 10px;
}

.option-menu {
  overflow: hidden;
  background-color: #333;
  position: relative;
  height: 30px;
  overflow: visible;
}

.option-menu .options {
  display: none;
  background-color: black;
  z-index: 999;
  position: relative;
}

.option-menu a {
  color: white;
  text-decoration: none;
  font-size: 17px;
  display: block;
  height: 30px;
  padding: 0;
  line-height: 30px;
  text-align: center;
  border: 2px black solid;
}

.option-menu a.icon {
  background: black;
  display: block;
  position: absolute;
  right: 0;
  top: 0;
}

.option-menu a:hover {
  background-color: lightyellow;
  color: black;
}

.active {
  background-color: brown;
  color: white;
}
</style>
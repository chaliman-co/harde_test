<template>
  <h1>The First 10 Items In The Book Collection</h1>

  <table id="customers">
    <thead>
      <tr>
        <th>Name</th>
        <th>Authors</th>
        <th>Publisher</th>
        <th>ISBN</th>
        <th>Release Date</th>
        <th>Number of Pages</th>
        <th>Country</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="book in books" :key="book.id">
        <td>{{book.name}}</td>
        <td v-html="book.authors.join('<br>')"></td>
        <td>{{ book.publisher }}</td>
        <td>{{ book.isbn }}</td>
        <td>{{ book.release_date }}</td>
        <td>{{ book.number_of_pages }}</td>
        <td>{{ book.country }}</td>
        <td><Options :book="book"></Options></td>

        
      </tr>
    </tbody>
  </table>
</template>
<script>
import {mapState} from 'vuex';
import Options from "../components/Options.vue";

export default {
  computed: mapState({
    books: state => state.books
  }),
  components: {
    Options
  }
}
</script>
<style>
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td,
#customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even) {
  background-color: #f2f2f2;
}

#customers tr:hover {
  background-color: #ddd;
}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #04AA6D;
  color: white;
}</style>
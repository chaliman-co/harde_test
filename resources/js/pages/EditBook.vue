<template>
  <form @submit.prevent="event=>submit()" className='edit-book-form'>
    <fieldset>
      <legend>Edit Book {{ book.name }}</legend>

      <div className='container'>
        <label for='name'><b>Name</b></label>
        <input id='name' v-model="name" required>
        <label for='country'><b>Country</b></label>
        <input id='country' v-model="country" required>
        <label for='isbn'><b>ISBN</b></label>
        <input id='isbn' v-model="isbn" required>
        <label for='authors'><b>Authors (please separate authors by comma(,))</b></label>
        <input id='authors' v-model="authors" required>
        <label for='publisher'><b>Publisher</b></label>
        <input id='publisher' v-model="publisher" required>
        <label for='release_date'><b>Release Date</b></label>
        <input id='release_date' v-model="release_date" type="date" required>
        <label for='number_of_pages'><b>Number of Pages</b></label>
        <input id='number_of_pages' v-model="number_of_pages" required>
        <button type='submit'>Update</button>
      </div>
    </fieldset>
  </form>
</template>
<script>
import { mapState } from 'vuex';
import { updateAtApi, showLoader, hideLoader } from "../util";

export default {
  data() {
    return {
    }
  },
  methods: {
    async submit() {
      const update = {
        "name": this.name,
        "isbn": this.isbn,
        "authors": this.authors.split(","),
        "country": this.country,
        "number_of_pages": this.number_of_pages,
        "publisher": this.publisher,
        "release_date": this.release_date,
      };
      showLoader();
      try {
      const response = await updateAtApi(`/books/${this.book.id}`, JSON.stringify(update));
      if (response.succeeded) { console.log("success all the way")
        this.$store.commit("updateBook", this.book, response.data);
        alert("book successfuly updated");
      }
      else alert("update failed")
      } catch (err) {
        alert("update failed. Please try again");
      } finally {
        hideLoader();
      }
    }
  },
  created() {
    console.log(this.book)

    this.name = this.book.name;
    this.isbn = this.book.isbn;
    this.authors = this.book.authors.join(",");
    this.country = this.book.country;
    this.number_of_pages = this.book.number_of_pages;
    this.publisher = this.book.publisher;
    this.release_date = this.book.release_date;
  },
  computed: mapState({
    book(state) {
      return state.books.find(book => book.id == this.$route.query.id);
    }
  })
}

</script>
<style>
body {
  font-family: Arial, Helvetica, sans-serif;
}

legend {
  margin: auto;
  font-weight: 600;
  font-size: 1.3em;
}

.edit-book-form {
  border: 3px solid #f1f1f1;
  margin-top: 50px;
}

fieldset {
  border: 0;
  max-width: 700px;
  margin: auto;
}

input {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: bbook-box;
}

.edit-book-form label {
  float: left;
}

button {
  background-color: #04AA6D;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

button:hover {
  opacity: 0.8;
}


.container {
  padding: 16px;
}

span.psw {
  float: right;
  padding-top: 16px;
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
  span.psw {
    display: block;
    float: none;
  }

  .cancelbtn {
    width: 100%;
  }
}
</style>
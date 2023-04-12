import { createStore } from "vuex";
export default createStore({
  state: {
    books: []
  },
  mutations: {
    setBooks(state, books) {
      state.books = books;
    },
    deleteBook(state, book) {
      state.books = state.books.filter(anotherBook => anotherBook != book);
    },
    updateBook(state, book, update) {
      Object.assign(book, update);
    }
  }
});
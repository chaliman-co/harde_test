import { createRouter, createWebHistory } from "vue-router";

import Books from "./pages/Books.vue";
import EditBook from "./pages/EditBook.vue";
const routes = [
  {
    path: "/",
    name: "Books",
    component: Books,
    meta: {
      title: "Books"
    }
  },
  {
    path: "/editbook",
    name: "editBook",
    component: EditBook,
    meta: {
      title: "Edit Book"
    }
  },
]
const router = createRouter({
  history: createWebHistory(),
  routes,
});
router.beforeEach(async (to, from, next) => {
  setPageTitle(to.meta && to.meta.title);
  next();
})
function setPageTitle(title) {
  if (title) document.title = `Harde Assessment | ${title}`;
  else document.title = "Harde Assessment";
}
export default router;
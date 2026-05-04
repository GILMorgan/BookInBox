<style scoped>
    nav {
        display: flex;
        flex-direction: row;
        justify-content: center;
    }

    nav a {
        border: 1px solid black;
        display: block;
        padding: 8px 12px;
        border-radius: 5px;
        cursor: pointer;
    }
</style>

<template>
  <table>
    <thead>
      <tr>
        <th>Titre</th>
        <th>Auteur</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="book in books">        
        <td>{{ book.title }}</td>
        <td>{{ getName(book) }}</td>
      </tr>
    </tbody>
  </table>

  <nav>
    <a @click="prevLink()">&laquo;</a>
    <div v-for="pageLink in pageLinks">
        <a @click="goToLink(pageLink)">{{ pageLink }}</a>
    </div>
    <a @click="nextLink()">&raquo;</a>
  </nav>
</template>

<script setup>
import { ref, toRefs } from 'vue'
import axios from 'axios' 

const books = ref([])
const currentPage = ref(1)
const maxPage = ref(1)
const pageLinks = ref([])

const params = {
  page: currentPage.value,
}

const props = defineProps(
  {
     url: String        
  }
)

const { url } = toRefs(props)

const getBooks = function () {
    const params = {
        page: currentPage.value,
    }

    axios
        .get(url.value, {params})
        .then(response => {
            books.value = response.data.books
            pageLinks.value = totalBooks(response.data.nbBooks)
        })
        .catch(error => {
            console.error('Error fetching data:', error)
        });
}

const totalBooks = function (nbBooks) {
    maxPage.value = Math.ceil(nbBooks / 25)
    let pageLinks = []

    for (var i = 0; i < maxPage.value; i++) {
        pageLinks.push(i + 1)
    }

    return pageLinks
}

const nextLink = function () {
    if (currentPage.value < maxPage.value) {
        currentPage.value++
        getBooks()
    }
}

const prevLink = function () {
    if (currentPage.value > 1) {
        currentPage.value--
        getBooks()
    }
}

const goToLink = function (page) {
    if (currentPage.value !== page) {
        currentPage.value = page
        getBooks()
    }
}

const getName = function (book) {
    if (book.authors[0]) {
        let completeName = []
        book.authors.forEach(function (author) {
            completeName.push(author.name + " " + author.firstName) 
        })

        return completeName.join(", ")
    }

    return "-"
}

getBooks()

</script>

<script>
export default {
  name: 'BookTable',
}
</script>

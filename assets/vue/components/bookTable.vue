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
        <td>{{ getTitle(book) }}</td>
        <td>{{ getName(book) }}</td>
      </tr>
    </tbody>
  </table>

  <paginator :url='url' :nbItems='nbItems' @update="handleUpdate"></paginator>
</template>

<script setup>
import { ref, toRefs } from 'vue'
import axios from 'axios'

const books = ref([])
const currentPage = ref(1)
const maxPage = ref(1)
const pageLinks = ref([])
const nbItems = ref(0)

const params = {
  page: currentPage.value,
}

const props = defineProps(
  {
     url: String        
  }
)

const { url } = toRefs(props)

const handleUpdate = function (event) {
    const params = {
        page: event.value,
    }

    axios
        .get(url.value, {params})
        .then(response => {
            books.value = response.data.books
            nbItems.value = response.data.nbBooks
        })
        .catch(error => {
            console.error('Error fetching data:', error)
        })
}

/*const nextLink = function () {
    if (currentPage.value < maxPage.value) {
        currentPage.value++
        getBooks()
    }
}*/

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

const getTitle = function (book) {
    if (book.serieName) {
        return book.title + " (" + book.serieName + " #" + book.serieNumber + ")"
    }

    return book.title
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
</script>

<script>
export default {
  name: 'BookTable',
}
</script>

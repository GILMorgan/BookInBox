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
                <th>Nom</th>
                <th>Date de naissance</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="author in authors">
                <td>{{ author.name }}</td>
                <td>{{ author.birthDate }}</td>
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

const authors = ref([])
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

const getAuthors = function () {
    const params = {
        page: currentPage.value,
    }

    axios
        .get(url.value, {params})
        .then(response => {
            authors.value = response.data.authors
            pageLinks.value = totalAuthors(response.data.nbAuthors)
        })
        .catch(error => {
            console.error('Error fetching data:', error)
        });
}

const totalAuthors = function (nbAuthors) {
    maxPage.value = Math.ceil(nbAuthors / 25)
    let pageLinks = []

    for (var i = 0; i < maxPage.value; i++) {
        pageLinks.push(i + 1)
    }

    return pageLinks
}

const nextLink = function () {
    if (currentPage.value < maxPage.value) {
        currentPage.value++
        getAuthors()
    }
}

const prevLink = function () {
    if (currentPage.value > 1) {
        currentPage.value--
        getAuthors()
    }
}

const goToLink = function (page) {
    if (currentPage.value !== page) {
        currentPage.value = page
        getAuthors()
    }
}

getAuthors()

</script>

<script>
export default {
  name: 'AuthorTable',
}
</script>

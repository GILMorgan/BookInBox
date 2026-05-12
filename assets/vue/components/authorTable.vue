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
                <td>{{ author.name }}, {{author.firstName }}</td>
                <td>{{ author.birthDate }}</td>
            </tr>
        </tbody>
    </table>

    <paginator :url='url' :nbItems='nbItems' @update="handleUpdate"></paginator>
</template>

<script setup>
import { ref, toRefs } from 'vue'
import axios from 'axios' 

const authors = ref([])
const currentPage = ref(1)
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
            authors.value = response.data.authors
            nbItems.value = response.data.nbAuthors
        })
        .catch(error => {
            console.error('Error fetching data:', error)
        });
}
</script>

<script>
export default {
  name: 'AuthorTable',
}
</script>

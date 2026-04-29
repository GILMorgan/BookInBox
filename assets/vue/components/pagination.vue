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
        <td></td>
      </tr>
    </tbody>
  </table>
</template>

<script setup>
import { ref, toRefs } from 'vue'
import axios from 'axios' 

const books = ref([])

const params = {
  page: '1',
}

const props = defineProps(
  {
     url: String        
  }
)

const { url } = toRefs(props)

axios
    .get(url.value, {params})
    .then(response => {
        books.value = response.data.books
    })
    .catch(error => {
        console.error('Error fetching data:', error)
    });

</script>

<script>
export default {
  name: 'Pagination',
}
</script>

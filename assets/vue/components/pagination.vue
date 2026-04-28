<template>
  <table>
    <thead>
      <tr>
        <th>Titre</th>
        <th>Autheur</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="{ author } in authors">
        <td>TEST</td>
      </tr>
    </tbody>
  </table>
</template>

<script setup>
import { ref, toRefs } from 'vue'
import axios from 'axios'; 

const authors = ref([])

const params = {
  page: '1',
};

const props = defineProps(
  {
     url: String        
  }
)

const { url } = toRefs(props)

axios
    .get(url.value, {params})
    .then(response => {
        authors.value = response.data;
    })
    .catch(error => {
        console.error('Error fetching data:', error);
    });


</script>

<script>
export default {
  name: 'Pagination',
}
</script>

<style scoped>
    div {
        display: flex;
        flex-direction: column;
    }

    ul {
        list-style-type: none;
    }

    ul li {
        cursor: pointer;
    }
</style>

<template>
<div>
    <input v-model="name" @input="onChange" type="text">
    <ul>
        <li v-for="author in authors" @click="addAuthor(author)">
            {{ author.name }}, {{ author.firstName }}
        </li>
    </ul>
</div>    
</template>

<script setup>
import { ref, toRefs } from 'vue'
import axios from 'axios'

const name = ref('')
const authors = ref([])

const props = defineProps(
  {
     url: String
  }
)

const { url } = toRefs(props)

const emit = defineEmits(['authorSelected']);

function onChange() {
    axios.post(
        url.value,
        {
            'name': name.value
        }
    ).then(response => {
        authors.value = response.data;
    })
    .catch(error => {
      console.error(error);
    })
}

function addAuthor(author) {
    emit('authorSelected', author)
    authors.value = []
    name.value = ""
}

</script>

<script>
export default {
  name: 'SelectAuthor',
}
</script>

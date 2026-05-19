<style scoped>
    .row {
        display: flex;
        flex-direction: column;
    }

    .authors {
        display: flex;
        flex-direction: column;
    }
</style>

<template>
    <div class="row">
        <span>Titre</span>
        <input v-model="title" type="text" />
    </div>
    <div class="row">
        <span>Auteur(s)</span>
        <div class="authors">
            <div v-for="author in authors" class="auteur">
                {{ author.name }} {{ author.firstName }}
                <div @click="removeAuthor(author)"> X </div>
            </div>
        </div>
        <select-author :url="urlAuthorSearch" @authorSelected="addAuthor"></select-author>
    </div>
    <div>
        <button @click="handleClick">Ajouter</button>
    </div>
</template>

<script setup>
import { ref, toRefs } from 'vue'
import axios from 'axios'

const props = defineProps(
  {
     urlSubmit: String,
     urlAuthorSearch: String
  }
)

const { urlSubmit } = toRefs(props)
const { urlAuthorSearch } = toRefs(props)
const title = ref('')
const authors = ref([])

function handleClick() {
    let authorsId = []

    authors.value.forEach(function (author) {
        authorsId.push(author.id)
    })


    console.log(urlSubmit.value)

    axios.post(
        urlSubmit.value,
        {
            'title': title.value,
//            'authors' : authorsId.join(', '),
        }
    )/*.then(response => {

    }).error(error => {
        console.log(error)
    })*/
}

function addAuthor(payload) {
    authors.value.push(payload)
}

function removeAuthor(author) {
    console.log(author)
}

</script>

<script>
export default {
  name: 'FormBook',
}
</script>

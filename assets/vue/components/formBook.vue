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
        <span>Serie</span>
        <input v-model="serieName" type="text" />
    </div>
    <div class="row">
        <span>Numéro</span>
        <input v-model="serieNumber" type="text" />
    </div>
    <div class="row">
        <span>Date de parution</span>
        <input v-model="publishDate" type="text" />
    </div>
    <div class="row">
        <span>Editeur</span>
        <input v-model="publisher" type="text" />
    </div>
    <div class="row">
        <span>ISBN 10</span>
        <input v-model="isbn10" type="text" />
    </div>
    <div class="row">
        <span>ISBN 13</span>
        <input v-model="isbn13" type="text" />
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
    <div class="row">
        <span>Nombre de pages</span>
        <input v-model="nbPages" type="number" />
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
const serieName = ref('')
const serieNumber = ref(0)
const publishDate = ref('')
const publisher = ref('')
const isbn10 = ref('')
const isbn13 = ref('')
const nbPages = ref(0)

function handleClick() {
    let authorsId = []

    authors.value.forEach(function (author) {
        authorsId.push(author.id)
    })

    axios.post(
        urlSubmit.value,
        {
            'title': title.value,
            'serieName': serieName.value,
            'serieNumber': serieNumber.value,
            'publishDate': publishDate.value,
            'publisher': publisher.value,
            'isbn10': isbn10.value,
            'isbn13': isbn13.value,
            'authors': authorsId.join(', '),
            'nbPages': nbPages.value,
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

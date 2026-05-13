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

    .activeLink {
        text-decoration: underline;
        font-weight: bold;
    }
</style>

<template>
<nav>
    <a @click="prevLink()">&laquo;</a>
    <div v-for="pageLink in pageLinks">
        <a @click="goToLink(pageLink)" :class="{ activeLink: active(pageLink) }">{{ pageLink }}</a>
    </div>
    <a @click="nextLink()">&raquo;</a>
</nav>
</template>

<script setup>
import { ref, toRefs, watchEffect } from 'vue'

const currentPage = ref(1)
const maxPage = ref(1)
const pageLinks = ref([])

const props = defineProps(
  {
     url: String,
     nbItems: Number
  }
)

const { url } = toRefs(props)
const { nbItems } = toRefs(props)

watchEffect(() => {
    if (props.nbItems === 0) {
        return
    }
    
    maxPage.value = Math.ceil(props.nbItems / 25)
    pageLinks.value = []

    let first, last
    [first, last] = getFirstAndLastIndex()
    
    for (var i = first; i <= last; i++) {
        pageLinks.value.push(i)
    }
})

const nextLink = function () {
    if (currentPage.value < maxPage.value) {
        currentPage.value++
        emit('update', currentPage)
    }
}

const prevLink = function () {
    if (currentPage.value > 1) {
        currentPage.value--
        emit('update', currentPage)
    }
}

const goToLink = function (page) {
    if (currentPage.value !== page) {
        currentPage.value = page
        emit('update', currentPage)
    }
}

const getFirstAndLastIndex = function () {
    if ((maxPage.value < 11) || (currentPage.value < 6)) {
        return [1, 10]
    }

    if (currentPage.value + 4 < maxPage.value) {
        return [currentPage.value - 4, currentPage.value + 5]
    }

    return [maxPage.value - 9, maxPage.value]
}

const active = function (page) {
    return page === currentPage.value
}

const emit = defineEmits(['update'])
emit('update', currentPage);

</script>

<script>
export default {
  name: 'Paginator',
}
</script>

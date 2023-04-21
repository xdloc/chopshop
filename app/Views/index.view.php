
<script>
    let id = 0;
    export default {
        data() {
            return {
                newItem: '',
                items: [
                    { id: id++, name: 'Bread' },
                    { id: id++, name: 'Milk' },
                    { id: id++, name: 'Nachos' }
                ]
            }
        },
        watch: {

        },
        methods: {
            addItem() {
                this.items.push({ id: id++, name: this.newItem })
                this.newItem = ''
                //this.fetchData()
            },
            removeItem(item) {
                this.items = this.items.filter((t) => t !== item)
                //this.fetchData()
            },
            created() {
                // fetch on init
                //this.fetchData()
            },
            async fetchData() {
                //this.items = await (await fetch(API_URL)).json()
            }
        }
    }
</script>

<template>
    <form @submit.prevent="addItem">
        <input v-model="newItem">
        <button>Add Item</button>
    </form>
    <ul>
        <li v-for="item in items" :key="item.id">
            {{ item.name }}
            <button @click="removeItem(item)">X</button>
        </li>
    </ul>
</template>
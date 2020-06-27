<template>
    <div>
        <h1> Types of Pokemons </h1>
        <v-data-table
            :headers="headers"
            :items="types"
            :footer-props="footerProps"
            :server-items-length="total"
            :items-per-page="5"
            :loading="loading"
            :options.sync="options"
            class="elevation-1"
        ></v-data-table>
    </div>
</template>

<script>
    export default {
        data: () => ({
            loading: true,
            total: 0,
            options: {},
            footerProps: {
                'items-per-page-options': [5, 10, 15]
            },
            headers: [
                {text: 'Name', sortable: false, value: 'name'},
            ],
            types: [],
        }),
        watch: {
            options: {
                handler() {
                    this.getDataFromApi()
                        .then(data => {
                            this.types = data.items
                            this.total = data.total
                        })
                },
                deep: true,
            },
        },
        mounted() {
            this.getDataFromApi()
                .then(data => {
                    this.types = data.items;
                    this.total = data.total;
                })
        },
        methods: {
            getDataFromApi() {
                this.loading = true;

                return new Promise((resolve, reject) => {
                    const {page, itemsPerPage} = this.options
                    const limit = itemsPerPage;
                    const offset = (page - 1) * itemsPerPage;

                    axios.get(`http://pokeapi.salestock.net/api/v2/type/?limit=${limit}&offset=${offset}`)
                        .then((response) => {
                            this.loading = false;
                            response.data.results.forEach(result => {
                                result.name = result.name.charAt(0).toUpperCase() + result.name.slice(1);
                            });
                            resolve({
                                items: response.data.results,
                                total: response.data.count
                            })
                        });
                });
            }
        }
    }
</script>

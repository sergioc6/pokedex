<template>
    <div>
        <h1> Pokemons </h1>
        <v-data-table
            :headers="headers"
            :items="pokemons"
            :items-per-page="15"
            :footer-props="footerProps"
            :loading="loading"
            :server-items-length="total"
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
                {text: 'N°', sortable: false, value: 'number'},
                {text: 'Name', sortable: false, value: 'name'},
                {text: 'Details', sortable: false, value: 'details'}
            ],
            pokemons: [],
        }),
        watch: {
            options: {
                handler() {
                    this.getDataFromApi()
                        .then(data => {
                            this.pokemons = data.items
                            this.total = data.total
                        })
                },
                deep: true,
            },
        },
        mounted() {
            this.getDataFromApi()
                .then(data => {
                    this.pokemons = data.items;
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

                    axios.get(`http://pokeapi.salestock.net/api/v2/pokemon/?limit=${limit}&offset=${offset}`)
                        .then((response) => {
                            this.loading = false;
                            response.data.results.forEach(result => {
                                result.name = result.name.charAt(0).toUpperCase() + result.name.slice(1);
                                result.number = result.url.replace(/\D/g,'').substr(1);
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

<template>
    <div>
        <h1> Pokemons </h1>
        <v-card>
            <v-text-field
                label="Search Pokemon by number or name"
                color="primary"
                v-model="search"
                @keypress.enter="getDataFromApi">

                <template v-slot:append>
                    <v-btn
                        depressed
                        tile
                        color="primary"
                        class="ma-0"
                        @click="getDataFromApi">
                        Find
                    </v-btn>
                </template>
            </v-text-field>

            <v-data-table
                :headers="headers"
                :items="pokemons"
                :items-per-page="15"
                :footer-props="footerProps"
                :loading="loading"
                :server-items-length="total"
                :options.sync="options"
                class="elevation-1"
            >
                <template v-slot:item.image="{ item }">
                    <v-img :src="item.image" :alt="item.name" aspect-ratio="1"></v-img>
                </template>

                <template v-slot:item.details="{ item }">
                    <v-btn color="error" fab small dark @click="selectedPokemon(item)">
                        <v-icon>mdi-pokeball</v-icon>
                    </v-btn>
                </template>
            </v-data-table>

            <pokemon-detail-component
                :number="pokemonSelected"
                :view="showDetail">
            </pokemon-detail-component>
        </v-card>
    </div>
</template>

<script>
    export default {
        data: () => ({
            search: '',
            loading: true,
            total: 0,
            options: {},
            footerProps: {
                'items-per-page-options': [5, 10, 15]
            },
            headers: [
                {text: 'Image', sortable: false, value: 'image'},
                {text: 'N°', sortable: false, value: 'number'},
                {text: 'Name', sortable: false, value: 'name'},
                {text: 'Details', sortable: false, value: 'details'}
            ],
            pokemons: [],
            pokemonSelected: null,
            showDetail: false,
        }),


        mounted() {
            this.getDataFromApi();
        },
        methods: {
            selectedPokemon(item) {
                this.pokemonSelected = item.number;
                this.showDetail = true;
            },

            getDataFromApi() {
                this.loading = true;

                const {page, itemsPerPage} = this.options;
                let search = this.search
                if (search === null) {
                    search = '';
                }

                axios.get(`/api/pokemons?page=${page}&page_size=${itemsPerPage}&search=${search}`)
                    .then((response) => {
                        this.loading = false;
                        this.pokemons = response.data.data.items;
                        this.total = response.data.data.total;
                    });
            }
        }
    }
</script>

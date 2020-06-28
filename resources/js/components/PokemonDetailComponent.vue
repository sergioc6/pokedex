<template>
    <div>
        <v-dialog
            v-model="view"
            max-width="500"
        >
            <v-card>
                <v-card-title class="headline">Pokemon</v-card-title>
                <v-card-text>
                    <v-list-item two-line>
                        <v-list-item-content>
                            <v-list-item-title>Name</v-list-item-title>
                            <v-list-item-subtitle>{{ pokemon.name }}</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-item two-line>
                        <v-list-item-content>
                            <v-list-item-title>Number</v-list-item-title>
                            <v-list-item-subtitle>{{ pokemon.id }}</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-item two-line>
                        <v-list-item-content>
                            <v-list-item-title>Height</v-list-item-title>
                            <v-list-item-subtitle>{{ pokemon.height }}</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-item two-line>
                        <v-list-item-content>
                            <v-list-item-title>Weight</v-list-item-title>
                            <v-list-item-subtitle>{{ pokemon.weight }}</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-item two-line>
                        <v-list-item-content>
                            <v-list-item-title>Types</v-list-item-title>
                            <v-list-item-subtitle>{{ pokemon.types.join(' - ') }}</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>

                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="red"
                        text
                        @click.stop="view=false"
                    >
                        Close
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    export default {
        props: {
            view: Boolean,
            number: Number
        },

        data: () => ({
            pokemon: null,
        }),

        watch: {
            number() {
                this.getDataFromApi(this.number)
            }
        },

        methods: {

            getDataFromApi(number) {
                axios.get(`http://pokeapi.salestock.net/api/v2/pokemon/${number}`)
                    .then((response) => {
                        this.formatData(response.data);
                    });
            },

            formatData(data) {
                this.pokemon = {
                    name: this.capitalizeFirstLetter(data.forms[0].name),
                    id: data.id,
                    height: data.height,
                    weight: data.weight,
                    types: data.types.map(function (x) {
                            return x.type.name;
                        }
                    ),
                };
                console.log(this.pokemon);
            },

            capitalizeFirstLetter(string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            }
        }
    }
</script>

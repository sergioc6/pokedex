<template>
    <v-app id="inspire">
        <v-navigation-drawer
            v-model="drawer"
            app
            clipped
        >
            <v-list dense>
                <v-list-item
                    v-for="item in items"
                    :key="item.text"
                    @click="swapComponent(item.component)"
                >
                    <v-list-item-action>
                        <v-icon>{{ item.icon }}</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>
                            {{ item.text }}
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar
            app
            clipped-left
            color="red"
            dense
        >
            <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
            <v-icon
                class="mx-4"
                large
            >
                mdi-pokeball
            </v-icon>
            <v-toolbar-title class="mr-12 align-center">
                <span class="title" @click="swapComponent('default-component')">Pokedex</span>
            </v-toolbar-title>
            <v-spacer></v-spacer>
        </v-app-bar>

        <v-main>
            <v-container>
                    <component :is="currentComponent"></component>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
    export default {
        props: {
            source: String,
        },
        data: () => ({
            currentComponent: 'default-component',
            drawer: null,
            items: [
                {
                    icon: 'mdi-pokemon-go',
                    text: 'Pokemons',
                    component: 'pokemons-component'
                },
                {
                    icon: 'mdi-format-list-bulleted-type',
                    text: 'Types of Pokemons',
                    component: 'types-component'
                },
                {
                    icon: 'mdi-earth',
                    text: 'Regions',
                    component: 'regions-component'
                }
            ],
        }),
        methods: {
            swapComponent: function(component) {
                this.currentComponent = component;
            }
        },
        created() {
            this.$vuetify.theme.default = true
        },
    }
</script>

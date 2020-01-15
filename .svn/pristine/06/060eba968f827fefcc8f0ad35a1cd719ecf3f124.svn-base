<template>
    <div id="app">
    <vue-progress-bar></vue-progress-bar>
        <v-header></v-header>
        <router-view></router-view>
        <tab></tab>
    </div>
</template>

<script>
    import home from './components/home'
    import header from './components/header'
    import tab from './components/tab'
    import './assets/css/style.css'

    export default {
        name: 'app',
        data(){
            return {
                title: "wemall商城"
            }
        },
        localStorage: {
            config: {
                type: Object,
                default: {}
            },
            cartData: {
                type: Object,
                default: []
            },
            product: {
                type: Object,
                default: []
            },
            menu: {
                type: Object,
                default: []
            },
            ads: {
                type: Object,
                default: []
            },
            user: {
                type: Object,
                default: {}
            },
            token: {
                type: String,
                default: ''
            }
        },
        components: {
            home, tab, 'v-header': header
        },
        mounted () {
            //  [App.vue specific] When App.vue is finish loading finish the progress bar
            this.$Progress.finish()
        },
        created () {
            //  [App.vue specific] When App.vue is first loaded start the progress bar
            this.$Progress.start()
            //  hook the progress bar to start before we move router-view
            this.$router.beforeEach((to, from, next) => {
                //  does the page we want to go to have a meta.progress object
                if (to.meta.progress !== undefined) {
                    let meta = to.meta.progress
                    // parse meta tags
                    this.$Progress.parseMeta(meta)
                }
                //  start the progress bar
                this.$Progress.start()

                //  continue to next page
                next()
            })
            //  hook the progress bar to finish after we've finished moving router-view
            this.$router.afterEach((to, from) => {
                //  finish the progress bar
                this.$Progress.finish()
            })
        }
    }
</script>

<style>
</style>

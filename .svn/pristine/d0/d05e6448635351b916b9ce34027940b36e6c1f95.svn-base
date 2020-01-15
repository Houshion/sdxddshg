<template>
    <div id="main">
        <section class="m-component-promotion" id="list-section">
            <ul class="list-unstyled" id="list-sale">
                <li v-for="ad in ads">
                    <router-link :to="ad.url"><img v-lazy="getFile(ad.file)"
                                                   style="display: inline; height: 137px;"></router-link>
                </li>
            </ul>
        </section>
    </div>
</template>

<script>
    import fetch from "./../fetch";
    import {getFile} from "./../util";

    export default {
        data() {
            return {
                ads: [],
                config: {}
            }
        },
        created() {

            this.$bus.emit('updateTitle', '首页');
            this.ads = this.$localStorage.get('ads');

            fetch('/api/config').then((res) => {
                if (res) {
                    this.config = res.data.data.config;
                    document.title = this.config.title;
                    // 缓存广告
                    this.$localStorage.set('config', this.config);
                }
            });

            fetch('/api/ads').then((res) => {
                if (res) {
                    this.ads = res.data.data.ads;

                    // 缓存广告
                    this.$localStorage.set('ads', this.ads);
                }
            });
        },
        methods: {
            getFile
        }
    }
</script>

<style>


</style>

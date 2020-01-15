<template>
    <div id="main">

        <div class="header">
            <div class="types types-flour">
                <swiper :options="swiperOption" ref="mySwiperProduct">
                    <swiper-slide class="menuItem swiper-slide" :class="{active: item.id == selectedMenu}"
                                  v-for="item in menu" style="width: 128.333px;">
                        <div @click="selectMenu(item.id)">{{item.name}}</div>
                    </swiper-slide>
                </swiper>
            </div>
        </div>

        <div id="mainList" class="main">
            <div class="items">
                <div class="item large" id="notification" style="display: block;">{{title}}</div>

                <div class="item" v-for="item in product" v-show="item.category_id == selectedMenu"
                     style="display: block;">
                    <div class="item-image">
                        <router-link :to="{ name: 'productDetail', params: { id: item.id }}">
                            <img v-lazy="getFile(item.file)" style="width: 100%; margin-top: 0px; display: inline;background-size: 30px;">
                        </router-link>

                        <div class="select-shadow" style="display: none;" v-show="item.selected">
                            <div class="select-inner"><img src="../assets/img/ico_select.png"
                                                           alt="selected"><span>已选</span></div>
                        </div>
                    </div>

                    <div class="single-item-info">
                        <div class="item-title">{{item.name}}</div>
                        <div class="item-price-show">
                            <div class="item-price"><span class="hotspot">￥{{item.price}}</span></div>
                        </div>
                        <div class="item-amount" @click="addCart(item)"><i class="ico ico-cart"></i>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <div class="backToTop">
            <div class="backToTop-inner" @click="backToTop()"><i class="ico ico-top"></i><span>回到顶部</span></div>
        </div>
    </div>
</template>

<script>
    import {swiper, swiperSlide} from 'vue-awesome-swiper';
    import fetch from "./../fetch";
    import {getFile} from "./../util";

    export default {
        data () {
            return {
                title: '欢迎来到wemall商城!',
                swiperOption: {
                    direction: 'horizontal',
                    slidesPerView: 3,
                    spaceBetween: 0,
                    paginationClickable: false,
                    slideToClickedSlide: false,
                    notNextTick: true
                },
                selectedMenu: 0,
                menu: [],
                product: []
            }
        },
        computed: {
            swiper(){
                return this.$refs.mySwiperProduct.swiper;
            }
        },
        components: {
            swiper,
            swiperSlide
        },
        created(){

            this.$bus.emit('updateTitle', '全部商品');
            this.menu = this.$localStorage.get('menu');
            this.product = this.$localStorage.get('product');
            this.title = this.$localStorage.get('config').title;

            this.initMenu();
            this.updateProduct();

            fetch('/api/product/category').then((res) => {
                if (res) {
                    this.menu = res.data.data.category;

                    // 缓存菜单
                    this.$localStorage.set('menu', this.menu);

                    // 设置默认第一个菜单
                    this.initMenu();
                }
            });

            fetch('/api/product').then((res) => {
                if (res) {
                    this.product = res.data.data.product;

                    // 缓存商品
                    this.$localStorage.set('product', this.product);

                    this.updateProduct();
                }
            });
        },
        methods: {
            backToTop () {
                window.scrollTo(0, 0)
            },
            selectMenu(id){
                this.selectedMenu = id;

                this.$localStorage.set('selectedMenu', this.selectedMenu);
            },
            initMenu(){
                if (!this.selectedMenu && this.menu.length){
                    this.selectMenu(this.menu[0].id);
                }
            },
            updateProduct(){
                // 更新视图
                let cartData = this.$localStorage.get('cartData');
                for (let key in this.product) {
                    // this.$set(`this.product[${key}].selected`,false);
                    // this.$set(this.product[key], Object.assign(this.product[key], {selected: false}));
                    for (let keyIn in cartData) {
                        if (this.product[key].id == cartData[keyIn].id) {
                            this.$set(this.product[key], Object.assign(this.product[key], {selected: true}))
                            // this.$set(`this.product[${key}].selected`,true);
                            // this.product[${key}].selected
                        }
                    }
                }
            },
            addCart(item){
                let cartData = this.$localStorage.get('cartData');

                let cartOut = true;
                for (let key in cartData) {
                    if (cartData[key].id == item.id) {
                        cartData[key].num++;
                        cartOut = false;
                    }
                }

                if (cartOut) {
                    cartData.push({
                        id: item.id,
                        name: item.name,
                        price: item.price,
                        num: 1
                    });
                }

                this.$localStorage.set('cartData', cartData);

                // 更新tab购物车数量
                this.$bus.emit('updateCart', true);
                this.updateProduct();
            },
            getFile
        }
    }
</script>

<style>

</style>

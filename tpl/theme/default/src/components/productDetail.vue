<template>
    <div id="main">
        <div class="detail" id="itemsDetail">
            <div class="container-gird">
                <swiper :options="swiperOption" v-if="product.files" ref="mySwiperDetail" style="height: 200px">
                    <swiper-slide class="swiper-slide"
                                  v-for="item in product.files" style="width: 128.333px;">
                        <img v-lazy="getFile(item)"/>
                    </swiper-slide>
                </swiper>

                <div class="detail-image" v-if="!product.files"><img v-lazy="getFile(product.file)"></div>

                <div class="detail-msg"><span class="single-name">{{product.name}}</span></div>
                <div class="detail-msg"><span class="detail-price"> <span
                        class="new-price">￥<span>{{product.price}}</span></span> </span>
                </div>
                <div class="detail-msg none" style="padding-bottom: 12px; display: none;" id="product-attr"><span
                        class="detail-attr"> <span>商品属性</span><br> <span id="detail-attr-btn"></span> </span></div>
                <div class="select-area" id="addCartBtn" style="">
                    <button class="addItem btn-shopping" @click="addCart(product)"><i
                            class="ico ico-shop"></i>添加到购物车
                    </button>
                </div>
                <div class="select-area" id="soldOut" style="display: none"><span
                        style="float: right;color: #646464;">已售罄</span></div>
            </div>
            <div class="detail-content">
                <div class="container-gird"><p class="detail-title">商品详情</p>
                    <div style="min-height: 200px">

                        <div v-if="product.detail" v-html="product.detail"></div>
                        <div v-else="product.detail" style="text-align: center;margin-top: 100px">商家比较懒，没有商品详情～</div>

                    </div>
                </div>
            </div>
            <div class="backToTop">
                <div class="backToTop-inner" @click="backToTop()"><i class="ico ico-top"></i><span>回到顶部</span></div>
            </div>
        </div>
    </div>
</template>

<script>
    import {swiper, swiperSlide} from 'vue-awesome-swiper';
    import fetch from "./../fetch";
    import {getFile} from "./../util";

    export default{
        data(){
            return {
                product: {},
                swiperOption: {
                    direction: 'horizontal'
                }
            }
        },
        components: {
            swiper,
            swiperSlide
        },
        methods: {
            backToTop () {
                window.scrollTo(0, 0)
            },
            getFile,
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
            }
        },
        created(){

            const product = this.$localStorage.get('product');
            for (let key in product){
                if(product[key].id == this.$route.params.id){
                    this.product = product[key];
                }
            }

            fetch(`/api/product/${this.$route.params.id}`).then((res) => {
                if (res) {
                    this.product = res.data.data.product;
                }
            });
        },
    }
</script>

<style>

</style>

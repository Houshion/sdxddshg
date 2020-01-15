<template>
    <div class="navigation-wrap">

        <router-link to="/home" class="navigation-item" style="-webkit-box-orient: vertical;">
            <div class="icon-home"></div>
            <div>首页</div>
        </router-link>

        <router-link to="/product" class="navigation-item" style="-webkit-box-orient: vertical;">
            <div class="icon-product"></div>
            <div>全部商品</div>
        </router-link>

        <router-link to="/cart" class="navigation-item" style="-webkit-box-orient: vertical;">
            <div class="icon-cart">
                <div class="icon-hit" id="shopcart-tip" style="display: block;">{{cartNum}}</div>
            </div>
            <div>购物车</div>
        </router-link>

        <router-link to="/user" class="navigation-item" style="-webkit-box-orient: vertical;">
            <div class="icon-user"></div>
            <div>我的账户</div>
        </router-link>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                cartNum: 0
            }
        },
        created(){

            this.updateCart();
            this.$bus.on('updateCart', this.updateCart);
        },
        methods: {
            updateCart() {
                this.cartNum = 0;
                const cartData = this.$localStorage.get('cartData');
                cartData.forEach((val, index) => {
                    this.cartNum += cartData[index].num;
                })
            }
        }
    }
</script>

<style>

</style>

<template>
    <div id="main">
        <div class="container-gird">
            <div class="confirmation-form">
                <div class="confirmation-header"><span>订单确认</span></div>
                <div class="confirmation-list" id="item-list">
                    <div class="dotted-divider" style="width: 105.263157894737%; margin-left: -2.9%"></div>
                    <ul>
                        <li v-for="item in cartData">
                            <div class="confirmation-item">
                                <div class="item-info"><span class="item-name">{{item.name}}<br></span><span
                                        class="item-price-info"><span><span
                                        class="item-single-price">{{item.price}}</span>×<span
                                        class="item-amount">{{item.num}}</span></span></span></div>
                                <div class="select-box"><span class="minus disabled"
                                                              @click="disCart(item)">—</span><input
                                        class="amount"
                                        type="text"
                                        name="amount"
                                        v-model="item.num"
                                        autocomplete="off"
                                        readonly=""><span
                                        class="add" @click="addCart(item)">+</span></div>
                                <div class="delete"><a class="delete-btn" @click="delCart(item)"><i
                                        class="ico ico-delete"></i></a></div>
                            </div>
                            <div class="divider"></div>
                        </li>
                    </ul>
                    <div class="total-info"><span
                            class="items-total-price">总计：<span
                            id="items-total-price">{{cartTotal}}</span>元</span></div>
                </div>
            </div>
        </div>
        <router-link to="/delivery" class="next mybtn">
            <span class="n-btn"
                  style="display: block; height: 39px; font-size: 1.2em;margin: 10px;background: #ff4146;color: #ffffff;border-radius: 6px;">下一步</span>
        </router-link>
    </div>
</template>

<script>
    export default{
        data(){
            return {
                cartData: [],
                cartNum: 0,
                cartTotal: 0
            }
        },
        created(){

            this.$bus.emit('updateTitle', '购物车');
            this.updateCart();
        },
        methods: {

            addCart(item){

                for (let key in this.cartData) {
                    if (this.cartData[key].id == item.id) {
                        this.cartData[key].num++;
                    }
                }

                this.$localStorage.set('cartData', this.cartData);
                this.updateCart();
            },
            disCart(item){
                for (let key in this.cartData) {
                    if (this.cartData[key].id == item.id) {
                        this.cartData[key].num--;
                        if (this.cartData[key].num == 0) {
                            this.delCart(item);
                        }
                    }
                }

                this.$localStorage.set('cartData', this.cartData);
                this.updateCart();
            },
            delCart(item){

                for (let key in this.cartData) {
                    if (this.cartData[key].id == item.id) {
                        this.cartData.splice(key, 1);
                    }
                }

                this.$localStorage.set('cartData', this.cartData);
                this.updateCart();
            },
            updateCart() {
                this.cartNum = 0;
                this.cartTotal = 0;
                this.cartData = this.$localStorage.get('cartData');

                this.cartData.forEach((val, index) => {
                    this.cartNum += parseInt(this.cartData[index].num);
                    this.cartTotal += parseInt(this.cartData[index].num) * parseFloat(this.cartData[index].price);
                })

                // 更新tab购物车数量
                this.$bus.emit('updateCart', true);
            }
        }
    }
</script>

<style>

</style>

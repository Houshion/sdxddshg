<template>
    <div id="main">
        <div class="container-gird" id="orderResult">
            <div class="orderResult-header"><span> <i class="ico ico-succ"></i>&nbsp;&nbsp;下单成功-<span
                    id="status">{{order.pay_status}}</span> </span>
            </div>
            <div class="orderResultList-container">
                <div>
                    <div class="orderResult-form">
                        <div class="orderResult-list" id="items-order-result">
                            <div class="order-info"><span> 订单号：<span
                                    id="result-order-no">{{order.orderid}}</span> </span> <span
                                    class="date" style="float: right">{{order.created_at}}</span></div>
                            <div class="order-list" id="item-order-list">
                                <ul>
                                    <li v-for="item in order.detail"><span class="order-item-name">{{item.name}}</span><span
                                            class="order-item-price">￥{{item.price}}</span><span
                                            class="order-item-amount">{{item.num}}份</span></li>
                                </ul>
                            </div>
                            <div class="divider"></div>
                            <div class="total-info">
                                <span class="total">共<span>{{order.totalprice}}</span>元 </span></div>
                        </div>
                    </div>
                    <div class="tips" id="items-tips"><span>温馨提示：<span id="timeBox">您的订单我们将在约定的时间送达，谢谢！收货时间在15:30～17:30时间段内，请留意您的手机。</span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import fetch from './../fetch';
    export default{
        data(){
            return {
                order: {}
            }
        },
        created() {

            fetch(`/api/order/${this.$route.params.id}`).then((res) => {
                this.order = res.data.data.order;
            });
        }
    }
</script>

<style>

</style>

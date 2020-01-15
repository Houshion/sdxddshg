<template>
    <div id="main">
        <div class="container-gird">
            <div class="confirmation-form">
                <div class="confirmation-list"><img
                        v-lazy="getAvaterFile"
                        class="avater">
                    <div style="text-align: center;padding: 10px 0px;">{{user.level}}
                        <router-link to="/login" v-show="user.username">
                            <span class="pi-loginout"  @click="logout" style="display:inline-block;position:absolute;right:10px;">
                            退出
                          </span>
                        </router-link>
                    </div>
                    <div class="divider"></div>
                    <div class="dotted-divider" style="width: 105.263157894737%; margin-left: -2.9%"></div>
                    <ul>
                        <li>
                            <div class="confirmation-item">
                                <div class="item-info"><span class="item-name">我的账号:<br></span></div>
                                <div class="select-box">{{user.username}}</div>
                            </div>
                            <div class="divider"></div>
                        </li>
                        <li>
                            <div class="confirmation-item">
                                <div class="item-info"><span class="item-name">我的账户:<br></span></div>
                                <div class="select-box">{{user.money}}元</div>
                            </div>
                            <div class="divider"></div>
                        </li>
                        <li>
                            <div class="confirmation-item">
                                <div class="item-info"><span class="item-name">我的积分:<br></span></div>
                                <div class="select-box">{{user.score}}分</div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="my-order-header"><span>我的订单</span>
            <div class="dotted-divider"></div>
        </div>
        <div class="myOrderList none" style="display: block;">
            <div>
                <div class="container-gird" v-if="order.length">
                    <div>
                        <div class="orderResult-list" id="items-order-result-list">
                            <ul>
                                <li v-for="item in order">
                                    <div class="order-info"><span class="number">订单号：<span
                                            id="order-no">{{item.orderid}}</span></span><span class="date"
                                                                                           style="float: right">{{item.created_at}}</span><span
                                            class="order-status">{{item.pay_status}},{{item.status}}</span></div>
                                    <div class="order-list" id="item-order-list">
                                        <ul>
                                            <li v-for="itemIn in item.detail"><span class="order-item-name">{{itemIn.name}}</span><span
                                                    class="order-item-price">￥{{itemIn.price}}</span><span
                                                    class="order-item-amount">{{itemIn.num}}份</span></li>
                                        </ul>
                                        <div class="mytotal-info"><span class="total">共{{item.totalprice}}元</span></div>
                                    </div>
                                    <div class="order-footer">

                                        <span class="cancelOrder" @click="cancelOrder(item)" v-if="item.status != '已取消'">取消</span>
                                        <span class="payOrder" @click="wxpay(item)" v-if="item.pay_status == '未支付'">微信付款</span>
                                        <span class="payOrder" @click="alipay(item)" v-if="item.pay_status == '未支付'">支付宝</span>

                                        <a class="dail-small" @click="tel"><span class="dail-ico"><i
                                            class="ico ico-phone"></i></span><span class="dail-text">拨打电话催一催</span></a>
                                    </div>
                                    <div class="divider"></div>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="history-loader"><i class="ico ico-history"></i> <span>点击查看历史订单</span></div>
    </div>
</template>

<script>
    import {getFile} from "./../util";
    import fetch from "./../fetch";
    import { Toast } from 'mint-ui';
    import defaultAvater from "./../assets/img/default_avater.png";
    export default {
        data() {
            return {
                user: {},
                order: [],
                config: {
                    tel: ''
                }
            }
        },
        created(){

            this.$bus.emit('updateTitle', '我的');
            this.$bus.emit('updateTitle', '我的');
            this.user = this.$localStorage.get('user');
            this.config = this.$localStorage.get('config');

            fetch('/api/order').then((res) => {
                if (res) {
                    this.order = res.data.data.order;
                }
            });
        },
        computed: {
            getAvaterFile(){
                if(this.user.avater_id){
                    return getFile(this.user.avater);
                }else{
                    return defaultAvater;
                }
                
            }
        },
        methods: {
            logout(){
                this.$localStorage.set('user', {});
                this.$localStorage.set('token', '');
            },
            cancelOrder(item){
                fetch(`/api/order/cancel/${item.id}`).then((res) => {
                    if(!res){
                        return;
                    }
                    if(res.data.code){
                        this.$router.go(0)
                    }else{
                        Toast(res.data.msg);
                    }
                });
            },
            tel(){
                location.href = 'tel:'+ this.config.tel;
            },
            wxpay(item){
                fetch(`/api/pay/wxpay/${item.id}`).then((res) => {
                    if(!res){
                        return;
                    }
                    WeixinJSBridge.invoke('getBrandWCPayRequest', res.data.data.jsApiParameters, function(res){
                      if(res.err_msg == "get_brand_wcpay_request:ok"){
                        alert("支付成功");
                        // 这里可以跳转到订单完成页面向用户展示
                        this.$router.go(0)
                      }else{
                        alert(res.err_code+res.err_desc+res.err_msg);
                      }
                    });
                });
            },
            alipay(item){
                fetch(`/api/pay/alipay/${item.id}`).then((res) => {
                    if(!res){
                        return;
                    }
                    if(res.data.code){
                        location.href = res.data.data.url;
                    }else{
                        Toast(res.data.msg);
                    }
                });
            }
        }
    }
</script>

<style>

</style>

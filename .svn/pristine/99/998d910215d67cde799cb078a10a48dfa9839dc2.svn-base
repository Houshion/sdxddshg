<template>
    <div>
        <div id="main">
            <div class="confirmation-form">
                <div class="confirmation-header-nb"><span>收货人信息</span>
                    <div class="dotted-divider"></div>
                </div>
                <div class="container-gird">
                    <form class="delivery-info">
                        <ul class="form_table">
                            <li>
                                <span class="td_left">姓名</span>
                                <span class="td_right">
                  <input type="text" name="username" v-model="contact.name" id="username" placeholder="务必使用真实姓名" value="" required=""></span>
                            </li>
                            <li>
                                <span class="td_left">手机</span>
                                <span class="td_right">
                  <input type="text" name="tel" v-model="contact.phone" id="tel" placeholder="" value="" required="">
                </span>
                            </li>
                            <li>
                                <span class="td_left">地址</span>
                                <span class="td_right">
                                  <select id="hat_city" name="hat_city" class="hat_select" v-model="province">
                                    <option :value="index" v-for="(item, index) in location">{{item.name}}</option>
                                  </select>
                                  <select id="hat_area" name="hat_area" class="hat_select" v-model="city">
                                    <option :value="index" v-for="(item, index) in location[province].sub">{{item.name}}</option>
                                  </select>
                                </span>
                            </li>
                            <li>
                                <span class="td_left"></span>
                                <span class="td_right">
                  <input type="text" name="address" v-model="contact.address" id="address" placeholder="详细地址" value="" required="">
                </span>
                            </li>
                            <li>
                                <span class="td_left">备注</span>
                                <span class="td_right">
                  <input type="text" name="note" id="note" placeholder="选填">
                </span>
                            </li>
                            <li>
                                <span class="td_left">配送时间</span>
                                <span class="td_right">
                                  <select id="deliveryTime" name="deliveryTime" v-model="selectedDeliveryTime" class="hat_select">
                                    <option :value="item" v-for="(item, index) in deliveryTime">{{item}}</option>
                                  </select>
                                </span>
                            </li>
                            <li></li>
                        </ul>
                    </form>
                </div>
            </div>
            <div class="payment"><p class="heading">支付方式</p>
                <div class="container-gird">
                    <div class="payment-content">
                        <span class="line" v-for="item in payment" @click="selectPayment(item)">
                          <span class="radio" :class="{selected: selectedPayment == item.id}"></span>
                          <span class="label">{{item.name}}</span>
                        </span>
                    </div>
                </div>
            </div>
            <a class="mybtn" @click="submit">
                <span style="display: block; height: 39px; font-size: 1.2em;margin: 10px;background: #ff4146;color: #ffffff;border-radius: 6px;">提交订单</span>
            </a>
        </div>
    </div>
</template>

<script>
    import fetch from "./../fetch";
    import { Toast, Indicator } from 'mint-ui';
    export default {
        data () {
            return {
                selectedPayment: 0,
                payment: [],
                contact: {
                    id: 0,
                    name: '',
                    phone: '',
                    address: '',
                    province_id: 0,
                    city_id: 0
                },
                location: [
                    {sub: []}
                ],
                deliveryTime: [],
                province: 0,
                city: 0,
                selectedDeliveryTime: ''
            }
        },
        created() {

            const cartData = this.$localStorage.get('cartData');
            if(!cartData.length){
                this.$router.go(-1);
                return;
            }

            Indicator.open();

            this.$bus.emit('updateTitle', '购物车');
            fetch('/api/payment').then((res) => {
                if(res){
                    this.payment = res.data.data.payment;
                    this.selectedPayment = this.payment[0].id;
                }
            });

            fetch('/api/location').then((res) => {
                if(res){
                    this.location = res.data.data.location[0].sub;

                    fetch('/api/contact').then((res) => {
                        if(res){
                            if(res.data.data.contact.length){
                                this.contact = res.data.data.contact[0];

                                for (let key in this.location) {
                                    if (this.location[key].id == this.contact.province_id) {
                                        this.province = key;

                                        for(let key1 in this.location[key].sub){
                                            if(this.location[key].sub[key1].id == this.contact.city_id){
                                                this.city = key1;
                                            }
                                        }
                                    }
                                }
                            }

                            Indicator.close();
                        }
                    });
                }
            });

            fetch('/api/addons/deliveryTime').then((res) => {
                if(res){
                    this.deliveryTime = res.data.data.delivery_time;
                    this.selectedDeliveryTime = res.data.data.delivery_time[0];
                }
            });
        },
        methods: {
            selectPayment(item){
                this.selectedPayment = item.id;
            },
            submit(){

                if(!this.contact.name){
                    Toast('姓名不能为空');
                    return;
                }
                if(!this.contact.phone){
                    Toast('手机号不能为空');
                    return;
                }
                if(!this.contact.address){
                    Toast('地址不能为空');
                    return;
                }

                Indicator.open();

                fetch('/api/contact', Object.assign({id: this.contact.id, phone: this.contact.phone, name: this.contact.name}, {province_id: this.location[this.province].id, city_id: this.location[this.province].sub[this.city].id})).then((res) => {
                    
                    if(res){
                        this.contact = res.data.data.contact;
                        fetch('/api/order', {cartData: this.$localStorage.get('cartData'), contact_id: this.contact.id,
                            payment_id: this.selectedPayment, delivery_time: this.selectedDeliveryTime}).then((res) => {
                            
                            if(res){
                                Indicator.close();
                                
                                if(res.data.code){
                                    this.$localStorage.set('cartData', []);
                                    this.$router.push({name:'orderResult', params: {id: res.data.data.order.id}});
                                    
                                    const order_id = res.data.data.order.id;
                                    if(this.selectedPayment == 2){
                                        fetch(`/api/pay/wxpay/${order_id}`).then((res) => {
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
                                    }
                                    if(this.selectedPayment == 3){
                                        fetch(`/api/pay/alipay/${order_id}`).then((res) => {
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
                                    if(this.selectedPayment == 4){
                                        fetch(`/api/pay/balance/${order_id}`).then((res) => {
                                            if(!res){
                                                return;
                                            }

                                            if(res.data.code){
                                                this.$router.go(0)
                                            }else{
                                                Toast(res.data.msg);
                                            }
                                        });
                                    }
                                }else{
                                    Toast(res.data.msg);
                                }
                            }
                        });
                    }
                });
            }
        }
    }
</script>

<style>

</style>

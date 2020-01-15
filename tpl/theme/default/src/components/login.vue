<template>
    <div id="main">
        <div class="b-color-f">
            <div class="con b-color-f">
                <section class="user-center user-login margin-lr">
                    <div class="text-all dis-box j-text-all" name="usernamediv"><label>账 号</label>
                        <div class="box-flex input-text"><input class="j-input-text" v-model="phone"
                                                                datatype="s5-16"
                                                                errormsg="昵称至少5个字符,最多16个字符！" type="text"
                                                                placeholder="手机号">
                            <i class="iconfont icon-guanbi is-null j-is-null"></i>
                        </div>
                    </div>
                    <div class="text-all dis-box j-text-all" name="passworddiv"><label>密 码</label>
                        <div class="box-flex input-text"><input v-model="password" class="j-input-text" name="password" type="password"
                                                                placeholder="请输入密码">
                            <span class="icon-eye"></span>
                        </div>
                        <i class="iconfont icon-yanjing is-yanjing j-yanjing disabled"></i></div>
                    <input type="hidden" name="back_act" value="">
                    <router-link to="/forgetPassword" class="fr t-remark" style="font-size: .96rem">忘记密码？
                    </router-link>
                    <button type="" class="btn-submit" @click="login">登录</button>
                    <router-link to="/register" class="a-first u-l-register">新用户注册</router-link>
                </section>
            </div>
            <div class="div-messages" style="text-align: center">
                <div class="other-login">
                    <div style="text-align: center">
                      <!--   <div style="border-bottom: 1px solid #F6F6F9;height:1px;position:absolute;width: 80%;padding: 6px;margin-left:8%"></div> -->
                        <span style="background: #fff;padding:6px;font-size:1.05rem">使用合作账号登录</span>
                    </div>
                    <ul class="dis-box" style="margin-top: 30px">
                        <li class="box-flex">
                            <span @click="oauth"><img style="width: 60px;height: 60px;" src="./../assets/img/weixin.png"></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import fetch from "./../fetch";
import { Toast, Indicator } from 'mint-ui';

export default {
    data(){
        return {
            phone: '',
            password: ''
        }
    },
    created(){
        Indicator.close();
    },
    methods: {
        login(){

            fetch('/api/public/login', {phone: this.phone, password: this.password}).then((res) => {

                if (res.data.code) {
                    this.$localStorage.set('user', res.data.data.user);
                    this.$localStorage.set('token', res.data.data.token);

                    this.$router.push('user');
                }else{
                    Toast(res.data.msg);
                }
            });
        },
        oauth() {

            location.href = '/static/oauth.html#/?redirect=' + encodeURIComponent(location.origin + '/app#/user');
        }
    }
}
</script>

<style>
    .b-color-f {
        background: #fff;
        padding-bottom: 40px;
        /*margin: 10px 0px;*/
    }

    .filter-top {
        width: 4.6rem;
        height: 4.6rem;
        text-align: center;
        line-height: 4.6rem;
        background: rgba(0, 0, 0, 0.5);
        border-radius: 100%;
        bottom: 12rem;
        right: 1.6rem;
        left: inherit;
    }

    .filter-top {
        display: none;
    }

    .filter-top .icon-jiantou {
        position: absolute;
        left: 0;
        right: 0;
        font-size: 2rem;
        color: #fff;
        -moz-transform: rotate(90deg);
        -webkit-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        transform: rotate(90deg);
    }

    .search-div {
        background: #fff;
        position: fixed;
        height: 100%;
        width: 100%;
        left: 0;
        top: 100%;
        right: 0;
        bottom: 0;
        z-index: 112;
        visibility: hidden;
    }

    .ts-3 {
        -webkit-transition: all .3s;
        -moz-transition: all .3s;
        -o-transition: all .3s;
        transition: all .3s;
    }

    .close-search {
        height: 4.6rem;
        line-height: 4.6rem;
        color: #777;
        position: absolute;
        bottom: 0;
        font-size: 1.7rem;
        text-align: center;
        width: 100%;
    }

    .user-center {
        margin-top: 2rem;
        font-size: 1.6rem;
    }

    .margin-lr {
        margin: 0 1.3rem;
    }

    .text-all {
        border-bottom: 1px solid #F6F6F9;
        padding: .5rem 0;
        width: 100%;
        overflow: hidden;
    }

    .dis-box {
        display: -webkit-box;
        display: -moz-box;
        display: -ms-box;
        display: box;
    }

    .text-all label {
        font-size: 1.05rem;
        display: block;
        height: 3rem;
        line-height: 3rem;
        margin-right: 0.8rem;
        vertical-align: middle;
    }

    .input-text {
        position: relative;
    }

    .box-flex {
        -webkit-box-flex: 1;
        -moz-box-flex: 1;
        -ms-box-flex: 1;
        box-flex: 1;
        display: block;
        width: 100%;
    }

    .input-text input {
        border: 0;
        height: 3rem;
        line-height: 2rem;
        padding: .5rem 0;
        box-sizing: border-box;
        width: 100%;
        color: #555;
        font-size: 1.05rem;
        padding-right: 3rem;
    }

    input:required, input:valid, input:invalid {
        border: 0 none;
        outline: 0 none;
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
        -ms-box-shadow: none;
        -o-box-shadow: none;
        box-shadow: none;
        ã€€-webkit-appearance: none;
        -webkit-tap-highlight-color: rgba(255, 255, 255, 0);
    }

    .is-null {
        font-size: 2.1rem;
        color: #ddd;
        top: 50%;
        transition: all 0.2s;
        margin-top: -1.2rem;
        z-index: 10;
        position: absolute;
        right: 0.2rem;
        visibility: hidden;
        opacity: 0;
        -webkit-transition: all 0.1s;
        -moz-transition: all 0.1s;
        -o-transition: all 0.1s;
        transition: all 0.1s;
    }

    .icon-guanbi:before {
        content: "\e630";
    }

    .user-center .t-remark {
        margin-top: 1.2rem;
    }

    .t-remark, .t-remark:link, .t-remark a:link, .t-remark a {
        color: #777;
        font-size: 1.05rem;
    }

    .fr {
        float: right;
    }

    .user-center .btn-submit {
        margin-top: 1.2rem;
    }

    .btn-submit {
        background: #ff4146;
        border: 1px solid #ff4146;
    }

    .btn-submit, .btn-submit1, .btn-disab, .btn-cart, .btn-reset, .btn-default, .btn-alipay, .btn-wechat {
        font-size: 1.05rem;
        color: #fff;
        border: 0;
        text-align: center;
        padding: .64rem 0;
        border-radius: 4px;
        width: 100%;
    }

    .u-l-register {
        font-size: 1.05rem;
        text-align: center;
        margin-top: 2.2rem;
        display: block;
    }

    .icon-eye {
        display: block;
        width: 28px;
        height: 28px;
        background-image: url(../assets/img/eye.png);
        background-size: 100%;
        margin-bottom: 5px;
        position: absolute;
        top: 10px;
        right: 60px;
    }
</style>

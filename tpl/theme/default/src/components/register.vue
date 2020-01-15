<template>

    <div id="main">
            <div class="b-color-f">
                <div class="user-register of-hidden">
                    <div id="j-tab-con" class="swiper-container-horizontal swiper-container-autoheight">
                        <div class="swiper-wrapper" style="height: 338px;">
                            <section class="swiper-slide swiper-no-swiping swiper-slide-active">
                                <div class="text-all dis-box j-text-all" name="mobilediv"><label>+86</label>
                                    <div class="box-flex input-text"><input class="j-input-text" v-model="phone"
                                                                            name="mobile"
                                                                            type="tel" placeholder="手机号"> <i
                                            class="iconfont icon-guanbi is-null j-is-null"></i></div>
                                </div>
                                <div class="text-all dis-box j-text-all" name="mobile_codediv">
                                    <div class="box-flex input-text" style="-webkit-box-flex: 1;"><input
                                            class="j-input-text" name="mobile_code" type="number"
                                            placeholder="请输入验证码" v-model="captcha"> <i
                                            class="iconfont icon-guanbi is-null j-is-null"></i></div>
                                    <a type="button" class="ipt-check-btn" id="sendsms" @click="getCaptcha">{{captcha_txt}}</a>
                                </div>
                                <div class="text-all dis-box j-text-all" name="smspassworddiv">
                                    <div class="box-flex input-text">
                                        <input class="j-input-text" name="smspassword" type="password"
                                               placeholder="请输入密码" v-model="password">
                                        <span class="icon-eye" style="right: 10px"></span>
                                    </div>
                                    <i class="iconfont icon-yanjing is-yanjing j-yanjing disabled"></i>
                                </div>
                                <div class="text-all dis-box j-text-all" name="repassworddiv">
                                    <div class="box-flex input-text">
                                        <input class="j-input-text" v-model="password2" name="repassword" type="password"
                                               placeholder="请重新输入密码">
                                        <span class="icon-eye" style="right: 10px"></span>
                                    </div>
                                    <i class="iconfont icon-yanjing is-yanjing j-yanjing disabled"></i>
                                </div>

                                <div class="text-all dis-box j-text-all" name="repassworddiv">
                                <div class="box-flex input-text">
                                    <input class="j-input-text" v-model="username" name="repassword" type="text"
                                           placeholder="用户名">
                                </div>
                                <i class="iconfont icon-yanjing is-yanjing j-yanjing disabled"></i></div>
                                
                                <button type="" class="btn-submit " @click="register">注册</button>
                                <router-link to="/login"
                                             style="color: #7D7B7B;font-size: .9rem;margin-top: 1.6rem;float: right;">
                                    已注册直接登录
                                </router-link>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
            <div class="div-messages"></div>
    </div>

</template>

<script>
import fetch from './../fetch';
import { Toast } from 'mint-ui';

export default {
    data(){
        return {
            phone: '',
            username: '',
            captcha: '',
            captcha_uuid: '',
            password: '',
            password2: '',
            captcha_txt: '发送验证码'
        }
    },
    methods: {

        getCaptcha(){

            if(!this.phone){
                Toast('手机号不能为空');
                return;
            }
            
            if(typeof this.captcha_txt == 'number'){
                return;
            }
            let i = 1;
            this.captcha_txt = 60;
            let captcha_interval = setInterval(()=>{
                this.captcha_txt -= i;
                if (this.captcha_txt == 0) {
                    clearInterval(captcha_interval);
                    this.captcha_txt = '发送验证码';
                }
            }, 1000);

            fetch('/api/public/sendSmsCaptcha', {phone: this.phone}).then((res) => {
                if(res.data.code){
                    this.captcha_uuid = res.data.data.uuid;
                }else{
                    Toast(res.data.msg);
                }
            });
        },

        register(){

            if(!this.phone){
                Toast('手机号不能为空');
                return;
            }
            if(!this.username){
                Toast('用户名不能为空');
                return;
            }
            if(!this.captcha_uuid || !this.captcha){
                Toast('请先发送验证码');
                return;
            }
            if(this.password != this.password2){
                Toast('手机号两次输入有误');
                return;
            }

            fetch('/api/public/register', {phone: this.phone, password: this.password, username: this.username, captcha: this.captcha, captcha_uuid: this.captcha_uuid}).then((res) => {

                if (res.data.code) {
                    this.$router.push('login');
                }else{
                    Toast(res.data.msg);
                }
            });
        }
    }
}

</script>

<style>
    .user-register .swiper-slide {
        padding: 0 1.3rem;
        box-sizing: border-box;
    }

    .user-register .hd {
        padding: 0 3rem;
        margin-bottom: .6rem;
        font-size: 1.05rem;
        text-align: center;
        border-bottom: 1px solid #F3F4F9;
    }

    .user-register .hd li {
        padding: .6rem 0;
        height: 2.6rem;
        line-height: 2.6rem;
        display: block;
        margin-bottom: -1px;
        position: relative;
    }

    .user-register .hd .active {
        color: #ff4146;
        border-bottom: 1px solid #ff4146;
    }

    .user-register .hd .active:after {
        content: " ";
        position: absolute;
        display: block;
        width: .7rem;
        height: .7rem;
        border: 1px solid #ff4146;
        border-right: 0;
        border-bottom: 0;
        -webkit-transform: rotate(45deg);
        -moz-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        -o-transform: rotate(45deg);
        transform: rotate(45deg);
        background: #fff;
        left: 50%;
        margin-left: -.5rem;
        top: 50%;
        margin-top: 1.55rem;
    }

    .user-register .bd {
        padding-bottom: 1rem !important;
    }

    .ipt-check-btn {
        padding: 0 1.4rem;
        height: 1.6rem;
        line-height: 1.6rem;
        margin: .7rem 0;
        text-align: center;
        color: #555;
        display: block;
        border-left: 1px solid #F3F4F9;
        margin-left: 1.2rem;
        font-size: 1rem;
    }
</style>

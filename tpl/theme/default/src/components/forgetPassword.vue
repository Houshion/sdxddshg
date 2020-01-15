<template>
    <div id="main">
        <div class="b-color-f">
            <div class="filter-top" id="scrollUp"><i class="iconfont icon-jiantou"></i></div>
            <div class="search-div j-search-div ts-3">
                <footer class="close-search j-close-search"> 点击关闭</footer>
            </div>
            <div class="con" id="pjax-container">
                <div id="check" style="display: block;">
                    <section class="user-center user-forget-tel margin-lr">
                        <div class="text-all dis-box j-text-all" name="sms_codediv">
                            <div class="input-text input-check box-flex">
                                <div class="text-all dis-box j-text-all" name="write_mobilediv">
                                <label>+86</label><div class="box-flex input-text"><input class="j-input-text" name="write_mobile" v-model="phone" type="tel" placeholder="请输入手机号"></div>
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
                            <div class="text-all dis-box j-text-all" name="repassworddiv" style="border-bottom: 0px;">
                                <div class="box-flex input-text">
                                    <input class="j-input-text" v-model="password2" name="repassword" type="password"
                                           placeholder="请重新输入密码">
                                    <span class="icon-eye" style="right: 10px"></span>
                                </div>
                                <i class="iconfont icon-yanjing is-yanjing j-yanjing disabled"></i>
                            </div>
                        </div>
                    </div>
                    <button type="" class="btn-submit" @click="resetPassword">重置密码</button>
                    </section>
                </div>
                <div class="div-messages"></div>
            </div>
        </div>
    </div>
</template>

<script>
import fetch from './../fetch';
import {toastr} from "./../util";
import { Toast } from 'mint-ui';
export default {
    data(){
        return {
            phone: '',
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

        resetPassword(){

            if(!this.phone){
                Toast('手机号不能为空');
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

            fetch('/api/public/resetPassword', {phone: this.phone, password: this.password, captcha: this.captcha, captcha_uuid: this.captcha_uuid}).then((res) => {

                if (res.data.code) {
                    this.$router.push('user');
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

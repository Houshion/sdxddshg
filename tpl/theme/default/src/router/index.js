import Vue from "vue";
import Router from "vue-router";
import login from "components/login";
import register from "components/register";
import home from "components/home";
import user from "components/user";
import product from "components/product";
import header from "components/header";
import tab from "components/tab";
import cart from "components/cart";
import productDetail from "components/productDetail";
import delivery from "components/delivery";
import orderResult from "components/orderResult";
import forgetPassword from "components/forgetPassword";

Vue.use(Router)

export default new Router({
    routes: [
        {
            path: '/login',
            component: login
        },
        {
            path: '/register',
            component: register
        },
        {
            path: '/forgetPassword',
            component: forgetPassword
        },
        {
            path: '/home',
            component: home
        },
        {
            path: '/user',
            component: user
        },
        {
            path: '/product',
            component: product
        },
        {
            path: '/header',
            component: header
        },
        {
            path: '/tab',
            component: tab
        },
        {
            path: '/cart',
            component: cart
        },
        {
            path: '/product/:id',
            name: 'productDetail',
            component: productDetail
        },
        {
            path: '/delivery',
            component: delivery
        },
        {
            path: '/order/:id',
            name: 'orderResult',
            component: orderResult
        },
        {
            path: '*',
            redirect: '/home'
        }
    ],
    linkActiveClass: 'selected'
})

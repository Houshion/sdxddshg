webpackJsonp([0],[
/* 0 */,
/* 1 */,
/* 2 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = fetch;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_axios__ = __webpack_require__(7);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_axios___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_axios__);


__WEBPACK_IMPORTED_MODULE_0_axios___default.a.defaults.baseURL = baseURL;
__WEBPACK_IMPORTED_MODULE_0_axios___default.a.defaults.headers.common['Authorization'] = '';

function fetch(url, params) {

    __WEBPACK_IMPORTED_MODULE_0_axios___default.a.defaults.headers.common['Authorization'] = localStorage.token;

    if (params) {
        return __WEBPACK_IMPORTED_MODULE_0_axios___default.a.post(url, params).catch(function (error) {
            if (error.response) {
                if (error.response.status == 401) {
                    location.href = '#login';
                }
            } else {
                console.log(error);
            }
        });
    }

    return __WEBPACK_IMPORTED_MODULE_0_axios___default.a.get(url).catch(function (error) {
        if (error.response) {
            if (error.response.status == 401) {
                location.href = '#login';
            }
        } else {
            console.log(error);
        }
    });
}

/***/ }),
/* 3 */,
/* 4 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = getFile;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_axios__ = __webpack_require__(7);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_axios___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_axios__);


function getFile(file) {
	if (file) {
		return __WEBPACK_IMPORTED_MODULE_0_axios___default.a.defaults.baseURL + `/public/uploads/${file.savepath}${file.savename}`;
	}
	return '';
}

/***/ }),
/* 5 */,
/* 6 */,
/* 7 */,
/* 8 */,
/* 9 */,
/* 10 */,
/* 11 */,
/* 12 */,
/* 13 */,
/* 14 */,
/* 15 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(61)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(49),
  /* template */
  __webpack_require__(93),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 16 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(69)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(50),
  /* template */
  __webpack_require__(102),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 17 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(66)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(56),
  /* template */
  __webpack_require__(98),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 18 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue__ = __webpack_require__(5);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_vue_router__ = __webpack_require__(109);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_components_login__ = __webpack_require__(87);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_components_login___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2_components_login__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_components_register__ = __webpack_require__(91);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_components_register___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3_components_register__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_components_home__ = __webpack_require__(16);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_components_home___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_4_components_home__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5_components_user__ = __webpack_require__(92);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5_components_user___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_5_components_user__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6_components_product__ = __webpack_require__(89);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6_components_product___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_6_components_product__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7_components_header__ = __webpack_require__(15);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7_components_header___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_7_components_header__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8_components_tab__ = __webpack_require__(17);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8_components_tab___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_8_components_tab__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9_components_cart__ = __webpack_require__(84);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9_components_cart___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_9_components_cart__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_10_components_productDetail__ = __webpack_require__(90);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_10_components_productDetail___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_10_components_productDetail__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_11_components_delivery__ = __webpack_require__(85);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_11_components_delivery___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_11_components_delivery__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_12_components_orderResult__ = __webpack_require__(88);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_12_components_orderResult___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_12_components_orderResult__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_13_components_forgetPassword__ = __webpack_require__(86);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_13_components_forgetPassword___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_13_components_forgetPassword__);















__WEBPACK_IMPORTED_MODULE_0_vue___default.a.use(__WEBPACK_IMPORTED_MODULE_1_vue_router__["a" /* default */]);

/* harmony default export */ __webpack_exports__["a"] = (new __WEBPACK_IMPORTED_MODULE_1_vue_router__["a" /* default */]({
    routes: [{
        path: '/login',
        component: __WEBPACK_IMPORTED_MODULE_2_components_login___default.a
    }, {
        path: '/register',
        component: __WEBPACK_IMPORTED_MODULE_3_components_register___default.a
    }, {
        path: '/forgetPassword',
        component: __WEBPACK_IMPORTED_MODULE_13_components_forgetPassword___default.a
    }, {
        path: '/home',
        component: __WEBPACK_IMPORTED_MODULE_4_components_home___default.a
    }, {
        path: '/user',
        component: __WEBPACK_IMPORTED_MODULE_5_components_user___default.a
    }, {
        path: '/product',
        component: __WEBPACK_IMPORTED_MODULE_6_components_product___default.a
    }, {
        path: '/header',
        component: __WEBPACK_IMPORTED_MODULE_7_components_header___default.a
    }, {
        path: '/tab',
        component: __WEBPACK_IMPORTED_MODULE_8_components_tab___default.a
    }, {
        path: '/cart',
        component: __WEBPACK_IMPORTED_MODULE_9_components_cart___default.a
    }, {
        path: '/product/:id',
        name: 'productDetail',
        component: __WEBPACK_IMPORTED_MODULE_10_components_productDetail___default.a
    }, {
        path: '/delivery',
        component: __WEBPACK_IMPORTED_MODULE_11_components_delivery___default.a
    }, {
        path: '/order/:id',
        name: 'orderResult',
        component: __WEBPACK_IMPORTED_MODULE_12_components_orderResult___default.a
    }, {
        path: '*',
        redirect: '/home'
    }],
    linkActiveClass: 'selected'
}));

/***/ }),
/* 19 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 20 */,
/* 21 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(64)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(45),
  /* template */
  __webpack_require__(96),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 22 */,
/* 23 */,
/* 24 */,
/* 25 */,
/* 26 */,
/* 27 */,
/* 28 */,
/* 29 */,
/* 30 */,
/* 31 */,
/* 32 */,
/* 33 */,
/* 34 */,
/* 35 */,
/* 36 */,
/* 37 */,
/* 38 */,
/* 39 */,
/* 40 */,
/* 41 */,
/* 42 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'swiper-slide',
  data() {
    return {
      slideClass: 'swiper-slide'
    };
  },
  ready() {
    this.update();
  },
  mounted() {
    this.update();
    if (this.$parent.options.slideClass) {
      this.slideClass = this.$parent.options.slideClass;
    }
  },
  updated() {
    this.update();
  },
  attached() {
    this.update();
  },
  methods: {
    update() {
      if (this.$parent && this.$parent.swiper && this.$parent.swiper.update) {
        this.$parent.swiper.update(true);
        if (this.$parent.options.loop) {
          this.$parent.swiper.reLoop();
        }
      }
    }
  }
});

/***/ }),
/* 43 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//

var browser = typeof window !== 'undefined';
if (browser) {
  window.Swiper = __webpack_require__(13);
  __webpack_require__(59);
}
/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'swiper',
  props: {
    options: {
      type: Object,
      default() {
        return {
          autoplay: 3500
        };
      }
    }
  },
  data() {
    return {
      defaultSwiperClasses: {
        wrapperClass: 'swiper-wrapper'
      }
    };
  },
  ready() {
    if (!this.swiper && browser) {
      this.swiper = new Swiper(this.$el, this.options);
    }
  },
  mounted() {
    var self = this;
    var mount = function () {
      if (!self.swiper && browser) {
        delete self.options.notNextTick;
        var setClassName = false;
        for (var className in self.defaultSwiperClasses) {
          if (self.defaultSwiperClasses.hasOwnProperty(className)) {
            if (self.options[className]) {
              setClassName = true;
              self.defaultSwiperClasses[className] = self.options[className];
            }
          }
        }
        var mountInstance = function () {
          self.swiper = new Swiper(self.$el, self.options);
        };
        setClassName ? self.$nextTick(mountInstance) : mountInstance();
      }
    };
    this.options.notNextTick ? mount() : this.$nextTick(mount);
  },
  updated() {
    if (this.swiper) {
      this.swiper.update();
    }
  },
  beforeDestroy() {
    if (this.swiper) {
      this.swiper.destroy();
      delete this.swiper;
    }
  }
});

/***/ }),
/* 44 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//

const inBrowser = typeof window !== 'undefined';
/* harmony default export */ __webpack_exports__["default"] = ({
    name: 'VueProgress',
    serverCacheKey: () => 'Progress',
    computed: {
        style() {
            let location = this.progress.options.location;
            let style = {
                'background-color': this.progress.options.canSuccess ? this.progress.options.color : this.progress.options.failedColor,
                'opacity': this.progress.options.show ? 1 : 0
            };
            if (location == 'top' || location == 'bottom') {
                location === 'top' ? style.top = '0px' : style.bottom = '0px';
                if (!this.progress.options.inverse) {
                    style.left = '0px';
                } else {
                    style.right = '0px';
                }
                style.width = this.progress.percent + '%';
                style.height = this.progress.options.thickness;
                style.transition = "width " + this.progress.options.transition.speed + ", opacity " + this.progress.options.transition.opacity;
            } else if (location == 'left' || location == 'right') {
                location === 'left' ? style.left = '0px' : style.right = '0px';
                if (!this.progress.options.inverse) {
                    style.bottom = '0px';
                } else {
                    style.top = '0px';
                }
                style.height = this.progress.percent + '%';
                style.width = this.progress.options.thickness;
                style.transition = "height " + this.progress.options.transition.speed + ", opacity " + this.progress.options.transition.opacity;
            }
            return style;
        },
        progress() {
            if (inBrowser) {
                return window.VueProgressBarEventBus.RADON_LOADING_BAR;
            } else {
                return {
                    percent: 0,
                    options: {
                        canSuccess: true,
                        show: false,
                        color: 'rgb(19, 91, 55)',
                        failedColor: 'red',
                        thickness: '2px',
                        transition: {
                            speed: '0.2s',
                            opacity: '0.6s',
                            termination: 300
                        },
                        location: 'top',
                        autoRevert: true,
                        inverse: false
                    }
                };
            }
        }
    }
});

/***/ }),
/* 45 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__components_home__ = __webpack_require__(16);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__components_home___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__components_home__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__components_header__ = __webpack_require__(15);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__components_header___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__components_header__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__components_tab__ = __webpack_require__(17);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__components_tab___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__components_tab__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__assets_css_style_css__ = __webpack_require__(60);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__assets_css_style_css___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3__assets_css_style_css__);
//
//
//
//
//
//
//
//
//






/* harmony default export */ __webpack_exports__["default"] = ({
    name: 'app',
    data() {
        return {
            title: "wemall商城"
        };
    },
    localStorage: {
        config: {
            type: Object,
            default: {}
        },
        cartData: {
            type: Object,
            default: []
        },
        product: {
            type: Object,
            default: []
        },
        menu: {
            type: Object,
            default: []
        },
        ads: {
            type: Object,
            default: []
        },
        user: {
            type: Object,
            default: {}
        },
        token: {
            type: String,
            default: ''
        }
    },
    components: {
        home: __WEBPACK_IMPORTED_MODULE_0__components_home___default.a, tab: __WEBPACK_IMPORTED_MODULE_2__components_tab___default.a, 'v-header': __WEBPACK_IMPORTED_MODULE_1__components_header___default.a
    },
    mounted() {
        //  [App.vue specific] When App.vue is finish loading finish the progress bar
        this.$Progress.finish();
    },
    created() {
        //  [App.vue specific] When App.vue is first loaded start the progress bar
        this.$Progress.start
        //  hook the progress bar to start before we move router-view
        ();this.$router.beforeEach((to, from, next) => {
            //  does the page we want to go to have a meta.progress object
            if (to.meta.progress !== undefined) {
                let meta = to.meta.progress;
                // parse meta tags
                this.$Progress.parseMeta(meta);
            }
            //  start the progress bar
            this.$Progress.start

            //  continue to next page
            ();next();
        }
        //  hook the progress bar to finish after we've finished moving router-view
        );this.$router.afterEach((to, from) => {
            //  finish the progress bar
            this.$Progress.finish();
        });
    }
});

/***/ }),
/* 46 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    data() {
        return {
            cartData: [],
            cartNum: 0,
            cartTotal: 0
        };
    },
    created() {

        this.$bus.emit('updateTitle', '购物车');
        this.updateCart();
    },
    methods: {

        addCart(item) {

            for (let key in this.cartData) {
                if (this.cartData[key].id == item.id) {
                    this.cartData[key].num++;
                }
            }

            this.$localStorage.set('cartData', this.cartData);
            this.updateCart();
        },
        disCart(item) {
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
        delCart(item) {

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
            }

            // 更新tab购物车数量
            );this.$bus.emit('updateCart', true);
        }
    }
});

/***/ }),
/* 47 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__fetch__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_mint_ui__ = __webpack_require__(3);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_mint_ui___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_mint_ui__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



/* harmony default export */ __webpack_exports__["default"] = ({
    data() {
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
            location: [{ sub: [] }],
            deliveryTime: [],
            province: 0,
            city: 0,
            selectedDeliveryTime: ''
        };
    },
    created() {

        const cartData = this.$localStorage.get('cartData');
        if (!cartData.length) {
            this.$router.go(-1);
            return;
        }

        __WEBPACK_IMPORTED_MODULE_1_mint_ui__["Indicator"].open();

        this.$bus.emit('updateTitle', '购物车');
        __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__fetch__["a" /* default */])('/api/payment').then(res => {
            if (res) {
                this.payment = res.data.data.payment;
                this.selectedPayment = this.payment[0].id;
            }
        });

        __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__fetch__["a" /* default */])('/api/location').then(res => {
            if (res) {
                this.location = res.data.data.location[0].sub;

                __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__fetch__["a" /* default */])('/api/contact').then(res => {
                    if (res) {
                        if (res.data.data.contact.length) {
                            this.contact = res.data.data.contact[0];

                            for (let key in this.location) {
                                if (this.location[key].id == this.contact.province_id) {
                                    this.province = key;

                                    for (let key1 in this.location[key].sub) {
                                        if (this.location[key].sub[key1].id == this.contact.city_id) {
                                            this.city = key1;
                                        }
                                    }
                                }
                            }
                        }

                        __WEBPACK_IMPORTED_MODULE_1_mint_ui__["Indicator"].close();
                    }
                });
            }
        });

        __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__fetch__["a" /* default */])('/api/addons/deliveryTime').then(res => {
            if (res) {
                this.deliveryTime = res.data.data.delivery_time;
                this.selectedDeliveryTime = res.data.data.delivery_time[0];
            }
        });
    },
    methods: {
        selectPayment(item) {
            this.selectedPayment = item.id;
        },
        submit() {

            if (!this.contact.name) {
                __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_1_mint_ui__["Toast"])('姓名不能为空');
                return;
            }
            if (!this.contact.phone) {
                __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_1_mint_ui__["Toast"])('手机号不能为空');
                return;
            }
            if (!this.contact.address) {
                __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_1_mint_ui__["Toast"])('地址不能为空');
                return;
            }

            __WEBPACK_IMPORTED_MODULE_1_mint_ui__["Indicator"].open();

            __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__fetch__["a" /* default */])('/api/contact', Object.assign({ id: this.contact.id, phone: this.contact.phone, name: this.contact.name }, { province_id: this.location[this.province].id, city_id: this.location[this.province].sub[this.city].id })).then(res => {

                if (res) {
                    this.contact = res.data.data.contact;
                    __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__fetch__["a" /* default */])('/api/order', { cartData: this.$localStorage.get('cartData'), contact_id: this.contact.id,
                        payment_id: this.selectedPayment, delivery_time: this.selectedDeliveryTime }).then(res => {

                        if (res) {
                            __WEBPACK_IMPORTED_MODULE_1_mint_ui__["Indicator"].close();

                            if (res.data.code) {
                                this.$localStorage.set('cartData', []);
                                this.$router.push({ name: 'orderResult', params: { id: res.data.data.order.id } });

                                const order_id = res.data.data.order.id;
                                if (this.selectedPayment == 2) {
                                    __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__fetch__["a" /* default */])(`/api/pay/wxpay/${order_id}`).then(res => {
                                        if (!res) {
                                            return;
                                        }
                                        WeixinJSBridge.invoke('getBrandWCPayRequest', res.data.data.jsApiParameters, function (res) {
                                            if (res.err_msg == "get_brand_wcpay_request:ok") {
                                                alert("支付成功");
                                                // 这里可以跳转到订单完成页面向用户展示
                                                this.$router.go(0);
                                            } else {
                                                alert(res.err_code + res.err_desc + res.err_msg);
                                            }
                                        });
                                    });
                                }
                                if (this.selectedPayment == 3) {
                                    __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__fetch__["a" /* default */])(`/api/pay/alipay/${order_id}`).then(res => {
                                        if (!res) {
                                            return;
                                        }
                                        if (res.data.code) {
                                            location.href = res.data.data.url;
                                        } else {
                                            __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_1_mint_ui__["Toast"])(res.data.msg);
                                        }
                                    });
                                }
                                if (this.selectedPayment == 4) {
                                    __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__fetch__["a" /* default */])(`/api/pay/balance/${order_id}`).then(res => {
                                        if (!res) {
                                            return;
                                        }

                                        if (res.data.code) {
                                            this.$router.go(0);
                                        } else {
                                            __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_1_mint_ui__["Toast"])(res.data.msg);
                                        }
                                    });
                                }
                            } else {
                                __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_1_mint_ui__["Toast"])(res.data.msg);
                            }
                        }
                    });
                }
            });
        }
    }
});

/***/ }),
/* 48 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__fetch__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__util__ = __webpack_require__(4);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_mint_ui__ = __webpack_require__(3);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_mint_ui___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2_mint_ui__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//




/* harmony default export */ __webpack_exports__["default"] = ({
    data() {
        return {
            phone: '',
            captcha: '',
            captcha_uuid: '',
            password: '',
            password2: '',
            captcha_txt: '发送验证码'
        };
    },
    methods: {

        getCaptcha() {

            if (!this.phone) {
                __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_2_mint_ui__["Toast"])('手机号不能为空');
                return;
            }

            if (typeof this.captcha_txt == 'number') {
                return;
            }
            let i = 1;
            this.captcha_txt = 60;
            let captcha_interval = setInterval(() => {
                this.captcha_txt -= i;
                if (this.captcha_txt == 0) {
                    clearInterval(captcha_interval);
                    this.captcha_txt = '发送验证码';
                }
            }, 1000);

            __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__fetch__["a" /* default */])('/api/public/sendSmsCaptcha', { phone: this.phone }).then(res => {
                if (res.data.code) {
                    this.captcha_uuid = res.data.data.uuid;
                } else {
                    __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_2_mint_ui__["Toast"])(res.data.msg);
                }
            });
        },

        resetPassword() {

            if (!this.phone) {
                __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_2_mint_ui__["Toast"])('手机号不能为空');
                return;
            }
            if (!this.captcha_uuid || !this.captcha) {
                __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_2_mint_ui__["Toast"])('请先发送验证码');
                return;
            }
            if (this.password != this.password2) {
                __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_2_mint_ui__["Toast"])('手机号两次输入有误');
                return;
            }

            __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__fetch__["a" /* default */])('/api/public/resetPassword', { phone: this.phone, password: this.password, captcha: this.captcha, captcha_uuid: this.captcha_uuid }).then(res => {

                if (res.data.code) {
                    this.$router.push('user');
                } else {
                    __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_2_mint_ui__["Toast"])(res.data.msg);
                }
            });
        }
    }
});

/***/ }),
/* 49 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    data() {
        return {
            title: ''
        };
    },
    created() {

        this.$bus.on('updateTitle', this.updateTitle);
    },
    methods: {
        updateTitle(title) {
            this.title = title;
        }
    }
});

/***/ }),
/* 50 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__fetch__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__util__ = __webpack_require__(4);
//
//
//
//
//
//
//
//
//
//
//
//
//




/* harmony default export */ __webpack_exports__["default"] = ({
    data() {
        return {
            ads: [],
            config: {}
        };
    },
    created() {

        this.$bus.emit('updateTitle', '首页');
        this.ads = this.$localStorage.get('ads');

        __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__fetch__["a" /* default */])('/api/config').then(res => {
            if (res) {
                this.config = res.data.data.config;
                document.title = this.config.title;
                // 缓存广告
                this.$localStorage.set('config', this.config);
            }
        });

        __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__fetch__["a" /* default */])('/api/ads').then(res => {
            if (res) {
                this.ads = res.data.data.ads;

                // 缓存广告
                this.$localStorage.set('ads', this.ads);
            }
        });
    },
    methods: {
        getFile: __WEBPACK_IMPORTED_MODULE_1__util__["a" /* getFile */]
    }
});

/***/ }),
/* 51 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__fetch__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_mint_ui__ = __webpack_require__(3);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_mint_ui___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_mint_ui__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//




/* harmony default export */ __webpack_exports__["default"] = ({
    data() {
        return {
            phone: '',
            password: ''
        };
    },
    created() {
        __WEBPACK_IMPORTED_MODULE_1_mint_ui__["Indicator"].close();
    },
    methods: {
        login() {

            __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__fetch__["a" /* default */])('/api/public/login', { phone: this.phone, password: this.password }).then(res => {

                if (res.data.code) {
                    this.$localStorage.set('user', res.data.data.user);
                    this.$localStorage.set('token', res.data.data.token);

                    this.$router.push('user');
                } else {
                    __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_1_mint_ui__["Toast"])(res.data.msg);
                }
            });
        },
        oauth() {

            location.href = '/static/oauth.html#/?redirect=' + encodeURIComponent(location.origin + '/app#/user');
        }
    }
});

/***/ }),
/* 52 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__fetch__ = __webpack_require__(2);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ __webpack_exports__["default"] = ({
    data() {
        return {
            order: {}
        };
    },
    created() {

        __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__fetch__["a" /* default */])(`/api/order/${this.$route.params.id}`).then(res => {
            this.order = res.data.data.order;
        });
    }
});

/***/ }),
/* 53 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue_awesome_swiper__ = __webpack_require__(14);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue_awesome_swiper___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_vue_awesome_swiper__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__fetch__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__util__ = __webpack_require__(4);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//





/* harmony default export */ __webpack_exports__["default"] = ({
    data() {
        return {
            title: '欢迎来到wemall商城!',
            swiperOption: {
                direction: 'horizontal',
                slidesPerView: 3,
                spaceBetween: 0,
                paginationClickable: false,
                slideToClickedSlide: false,
                notNextTick: true
            },
            selectedMenu: 0,
            menu: [],
            product: []
        };
    },
    computed: {
        swiper() {
            return this.$refs.mySwiperProduct.swiper;
        }
    },
    components: {
        swiper: __WEBPACK_IMPORTED_MODULE_0_vue_awesome_swiper__["swiper"],
        swiperSlide: __WEBPACK_IMPORTED_MODULE_0_vue_awesome_swiper__["swiperSlide"]
    },
    created() {

        this.$bus.emit('updateTitle', '全部商品');
        this.menu = this.$localStorage.get('menu');
        this.product = this.$localStorage.get('product');
        this.title = this.$localStorage.get('config').title;

        this.initMenu();
        this.updateProduct();

        __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_1__fetch__["a" /* default */])('/api/product/category').then(res => {
            if (res) {
                this.menu = res.data.data.category;

                // 缓存菜单
                this.$localStorage.set('menu', this.menu);

                // 设置默认第一个菜单
                this.initMenu();
            }
        });

        __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_1__fetch__["a" /* default */])('/api/product').then(res => {
            if (res) {
                this.product = res.data.data.product;

                // 缓存商品
                this.$localStorage.set('product', this.product);

                this.updateProduct();
            }
        });
    },
    methods: {
        backToTop() {
            window.scrollTo(0, 0);
        },
        selectMenu(id) {
            this.selectedMenu = id;

            this.$localStorage.set('selectedMenu', this.selectedMenu);
        },
        initMenu() {
            if (!this.selectedMenu && this.menu.length) {
                this.selectMenu(this.menu[0].id);
            }
        },
        updateProduct() {
            // 更新视图
            let cartData = this.$localStorage.get('cartData');
            for (let key in this.product) {
                // this.$set(`this.product[${key}].selected`,false);
                // this.$set(this.product[key], Object.assign(this.product[key], {selected: false}));
                for (let keyIn in cartData) {
                    if (this.product[key].id == cartData[keyIn].id) {
                        this.$set(this.product[key], Object.assign(this.product[key], { selected: true })
                        // this.$set(`this.product[${key}].selected`,true);
                        // this.product[${key}].selected
                        );
                    }
                }
            }
        },
        addCart(item) {
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
            this.updateProduct();
        },
        getFile: __WEBPACK_IMPORTED_MODULE_2__util__["a" /* getFile */]
    }
});

/***/ }),
/* 54 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue_awesome_swiper__ = __webpack_require__(14);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue_awesome_swiper___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_vue_awesome_swiper__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__fetch__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__util__ = __webpack_require__(4);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//





/* harmony default export */ __webpack_exports__["default"] = ({
    data() {
        return {
            product: {},
            swiperOption: {
                direction: 'horizontal'
            }
        };
    },
    components: {
        swiper: __WEBPACK_IMPORTED_MODULE_0_vue_awesome_swiper__["swiper"],
        swiperSlide: __WEBPACK_IMPORTED_MODULE_0_vue_awesome_swiper__["swiperSlide"]
    },
    methods: {
        backToTop() {
            window.scrollTo(0, 0);
        },
        getFile: __WEBPACK_IMPORTED_MODULE_2__util__["a" /* getFile */],
        addCart(item) {
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
    created() {

        const product = this.$localStorage.get('product');
        for (let key in product) {
            if (product[key].id == this.$route.params.id) {
                this.product = product[key];
            }
        }

        __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_1__fetch__["a" /* default */])(`/api/product/${this.$route.params.id}`).then(res => {
            if (res) {
                this.product = res.data.data.product;
            }
        });
    }
});

/***/ }),
/* 55 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__fetch__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_mint_ui__ = __webpack_require__(3);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_mint_ui___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_mint_ui__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//




/* harmony default export */ __webpack_exports__["default"] = ({
    data() {
        return {
            phone: '',
            username: '',
            captcha: '',
            captcha_uuid: '',
            password: '',
            password2: '',
            captcha_txt: '发送验证码'
        };
    },
    methods: {

        getCaptcha() {

            if (!this.phone) {
                __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_1_mint_ui__["Toast"])('手机号不能为空');
                return;
            }

            if (typeof this.captcha_txt == 'number') {
                return;
            }
            let i = 1;
            this.captcha_txt = 60;
            let captcha_interval = setInterval(() => {
                this.captcha_txt -= i;
                if (this.captcha_txt == 0) {
                    clearInterval(captcha_interval);
                    this.captcha_txt = '发送验证码';
                }
            }, 1000);

            __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__fetch__["a" /* default */])('/api/public/sendSmsCaptcha', { phone: this.phone }).then(res => {
                if (res.data.code) {
                    this.captcha_uuid = res.data.data.uuid;
                } else {
                    __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_1_mint_ui__["Toast"])(res.data.msg);
                }
            });
        },

        register() {

            if (!this.phone) {
                __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_1_mint_ui__["Toast"])('手机号不能为空');
                return;
            }
            if (!this.username) {
                __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_1_mint_ui__["Toast"])('用户名不能为空');
                return;
            }
            if (!this.captcha_uuid || !this.captcha) {
                __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_1_mint_ui__["Toast"])('请先发送验证码');
                return;
            }
            if (this.password != this.password2) {
                __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_1_mint_ui__["Toast"])('手机号两次输入有误');
                return;
            }

            __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__fetch__["a" /* default */])('/api/public/register', { phone: this.phone, password: this.password, username: this.username, captcha: this.captcha, captcha_uuid: this.captcha_uuid }).then(res => {

                if (res.data.code) {
                    this.$router.push('login');
                } else {
                    __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_1_mint_ui__["Toast"])(res.data.msg);
                }
            });
        }
    }
});

/***/ }),
/* 56 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    data() {
        return {
            cartNum: 0
        };
    },
    created() {

        this.updateCart();
        this.$bus.on('updateCart', this.updateCart);
    },
    methods: {
        updateCart() {
            this.cartNum = 0;
            const cartData = this.$localStorage.get('cartData');
            cartData.forEach((val, index) => {
                this.cartNum += cartData[index].num;
            });
        }
    }
});

/***/ }),
/* 57 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__util__ = __webpack_require__(4);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__fetch__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_mint_ui__ = __webpack_require__(3);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_mint_ui___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2_mint_ui__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__assets_img_default_avater_png__ = __webpack_require__(77);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__assets_img_default_avater_png___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3__assets_img_default_avater_png__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//





/* harmony default export */ __webpack_exports__["default"] = ({
    data() {
        return {
            user: {},
            order: [],
            config: {
                tel: ''
            }
        };
    },
    created() {

        this.$bus.emit('updateTitle', '我的');
        this.$bus.emit('updateTitle', '我的');
        this.user = this.$localStorage.get('user');
        this.config = this.$localStorage.get('config');

        __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_1__fetch__["a" /* default */])('/api/order').then(res => {
            if (res) {
                this.order = res.data.data.order;
            }
        });
    },
    computed: {
        getAvaterFile() {
            if (this.user.avater_id) {
                return __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_0__util__["a" /* getFile */])(this.user.avater);
            } else {
                return __WEBPACK_IMPORTED_MODULE_3__assets_img_default_avater_png___default.a;
            }
        }
    },
    methods: {
        logout() {
            this.$localStorage.set('user', {});
            this.$localStorage.set('token', '');
        },
        cancelOrder(item) {
            __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_1__fetch__["a" /* default */])(`/api/order/cancel/${item.id}`).then(res => {
                if (!res) {
                    return;
                }
                if (res.data.code) {
                    this.$router.go(0);
                } else {
                    __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_2_mint_ui__["Toast"])(res.data.msg);
                }
            });
        },
        tel() {
            location.href = 'tel:' + this.config.tel;
        },
        wxpay(item) {
            __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_1__fetch__["a" /* default */])(`/api/pay/wxpay/${item.id}`).then(res => {
                if (!res) {
                    return;
                }
                WeixinJSBridge.invoke('getBrandWCPayRequest', res.data.data.jsApiParameters, function (res) {
                    if (res.err_msg == "get_brand_wcpay_request:ok") {
                        alert("支付成功");
                        // 这里可以跳转到订单完成页面向用户展示
                        this.$router.go(0);
                    } else {
                        alert(res.err_code + res.err_desc + res.err_msg);
                    }
                });
            });
        },
        alipay(item) {
            __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_1__fetch__["a" /* default */])(`/api/pay/alipay/${item.id}`).then(res => {
                if (!res) {
                    return;
                }
                if (res.data.code) {
                    location.href = res.data.data.url;
                } else {
                    __webpack_require__.i(__WEBPACK_IMPORTED_MODULE_2_mint_ui__["Toast"])(res.data.msg);
                }
            });
        }
    }
});

/***/ }),
/* 58 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue__ = __webpack_require__(5);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__App__ = __webpack_require__(21);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__App___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__App__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__router__ = __webpack_require__(18);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_vue_progressbar__ = __webpack_require__(23);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_vue_progressbar___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3_vue_progressbar__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_vue_localstorage__ = __webpack_require__(22);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_vue_localstorage___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_4_vue_localstorage__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5_vue_bus__ = __webpack_require__(20);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5_vue_bus___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_5_vue_bus__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6_mint_ui__ = __webpack_require__(3);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6_mint_ui___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_6_mint_ui__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7_mint_ui_lib_style_css__ = __webpack_require__(19);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7_mint_ui_lib_style_css___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_7_mint_ui_lib_style_css__);
// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.









__WEBPACK_IMPORTED_MODULE_0_vue___default.a.use(__WEBPACK_IMPORTED_MODULE_5_vue_bus___default.a);
__WEBPACK_IMPORTED_MODULE_0_vue___default.a.use(__WEBPACK_IMPORTED_MODULE_6_mint_ui___default.a);
__WEBPACK_IMPORTED_MODULE_0_vue___default.a.use(__WEBPACK_IMPORTED_MODULE_4_vue_localstorage___default.a);
__WEBPACK_IMPORTED_MODULE_0_vue___default.a.use(__WEBPACK_IMPORTED_MODULE_3_vue_progressbar___default.a, {
    color: '#18ac16',
    failedColor: 'red',
    thickness: '3px'
});

/* eslint-disable no-new */
new __WEBPACK_IMPORTED_MODULE_0_vue___default.a({
    el: '#app',
    router: __WEBPACK_IMPORTED_MODULE_2__router__["a" /* default */],
    template: '<App/>',
    components: { App: __WEBPACK_IMPORTED_MODULE_1__App___default.a }
});

/***/ }),
/* 59 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 60 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 61 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 62 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 63 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 64 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 65 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 66 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 67 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 68 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 69 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 70 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 71 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 72 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 73 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 74 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 75 */,
/* 76 */,
/* 77 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__.p + "static/img/default_avater.eb3d62d.png";

/***/ }),
/* 78 */
/***/ (function(module, exports) {

module.exports = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACYAAAAmCAYAAACoPemuAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA7lJREFUeNrEmFlIVVEUhr1DGqWWlU3mzZKsKIkSrKAiyGygEaIIe5CgaBCKHsKG1ygCmxDqJQOJIiKohCilECmQMmyAEqEU05CKJCvL8fZvWCd+DmfY5w644MPjueus9d+z19177e0Lh8MJEdgksAosB3NAJkgDPtAFPoMm8AzUgA7PGZQwTXxgPagGA2F9GwS1YAfw6+bzab6xJaAc5Fl81g9awQ+5Hg2yQKqFr3qLh0B1tG9sBCiTb832HpwEi8XH6tkZYDd4YPGGK8Aop9xOotJAnSngS7DOw/CzyArTF3wDMrwKSwevKchfcNhLjdiQD5opbiuYpitsJKinhzslYEKMSJXh5bJI0xF2mR76AnJiKIpr9x7luSu/eltha8j5D8iLgygDVfwvKF+xnbCgafxL4ijKIAt00+ikWgkrJlH1MSh0XY5Q3lIrYY3kUOASLBtM1Ug6G4x38UkE7ZJX/Q2wsFzT/OIU6LT49YMiB78r4tcLNrrEPEb5C1lYKX1w1CFAUBIZ1mDjN9Y0Mde4CMsk34vqnl9WppW0Sj1yWMEGQAv9/9HGr0c6DMPaXFbGT+CdXK/gtbJN1P7WKPocWV4uuNSPKo9KcBakaNTjNRr6gFF8Q5r1FU+4zkJqKFOkwUuQJm+4jHOPUcKS6EbfMArj3H4lrJtupAyjsGS67lXCfoGfcmO6zUMF4AOoBYEIE++VGKdsPs+i6w6j8Bqo8Ca4zM6lERS2WiW+S6O4wManhmb//9NFOQnbbvPgHvm8z2N/lkid8FUbnySZqpTdYWFbSNgth13SY2oe52mISpJeS1kLdw8mOP9+Fqa61i7qw6bYBMigyVj57zQ3eKYJ9jm1NLkOX+AhjcZEc3dxiVSXOQSZKe2wYY0yOW4Aa8FBUEUbjw6XhjOfYt22antCtEAr5XMdgqkl5rxsUuysX5audIc4ftpfqNVnkV1rfcbUOSS61JB67QdEgPpVPQE3ZEcV0qjB45Sv0qnnTza119cdaihaNtNGuNOoLadd0kL66YZl1Q/GWNRWKhslbrXuhneTaVuvDlImx0CQqqkTFFvV1T6vRwTbTMX9Vc4iIt2kqJF4SvEGjDnLqzDFMlqKDGuSrd04DTEBObq6Tz2fsm9u+wCdY6h0cA4UUd+mbBA0CM3ST/XJAV4IzJc2eYwpXhUocW23PQzFUjlzGApHZnVWRR7twR1bNtgFCkE+CNr4qTf6Sg7pboK3XpJEIoxNdb+zZOhUo2f0d+0yvD2RBo5WWNzsnwADAPjNSRnc08dPAAAAAElFTkSuQmCC"

/***/ }),
/* 79 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__.p + "static/img/weixin.5f4691f.png";

/***/ }),
/* 80 */,
/* 81 */
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(42),
  /* template */
  __webpack_require__(100),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 82 */
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(43),
  /* template */
  __webpack_require__(107),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 83 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(71)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(44),
  /* template */
  __webpack_require__(104),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 84 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(73)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(46),
  /* template */
  __webpack_require__(106),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 85 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(72)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(47),
  /* template */
  __webpack_require__(105),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 86 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(63)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(48),
  /* template */
  __webpack_require__(95),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 87 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(65)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(51),
  /* template */
  __webpack_require__(97),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 88 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(68)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(52),
  /* template */
  __webpack_require__(101),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 89 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(70)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(53),
  /* template */
  __webpack_require__(103),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 90 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(67)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(54),
  /* template */
  __webpack_require__(99),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 91 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(62)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(55),
  /* template */
  __webpack_require__(94),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 92 */
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(74)

var Component = __webpack_require__(0)(
  /* script */
  __webpack_require__(57),
  /* template */
  __webpack_require__(108),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),
/* 93 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "header-bar"
  }, [_c('div', {
    staticClass: "header-left",
    staticStyle: {
      "display": "none"
    },
    attrs: {
      "href": "javascript:void(history.back());"
    }
  }), _vm._v(" "), _c('div', {
    staticClass: "header-title"
  }, [_vm._v(_vm._s(_vm.title))])])
},staticRenderFns: []}

/***/ }),
/* 94 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    attrs: {
      "id": "main"
    }
  }, [_c('div', {
    staticClass: "b-color-f"
  }, [_c('div', {
    staticClass: "user-register of-hidden"
  }, [_c('div', {
    staticClass: "swiper-container-horizontal swiper-container-autoheight",
    attrs: {
      "id": "j-tab-con"
    }
  }, [_c('div', {
    staticClass: "swiper-wrapper",
    staticStyle: {
      "height": "338px"
    }
  }, [_c('section', {
    staticClass: "swiper-slide swiper-no-swiping swiper-slide-active"
  }, [_c('div', {
    staticClass: "text-all dis-box j-text-all",
    attrs: {
      "name": "mobilediv"
    }
  }, [_c('label', [_vm._v("+86")]), _vm._v(" "), _c('div', {
    staticClass: "box-flex input-text"
  }, [_c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.phone),
      expression: "phone"
    }],
    staticClass: "j-input-text",
    attrs: {
      "name": "mobile",
      "type": "tel",
      "placeholder": "手机号"
    },
    domProps: {
      "value": (_vm.phone)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.phone = $event.target.value
      }
    }
  }), _vm._v(" "), _c('i', {
    staticClass: "iconfont icon-guanbi is-null j-is-null"
  })])]), _vm._v(" "), _c('div', {
    staticClass: "text-all dis-box j-text-all",
    attrs: {
      "name": "mobile_codediv"
    }
  }, [_c('div', {
    staticClass: "box-flex input-text",
    staticStyle: {
      "-webkit-box-flex": "1"
    }
  }, [_c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.captcha),
      expression: "captcha"
    }],
    staticClass: "j-input-text",
    attrs: {
      "name": "mobile_code",
      "type": "number",
      "placeholder": "请输入验证码"
    },
    domProps: {
      "value": (_vm.captcha)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.captcha = $event.target.value
      },
      "blur": function($event) {
        _vm.$forceUpdate()
      }
    }
  }), _vm._v(" "), _c('i', {
    staticClass: "iconfont icon-guanbi is-null j-is-null"
  })]), _vm._v(" "), _c('a', {
    staticClass: "ipt-check-btn",
    attrs: {
      "type": "button",
      "id": "sendsms"
    },
    on: {
      "click": _vm.getCaptcha
    }
  }, [_vm._v(_vm._s(_vm.captcha_txt))])]), _vm._v(" "), _c('div', {
    staticClass: "text-all dis-box j-text-all",
    attrs: {
      "name": "smspassworddiv"
    }
  }, [_c('div', {
    staticClass: "box-flex input-text"
  }, [_c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.password),
      expression: "password"
    }],
    staticClass: "j-input-text",
    attrs: {
      "name": "smspassword",
      "type": "password",
      "placeholder": "请输入密码"
    },
    domProps: {
      "value": (_vm.password)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.password = $event.target.value
      }
    }
  }), _vm._v(" "), _c('span', {
    staticClass: "icon-eye",
    staticStyle: {
      "right": "10px"
    }
  })]), _vm._v(" "), _c('i', {
    staticClass: "iconfont icon-yanjing is-yanjing j-yanjing disabled"
  })]), _vm._v(" "), _c('div', {
    staticClass: "text-all dis-box j-text-all",
    attrs: {
      "name": "repassworddiv"
    }
  }, [_c('div', {
    staticClass: "box-flex input-text"
  }, [_c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.password2),
      expression: "password2"
    }],
    staticClass: "j-input-text",
    attrs: {
      "name": "repassword",
      "type": "password",
      "placeholder": "请重新输入密码"
    },
    domProps: {
      "value": (_vm.password2)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.password2 = $event.target.value
      }
    }
  }), _vm._v(" "), _c('span', {
    staticClass: "icon-eye",
    staticStyle: {
      "right": "10px"
    }
  })]), _vm._v(" "), _c('i', {
    staticClass: "iconfont icon-yanjing is-yanjing j-yanjing disabled"
  })]), _vm._v(" "), _c('div', {
    staticClass: "text-all dis-box j-text-all",
    attrs: {
      "name": "repassworddiv"
    }
  }, [_c('div', {
    staticClass: "box-flex input-text"
  }, [_c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.username),
      expression: "username"
    }],
    staticClass: "j-input-text",
    attrs: {
      "name": "repassword",
      "type": "text",
      "placeholder": "用户名"
    },
    domProps: {
      "value": (_vm.username)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.username = $event.target.value
      }
    }
  })]), _vm._v(" "), _c('i', {
    staticClass: "iconfont icon-yanjing is-yanjing j-yanjing disabled"
  })]), _vm._v(" "), _c('button', {
    staticClass: "btn-submit ",
    attrs: {
      "type": ""
    },
    on: {
      "click": _vm.register
    }
  }, [_vm._v("注册")]), _vm._v(" "), _c('router-link', {
    staticStyle: {
      "color": "#7D7B7B",
      "font-size": ".9rem",
      "margin-top": "1.6rem",
      "float": "right"
    },
    attrs: {
      "to": "/login"
    }
  }, [_vm._v("\n                                已注册直接登录\n                            ")])], 1)])])])]), _vm._v(" "), _c('div', {
    staticClass: "div-messages"
  })])
},staticRenderFns: []}

/***/ }),
/* 95 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    attrs: {
      "id": "main"
    }
  }, [_c('div', {
    staticClass: "b-color-f"
  }, [_vm._m(0), _vm._v(" "), _vm._m(1), _vm._v(" "), _c('div', {
    staticClass: "con",
    attrs: {
      "id": "pjax-container"
    }
  }, [_c('div', {
    staticStyle: {
      "display": "block"
    },
    attrs: {
      "id": "check"
    }
  }, [_c('section', {
    staticClass: "user-center user-forget-tel margin-lr"
  }, [_c('div', {
    staticClass: "text-all dis-box j-text-all",
    attrs: {
      "name": "sms_codediv"
    }
  }, [_c('div', {
    staticClass: "input-text input-check box-flex"
  }, [_c('div', {
    staticClass: "text-all dis-box j-text-all",
    attrs: {
      "name": "write_mobilediv"
    }
  }, [_c('label', [_vm._v("+86")]), _c('div', {
    staticClass: "box-flex input-text"
  }, [_c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.phone),
      expression: "phone"
    }],
    staticClass: "j-input-text",
    attrs: {
      "name": "write_mobile",
      "type": "tel",
      "placeholder": "请输入手机号"
    },
    domProps: {
      "value": (_vm.phone)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.phone = $event.target.value
      }
    }
  })])]), _vm._v(" "), _c('div', {
    staticClass: "text-all dis-box j-text-all",
    attrs: {
      "name": "mobile_codediv"
    }
  }, [_c('div', {
    staticClass: "box-flex input-text",
    staticStyle: {
      "-webkit-box-flex": "1"
    }
  }, [_c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.captcha),
      expression: "captcha"
    }],
    staticClass: "j-input-text",
    attrs: {
      "name": "mobile_code",
      "type": "number",
      "placeholder": "请输入验证码"
    },
    domProps: {
      "value": (_vm.captcha)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.captcha = $event.target.value
      },
      "blur": function($event) {
        _vm.$forceUpdate()
      }
    }
  }), _vm._v(" "), _c('i', {
    staticClass: "iconfont icon-guanbi is-null j-is-null"
  })]), _vm._v(" "), _c('a', {
    staticClass: "ipt-check-btn",
    attrs: {
      "type": "button",
      "id": "sendsms"
    },
    on: {
      "click": _vm.getCaptcha
    }
  }, [_vm._v(_vm._s(_vm.captcha_txt))])]), _vm._v(" "), _c('div', {
    staticClass: "text-all dis-box j-text-all",
    attrs: {
      "name": "smspassworddiv"
    }
  }, [_c('div', {
    staticClass: "box-flex input-text"
  }, [_c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.password),
      expression: "password"
    }],
    staticClass: "j-input-text",
    attrs: {
      "name": "smspassword",
      "type": "password",
      "placeholder": "请输入密码"
    },
    domProps: {
      "value": (_vm.password)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.password = $event.target.value
      }
    }
  }), _vm._v(" "), _c('span', {
    staticClass: "icon-eye",
    staticStyle: {
      "right": "10px"
    }
  })]), _vm._v(" "), _c('i', {
    staticClass: "iconfont icon-yanjing is-yanjing j-yanjing disabled"
  })]), _vm._v(" "), _c('div', {
    staticClass: "text-all dis-box j-text-all",
    staticStyle: {
      "border-bottom": "0px"
    },
    attrs: {
      "name": "repassworddiv"
    }
  }, [_c('div', {
    staticClass: "box-flex input-text"
  }, [_c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.password2),
      expression: "password2"
    }],
    staticClass: "j-input-text",
    attrs: {
      "name": "repassword",
      "type": "password",
      "placeholder": "请重新输入密码"
    },
    domProps: {
      "value": (_vm.password2)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.password2 = $event.target.value
      }
    }
  }), _vm._v(" "), _c('span', {
    staticClass: "icon-eye",
    staticStyle: {
      "right": "10px"
    }
  })]), _vm._v(" "), _c('i', {
    staticClass: "iconfont icon-yanjing is-yanjing j-yanjing disabled"
  })])])]), _vm._v(" "), _c('button', {
    staticClass: "btn-submit",
    attrs: {
      "type": ""
    },
    on: {
      "click": _vm.resetPassword
    }
  }, [_vm._v("重置密码")])])]), _vm._v(" "), _c('div', {
    staticClass: "div-messages"
  })])])])
},staticRenderFns: [function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "filter-top",
    attrs: {
      "id": "scrollUp"
    }
  }, [_c('i', {
    staticClass: "iconfont icon-jiantou"
  })])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "search-div j-search-div ts-3"
  }, [_c('footer', {
    staticClass: "close-search j-close-search"
  }, [_vm._v(" 点击关闭")])])
}]}

/***/ }),
/* 96 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    attrs: {
      "id": "app"
    }
  }, [_c('vue-progress-bar'), _vm._v(" "), _c('v-header'), _vm._v(" "), _c('router-view'), _vm._v(" "), _c('tab')], 1)
},staticRenderFns: []}

/***/ }),
/* 97 */
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    attrs: {
      "id": "main"
    }
  }, [_c('div', {
    staticClass: "b-color-f"
  }, [_c('div', {
    staticClass: "con b-color-f"
  }, [_c('section', {
    staticClass: "user-center user-login margin-lr"
  }, [_c('div', {
    staticClass: "text-all dis-box j-text-all",
    attrs: {
      "name": "usernamediv"
    }
  }, [_c('label', [_vm._v("账 号")]), _vm._v(" "), _c('div', {
    staticClass: "box-flex input-text"
  }, [_c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.phone),
      expression: "phone"
    }],
    staticClass: "j-input-text",
    attrs: {
      "datatype": "s5-16",
      "errormsg": "昵称至少5个字符,最多16个字符！",
      "type": "text",
      "placeholder": "手机号"
    },
    domProps: {
      "value": (_vm.phone)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.phone = $event.target.value
      }
    }
  }), _vm._v(" "), _c('i', {
    staticClass: "iconfont icon-guanbi is-null j-is-null"
  })])]), _vm._v(" "), _c('div', {
    staticClass: "text-all dis-box j-text-all",
    attrs: {
      "name": "passworddiv"
    }
  }, [_c('label', [_vm._v("密 码")]), _vm._v(" "), _c('div', {
    staticClass: "box-flex input-text"
  }, [_c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.password),
      expression: "password"
    }],
    staticClass: "j-input-text",
    attrs: {
      "name": "password",
      "type": "password",
      "placeholder": "请输入密码"
    },
    domProps: {
      "value": (_vm.password)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.password = $event.target.value
      }
    }
  }), _vm._v(" "), _c('span', {
    staticClass: "icon-eye"
  })]), _vm._v(" "), _c('i', {
    staticClass: "iconfont icon-yanjing is-yanjing j-yanjing disabled"
  })]), _vm._v(" "), _c('input', {
    attrs: {
      "type": "hidden",
      "name": "back_act",
      "value": ""
    }
  }), _vm._v(" "), _c('router-link', {
    staticClass: "fr t-remark",
    staticStyle: {
      "font-size": ".96rem"
    },
    attrs: {
      "to": "/forgetPassword"
    }
  }, [_vm._v("忘记密码？\n                ")]), _vm._v(" "), _c('button', {
    staticClass: "btn-submit",
    attrs: {
      "type": ""
    },
    on: {
      "click": _vm.login
    }
  }, [_vm._v("登录")]), _vm._v(" "), _c('router-link', {
    staticClass: "a-first u-l-register",
    attrs: {
      "to": "/register"
    }
  }, [_vm._v("新用户注册")])], 1)]), _vm._v(" "), _c('div', {
    staticClass: "div-messages",
    staticStyle: {
      "text-align": "center"
    }
  }, [_c('div', {
    staticClass: "other-login"
  }, [_vm._m(0), _vm._v(" "), _c('ul', {
    staticClass: "dis-box",
    staticStyle: {
      "margin-top": "30px"
    }
  }, [_c('li', {
    staticClass: "box-flex"
  }, [_c('span', {
    on: {
      "click": _vm.oauth
    }
  }, [_c('img', {
    staticStyle: {
      "width": "60px",
      "height": "60px"
    },
    attrs: {
      "src": __webpack_require__(79)
    }
  })])])])])])])])
},staticRenderFns: [function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticStyle: {
      "text-align": "center"
    }
  }, [_c('span', {
    staticStyle: {
      "background": "#fff",
      "padding": "6px",
      "font-size": "1.05rem"
    }
  }, [_vm._v("使用合作账号登录")])])
}]}

/***/ }),
/* 98 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "navigation-wrap"
  }, [_c('router-link', {
    staticClass: "navigation-item",
    staticStyle: {
      "-webkit-box-orient": "vertical"
    },
    attrs: {
      "to": "/home"
    }
  }, [_c('div', {
    staticClass: "icon-home"
  }), _vm._v(" "), _c('div', [_vm._v("首页")])]), _vm._v(" "), _c('router-link', {
    staticClass: "navigation-item",
    staticStyle: {
      "-webkit-box-orient": "vertical"
    },
    attrs: {
      "to": "/product"
    }
  }, [_c('div', {
    staticClass: "icon-product"
  }), _vm._v(" "), _c('div', [_vm._v("全部商品")])]), _vm._v(" "), _c('router-link', {
    staticClass: "navigation-item",
    staticStyle: {
      "-webkit-box-orient": "vertical"
    },
    attrs: {
      "to": "/cart"
    }
  }, [_c('div', {
    staticClass: "icon-cart"
  }, [_c('div', {
    staticClass: "icon-hit",
    staticStyle: {
      "display": "block"
    },
    attrs: {
      "id": "shopcart-tip"
    }
  }, [_vm._v(_vm._s(_vm.cartNum))])]), _vm._v(" "), _c('div', [_vm._v("购物车")])]), _vm._v(" "), _c('router-link', {
    staticClass: "navigation-item",
    staticStyle: {
      "-webkit-box-orient": "vertical"
    },
    attrs: {
      "to": "/user"
    }
  }, [_c('div', {
    staticClass: "icon-user"
  }), _vm._v(" "), _c('div', [_vm._v("我的账户")])])], 1)
},staticRenderFns: []}

/***/ }),
/* 99 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    attrs: {
      "id": "main"
    }
  }, [_c('div', {
    staticClass: "detail",
    attrs: {
      "id": "itemsDetail"
    }
  }, [_c('div', {
    staticClass: "container-gird"
  }, [(_vm.product.files) ? _c('swiper', {
    ref: "mySwiperDetail",
    staticStyle: {
      "height": "200px"
    },
    attrs: {
      "options": _vm.swiperOption
    }
  }, _vm._l((_vm.product.files), function(item) {
    return _c('swiper-slide', {
      staticClass: "swiper-slide",
      staticStyle: {
        "width": "128.333px"
      }
    }, [_c('img', {
      directives: [{
        name: "lazy",
        rawName: "v-lazy",
        value: (_vm.getFile(item)),
        expression: "getFile(item)"
      }]
    })])
  })) : _vm._e(), _vm._v(" "), (!_vm.product.files) ? _c('div', {
    staticClass: "detail-image"
  }, [_c('img', {
    directives: [{
      name: "lazy",
      rawName: "v-lazy",
      value: (_vm.getFile(_vm.product.file)),
      expression: "getFile(product.file)"
    }]
  })]) : _vm._e(), _vm._v(" "), _c('div', {
    staticClass: "detail-msg"
  }, [_c('span', {
    staticClass: "single-name"
  }, [_vm._v(_vm._s(_vm.product.name))])]), _vm._v(" "), _c('div', {
    staticClass: "detail-msg"
  }, [_c('span', {
    staticClass: "detail-price"
  }, [_c('span', {
    staticClass: "new-price"
  }, [_vm._v("￥"), _c('span', [_vm._v(_vm._s(_vm.product.price))])])])]), _vm._v(" "), _vm._m(0), _vm._v(" "), _c('div', {
    staticClass: "select-area",
    attrs: {
      "id": "addCartBtn"
    }
  }, [_c('button', {
    staticClass: "addItem btn-shopping",
    on: {
      "click": function($event) {
        _vm.addCart(_vm.product)
      }
    }
  }, [_c('i', {
    staticClass: "ico ico-shop"
  }), _vm._v("添加到购物车\n                ")])]), _vm._v(" "), _vm._m(1)], 1), _vm._v(" "), _c('div', {
    staticClass: "detail-content"
  }, [_c('div', {
    staticClass: "container-gird"
  }, [_c('p', {
    staticClass: "detail-title"
  }, [_vm._v("商品详情")]), _vm._v(" "), _c('div', {
    staticStyle: {
      "min-height": "200px"
    }
  }, [(_vm.product.detail) ? _c('div', {
    domProps: {
      "innerHTML": _vm._s(_vm.product.detail)
    }
  }) : _c('div', {
    staticStyle: {
      "text-align": "center",
      "margin-top": "100px"
    }
  }, [_vm._v("商家比较懒，没有商品详情～")])])])]), _vm._v(" "), _c('div', {
    staticClass: "backToTop"
  }, [_c('div', {
    staticClass: "backToTop-inner",
    on: {
      "click": function($event) {
        _vm.backToTop()
      }
    }
  }, [_c('i', {
    staticClass: "ico ico-top"
  }), _c('span', [_vm._v("回到顶部")])])])])])
},staticRenderFns: [function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "detail-msg none",
    staticStyle: {
      "padding-bottom": "12px",
      "display": "none"
    },
    attrs: {
      "id": "product-attr"
    }
  }, [_c('span', {
    staticClass: "detail-attr"
  }, [_c('span', [_vm._v("商品属性")]), _c('br'), _vm._v(" "), _c('span', {
    attrs: {
      "id": "detail-attr-btn"
    }
  })])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "select-area",
    staticStyle: {
      "display": "none"
    },
    attrs: {
      "id": "soldOut"
    }
  }, [_c('span', {
    staticStyle: {
      "float": "right",
      "color": "#646464"
    }
  }, [_vm._v("已售罄")])])
}]}

/***/ }),
/* 100 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    class: _vm.slideClass
  }, [_vm._t("default")], 2)
},staticRenderFns: []}

/***/ }),
/* 101 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    attrs: {
      "id": "main"
    }
  }, [_c('div', {
    staticClass: "container-gird",
    attrs: {
      "id": "orderResult"
    }
  }, [_c('div', {
    staticClass: "orderResult-header"
  }, [_c('span', [_c('i', {
    staticClass: "ico ico-succ"
  }), _vm._v("  下单成功-"), _c('span', {
    attrs: {
      "id": "status"
    }
  }, [_vm._v(_vm._s(_vm.order.pay_status))])])]), _vm._v(" "), _c('div', {
    staticClass: "orderResultList-container"
  }, [_c('div', [_c('div', {
    staticClass: "orderResult-form"
  }, [_c('div', {
    staticClass: "orderResult-list",
    attrs: {
      "id": "items-order-result"
    }
  }, [_c('div', {
    staticClass: "order-info"
  }, [_c('span', [_vm._v(" 订单号："), _c('span', {
    attrs: {
      "id": "result-order-no"
    }
  }, [_vm._v(_vm._s(_vm.order.orderid))])]), _vm._v(" "), _c('span', {
    staticClass: "date",
    staticStyle: {
      "float": "right"
    }
  }, [_vm._v(_vm._s(_vm.order.created_at))])]), _vm._v(" "), _c('div', {
    staticClass: "order-list",
    attrs: {
      "id": "item-order-list"
    }
  }, [_c('ul', _vm._l((_vm.order.detail), function(item) {
    return _c('li', [_c('span', {
      staticClass: "order-item-name"
    }, [_vm._v(_vm._s(item.name))]), _c('span', {
      staticClass: "order-item-price"
    }, [_vm._v("￥" + _vm._s(item.price))]), _c('span', {
      staticClass: "order-item-amount"
    }, [_vm._v(_vm._s(item.num) + "份")])])
  }))]), _vm._v(" "), _c('div', {
    staticClass: "divider"
  }), _vm._v(" "), _c('div', {
    staticClass: "total-info"
  }, [_c('span', {
    staticClass: "total"
  }, [_vm._v("共"), _c('span', [_vm._v(_vm._s(_vm.order.totalprice))]), _vm._v("元 ")])])])]), _vm._v(" "), _vm._m(0)])])])])
},staticRenderFns: [function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "tips",
    attrs: {
      "id": "items-tips"
    }
  }, [_c('span', [_vm._v("温馨提示："), _c('span', {
    attrs: {
      "id": "timeBox"
    }
  }, [_vm._v("您的订单我们将在约定的时间送达，谢谢！收货时间在15:30～17:30时间段内，请留意您的手机。")])])])
}]}

/***/ }),
/* 102 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    attrs: {
      "id": "main"
    }
  }, [_c('section', {
    staticClass: "m-component-promotion",
    attrs: {
      "id": "list-section"
    }
  }, [_c('ul', {
    staticClass: "list-unstyled",
    attrs: {
      "id": "list-sale"
    }
  }, _vm._l((_vm.ads), function(ad) {
    return _c('li', [_c('router-link', {
      attrs: {
        "to": ad.url
      }
    }, [_c('img', {
      directives: [{
        name: "lazy",
        rawName: "v-lazy",
        value: (_vm.getFile(ad.file)),
        expression: "getFile(ad.file)"
      }],
      staticStyle: {
        "display": "inline",
        "height": "137px"
      }
    })])], 1)
  }))])])
},staticRenderFns: []}

/***/ }),
/* 103 */
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    attrs: {
      "id": "main"
    }
  }, [_c('div', {
    staticClass: "header"
  }, [_c('div', {
    staticClass: "types types-flour"
  }, [_c('swiper', {
    ref: "mySwiperProduct",
    attrs: {
      "options": _vm.swiperOption
    }
  }, _vm._l((_vm.menu), function(item) {
    return _c('swiper-slide', {
      staticClass: "menuItem swiper-slide",
      class: {
        active: item.id == _vm.selectedMenu
      },
      staticStyle: {
        "width": "128.333px"
      }
    }, [_c('div', {
      on: {
        "click": function($event) {
          _vm.selectMenu(item.id)
        }
      }
    }, [_vm._v(_vm._s(item.name))])])
  }))], 1)]), _vm._v(" "), _c('div', {
    staticClass: "main",
    attrs: {
      "id": "mainList"
    }
  }, [_c('div', {
    staticClass: "items"
  }, [_c('div', {
    staticClass: "item large",
    staticStyle: {
      "display": "block"
    },
    attrs: {
      "id": "notification"
    }
  }, [_vm._v(_vm._s(_vm.title))]), _vm._v(" "), _vm._l((_vm.product), function(item) {
    return _c('div', {
      directives: [{
        name: "show",
        rawName: "v-show",
        value: (item.category_id == _vm.selectedMenu),
        expression: "item.category_id == selectedMenu"
      }],
      staticClass: "item",
      staticStyle: {
        "display": "block"
      }
    }, [_c('div', {
      staticClass: "item-image"
    }, [_c('router-link', {
      attrs: {
        "to": {
          name: 'productDetail',
          params: {
            id: item.id
          }
        }
      }
    }, [_c('img', {
      directives: [{
        name: "lazy",
        rawName: "v-lazy",
        value: (_vm.getFile(item.file)),
        expression: "getFile(item.file)"
      }],
      staticStyle: {
        "width": "100%",
        "margin-top": "0px",
        "display": "inline",
        "background-size": "30px"
      }
    })]), _vm._v(" "), _c('div', {
      directives: [{
        name: "show",
        rawName: "v-show",
        value: (item.selected),
        expression: "item.selected"
      }],
      staticClass: "select-shadow",
      staticStyle: {
        "display": "none"
      }
    }, [_vm._m(0, true)])], 1), _vm._v(" "), _c('div', {
      staticClass: "single-item-info"
    }, [_c('div', {
      staticClass: "item-title"
    }, [_vm._v(_vm._s(item.name))]), _vm._v(" "), _c('div', {
      staticClass: "item-price-show"
    }, [_c('div', {
      staticClass: "item-price"
    }, [_c('span', {
      staticClass: "hotspot"
    }, [_vm._v("￥" + _vm._s(item.price))])])]), _vm._v(" "), _c('div', {
      staticClass: "item-amount",
      on: {
        "click": function($event) {
          _vm.addCart(item)
        }
      }
    }, [_c('i', {
      staticClass: "ico ico-cart"
    })])])])
  })], 2)]), _vm._v(" "), _c('div', {
    staticClass: "backToTop"
  }, [_c('div', {
    staticClass: "backToTop-inner",
    on: {
      "click": function($event) {
        _vm.backToTop()
      }
    }
  }, [_c('i', {
    staticClass: "ico ico-top"
  }), _c('span', [_vm._v("回到顶部")])])])])
},staticRenderFns: [function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "select-inner"
  }, [_c('img', {
    attrs: {
      "src": __webpack_require__(78),
      "alt": "selected"
    }
  }), _c('span', [_vm._v("已选")])])
}]}

/***/ }),
/* 104 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "__cov-progress",
    style: (_vm.style)
  })
},staticRenderFns: []}

/***/ }),
/* 105 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', [_c('div', {
    attrs: {
      "id": "main"
    }
  }, [_c('div', {
    staticClass: "confirmation-form"
  }, [_vm._m(0), _vm._v(" "), _c('div', {
    staticClass: "container-gird"
  }, [_c('form', {
    staticClass: "delivery-info"
  }, [_c('ul', {
    staticClass: "form_table"
  }, [_c('li', [_c('span', {
    staticClass: "td_left"
  }, [_vm._v("姓名")]), _vm._v(" "), _c('span', {
    staticClass: "td_right"
  }, [_c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.contact.name),
      expression: "contact.name"
    }],
    attrs: {
      "type": "text",
      "name": "username",
      "id": "username",
      "placeholder": "务必使用真实姓名",
      "value": "",
      "required": ""
    },
    domProps: {
      "value": (_vm.contact.name)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.contact.name = $event.target.value
      }
    }
  })])]), _vm._v(" "), _c('li', [_c('span', {
    staticClass: "td_left"
  }, [_vm._v("手机")]), _vm._v(" "), _c('span', {
    staticClass: "td_right"
  }, [_c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.contact.phone),
      expression: "contact.phone"
    }],
    attrs: {
      "type": "text",
      "name": "tel",
      "id": "tel",
      "placeholder": "",
      "value": "",
      "required": ""
    },
    domProps: {
      "value": (_vm.contact.phone)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.contact.phone = $event.target.value
      }
    }
  })])]), _vm._v(" "), _c('li', [_c('span', {
    staticClass: "td_left"
  }, [_vm._v("地址")]), _vm._v(" "), _c('span', {
    staticClass: "td_right"
  }, [_c('select', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.province),
      expression: "province"
    }],
    staticClass: "hat_select",
    attrs: {
      "id": "hat_city",
      "name": "hat_city"
    },
    on: {
      "change": function($event) {
        var $$selectedVal = Array.prototype.filter.call($event.target.options, function(o) {
          return o.selected
        }).map(function(o) {
          var val = "_value" in o ? o._value : o.value;
          return val
        });
        _vm.province = $event.target.multiple ? $$selectedVal : $$selectedVal[0]
      }
    }
  }, _vm._l((_vm.location), function(item, index) {
    return _c('option', {
      domProps: {
        "value": index
      }
    }, [_vm._v(_vm._s(item.name))])
  })), _vm._v(" "), _c('select', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.city),
      expression: "city"
    }],
    staticClass: "hat_select",
    attrs: {
      "id": "hat_area",
      "name": "hat_area"
    },
    on: {
      "change": function($event) {
        var $$selectedVal = Array.prototype.filter.call($event.target.options, function(o) {
          return o.selected
        }).map(function(o) {
          var val = "_value" in o ? o._value : o.value;
          return val
        });
        _vm.city = $event.target.multiple ? $$selectedVal : $$selectedVal[0]
      }
    }
  }, _vm._l((_vm.location[_vm.province].sub), function(item, index) {
    return _c('option', {
      domProps: {
        "value": index
      }
    }, [_vm._v(_vm._s(item.name))])
  }))])]), _vm._v(" "), _c('li', [_c('span', {
    staticClass: "td_left"
  }), _vm._v(" "), _c('span', {
    staticClass: "td_right"
  }, [_c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.contact.address),
      expression: "contact.address"
    }],
    attrs: {
      "type": "text",
      "name": "address",
      "id": "address",
      "placeholder": "详细地址",
      "value": "",
      "required": ""
    },
    domProps: {
      "value": (_vm.contact.address)
    },
    on: {
      "input": function($event) {
        if ($event.target.composing) { return; }
        _vm.contact.address = $event.target.value
      }
    }
  })])]), _vm._v(" "), _vm._m(1), _vm._v(" "), _c('li', [_c('span', {
    staticClass: "td_left"
  }, [_vm._v("配送时间")]), _vm._v(" "), _c('span', {
    staticClass: "td_right"
  }, [_c('select', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: (_vm.selectedDeliveryTime),
      expression: "selectedDeliveryTime"
    }],
    staticClass: "hat_select",
    attrs: {
      "id": "deliveryTime",
      "name": "deliveryTime"
    },
    on: {
      "change": function($event) {
        var $$selectedVal = Array.prototype.filter.call($event.target.options, function(o) {
          return o.selected
        }).map(function(o) {
          var val = "_value" in o ? o._value : o.value;
          return val
        });
        _vm.selectedDeliveryTime = $event.target.multiple ? $$selectedVal : $$selectedVal[0]
      }
    }
  }, _vm._l((_vm.deliveryTime), function(item, index) {
    return _c('option', {
      domProps: {
        "value": item
      }
    }, [_vm._v(_vm._s(item))])
  }))])]), _vm._v(" "), _c('li')])])])]), _vm._v(" "), _c('div', {
    staticClass: "payment"
  }, [_c('p', {
    staticClass: "heading"
  }, [_vm._v("支付方式")]), _vm._v(" "), _c('div', {
    staticClass: "container-gird"
  }, [_c('div', {
    staticClass: "payment-content"
  }, _vm._l((_vm.payment), function(item) {
    return _c('span', {
      staticClass: "line",
      on: {
        "click": function($event) {
          _vm.selectPayment(item)
        }
      }
    }, [_c('span', {
      staticClass: "radio",
      class: {
        selected: _vm.selectedPayment == item.id
      }
    }), _vm._v(" "), _c('span', {
      staticClass: "label"
    }, [_vm._v(_vm._s(item.name))])])
  }))])]), _vm._v(" "), _c('a', {
    staticClass: "mybtn",
    on: {
      "click": _vm.submit
    }
  }, [_c('span', {
    staticStyle: {
      "display": "block",
      "height": "39px",
      "font-size": "1.2em",
      "margin": "10px",
      "background": "#ff4146",
      "color": "#ffffff",
      "border-radius": "6px"
    }
  }, [_vm._v("提交订单")])])])])
},staticRenderFns: [function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "confirmation-header-nb"
  }, [_c('span', [_vm._v("收货人信息")]), _vm._v(" "), _c('div', {
    staticClass: "dotted-divider"
  })])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('li', [_c('span', {
    staticClass: "td_left"
  }, [_vm._v("备注")]), _vm._v(" "), _c('span', {
    staticClass: "td_right"
  }, [_c('input', {
    attrs: {
      "type": "text",
      "name": "note",
      "id": "note",
      "placeholder": "选填"
    }
  })])])
}]}

/***/ }),
/* 106 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    attrs: {
      "id": "main"
    }
  }, [_c('div', {
    staticClass: "container-gird"
  }, [_c('div', {
    staticClass: "confirmation-form"
  }, [_vm._m(0), _vm._v(" "), _c('div', {
    staticClass: "confirmation-list",
    attrs: {
      "id": "item-list"
    }
  }, [_c('div', {
    staticClass: "dotted-divider",
    staticStyle: {
      "width": "105.263157894737%",
      "margin-left": "-2.9%"
    }
  }), _vm._v(" "), _c('ul', _vm._l((_vm.cartData), function(item) {
    return _c('li', [_c('div', {
      staticClass: "confirmation-item"
    }, [_c('div', {
      staticClass: "item-info"
    }, [_c('span', {
      staticClass: "item-name"
    }, [_vm._v(_vm._s(item.name)), _c('br')]), _c('span', {
      staticClass: "item-price-info"
    }, [_c('span', [_c('span', {
      staticClass: "item-single-price"
    }, [_vm._v(_vm._s(item.price))]), _vm._v("×"), _c('span', {
      staticClass: "item-amount"
    }, [_vm._v(_vm._s(item.num))])])])]), _vm._v(" "), _c('div', {
      staticClass: "select-box"
    }, [_c('span', {
      staticClass: "minus disabled",
      on: {
        "click": function($event) {
          _vm.disCart(item)
        }
      }
    }, [_vm._v("—")]), _c('input', {
      directives: [{
        name: "model",
        rawName: "v-model",
        value: (item.num),
        expression: "item.num"
      }],
      staticClass: "amount",
      attrs: {
        "type": "text",
        "name": "amount",
        "autocomplete": "off",
        "readonly": ""
      },
      domProps: {
        "value": (item.num)
      },
      on: {
        "input": function($event) {
          if ($event.target.composing) { return; }
          item.num = $event.target.value
        }
      }
    }), _c('span', {
      staticClass: "add",
      on: {
        "click": function($event) {
          _vm.addCart(item)
        }
      }
    }, [_vm._v("+")])]), _vm._v(" "), _c('div', {
      staticClass: "delete"
    }, [_c('a', {
      staticClass: "delete-btn",
      on: {
        "click": function($event) {
          _vm.delCart(item)
        }
      }
    }, [_c('i', {
      staticClass: "ico ico-delete"
    })])])]), _vm._v(" "), _c('div', {
      staticClass: "divider"
    })])
  })), _vm._v(" "), _c('div', {
    staticClass: "total-info"
  }, [_c('span', {
    staticClass: "items-total-price"
  }, [_vm._v("总计："), _c('span', {
    attrs: {
      "id": "items-total-price"
    }
  }, [_vm._v(_vm._s(_vm.cartTotal))]), _vm._v("元")])])])])]), _vm._v(" "), _c('router-link', {
    staticClass: "next mybtn",
    attrs: {
      "to": "/delivery"
    }
  }, [_c('span', {
    staticClass: "n-btn",
    staticStyle: {
      "display": "block",
      "height": "39px",
      "font-size": "1.2em",
      "margin": "10px",
      "background": "#ff4146",
      "color": "#ffffff",
      "border-radius": "6px"
    }
  }, [_vm._v("下一步")])])], 1)
},staticRenderFns: [function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "confirmation-header"
  }, [_c('span', [_vm._v("订单确认")])])
}]}

/***/ }),
/* 107 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "swiper-container"
  }, [_vm._t("parallax-bg"), _vm._v(" "), _c('div', {
    class: _vm.defaultSwiperClasses.wrapperClass
  }, [_vm._t("default")], 2), _vm._v(" "), _vm._t("pagination"), _vm._v(" "), _vm._t("button-prev"), _vm._v(" "), _vm._t("button-next"), _vm._v(" "), _vm._t("scrollbar")], 2)
},staticRenderFns: []}

/***/ }),
/* 108 */
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    attrs: {
      "id": "main"
    }
  }, [_c('div', {
    staticClass: "container-gird"
  }, [_c('div', {
    staticClass: "confirmation-form"
  }, [_c('div', {
    staticClass: "confirmation-list"
  }, [_c('img', {
    directives: [{
      name: "lazy",
      rawName: "v-lazy",
      value: (_vm.getAvaterFile),
      expression: "getAvaterFile"
    }],
    staticClass: "avater"
  }), _vm._v(" "), _c('div', {
    staticStyle: {
      "text-align": "center",
      "padding": "10px 0px"
    }
  }, [_vm._v(_vm._s(_vm.user.level) + "\n                    "), _c('router-link', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.user.username),
      expression: "user.username"
    }],
    attrs: {
      "to": "/login"
    }
  }, [_c('span', {
    staticClass: "pi-loginout",
    staticStyle: {
      "display": "inline-block",
      "position": "absolute",
      "right": "10px"
    },
    on: {
      "click": _vm.logout
    }
  }, [_vm._v("\n                        退出\n                      ")])])], 1), _vm._v(" "), _c('div', {
    staticClass: "divider"
  }), _vm._v(" "), _c('div', {
    staticClass: "dotted-divider",
    staticStyle: {
      "width": "105.263157894737%",
      "margin-left": "-2.9%"
    }
  }), _vm._v(" "), _c('ul', [_c('li', [_c('div', {
    staticClass: "confirmation-item"
  }, [_vm._m(0), _vm._v(" "), _c('div', {
    staticClass: "select-box"
  }, [_vm._v(_vm._s(_vm.user.username))])]), _vm._v(" "), _c('div', {
    staticClass: "divider"
  })]), _vm._v(" "), _c('li', [_c('div', {
    staticClass: "confirmation-item"
  }, [_vm._m(1), _vm._v(" "), _c('div', {
    staticClass: "select-box"
  }, [_vm._v(_vm._s(_vm.user.money) + "元")])]), _vm._v(" "), _c('div', {
    staticClass: "divider"
  })]), _vm._v(" "), _c('li', [_c('div', {
    staticClass: "confirmation-item"
  }, [_vm._m(2), _vm._v(" "), _c('div', {
    staticClass: "select-box"
  }, [_vm._v(_vm._s(_vm.user.score) + "分")])])])])])])]), _vm._v(" "), _vm._m(3), _vm._v(" "), _c('div', {
    staticClass: "myOrderList none",
    staticStyle: {
      "display": "block"
    }
  }, [_c('div', [(_vm.order.length) ? _c('div', {
    staticClass: "container-gird"
  }, [_c('div', [_c('div', {
    staticClass: "orderResult-list",
    attrs: {
      "id": "items-order-result-list"
    }
  }, [_c('ul', _vm._l((_vm.order), function(item) {
    return _c('li', [_c('div', {
      staticClass: "order-info"
    }, [_c('span', {
      staticClass: "number"
    }, [_vm._v("订单号："), _c('span', {
      attrs: {
        "id": "order-no"
      }
    }, [_vm._v(_vm._s(item.orderid))])]), _c('span', {
      staticClass: "date",
      staticStyle: {
        "float": "right"
      }
    }, [_vm._v(_vm._s(item.created_at))]), _c('span', {
      staticClass: "order-status"
    }, [_vm._v(_vm._s(item.pay_status) + "," + _vm._s(item.status))])]), _vm._v(" "), _c('div', {
      staticClass: "order-list",
      attrs: {
        "id": "item-order-list"
      }
    }, [_c('ul', _vm._l((item.detail), function(itemIn) {
      return _c('li', [_c('span', {
        staticClass: "order-item-name"
      }, [_vm._v(_vm._s(itemIn.name))]), _c('span', {
        staticClass: "order-item-price"
      }, [_vm._v("￥" + _vm._s(itemIn.price))]), _c('span', {
        staticClass: "order-item-amount"
      }, [_vm._v(_vm._s(itemIn.num) + "份")])])
    })), _vm._v(" "), _c('div', {
      staticClass: "mytotal-info"
    }, [_c('span', {
      staticClass: "total"
    }, [_vm._v("共" + _vm._s(item.totalprice) + "元")])])]), _vm._v(" "), _c('div', {
      staticClass: "order-footer"
    }, [(item.status != '已取消') ? _c('span', {
      staticClass: "cancelOrder",
      on: {
        "click": function($event) {
          _vm.cancelOrder(item)
        }
      }
    }, [_vm._v("取消")]) : _vm._e(), _vm._v(" "), (item.pay_status == '未支付') ? _c('span', {
      staticClass: "payOrder",
      on: {
        "click": function($event) {
          _vm.wxpay(item)
        }
      }
    }, [_vm._v("微信付款")]) : _vm._e(), _vm._v(" "), (item.pay_status == '未支付') ? _c('span', {
      staticClass: "payOrder",
      on: {
        "click": function($event) {
          _vm.alipay(item)
        }
      }
    }, [_vm._v("支付宝")]) : _vm._e(), _vm._v(" "), _c('a', {
      staticClass: "dail-small",
      on: {
        "click": _vm.tel
      }
    }, [_vm._m(4, true), _c('span', {
      staticClass: "dail-text"
    }, [_vm._v("拨打电话催一催")])])]), _vm._v(" "), _c('div', {
      staticClass: "divider"
    })])
  }))])])]) : _vm._e()])]), _vm._v(" "), _vm._m(5)])
},staticRenderFns: [function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "item-info"
  }, [_c('span', {
    staticClass: "item-name"
  }, [_vm._v("我的账号:"), _c('br')])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "item-info"
  }, [_c('span', {
    staticClass: "item-name"
  }, [_vm._v("我的账户:"), _c('br')])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "item-info"
  }, [_c('span', {
    staticClass: "item-name"
  }, [_vm._v("我的积分:"), _c('br')])])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "my-order-header"
  }, [_c('span', [_vm._v("我的订单")]), _vm._v(" "), _c('div', {
    staticClass: "dotted-divider"
  })])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('span', {
    staticClass: "dail-ico"
  }, [_c('i', {
    staticClass: "ico ico-phone"
  })])
},function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "history-loader"
  }, [_c('i', {
    staticClass: "ico ico-history"
  }), _vm._v(" "), _c('span', [_vm._v("点击查看历史订单")])])
}]}

/***/ })
],[58]);
//# sourceMappingURL=app.53aaa5f69b426e20e3e5.js.map
<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;
Route::any('addons/:v/:addon/index', 'app/addons/index',['ext'=>'html']);
Route::any('web', "/tpl/web/index.html");
Route::any('static', "app/index/themeStatic");
Route::any('tpl/theme', "app/index/source");
Route::any('api/addons/deliveryTime','\addons\shuiguo\delivery\controller\Api@deliveryTime');
Route::any('api/addons/stores','\addons\shuiguo\stores\controller\Api@storesList');
Route::any('api/addons/couponList','\addons\common\coupon\controller\Api@couponList');
Route::any('api/addons/myCoupon','\addons\common\coupon\controller\Api@myCoupon');
Route::any('api/addons/couponChange','\addons\common\coupon\controller\Api@couponChange');
Route::any('api/addons/addCoupon','\addons\common\coupon\controller\Api@addCoupon');
Route::any('app/wxpay', "app/wxpay/index");
return [
    '[api]' =>  [
        'config$'  => ['api/config.shop/index',['method' => 'options/get']],
        'getJsSign$'  => ['api/config.wx/getJsSign',['method' => 'options/post']],
        'product$'       => ['api/shop.product.index/index',['method' => 'options/get']],
        'product/:id$'       => ['api/shop.product.index/detail',['method' => 'options/get'],['id' => '\d+']],
        'product/category$'       => ['api/shop.product.category/index',['method' => 'options/get']],
        'product/category/:id$'       => ['api/shop.product.category/detail',['method' => 'options/get'],['id' => '\d+']],
        'product/comment$'       => ['api/shop.product.comment/add',['method' => 'options/post']],
        'product/comment/:id$'       => ['api/shop.product.comment/index',['method' => 'options/get'],['id' => '\d+']],
        'ads$'       => ['api/ads.index/index',['method' => 'options/get']],
        'ads/:id$'       => ['api/ads.index/detail',['method' => 'options/get'],['id' => '\d+']],
        'payment$'       => ['api/config.payment/index',['method' => 'options/get']],
        'search$'       => ['api/shop.product.index/index',['method' => 'options/get']],
        'public/login$'       => ['api/public/Login',['method' => 'options/post']],
        'public/register$'       => ['api/public/register',['method' => 'options/post']],
        'public/resetPassword$'       => ['api/public/resetPassword',['method' => 'options/post']],
        'public/sendSmsCaptcha$'       => ['api/public/sendSmsCaptcha',['method' => 'options/post/get']],
        'public/oauth$'       => ['api/public/oauth',['method' => 'options/get']],
        'public/x_oauth$'       => ['api/public/x_oauth',['method' => 'options/post']],
        'pay/wxpay/:id$'       => ['api/pay/wxpay',['method' => 'options/get'],['id' => '\d+']],
        'pay/x_wxpay/:id$'       => ['api/pay/x_wxpay',['method' => 'options/get'],['id' => '\d+']],
        'pay/alipay/:id$'       => ['api/pay/alipay',['method' => 'options/get'],['id' => '\d+']],
        'pay/balance/:id$'       => ['api/pay/balance',['method' => 'options/get'],['id' => '\d+']],
        'order$'       => ['api/shop.order.index/index',['method' => 'options/get/post']],
        'order/:id$'       => ['api/shop.order.index/detail',['method' => 'options/get'],['id' => '\d+']],
        'order/confirmReceipt/:id$'       => ['api/shop.order.index/confirmReceipt',['method' => 'options/get'],['id' => '\d+']],
        'order/cancel/:id$'       => ['api/shop.order.index/cancel',['method' => 'options/get'],['id' => '\d+']],
        'user$'       => ['api/user.index/index',['method' => 'options/get/post']],
        'contact$'       => ['api/user.contact/index',['method' => 'options/get/post']],        
        'contact/:id$'       => ['api/user.contact/detail',['method' => 'options/get'],['id' => '\d+']],
        'contact/setDefault$'       => ['api/user.contact/setDefault',['method' => 'options/post']],
        'location$'       => ['api/location.index/index',['method' => 'options/get']],
        'rechargeList$'   => ['api/user.recharge/index',['method' => 'options/get']],
        'recharge$'       => ['api/user.recharge/x_wx',['method' => 'options/post']],
        'wxRecharge$'       => ['api/user.recharge/wx',['method' => 'options/post']],
        'avater$'         => ['api/user.index/avater',['method' => 'options/post']],
        'tpl/fee$'   => ['api/tpl.fee/index',['method' => 'options/get']],
        'feedback$'         => ['api/shop.feedback/index',['method' => 'options/post/get']],
        // '__miss__'  => 'api/public/miss',
    ],
];




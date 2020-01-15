<?php
return $config = array (
		//应用ID,您的APPID。
		'app_id' => "2018050302627629",

		//商户私钥，您的原始格式RSA私钥
		'merchant_private_key' => "MIIEogIBAAKCAQEAvUUsnWj/sLuMA8g/7PCBlaGHgYxkYHZ2dJmCF1QKsYgIVw6V0K6ICDWRaX8Ii9uO3+yiGNudgAdqur7lvfjlLYW6cVkpW0k+P7mgc2JdoFIYvhz4g4SSElTydY2URp1PrzU3DKB7L2BnvWuOeMVsDkwIT4xwdI73S64HQAcIQYjdK9MYS9l+qbkMkjAncNnO38Ksp1ggT6WR4hnglE21/JAPP20Sr/Xtdy01ihIy78ojtrDaizYf4A1wztCrRyDxabPIuApSxPfVItFciUmDFyQ8Betct1jWih0wXMPdXqcu4v4biJgcBR8eokzjnYe/2qq3UK7XD5QMlrolyMG9KQIDAQABAoIBACF4yEkWNpHEuSA6G8QFTIVvyY0JjP7aNFyugSkq/bEjw4XR2IDNPNVm0856XsKNE5laOdh3jkUECsX32J1eFPmV+sDs6blxHIcchtmg/bnKiwGkEfcATOzdBPvxC9XpIBx2JsQe5WodfHstOEb3cwKcQ6P9zC1w0x8ZKcMS+0zLXyA2d8nBeYunhDzMdGbWYYdKkKOoM2AkswpsRJhxQTbDLRe/1cz6ilmWa2TAGnYgHry5nbG81PrqLq0DF3thUF0Ys7+vVOzBz3DBXcYRQbPRbXBy6kO5pAvIJ/NZ5UekvVAi/c/NkJAo9ghz2xiWSKIrs6pNfkr+9dta5xWziQECgYEA9zR4+ZJTIqOq6Xl4Lhj6RfWxOMVa8WrHeXMWLjQfEIwjblqKr9AK1Cv4QwzjTGRNVxH4WpPwVitKzGsKx4WuPthRwGI9N735Gowtt7mvn9mJetn6BBn6T5Q8AyJtiMURsFL9cbFM+3QUh0z6xmPuZaaWMZG7EULcMh2nyBZs5xECgYEAxAEJGeeSkUZlbmjiAMfMRBhoIKZ3IV5Zld5lvrqzwZQywthRXcbGUKS8D1qxXqeGw5zkzJTWOkWtF+I1u4A6Bn5GfgLyglpiE4vi+wLHQvJCa0CFXT0zPWBAP9Y83wN5M1sHYRwW2+ECreuQ2qRXjBy/cWzCXucm5KBfIlrZZJkCgYBgGVjyBE0nSSLW8m6i1PjuG24SmL4a3Zy//NphiceNwjy/2JjTcffTtWgkgK0X9GIQeB7o71vd06SXRQGCwNgU/DkDpe0Qb1yYUmgvZRL9/C4ywOwtjf+90e1mdorIQXv35Ls76GX51o1ob6eJWi3B/HmkuXdUZX5+SQMBiJ47UQKBgCogptoggcojvU1b0aelSewg6tCJtvU/GDY0FN5HtrcWqUpjwClNvfY7Ughiz9iuXTLSGAM4wkrICwolHrNsPgyDO5d9/q2xy360BFc7I6Tp+QigV4nQy6CXfXe7Dl5ImtZE7HMc3HTqCe9jwECeLgr5atRwMd7ABAYDyi7SJAORAoGAagCg2+V/agzh0WUw5x3Z8N+fsNjr+QApiDroO/TqNTv+ZMMXQGHkd3ZXHF0u2gp88XWM7QdDD477wpo1mMp57vYAhwyCWLCWuQlJHkil5hAHptqm5bgxK8r+hZGYLX5aNcxkYflePaYolIFAW3na2YDCbTFj37uvmA5xD1wT2/c=",
		
		//异步通知地址
		'notify_url' => "http://".$_SERVER['HTTP_HOST']."/wxsite/alipay/order_notify_url",
		
		//同步跳转
		'return_url' => "http://".$_SERVER['HTTP_HOST']."/h5/html/center.html",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAotpp9P6wa0hAjZAFUDlRteiJr0em5jsl5ag3bW3Qa+LvoGnEfNiZS+YQBz25yKa05S1hRttCyLJ1XSkrB7dn/oVKl6qkxGAuq5OYJOa7WPsika2KZ2NU0LxibY8y3dmXvk+1w+KxMNwTtrxcWljgHW68TP0jmRwpurUHfRQiRq10pHCIKjtzGNySyj0QYvGGtCjp7inKfuU6kWnJJ+4Fcp9ZEmj5LOJ50mdcdtPHYsWTjUw3O9RtAuFyIDMuYdnFQgITtPWQ3IvtyRf0vjgMsRtjZm2SoY+BBBe5F6KUyOgkzocRPACYwUVT0BVvhtzG4ncdHE3jElJuH5n6N2cLkQIDAQAB",
		
	
);
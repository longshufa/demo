<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2016090800465931",

		//商户私钥
		'merchant_private_key' => "MIIEowIBAAKCAQEAsgw2EV3ti8weWMNlWaaRp96XVBuhqViXzl2XUTlgCkpAn8rSA2pqD5Ry9nGn91F3t0KX0bhpJQvz9xRt+D3X/rjBR/Q8ank9+XZWjyCtg28Xj7Mc/oeC3mzeLBIgUJRetvlzTHIym23k76NiGQ6wo4kEKcfhD2ncsgszyQbPI+LU2ry8EjB0n3dJddRkC4biTCT6RqH5+Md7jd06Ccn+QfMSpEstbpj+sikBOSesPMPsOmT0H6YSf1a2WNQFRubSRNX/U9CG3dCBX/lYBYJBnPY3+wszXHZL9NZmiUKTPryUP/RXzgvb72Lwjwz7hL6nLHvccaGyheEiQovKeAYcbQIDAQABAoIBAGvdqgPre7Zt+xSbjBM8LpIc8GEsPEx0N8P2P24d7GlPgsdMAN/A4HB/5wYW5UOYP4bu+Ts9FbYz/6F45wa1sN3I4I/PD6sRuNIhN1+O1JAEBaoxQSeSwV4vZoockSdAPAFuLsPpi29OrJvhx9SWab0pjTQiu96yq9nRn5XyYhvClVOYE8NIKSROeNMYTfgFU5G2uBs4s3M6AX1GWImEHo/JzK5yd9+oYksv2kRaWeUIxhd4xZTRDNIabBo2mMV0el873HSZ0U03oVQ6aB16i5MqnyaW6X++tnTTV2yNfdoG0VP7JPZLeeGnLiud0Y8wzd/S4ehWlmrjoIs16JjaugECgYEA4ThQWPwV8nBt6qR8BbAP/FzoiBzZRikvpjO59VK35LuXVB5fZU/jF4J0HBldVd+S5A2tPVJZTKwAAR1ZYT9M9vuCBY1mDyDuANyGZfkW/ACwSLLLAZvkTp09h9v1ywExtFnenQyOCUnicjOZmjr6vSmCvbayS7sfbvCy+X5idB0CgYEAymF/rslgUla0lquu6nN68zJ74TTEBFswiVNHSVu9tic9SD6j/aXnkEy7uGAvp7Zb7YFe25hiyZ9MMmQo3U+TQVe7EFAzpl+44ougXGklUgE67s9oRdN/2C43jzCyy5ioQSnwBGe8i4ipMVPk4MQM3pumbGQ5HqvYlKLXFu2MOJECgYEA0PcWHaovltVYNtjMtd5IxsdRfVD/C4kVS+k8hfFs7E5dt0/DBVZdBygkIRorroyVVwGVlor8jhYcnuwjTQaVm6d6WTp70lekXKpADQdTmxfseFdj4idJauOb/p1I7kU6X/LuiNroQpgKAhn8T8yfbrnAM9P6lCeXn7C27qSkJsUCgYBWXo/AR17dJPXDC5gFpK0HFzd5ICy7czNel/TnYMiw8UQdDeasvF373lOK1znfSFspHDogW4Nlap95Lfemo2xDya4iwyeXzGg5/r68UX9E5ROCkW99xUpdNzQs3uqfKxI7ZStypdb4caVLUPNv3Rtk8WZwAcHCzjILFQfYWB6skQKBgCvu3AwWPh8ineFJivDHbXPV4g1mE3MUw6ijCS9knzPi2vrAW5z9trSS46cFHdG//yZHrvIy+uXEkjezXQAEADGiRCZGefjGeEiXKJE2e9YPuYKOaogMDGPFK6ipqFHERP729Fgh8l1RCSQ8FkEr0qbGdrcuS4hxHGYsQ45UTrvZ",
		
		//异步通知地址
		'notify_url' => "http://damall.cn/pay/notify_url.php",
		
		//同步跳转
		'return_url' => "http://damall.cn/pay/return_url.php",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		//'gatewayUrl' => "https://openapi.alipay.com/gateway.do", //生产环境
		'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do", //沙箱环境

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA6Z91KPkPVJ2+gab1aDiZLABLUxQXD+D2EhYu9T2tnIRSATv6t2uMsHJDmuZAMMaPOPjGdgqh7VLw986s+2vdRK5dBFnYmh8Xj7ybqMe16ra8DLPriayy6yHAxDLQrzWM6XViNlYRjBoCh4NIcWaHNlKvEAq5D4Gyqb3Ad4AfFpgnWE0OjiOSQKVnzfWg4D2JhrzwM6NxK3sM5lBHocONdoyQfgrXMZ91sozRubPwg47yMxUfF1n43uH/G0NFFWLZL0WFCz5i3sDqWuTn+B9X535QCTMcrxAC71ZrA/5MFuvnTisBGjSBS3s4PKjP/XbjGPXI/8iXNTN+tByHZWdewQIDAQAB",
);
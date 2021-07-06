# Laravel CAS Client
> 




## 快速开始
1. 使用 composer 安装
 ```
 composer require zbanx/laravel-cas-client
 ```

2. 发布配置文件
```
php artisan vendor:publish --provider="Zbanx\CasClient\CasClientServiceProvider"
```


## 接口路由
| Method | Uri | Desc |
| :-----| :---- | :---- |
| GET | /cas/routes | 获取权限路由 |
| POSE | /cas/login | 登录接口 |

## 错误码说明


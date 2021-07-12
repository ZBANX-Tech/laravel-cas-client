# Laravel CAS Client

> Zbanx CAS Client

## 快速开始

1. 使用 composer 安装

 ```
 composer require zbanx/laravel-cas-client
 ```

2. 发布配置文件

```
php artisan vendor:publish --provider="Zbanx\CasClient\CasClientServiceProvider"
```

3. 用户模型添加 `\Zbanx\CasClient\Traits\CasUser` 特性
```
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use SoftDeletes;
    use CasUser;
    
    // ...
}
```

4. 为需要管理权限的接口增加 `cas.permission` 中间件
```
Route::post('/download', 'ProjectAnalysisController@download')->name('download')->middleware('cas.permission');
```
## 接口路由

| Method | Uri | Desc |
| :-----| :---- | :---- |
| GET | /cas/routes | 获取权限路由 |
| POSE | /cas/login | 登录接口 |
| POSE | /cas/logout | 退出登录接口 |

## 异常说明


tanmo/laravel-api
---

模仿 `dingo/api` 的响应方式，基于Laravel `Api resource` 做转换层的api开发扩展包

依赖
---
Laravel 5.5以上版本

安装
---
```
composer require tanmo/laravel-api
```

发布资源
```php
php artisan vendor:publish --provider="Tanmo\Api\Providers\ApiServiceProvider"
```

使用
---
可以在控制器中引入 `Helpers Trait` ，也可以使用 `api()` 辅助函数

```php
<?php
use \Tanmo\Api\Traits\Helpers;

class UserController extends Controller
{
    use Helpers;
    
    public function show($id)
    {
        return $this->response()->item(User::find($id), UserResource::class);
    }
}
```

### 响应item
```php
return api()->item(User::find(1), UserResource::class);
```

### 响应集合
```php
return api()->collection(User::all(), UserCollection::class); //相当于 return new UserCollection(User::all());
```

```php
return api()->collection(User::all(), UserResource::class); //相当于 return UserResource::collection(User::all())
```

```php
// 分页，同样支持 Collection 和 Resource
return api()->collection(User::paginate(5), UserCollection::class);
```

### 设置Meta元素
```php
return api()->item(User::find(1), UserResource::class)->setMeta(['key' => 'value'])
```

### 快捷响应
```php
return api()->created();
return api()->accepted();
return api()->noContent();
```

### 异常处理
需要在 `config/api.php` 里设置 `debug = true` 才会显示调试信息

```php
api()->errorForbidden();
api()->errorNotFound();
api()->errorBadRequest();
api()->errorInternal();
api()->errorUnauthorized();
api()->errorMethodNotAllowed();
```
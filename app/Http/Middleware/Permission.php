<?php



namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Permission
{
    /**
     * @var string
     */
    protected $routePrefix = 'api/admin';

    /**
     * @var array 权限排除路由
     */
    protected $excepts = [
        'admin/login',
        'admin/logout',
        'admin/me',
        'admin/menu-tree',
        'admin/config/services',
        'admin/config/warehouse/all'
    ];

    /**
     * @var array 超级管理员保护路由
     */
    protected $protects = [
        'admin/admins',
        'admin/admin-groups',
    ];

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param array $args
     *
     * @return mixed
     * @throws \App\Exceptions\AccidentException
     */
    public function handle(Request $request, \Closure $next, ...$args)
    {
        if (!auth('admin')->user() || !empty($args) || $this->shouldPassThrough($request)) {
            return $next($request);
        }

        if (auth('admin')->user()->isAdministrator()) {
            return $next($request);
        }

        if ($this->checkRoutePermission($request)) {
            return $next($request);
        }

        return eRet('当前操作暂无权限！', 403);
    }

    /**
     * @param Request $request
     *
     * @return bool
     */
    public function checkRoutePermission(Request $request): bool
    {
        $routeName = $request->route()->getName();

        if (PermissionService::hasPermission($routeName)) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the request has a URI that should pass through verification.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    protected function shouldPassThrough(Request $request): bool
    {
        return $this->routerChecker($request, $this->excepts);
    }

    /**
     * 超级管理员保护权限
     * @param Request $request
     * @return bool
     */
    protected function protectedRoutes(Request $request): bool
    {
        return $this->routerChecker($request, $this->protects);
    }

    /**
     * 路由检查器
     * @param Request $request
     * @param array $rules
     * @return bool
     */
    protected function routerChecker(Request $request, array $rules): bool
    {
        return collect($rules)
            ->contains(function ($except) use ($request) {
                if ($except !== '/') {
                    $except = trim($except, '/');
                }

                return $request->is('api/' . $except) || Str::startsWith($request->getPathInfo(), '/api/' . $except);
            });
    }
}

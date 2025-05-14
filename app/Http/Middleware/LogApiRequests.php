<?php

namespace App\Http\Middleware;

use App\Models\System\SysLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Jenssegers\Agent\Agent;
use Symfony\Component\HttpFoundation\Response;

class LogApiRequests
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next)
    {
        $start = microtime(true);

        // 处理请求
        $response = $next($request);

        $executionTime = round((microtime(true) - $start) * 1000, 2);

        // 排除特定路由（可选）
        if ($this->shouldExclude($request)) {
            return $response;
        }
// 解析客户端信息
        $agent = new Agent();
        $agent->setUserAgent($request->userAgent());

        $route = $request->route();
        if ($route) {
            $action = $route->getAction(); // 获取路由动作信息
            // 解析控制器和方法
            if (isset($action['controller'])) {
                list($controller, $action) = explode('@', $action['controller']);
            } else {
                // 处理闭包路由的情况
                $controller = 'Closure';
                $action = 'Closure';
            }
        }
        // 记录日志
        SysLog::create([
            'module' => $controller,
            'request_method' => $request->method(),
            'request_params' => json_encode($this->filterSensitiveFields($request)),
            'response_content' => $this->truncateContent($response->getContent()),
            'content' => $action,
            'request_uri' => $request->path(),
            'method' => $request->method(),
            'ip' => $request->ip(),
            'execution_time' => $executionTime,
            'browser' => $agent->browser(),
            'browser_version' => $agent->version($agent->browser()),
            'os' => $agent->platform(),
            'create_by' => optional(auth()->user())->id,
            'created_at' => Carbon::now()->toDateTimeString(),
        ]);

        return $response;
    }

    /**
     * 过滤敏感字段（如密码、token等）
     */
    private function filterSensitiveFields(Request $request): array
    {
        $filterKeys = ['password', 'password_confirmation', 'token'];
        return $request->except($filterKeys);
    }

    /**
     * 截断过长的响应内容（避免数据库溢出）
     */
    private function truncateContent(?string $content): ?string
    {
        return $content ? substr($content, 0, 4096) : null;
    }

    /**
     * 排除不需要记录的路径（如健康检查）
     */
    private function shouldExclude(Request $request): bool
    {
        return in_array($request->path(), [
            'health',
            'ping',
        ]);
    }


}

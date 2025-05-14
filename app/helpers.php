<?php

use App\Exceptions\AccidentException;
use Carbon\Carbon;

if (!function_exists('formatRet')) {
    /**
     * @param $code
     * @param string $message
     * @param array $data
     * @param int $status
     * @param array $replace
     * @param array $headers
     * @param int $options
     * @return \Illuminate\Http\JsonResponse
     */
    function formatRet($code, $message = '', $data = [], $status = 200, array $replace = [], array $headers = [], $options = 0)
    {
        if ($data instanceof \Illuminate\Contracts\Support\Arrayable) {
            $data = $data->toArray();
        }
        $rt = [
            'code' => $code,
            'msg' => $message,
            'data' => $data,
        ];
        //需要返回空对象
        if ($data instanceof \StdClass) {
            return response()->json($rt, $status, $headers, \Illuminate\Http\JsonResponse::DEFAULT_ENCODING_OPTIONS | JSON_FORCE_OBJECT);
        }

        return response()->json($rt, $status, $headers, $options);
    }
}

if (!function_exists('eRet')) {
    /**
     * 意外的报错返回
     * @param string $message
     * @param int $status
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     * @throws AccidentException
     */
    function eRet($message = '', $status = 200, $data = [])
    {
        throw new AccidentException($message !== '' ? $message : 'failed', $status, $data);
    }
}

if (!function_exists('success')) {
    /**
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    function success($data = [])
    {
        return formatRet(1, 'success', $data);
    }
}

if (!function_exists('failed')) {
    /**
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    function failed($data = [])
    {
        return formatRet(0, 'failed', []);
    }
}

if (!function_exists('mb_str_split')) {
    /**
     * @param $str
     * @return array|false|string[]
     */
    function mb_str_split($str)
    {
        if (preg_match("/[\x7f-\xff]/", $str) === 0) {
            return explode(' ', $str);
        }
        return preg_split('/(?<!^)(?!$)/u', $str);
    }
}


if (!function_exists('get_client_ip')) {
    /**
     * @return mixed|string
     */
    function get_client_ip()
    {
        if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
            $ip = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
            $ip = getenv('REMOTE_ADDR');
        } elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return preg_match('/[\d\.]{7,15}/', $ip, $matches) ? $matches[0] : '';
    }
}

if (!function_exists('isEn')) {
    /**
     * @return bool
     */
    function isEn()
    {
        return app('request')->header('language') === 'en' || app()->isLocale('en');
    }
}


if (!function_exists('admin_path')) {
    function admin_path(string $path = '')
    {
        $path = ltrim($path, '/');

        return sprintf('admin/%s', $path);
    }
}

if (!function_exists('remove_special_char')) {
    /**
     *
     * @param string $str
     * @return string
     */
    function remove_special_char(string $str)
    {
        return str_replace(['/', '\\', ':', '*', '"', '<', '>', '|', '?', ' ', '#', '%'], '_', $str);
    }
}

/**
 * 删除全部空格 *
 * @param string $str
 * @return integer
 */
if (!function_exists('trim_all')) {
    function trim_all($str)//删除空格
    {
        $qian = array(" ", "　", "\t", "\n", "\r");
        $hou = array("", "", "", "", "");
        return str_replace($qian, $hou, $str);
    }
}

if (!function_exists('getTmpDir')) {
    function getTmpDir(): string
    {
        $tmp = ini_get('upload_tmp_dir');

        if ($tmp !== False && file_exists($tmp)) {
            return realpath($tmp);
        }

        return realpath(sys_get_temp_dir());
    }
}

/**
 * 获得毫秒
 * */
function getMillisecond()
{
    list($microsecond, $time) = explode(' ', microtime()); //' '中间是一个空格
    return (float)sprintf('%.0f', (floatval($microsecond) + floatval($time)) * 1000);
}

function hmac_sha256_encrypt($message, $secret_key, $hash_key)
{
    $hash = hash_hmac('sha256', $message, $hash_key, true);
    $encrypt = base64_encode(hash_hmac('sha256', $hash, $secret_key, true));
    return $encrypt;
}

if (!function_exists('getIp')) {
    /**
     * 获取请求来源ip
     */
    function getIp()
    {
        $clientIP = request()->ip();

        if (getenv('HTTP_CLIENT_IP')) {
            $clientIP = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $clientIP = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_X_FORWARDED')) {
            $clientIP = getenv('HTTP_X_FORWARDED');
        } elseif (getenv('HTTP_FORWARDED_FOR')) {
            $clientIP = getenv('HTTP_FORWARDED_FOR');
        } elseif (getenv('HTTP_FORWARDED')) {
            $clientIP = getenv('HTTP_FORWARDED');
        } elseif (getenv('REMOTE_ADDR')) {
            $clientIP = getenv('REMOTE_ADDR');
        }

        return $clientIP;
    }
}
if (!function_exists('_id')) {
    /**
     * 获取请求来源ip
     */
    function _id($id)
    {
        if (is_string($id) && strpos($id, ',') !== false) {
            return explode(',', $id);
        } else if (is_array($id)) {
            return $id;
        } else {
            return [$id];
        }
    }
}

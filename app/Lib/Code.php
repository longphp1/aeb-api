<?php

namespace App\Lib;

class Code
{


    const SUCCESS_CODE = "00000";
    const SUCCESS = ["code" => "00000", "msg" => "一切ok"];
    /** 一级宏观错误码  */
    const USER_ERROR = ["code" => "A0001", "msg" => "用户端错误"];
    const OPERATE_ERROR = ["code" => "A0002", "msg" => "操作错误"];

    const SERVICE_ERROR_CODE = "A0003";
    const SERVICE_ERROR = ["code" => "A0003", "msg" => "服务端错误"];
    /** 二级宏观错误码  */
    const USER_REGISTRATION_ERROR = ["code" => "A0100", "msg" => "用户注册错误"];
    const USER_NOT_AGREE_PRIVACY_AGREEMENT = ["code" => "A0101", "msg" => "用户未同意隐私协议"];
    const REGISTRATION_COUNTRY_OR_REGION_RESTRICTED = ["code" => "A0102", "msg" => "注册国家或地区受限"];
    const USERNAME_VERIFICATION_FAILED = ["code" => "A0110", "msg" => "用户名校验失败"];
    const USERNAME_ALREADY_EXISTS = ["code" => "A0111", "msg" => "用户名已存在"];
    const USERNAME_CONTAINS_SENSITIVE_WORDS = ["code" => "A0112", "msg" => "用户名包含敏感词"];
    const USERNAME_CONTAINS_SPECIAL_CHARACTERS = ["code" => "A0113", "msg" => "用户名包含特殊字符"];
    const PASSWORD_VERIFICATION_FAILED = ["code" => "A0120", "msg" => "密码校验失败"];
    const PASSWORD_LENGTH_NOT_ENOUGH = ["code" => "A0121", "msg" => "密码长度不够"];
    const PASSWORD_STRENGTH_NOT_ENOUGH = ["code" => "A0122", "msg" => "密码强度不够"];
    const VERIFICATION_CODE_INPUT_ERROR = ["code" => "A0130", "msg" => "校验码输入错误"];
    const SMS_VERIFICATION_CODE_INPUT_ERROR = ["code" => "A0131", "msg" => "短信校验码输入错误"];
    const EMAIL_VERIFICATION_CODE_INPUT_ERROR = ["code" => "A0132", "msg" => "邮件校验码输入错误"];
    const VOICE_VERIFICATION_CODE_INPUT_ERROR = ["code" => "A0133", "msg" => "语音校验码输入错误"];
    const USER_CERTIFICATE_EXCEPTION = ["code" => "A0140", "msg" => "用户证件异常"];
    const USER_CERTIFICATE_TYPE_NOT_SELECTED = ["code" => "A0141", "msg" => "用户证件类型未选择"];
    const MAINLAND_ID_NUMBER_VERIFICATION_ILLEGAL = ["code" => "A0142", "msg" => "大陆身份证编号校验非法"];
    const USER_BASIC_INFORMATION_VERIFICATION_FAILED = ["code" => "A0150", "msg" => "用户基本信息校验失败"];
    const PHONE_FORMAT_VERIFICATION_FAILED = ["code" => "A0151", "msg" => "手机格式校验失败"];
    const ADDRESS_FORMAT_VERIFICATION_FAILED = ["code" => "A0152", "msg" => "地址格式校验失败"];
    const EMAIL_FORMAT_VERIFICATION_FAILED = ["code" => "A0153", "msg" => "邮箱格式校验失败"];
    /** 二级宏观错误码  */
    const USER_LOGIN_EXCEPTION = ["code" => "A0200", "msg" => "用户登录异常"];
    const USER_ACCOUNT_FROZEN = ["code" => "A0201", "msg" => "用户账户被冻结"];
    const USER_ACCOUNT_ABOLISHED = ["code" => "A0202", "msg" => "用户账户已作废"];
    const USER_PASSWORD_ERROR = ["code" => "A0210", "msg" => "用户名或密码错误"];
    const USER_INPUT_PASSWORD_ERROR_LIMIT_EXCEEDED = ["code" => "A0211", "msg" => "用户输入密码错误次数超限"];
    const USER_NOT_EXIST = ["code" => "A0212", "msg" => "用户不存在"];
    const USER_IDENTITY_VERIFICATION_FAILED = ["code" => "A0220", "msg" => "用户身份校验失败"];
    const USER_FINGERPRINT_RECOGNITION_FAILED = ["code" => "A0221", "msg" => "用户指纹识别失败"];
    const USER_FACE_RECOGNITION_FAILED = ["code" => "A0222", "msg" => "用户面容识别失败"];
    const USER_NOT_AUTHORIZED_THIRD_PARTY_LOGIN = ["code" => "A0223", "msg" => "用户未获得第三方登录授权"];
    const ACCESS_TOKEN_INVALID = ["code" => "A0230", "msg" => "访问令牌无效或已过期"];
    const REFRESH_TOKEN_INVALID = ["code" => "A0231", "msg" => "刷新令牌无效或已过期"];

    // 验证码错误
    const USER_VERIFICATION_CODE_ERROR = ["code" => "A0240", "msg" => "验证码错误"];
    const USER_VERIFICATION_CODE_ATTEMPT_LIMIT_EXCEEDED = ["code" => "A0241", "msg" => "用户验证码尝试次数超限"];
    const USER_VERIFICATION_CODE_EXPIRED = ["code" => "A0242", "msg" => "用户验证码过期"];

    /** 二级宏观错误码  */
    const ACCESS_PERMISSION_EXCEPTION = ["code" => "A0300", "msg" => "访问权限异常"];
    const ACCESS_UNAUTHORIZED = ["code" => "A0301", "msg" => "访问未授权"];
    const AUTHORIZATION_IN_PROGRESS = ["code" => "A0302", "msg" => "正在授权中"];
    const USER_AUTHORIZATION_APPLICATION_REJECTED = ["code" => "A0303", "msg" => "用户授权申请被拒绝"];
    const ACCESS_OBJECT_PRIVACY_SETTINGS_BLOCKED = ["code" => "A0310", "msg" => "因访问对象隐私设置被拦截"];
    const AUTHORIZATION_EXPIRED = ["code" => "A0311", "msg" => "授权已过期"];
    const NO_PERMISSION_TO_USE_API = ["code" => "A0312", "msg" => "无权限使用 API"];
    const USER_ACCESS_BLOCKED = ["code" => "A0320", "msg" => "用户访问被拦截"];
    const BLACKLISTED_USER = ["code" => "A0321", "msg" => "黑名单用户"];
    const ACCOUNT_FROZEN = ["code" => "A0322", "msg" => "账号被冻结"];
    const ILLEGAL_IP_ADDRESS = ["code" => "A0323", "msg" => "非法 IP 地址"];
    const GATEWAY_ACCESS_RESTRICTED = ["code" => "A0324", "msg" => "网关访问受限"];
    const REGION_BLACKLIST = ["code" => "A0325", "msg" => "地域黑名单"];
    const SERVICE_ARREARS = ["code" => "A0330", "msg" => "服务已欠费"];
    const USER_SIGNATURE_EXCEPTION = ["code" => "A0340", "msg" => "用户签名异常"];
    const RSA_SIGNATURE_ERROR = ["code" => "A0341", "msg" => "RSA 签名错误"];

    /** 二级宏观错误码  */
    const USER_REQUEST_PARAMETER_ERROR = ["code" => "A0400", "msg" => "用户请求参数错误"];
    const CONTAINS_ILLEGAL_MALICIOUS_REDIRECT_LINK = ["code" => "A0401", "msg" => "包含非法恶意跳转链接"];
    const INVALID_USER_INPUT = ["code" => "A0402", "msg" => "无效的用户输入"];
    const REQUEST_REQUIRED_PARAMETER_IS_EMPTY = ["code" => "A0410", "msg" => "请求必填参数为空"];
    const REQUEST_PARAMETER_VALUE_EXCEEDS_ALLOWED_RANGE = ["code" => "A0420", "msg" => "请求参数值超出允许的范围"];
    const PARAMETER_FORMAT_MISMATCH = ["code" => "A0421", "msg" => "参数格式不匹配"];
    const USER_INPUT_CONTENT_ILLEGAL = ["code" => "A0430", "msg" => "用户输入内容非法"];
    const CONTAINS_PROHIBITED_SENSITIVE_WORDS = ["code" => "A0431", "msg" => "包含违禁敏感词"];
    const USER_OPERATION_EXCEPTION = ["code" => "A0440", "msg" => "用户操作异常"];

    /** 二级宏观错误码  */
    const USER_REQUEST_SERVICE_EXCEPTION = ["code" => "A0500", "msg" => "用户请求服务异常"];
    const REQUEST_LIMIT_EXCEEDED = ["code" => "A0501", "msg" => "请求次数超出限制"];
    const REQUEST_CONCURRENCY_LIMIT_EXCEEDED = ["code" => "A0502", "msg" => "请求并发数超出限制"];
    const USER_OPERATION_PLEASE_WAIT = ["code" => "A0503", "msg" => "用户操作请等待"];
    const WEBSOCKET_CONNECTION_EXCEPTION = ["code" => "A0504", "msg" => "WebSocket 连接异常"];
    const WEBSOCKET_CONNECTION_DISCONNECTED = ["code" => "A0505", "msg" => "WebSocket 连接断开"];
    const USER_DUPLICATE_REQUEST = ["code" => "A0506", "msg" => "请求过于频繁，请稍后再试。"];

    /** 二级宏观错误码  */
    const USER_RESOURCE_EXCEPTION = ["code" => "A0600", "msg" => "用户资源异常"];
    const ACCOUNT_BALANCE_INSUFFICIENT = ["code" => "A0601", "msg" => "账户余额不足"];
    const USER_DISK_SPACE_INSUFFICIENT = ["code" => "A0602", "msg" => "用户磁盘空间不足"];
    const USER_MEMORY_SPACE_INSUFFICIENT = ["code" => "A0603", "msg" => "用户内存空间不足"];
    const USER_OSS_CAPACITY_INSUFFICIENT = ["code" => "A0604", "msg" => "用户 OSS 容量不足"];
    const USER_QUOTA_EXHAUSTED = ["code" => "A0605", "msg" => "用户配额已用光"];
    const USER_RESOURCE_NOT_FOUND = ["code" => "A0606", "msg" => "用户资源不存在"];

    /** 二级宏观错误码  */
    const UPLOAD_FILE_EXCEPTION = ["code" => "A0700", "msg" => "上传文件异常"];
    const UPLOAD_FILE_TYPE_MISMATCH = ["code" => "A0701", "msg" => "上传文件类型不匹配"];
    const UPLOAD_FILE_TOO_LARGE = ["code" => "A0702", "msg" => "上传文件太大"];
    const UPLOAD_IMAGE_TOO_LARGE = ["code" => "A0703", "msg" => "上传图片太大"];
    const UPLOAD_VIDEO_TOO_LARGE = ["code" => "A0704", "msg" => "上传视频太大"];
    const UPLOAD_COMPRESSED_FILE_TOO_LARGE = ["code" => "A0705", "msg" => "上传压缩文件太大"];
    const DELETE_FILE_EXCEPTION = ["code" => "A0710", "msg" => "删除文件异常"];

    /** 二级宏观错误码  */
    const USER_CURRENT_VERSION_EXCEPTION = ["code" => "A0800", "msg" => "用户当前版本异常"];
    const USER_INSTALLED_VERSION_NOT_MATCH_SYSTEM = ["code" => "A0801", "msg" => "用户安装版本与系统不匹配"];
    const USER_INSTALLED_VERSION_TOO_LOW = ["code" => "A0802", "msg" => "用户安装版本过低"];
    const USER_INSTALLED_VERSION_TOO_HIGH = ["code" => "A0803", "msg" => "用户安装版本过高"];
    const USER_INSTALLED_VERSION_EXPIRED = ["code" => "A0804", "msg" => "用户安装版本已过期"];
    const USER_API_REQUEST_VERSION_NOT_MATCH = ["code" => "A0805", "msg" => "用户 API 请求版本不匹配"];
    const USER_API_REQUEST_VERSION_TOO_HIGH = ["code" => "A0806", "msg" => "用户 API 请求版本过高"];
    const USER_API_REQUEST_VERSION_TOO_LOW = ["code" => "A0807", "msg" => "用户 API 请求版本过低"];

    /** 二级宏观错误码  */
    const USER_PRIVACY_NOT_AUTHORIZED = ["code" => "A0900", "msg" => "用户隐私未授权"];
    const USER_PRIVACY_NOT_SIGNED = ["code" => "A0901", "msg" => "用户隐私未签署"];
    const USER_CAMERA_NOT_AUTHORIZED = ["code" => "A0903", "msg" => "用户相机未授权"];
    const USER_PHOTO_LIBRARY_NOT_AUTHORIZED = ["code" => "A0904", "msg" => "用户图片库未授权"];
    const USER_FILE_NOT_AUTHORIZED = ["code" => "A0905", "msg" => "用户文件未授权"];
    const USER_LOCATION_INFORMATION_NOT_AUTHORIZED = ["code" => "A0906", "msg" => "用户位置信息未授权"];
    const USER_CONTACTS_NOT_AUTHORIZED = ["code" => "A0907", "msg" => "用户通讯录未授权"];
    const USER_ROLE_NAME_ALREADY_EXISTS  = ["code" => "A0908", "msg" => "角色名称已存在"];
    const USER_ROLE_CODE_ALREADY_EXISTS  = ["code" => "A0909", "msg" => "角色编码已存在"];
    const CONFIG_KEY_ALREADY_EXISTS  = ["code" => "A0910", "msg" => "系统配置键已存在"];
    const CONFIG_KEY_NOT_ALREADY_EXISTS  = ["code" => "A0911", "msg" => "系统配置不已存在"];



    /** 一级宏观错误码  */
    const SYSTEM_ERROR = ["code" => "B0001", "msg" => "系统执行出错"];
    /** 二级宏观错误码  */
    const SYSTEM_EXECUTION_TIMEOUT = ["code" => "B0100", "msg" => "系统执行超时"];
    /** 二级宏观错误码  */
    const SYSTEM_DISASTER_RECOVERY_FUNCTION_TRIGGERED = ["code" => "B0200", "msg" => "系统容灾功能被触发"];
    const SYSTEM_RATE_LIMITING = ["code" => "B0210", "msg" => "系统限流"];
    const SYSTEM_FUNCTION_DEGRADATION = ["code" => "B0220", "msg" => "系统功能降级"];
    /** 二级宏观错误码  */
    const SYSTEM_RESOURCE_EXCEPTION = ["code" => "B0300", "msg" => "系统资源异常"];
    const SYSTEM_RESOURCE_EXHAUSTED = ["code" => "B0310", "msg" => "系统资源耗尽"];
    const SYSTEM_DISK_SPACE_EXHAUSTED = ["code" => "B0311", "msg" => "系统磁盘空间耗尽"];
    const SYSTEM_MEMORY_EXHAUSTED = ["code" => "B0312", "msg" => "系统内存耗尽"];
    const FILE_HANDLE_EXHAUSTED = ["code" => "B0313", "msg" => "文件句柄耗尽"];
    const SYSTEM_CONNECTION_POOL_EXHAUSTED = ["code" => "B0314", "msg" => "系统连接池耗尽"];
    const SYSTEM_THREAD_POOL_EXHAUSTED = ["code" => "B0315", "msg" => "系统线程池耗尽"];
    const SYSTEM_RESOURCE_ACCESS_EXCEPTION = ["code" => "B0320", "msg" => "系统资源访问异常"];
    const SYSTEM_READ_DISK_FILE_FAILED = ["code" => "B0321", "msg" => "系统读取磁盘文件失败"];


    /** 一级宏观错误码  */
    const THIRD_PARTY_SERVICE_ERROR = ["code" => "C0001", "msg" => "调用第三方服务出错"];

    /** 二级宏观错误码  */
    const MIDDLEWARE_SERVICE_ERROR = ["code" => "C0100", "msg" => "中间件服务出错"];
    const RPC_SERVICE_ERROR = ["code" => "C0110", "msg" => "RPC 服务出错"];
    const RPC_SERVICE_NOT_FOUND = ["code" => "C0111", "msg" => "RPC 服务未找到"];
    const RPC_SERVICE_NOT_REGISTERED = ["code" => "C0112", "msg" => "RPC 服务未注册"];
    const INTERFACE_NOT_EXIST = ["code" => "C0113", "msg" => "接口不存在"];
    const MESSAGE_SERVICE_ERROR = ["code" => "C0120", "msg" => "消息服务出错"];
    const MESSAGE_DELIVERY_ERROR = ["code" => "C0121", "msg" => "消息投递出错"];
    const MESSAGE_CONSUMPTION_ERROR = ["code" => "C0122", "msg" => "消息消费出错"];
    const MESSAGE_SUBSCRIPTION_ERROR = ["code" => "C0123", "msg" => "消息订阅出错"];
    const MESSAGE_GROUP_NOT_FOUND = ["code" => "C0124", "msg" => "消息分组未查到"];
    const CACHE_SERVICE_ERROR = ["code" => "C0130", "msg" => "缓存服务出错"];
    const KEY_LENGTH_EXCEEDS_LIMIT = ["code" => "C0131", "msg" => "key 长度超过限制"];
    const VALUE_LENGTH_EXCEEDS_LIMIT = ["code" => "C0132", "msg" => "value 长度超过限制"];
    const STORAGE_CAPACITY_FULL = ["code" => "C0133", "msg" => "存储容量已满"];
    const UNSUPPORTED_DATA_FORMAT = ["code" => "C0134", "msg" => "不支持的数据格式"];
    const CONFIGURATION_SERVICE_ERROR = ["code" => "C0140", "msg" => "配置服务出错"];

    /** 二级宏观错误码  */
    const THIRD_PARTY_SYSTEM_EXECUTION_TIMEOUT = ["code" => "C0200", "msg" => "第三方系统执行超时"];
    const RPC_EXECUTION_TIMEOUT = ["code" => "C0210", "msg" => "RPC 执行超时"];
    const MESSAGE_DELIVERY_TIMEOUT = ["code" => "C0220", "msg" => "消息投递超时"];
    const CACHE_SERVICE_TIMEOUT = ["code" => "C0230", "msg" => "缓存服务超时"];
    const CONFIGURATION_SERVICE_TIMEOUT = ["code" => "C0240", "msg" => "配置服务超时"];
    const DATABASE_SERVICE_TIMEOUT = ["code" => "C0250", "msg" => "数据库服务超时"];

    /** 二级宏观错误码  */
    const DATABASE_SERVICE_ERROR = ["code" => "C0300", "msg" => "数据库服务出错"];
    const TABLE_NOT_EXIST = ["code" => "C0311", "msg" => "表不存在"];
    const COLUMN_NOT_EXIST = ["code" => "C0312", "msg" => "列不存在"];
    const MULTIPLE_SAME_NAME_COLUMNS_IN_MULTI_TABLE_ASSOCIATION = ["code" => "C0321", "msg" => "多表关联中存在多个相同名称的列"];
    const DATABASE_DEADLOCK = ["code" => "C0331", "msg" => "数据库死锁"];
    const PRIMARY_KEY_CONFLICT = ["code" => "C0341", "msg" => "主键冲突"];
    /** 二级宏观错误码  */
    const THIRD_PARTY_DISASTER_RECOVERY_SYSTEM_TRIGGERED = ["code" => "C0400", "msg" => "第三方容灾系统被触发"];
    const THIRD_PARTY_SYSTEM_RATE_LIMITING = ["code" => "C0401", "msg" => "第三方系统限流"];
    const THIRD_PARTY_FUNCTION_DEGRADATION = ["code" => "C0402", "msg" => "第三方功能降级"];
    /** 二级宏观错误码  */
    const NOTIFICATION_SERVICE_ERROR = ["code" => "C0500", "msg" => "通知服务出错"];
    const SMS_REMINDER_SERVICE_FAILED = ["code" => "C0501", "msg" => "短信提醒服务失败"];
    const VOICE_REMINDER_SERVICE_FAILED = ["code" => "C0502", "msg" => "语音提醒服务失败"];
    const EMAIL_REMINDER_SERVICE_FAILED = ["code" => "C0503", "msg" => "邮件提醒服务失败"];

    /** 参数校验  */

/**
 * 根据错误码获取完整错误信息
 * @param string $code 错误码
 * @return array 错误信息数组
 */
    public static function getValue(string $code): array
    {
        $reflection = new ReflectionClass(__CLASS__);
        $constants = $reflection->getConstants();

        foreach ($constants as $constant) {
            if ($constant['code'] === $code) {
                return $constant;
            }
        }

        // 未找到时返回系统错误
        return self::SYSTEM_ERROR;
    }

    /**
     * 获取错误码描述信息
     * @param string $code 错误码
     * @return string 错误描述
     */
    public static function getMessage(string $code): string
    {
        return self::getValue($code)['msg'] ?? self::SYSTEM_ERROR['msg'];
    }

    /**
     * 转换为JSON字符串
     * @param string $code 错误码
     * @return string JSON格式字符串
     */
    public static function toJson(string $code): string
    {
        $data = self::getValue($code);
        return json_encode([
            'code' => $data['code'],
            'msg' => $data['msg']
        ], JSON_UNESCAPED_UNICODE);
    }
}

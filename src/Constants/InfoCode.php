<?php

declare(strict_types=1);

namespace TheFairLib\Constants;

use Hyperf\Constants\Annotation\Constants;

/**
 * @Constants
 * @method static getMessage($code, $data)
 */
class InfoCode extends ErrorCode
{
    /**
     * @Message("message.rate_limit_error")
     */
    const CODE_RATE_LIMIT = 50003;

    /**
     * @Message("login")
     */
    const CODE_LOGIN = 40000;

    /**
     * @Message("server error")
     */
    const CODE_ERROR = 40001;

    /**
     * @Message("message.error_null")
     */
    const CODE_ERROR_NULL = 400400;

    /**
     * @Message("service forbidden")
     */
    const CODE_SERVER_FORBIDDEN = 400300;

    /**
     * @Message("service http_not_found")
     */
    const CODE_SERVER_HTTP_NOT_FOUND = 400404;

    /**
     * @Message("server error")
     */
    const SERVER_CODE_ERROR = 50000;
}

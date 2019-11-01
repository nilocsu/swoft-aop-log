<?php


namespace App\Annotation\Parser;


use App\Annotation\Mapping\Log;
use App\Exception\ApiException;
/**
 * @since 2.0
 */
class LogRegister
{
    private static $logs = [];
    /**
     * @param string $className
     * @param string $method
     * @param Log $log
     * @throws ApiException
     */
    public static function registerLogs(
        string $className,
        string $method,
        Log $log
    ) {
        if (isset(self::$logs[$className][$method])) {
            throw new ApiException(
                sprintf('`@log` must be only one on method(%s->%s)!', $className, $method)
            );
        }
        self::$logs[$className][$method] = [
            'value'   => $log->getValue(),
        ];
    }
    /**
     * @param string $className
     * @param string $method
     *
     * @return array
     */
    public static function getLogs(string $className, string $method): array
    {
        return self::$logs[$className][$method];
    }
}
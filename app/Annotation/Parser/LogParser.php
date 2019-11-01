<?php

namespace App\Annotation\Parser;

use App\Annotation\Mapping\Log;
use App\Exception\ApiException;
use Swoft\Annotation\Annotation\Mapping\AnnotationParser;
use Swoft\Annotation\Annotation\Parser\Parser;
/**
 * @since 2.0
 *
 * @AnnotationParser(Log::class)
 */
class LogParser extends  Parser
{
    /**
     * @param int $type
     * @param Log $annotationObject
     *
     * @return array
     * @throws ApiException
     */
    public function parse(int $type, $annotationObject): array
    {
        if ($type != self::TYPE_METHOD){
            return [];
        }
        LogRegister::registerLogs($this->className, $this->methodName, $annotationObject);
        return [];
    }
}
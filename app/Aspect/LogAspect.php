<?php


namespace App\Aspect;

use App\Annotation\Parser\LogRegister;
use App\Exception\ApiException;
use App\Model\Entity\TLog;
use Swoft\Aop\Annotation\Mapping\Around;
use Swoft\Aop\Annotation\Mapping\Aspect;
use Swoft\Aop\Annotation\Mapping\Before;
use Swoft\Aop\Annotation\Mapping\PointAnnotation;
use App\Annotation\Mapping\Log;
use Swoft\Aop\Point\ProceedingJoinPoint;
use Swoft\Aop\Proxy;
use Swoft\Context\Context;

/**
 * @Aspect(order=1)
 * @PointAnnotation(
 *     include={Log::class}
 * )
 */
class LogAspect
{

    protected $start;

    /**
     * @Before()
     */
    public function before()
    {
        $this->start = milliseconds();
    }

    /**
     * @Around()
     *
     * @param ProceedingJoinPoint $joinPoint
     *
     * @return mixed
     * @throws ApiException
     */
    public function around(ProceedingJoinPoint $joinPoint)
    {
        // 执行方法
        $result = $joinPoint->proceed();
//        $args      = $joinPoint->getArgs();
        $target        = $joinPoint->getTarget();
        $method        = $joinPoint->getMethod();
        $className     = get_class($target);
        $className     = Proxy::getOriginalClassName($className);
        $value         = LogRegister::getLogs($className, $method);
        $request       = Context::get()->getRequest();
        $remoteAddress = $request->getServerParams()["remote_addr"];
        // 执行时长(毫秒)
        $time = milliseconds() - $this->start;
        // 保存日志
        $log = new TLog();
        $log->setUsername('test');
        $log->setOperation($value['value']);
        $log->setIp($remoteAddress);
        $log->setLocation('');
        $log->setMethod($className . '::' . $method . '()');
        $log->setTime($time);
        $log->setParams(json_encode($request->input()));
        $log->save();
        return $result;
    }
}
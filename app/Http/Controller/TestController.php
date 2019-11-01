<?php

namespace App\Http\Controller;

use App\Annotation\Mapping\Log;
use App\Exception\ApiException;
use Swoft\Co;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;

/**
 * @Controller(prefix="/test")
 */
class TestController
{
    /**
     * @Log("方法一")
     * @RequestMapping(route="one")
     * @return string
     */
    public function methodOne(){
        return 'one';
    }
    /**
     * @Log(value="方法二")
     * @RequestMapping(route="two")
     * @return string
     * @throws ApiException
     */
    public function methodTwo(){
        Co::sleep(0.2);
        return 'two';
    }
    /**
     * @Log(value="方法三")
     * @RequestMapping(route="three")
     * @return string
     * @throws ApiException
     */
    public function methodThree(){
        throw new ApiException('tree');
    }
}
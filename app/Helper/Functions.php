<?php
/**
 * Custom global functions
 */

function user_func(): string
{
    return 'hello';
}
/**
 * 获取ms时间戳
 * @return int
 */
function milliseconds(){
    return intval(microtime(true)*1000);
}
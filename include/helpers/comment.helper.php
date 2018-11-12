<?php  if(!defined('DEDEINC')) exit('dedecms');

/**
 * 评论小助手
 *
 * @link           https://www.dedemao.com
 */
function getCommentValidate($id)
{
    @session_start();
    $_SESSION['securimage_code_value']=mt_rand(10000,99999);
    return $_SESSION['securimage_code_value'];
}

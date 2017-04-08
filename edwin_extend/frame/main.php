<?php
/**
 * <p>
 * Title:extend.edwin.php
 * </p>
 * <p>
 * Description:自定义的一些扩展函数
 * </p>
 *
 * @author ed
 * @since 2017-4-1
 * @version 1.0
 */

/*********************************************************其他自定义扩展函数  START*******************************************************/
/**
 * 根据评分获取页面小星星
 * @param $score  评分
 * @return string  根据评分生成的页面小星星字符串
 */
function getSmallStars($score)
{
    //申明要使用全局的php变量 $cfg_templets_skin是dede定义的一个php变量，在模板中使用的是 {dede:global.cfg_templets_skin/}
    global $cfg_templets_skin;

    //约定页面上星星的显示个数
    $stars = 5;

    //获取金色星星数量
    $goldCount = round($score / 2);

    //获取灰色星星数量  这里约定页面上
    $gridCount = $stars - $goldCount;

    $toReturn = '';

    //输出两个种星星
    for ($i = 0; $i < $goldCount; ++$i) {
        $toReturn .= "<img src='$cfg_templets_skin/images/star.jpg'/>";
    }
    for ($i = 0; $i < $gridCount; ++$i) {
        $toReturn .= "<img src='$cfg_templets_skin/images/star_grid.jpg'/>";
    }

    return $toReturn;
}
/*********************************************************其他自定义扩展函数  END*******************************************************/
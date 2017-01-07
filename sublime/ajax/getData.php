<?php
require "./mysql_tool.php";

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$numInOnePage = 1; // 每一页3条记录
$pageNum = 5;  //一共显示几个页码
$start = ($page - 1) * $numInOnePage;

$sql = "select * from  `student` limit ".$start.",".$numInOnePage.";";
$dbTool = mysql_tool::getInstance();
$result = $dbTool->fetchAll($sql);

//获取总页数
$sql = "select count(*) from `student`;";
$maxPage = ceil( $dbTool->fetchOne($sql) / $numInOnePage );

echo <<<eof
<table>
	<thead>
		<tr>
			<td>序号</td>
			<td>姓名</td>
			<td>性别</td>
			<td>省份</td>
			<td>学院id</td>
		</tr>
	</thead>
	<tbody>
eof;

foreach ($result as $row) {
	echo "<tr>";
	echo "<td>".++$start."</td>";
	echo "<td>".$row['name']."</td>";
	echo "<td>".$row['gender']."</td>";
	echo "<td>".$row['provence']."</td>";
	echo "<td>".$row['college_id']."</td>";
	echo "</tr>";
}
echo "</tbody>";
echo "</table>";

if($page <= 1) {
	echo "上一页";
} else {
	echo "<input type='button' name='nextpage' value='上一页' onclick='showPage(".($page-1).")'>"; 
}
echo "&nbsp;&nbsp;";
if($page  >= $maxPage) {
	echo "下一页";
} else {
	echo "<input type='button' name='nextpage' value='下一页' onclick='showPage(".($page+1).")'>";  
}
echo "&nbsp;&nbsp;";
printPageNum($page,$maxPage,$pageNum);
printGo();

/**
 * 打印页码列表
 * @param  number $page    当前页码
 * @param  number $maxPage 最大页码，也即是共有多少页
 * @param  number $pageNum 显示页码数量
 * @return [type]          [description]
 */
function printPageNum($page,$maxPage,$pageNum){
	if($page < $pageNum) {
		//打印1 ~ $page 跟后面刚好凑成5条的其他页
		for($i = 1; $i < $page; ++$i) printLink($i);
		printText($page);
		for($i = $page + 1; $i <= $pageNum && $i <= $maxPage; ++$i) printLink($i);
	} else if($page < $maxPage) {
		//$page 很大的时候打印 $page 跟 其后面一项， 其余的是$page 前面页
		for($i = $page -3; $i < $page; ++$i) printLink($i);
		printText($page);
		printLink($page + 1);
	} else {
		for($i = $page -4; $i < $page; ++$i) printLink($i);
		printText($page);
	}
}

/**
 * 打印纯文本的页码
 * @param  number $page 页码
 * @return [type]       [description]
 */
function printText($page){
	echo $page;
	echo "&nbsp;&nbsp;";
}

/**
 * 打印带超链接点击效果的页码
 * @param  number $page 页码
 * @return [type]       [description]
 */
function printLink($page){
	echo "<a href='javascript:showPage(".$page.")'>".$page."</a>";
	echo "&nbsp;&nbsp;";
}


function printGo() {
	echo "<input type='text' value='".$GLOBALS['page']."' id='pageGo' onkeydown='EnterKey(event)' style='width:40px;'>";
	echo "<input type='button' value='Go' onclick='GoTo()'>";
}
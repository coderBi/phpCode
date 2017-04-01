<?php
return array(
	//'配置项'=>'配置值'

	//开启绑定操作到类的配置
	'ACTION_BIND_CLASS' => true, //开启后每一个操作是相应的目录下面的一个 操作名.class.php，实际执行的是里面的run方法的代码。开启之后原有的 XXController.class.php的书写模式失效。
);
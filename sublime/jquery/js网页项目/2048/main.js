var board = new Array();  //存贮棋盘数字格里面的数字
var score = 0;   
var isConflicted = new Array(); //所有格子是否已经被叠加的状态
var canmove = true; //是否处于可移动状态，如果新的数字格还在创建当中，是不能进行下次移动的。

$(function() {
	newgame();
} );

function newgame() {
	//初始化棋盘格
	init();
	//生成两个随机数字
	generateOneNumber();
	generateOneNumber();
	score = 0;
	updateScore(score);
}

function init() {
	for( var i = 0; i < 4; ++i ) {
		board[i] = new Array();
		isConflicted[i] = new Array();
		for( var j = 0; j < 4; ++j ) {
			//初始化小格子的值为0
			board[i][j] = 0;
			isConflicted[i][j] = false; //所有格子初始化为未叠加状态
			var gridCell = $('#grid-cell-'+i+'-'+j);

			//设置每一个小格子的位置
			gridCell.css('top', getPosTop(i, j) );
			gridCell.css('left', getPosLeft(i, j));
		}
	}
	updateBoardView();
}


function updateBoardView() {
	$('.number-cell').remove();  //刷新之前，先要将之前的所有的数字格清楚
	for( var i = 0; i < 4; ++i ) {
		for( var j = 0; j < 4; ++j ) {
			updateOneNode(i, j);
			isConflicted[i][j] = false; //更新棋盘的时候重置每一个格子的叠加状态
		}
	}
}

function updateOneNode(i,j) {
	$('#grid-container').append('<div class="number-cell" id="number-cell-'+i+'-'+j+'"></div>');
	var numberCell = $('#number-cell-'+i+'-'+j);

	//如果棋盘的值是0 就将其高度高度置0
	if(board[i][j] == 0){
		numberCell.css('width','0px');
		numberCell.css('height','0px');
	}
	else {
		numberCell.css('width','100px');
		numberCell.css('height','100px');
		numberCell.css('top', getPosTop(i, j));
		numberCell.css('left', getPosLeft(i, j));
		numberCell.css('background-color', getNumberBackgroundColor( board[i][j] ) );
		numberCell.css('color', getNumberColor(board[i][j]));
		numberCell.text(board[i][j]);
	}
}

function generateOneNumber() {
	//生成一个随机的空位置
	var randx = parseInt(Math.floor(Math.random() * 4)); //x轴
	var randy = parseInt(Math.floor(Math.random() * 4)); //y轴

	while(true) {
		if(board[randx][randy] == 0 ){
			break;  //当前格子是空的  就终止循环
		}
		else {
			//重新生成
			var randx = parseInt(Math.floor(Math.random() * 4)); //x轴
			var randy = parseInt(Math.floor(Math.random() * 4)); //y轴
		}
	}

	//生成一个数组，50% 是2 50%是 4
	var randNumber = Math.random() < 0.5 ? 2 : 4;

	//在随机的位置上面显示随机的数字
	board[randx][randy] = randNumber;
	showNumberWithAnimation(randx, randy, randNumber);
}
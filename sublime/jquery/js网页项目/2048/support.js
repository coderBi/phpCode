function getPosTop(i, j) {
	return 20 + i * 120;
}

function getPosLeft(i, j) {
	return 20 + j * 120;
}

function getNumberBackgroundColor(number){
	switch(number) {
		case 2: return '#eee4da'; break;
		case 4: return '#ede0c8'; break;
		case 8: return '#f2b179'; break;
		case 16: return '#f59563'; break;
		case 32: return '#f67c5f'; break;
		case 64: return '#f65e3b'; break;
		case 128: return '#edcf72'; break;
		case 256: return '#edcc61'; break;
		case 512: return '#9c0'; break;
		case 1024: return '#33b5e5'; break;
		case 2048: return '#09c'; break;
		case 4096: return '#a6c'; break;
		case 8192: return '#93c'; break;
	}
}

function getNumberColor(number) {
	//如果是2 4
	if(number <= 4 ){
		return '#776e65';
	}
	return 'white';
}

function canMoveLeft(board) {
	for( var i = 0; i < 4; ++i){
		for( var j = 1; j < 4; ++j) { //从第2列开始，才可以左移
			if( board[i][j] != 0 && ( board[i][j-1] == 0 || ( board[i][j-1] == board[i][j] && !isConflicted[i][j-1] ) ) ){
				return true;
			}
		}
	}
	return false;
}

function canMoveRight(board) {
	for( var i = 0; i < 4; ++i){
		for( var j = 2; j >= 0; --j) { //从倒数第2列开始，才可以右移
			if( board[i][j] != 0 && ( board[i][j+1] == 0 || ( board[i][j+1] == board[i][j] && !isConflicted[i][j+1] ) ) ){
				return true;
			}
		}
	}
	return false;
}

function canMoveUp(board) {
	for( var i = 1; i < 4; ++i){ //从第2行开始，才可以上移
		for( var j = 0; j < 4; ++j) { 
			if( board[i][j] != 0 && ( board[i-1][j] == 0 || ( board[i-1][j] == board[i][j] && !isConflicted[i-1][j] ) ) ){
				return true;
			}
		}
	}
	return false;
}

function canMoveDown(board) {
	for( var i = 0; i < 3; ++i){ //从倒数第2行开始，才可以下移
		for( var j = 0; j < 4; ++j) {
			if( board[i][j] != 0 && ( board[i+1][j] == 0 || ( board[i+1][j] == board[i][j] && !isConflicted[i+1][j] ) ) ){
				return true;
			}
		}
	}
	return false;
}
 
 /**
  * 判断某一行的某两个元素之间是否都是空值
  * @param  {int} row   指定行号
  * @param  {int} col1  较小的列号
  * @param  {int} col2  较大的列号
  * @param  {array[][]} board 棋盘的数据数组
  * @return {boolean}       全部是空格返回true  否则false
  */
function noBlokHorizontalCol(row, col1, col2, board) {
	for(var i = col1 + 1; i < col2; ++i){
		if(board[row][i] != 0) return false;
	}
	return true;
}

/**
  * 判断某一列的某两个元素之间是否都是空值
  * @param  {int} col   指定列号
  * @param  {int} row1  较小的行号
  * @param  {int} row2  较大的行号
  * @param  {array[][]} board 棋盘的数据数组
  * @return {boolean}       全部是空格返回true  否则false
  */
function noBlokVerticalRow(col, row1, row2, board) {
	for(var i = row1 + 1; i < row2; ++i){
		if(board[i][col] != 0) return false;
	}
	return true;
}

function updateScore(score) {
	$('#score').text( score );
}
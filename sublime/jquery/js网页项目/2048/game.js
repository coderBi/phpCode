$(document).keydown(function(event) {
	switch(event.keyCode) {
		case 37: //left
		if(moveLeft()) {
			//如果可以向左移动，就重新生成一个新的数字
			setTimeout( 'generateOneNumber();canmove=true;', 210 );
			setTimeout( 'isgameover()', 300 );
		}
		break;
		case 38: //up
		if(moveUp()) {
			//如果可以向上移动，就重新生成一个新的数字
			setTimeout( 'generateOneNumber();canmove=true;', 210 );
			setTimeout( 'isgameover();canmove=true;', 300 );
		}
		break;
		case 39: //right
		if(moveRight()) {
			//如果可以向右移动，就重新生成一个新的数字
			setTimeout( 'generateOneNumber();canmove=true;', 210 );
			setTimeout( 'isgameover()', 300 );
		}
		break;
		case 40: //down
		if(moveDown()) {
			//如果可以向下移动，就重新生成一个新的数字
			setTimeout( 'generateOneNumber();canmove=true;', 210 );
			setTimeout( 'isgameover()', 300 );
		}
		break;
		default: break;
	}
});

function moveLeft() {
	if( !canmove ) return false;  //新的数字格还没创建完成，现在不能进行新的移动
	
	if( !canMoveLeft(board) ) {
		return false;
	}

	canmove = false;   ///进行一次移动之前，将可移动标志置成false，这下这次移动结束之前，不会有其他的移动进入

	//完成向左移动
	for( var i = 0; i < 4; ++i){
		for( var j = 1; j < 4; ++j) { //从第2列开始，才可以左移
			if( board[i][j] != 0 ){
				for( var k = 0; k < j; ++k ) {
					//非空节点前面有空节点  或者 有跟它值一样的节点 
					if( board[i][k] == 0 && noBlokHorizontalCol(i, k, j, board)) {
						showMoveAnimation(i,j,i,k);
						board[i][k] = board[i][j];
						board[i][j] = 0;
						break;
					} else if( board[i][k] == board[i][j] && noBlokHorizontalCol(i, k, j, board) && !isConflicted[i][k] ) {
						showMoveAnimation(i,j,i,k);
						board[i][k] += board[i][j];

						board[i][j] = 0;
						score += board[i][k];
						updateScore(score);
						isConflicted[i][k] = true;
						break;
					}
				}
			}
		}
	}
	setTimeout( 'updateBoardView()', 200 );
	return true;
}

function moveRight() {
	if( !canmove ) return false;  //新的数字格还没创建完成，现在不能进行新的移动
	
	if( !canMoveRight(board) ) {
		return false;
	}

	canmove = false;   ///进行一次移动之前，将可移动标志置成false，这下这次移动结束之前，不会有其他的移动进入

	//完成向右移动
	for( var i = 0; i < 4; ++i){
		//outfor: //命名这个for
		for( var j = 2; j >= 0; --j) { //从倒数第2列开始，才可以右移
			if( board[i][j] != 0 ){
				for( var k = 4; k > j; --k ) {
					//非空节点右面有空节点  或者 有跟它值一样的节点 
					if( board[i][k] == 0 && noBlokHorizontalCol(i, j, k, board) ) {
						showMoveAnimation(i,j,i,k);
						board[i][k] = board[i][j];
						board[i][j] = 0;
						break;
					} else if( board[i][k] == board[i][j] && noBlokHorizontalCol(i, j, k, board) && !isConflicted[i][k] ) {
						showMoveAnimation(i,j,i,k);
						board[i][k] += board[i][j];

						board[i][j] = 0;
						score += board[i][k];
						updateScore(score);
						isConflicted[i][k] = true;
						break;
					}
				}
			}
		}
	}
	setTimeout( 'updateBoardView()', 200 );
	return true;
}

function moveUp() {
	if( !canmove ) return false;  //新的数字格还没创建完成，现在不能进行新的移动
	
	if( !canMoveUp(board) ) {
		return false;
	}

	canmove = false;   ///进行一次移动之前，将可移动标志置成false，这下这次移动结束之前，不会有其他的移动进入

	//完成向上移动
	for( var i = 1; i < 4; ++i){ //从第2行开始，才可以上移
		for( var j = 0; j < 4; ++j) {
			if( board[i][j] != 0 ){
				for( var k = 0; k < i; ++k ) {
					//非空节点上面有空节点  或者 有跟它值一样的节点 
					if( board[k][j] == 0 && noBlokVerticalRow(j, k, i, board) ) {
						showMoveAnimation(i,j,k,j);
						board[k][j] = board[i][j];
						board[i][j] = 0;
						break;
					} else if( board[k][j] == board[i][j] && noBlokVerticalRow(j, k, i, board) && !isConflicted[k][j] ) {
						showMoveAnimation(i,j,k,j);
						board[k][j] += board[i][j];
						board[i][j] = 0;
						score += board[k][j];
						updateScore(score);
						isConflicted[k][j] = true;
						break;
					}
				}
			}
		}
	}
	setTimeout( 'updateBoardView()', 200 );
	return true;
}

function moveDown() {
	if( !canmove ) return false;  //新的数字格还没创建完成，现在不能进行新的移动

	if( !canMoveDown(board) ) {
		return false;
	}

	canmove = false;   ///进行一次移动之前，将可移动标志置成false，这下这次移动结束之前，不会有其他的移动进入
	
	//完成向下移动
	for( var i = 2; i >= 0; --i){ //从倒数第2行开始，才可以下移
		for( var j = 0; j < 4; ++j) { 
			if( board[i][j] != 0 ){
				for( var k = 3; k > i; --k ) {
					//非空节点下面有空节点  或者 有跟它值一样的节点 
					if( board[k][j] == 0 && noBlokVerticalRow(j, i, k, board) ) {
						showMoveAnimation(i,j,k,j);
						board[k][j] = board[i][j];
						board[i][j] = 0;
						break;
					} else if( board[k][j] == board[i][j] && noBlokVerticalRow(j, i, k, board) && !isConflicted[k][j] ) {
						showMoveAnimation(i,j,k,j);
						board[k][j] += board[i][j];
						board[i][j] = 0;
						score += board[k][j];
						updateScore(score);
						isConflicted[k][j] = true;
						break;
					}
				}
			}
		}
	}
	setTimeout( 'updateBoardView()', 200 );
	return true;
}

function isgameover(){
	if( !canMoveLeft(board) && !canMoveRight(board) && !canMoveUp(board) && !canMoveDown(board) ) {
		$('#grid-container').append( "<div id='gameover'><p>本次得分</p><span>"+score+"</span><a href='javascript:;\
			' onclick='restartGame()' id='restartGame'>Restart</a></div>" );
	}
}

function restartGame() {
	$('#gameover').remove();
	newgame();
}
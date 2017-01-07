function showNumberWithAnimation(i, j, randNumber) {
	var numberCell = $('#number-cell-' +i+ '-' + j);

	//设置当前数字的背景颜色跟颜色和数字
	numberCell.css('background-color', getNumberBackgroundColor(randNumber));
	numberCell.css('color', getNumberColor(randNumber));
	numberCell.text(randNumber);

	//设置当前数字格的显示动画
	numberCell.animate( {
		width: '100px',
		height: '100px',
		top: getPosTop(i, j),
		left: getPosLeft(i, j),
	}, 50 );
}

function showMoveAnimation(fromx, fromy, tox, toy ) {
	//获取当前数字格内容
	var numberCell = $('#number-cell-' + fromx + '-' + fromy);
	numberCell.animate( {
		top: getPosTop(tox,toy),
		left: getPosLeft(tox,toy),
	}, 200)
}
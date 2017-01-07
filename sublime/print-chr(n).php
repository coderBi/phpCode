<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>获取编码32~126（可见字符）字符</title>
	<style>
		table {
			border-collapse: collapse;
		}
		table td {
			border: 1px solid silver;
		}
	</style>
</head>
<body>
	<table>
		<thead>
			<tr>
				<?php  
					for($i = 0; $i < 10; $i++){
						echo "<td>编码</td><td>编码对应字符</td>";
					}
				?>				
			</tr>
		</thead>
		<tbody>
			<?php  
				for($i = 32, $count = 0; $i <= 126; $i++, $count++){
					$res = chr($i);
					if($count % 10 == 0){
						echo("<tr><td>".$i."</td><td>".$res."</td>");
					} elseif ($count % 10 == 9) {
						echo("<td>".$i."</td><td>".$res."</td></tr>");
					} else {
						echo("<td>".$i."</td><td>".$res."</td>");
					}	
				}
			?>
		</tbody>		
	</table>
	
</body>
</html>
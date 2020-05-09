<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

</body>
<script type="text/javascript">
	let xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function(){
		if(xhttp.readyState == 4 && xhttp.status == 200){
			console.log(JSON.parse(this.responseText));
		}
	}

	xhttp.open("GET", "api/product/read_paging.php?page=3", true); 
	xhttp.send();   

</script>
</html>
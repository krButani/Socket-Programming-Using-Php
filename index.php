<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Hello</title>
</head>
<body>


	<script type="text/javascript">

		// you can route multiple socket connection
		var conn = new WebSocket('ws://localhost:8080/home');
		conn.onopen = function(e) {
		    console.log("Connection established!");
		    var data = {
		    		'name': "kartik",
		    		'age': 28,
		    		'bio': {
		    			'hobi': 'reading',
		    			'skill': 'Codding'
		    		}
		    };
		    conn.send(JSON.stringify(data));
		};

		conn.onmessage = function(e) {
		    console.log(e.data);
		};


		var conn2 = new WebSocket('ws://localhost:8080/realtime');
		conn2.onopen = function(e) {
		    console.log("Connection established!");
		    var data = {
		    		'name': "Its Stock Data",
		    		'age': 28,
		    		'bio': {
		    			'hobi': 'reading',
		    			'skill': 'Codding'
		    		}
		    };
		    conn2.send(JSON.stringify(data));
		};

		conn2.onmessage = function(e) {
		    console.log(e.data);
		};

	</script>
</body>
</html>
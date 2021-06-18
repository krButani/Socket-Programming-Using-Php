# Socket Programming Using PHP


- Here bin folder is contain server file that you can execute on command.
- Src folder is contain atual logic on it.

- First, Download Ratchet Library file on your pc using composer

```
composer require cboden/ratchet
```

- Then after Create Our Login File on src folder ( RealTimeData.php )

```
namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class RealTimeData implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        //print_r($this->clients);
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

       // print_r($conn->resourceId);

        echo "RealTime Data New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        //echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"  , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');
        
        $msg = json_decode($msg);
       //print_r($msg);
        foreach ($this->clients as $client) {
            if ($from === $client) {
                // The sender is not the receiver, send to each client connected
                $client->send(json_encode(array('status'=>"Success")));
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}
```

- After done this thing create server on bin folder ( realtimedata.php )

```
<?php
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use MyApp\RealTimeData;

    require dirname(__DIR__) . '/vendor/autoload.php';

    $server = IoServer::factory(
        new HttpServer(
            new WsServer(
                new RealTimeData()
            )
        ),
        8080
    );

    $server->run();
```

- Now You call these WebSocket Services ( index.php )

```
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Hello</title>
</head>
<body>


    <script type="text/javascript">
        // When Single Connection
        var conn = new WebSocket('ws://localhost:8080');
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

/*
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
*/
    </script>
</body>
</html>
```

### Run Program

- Fire following command to run server
```
php bin/realtimedata.php
```
- then open in browser index.php and see output on console or command line



- Auther: krbutani
- Contact Me need More help
- [Whatsapp: +91 8460304360](https://api.whatsapp.com/send?phone=918460304360&text=I%20read%20your%20Github%20repo.%20I%20want%20help%20with%20Socket%20programming%20using%20PHP.%F0%9F%98%80)


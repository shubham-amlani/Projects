<?php
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\App;

require __DIR__ . '/vendor/autoload.php'; // Autoload Ratchet and dependencies

class Chat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage; // Stores all connected clients
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection(s)' . "\n", $from->resourceId, $msg, $numRecv);

        foreach ($this->clients as $client) {
            if ($from !== $client) {
                // Send the message to all other clients
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // Remove the connection when it closes
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}

// Create WebSocket server on port 8080
$server = new App('0.0.0.0', 8080);
$server->route('/chat', new Chat, ['*']);
$server->run();
?>
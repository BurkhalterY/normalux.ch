<?php
namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Game implements MessageComponentInterface {
	protected $clients;
	protected $positions = [];

	public function __construct() {
		$this->clients = new \SplObjectStorage;
	}

	public function onOpen(ConnectionInterface $conn) {
		// Store the new connection to send messages to later
		$this->clients->attach($conn);
		$conn->room_code = '';

		echo "New connection! ({$conn->resourceId})\n";
	}

	public function onMessage(ConnectionInterface $from, $msg) {
		$datas = json_decode($msg);
		switch ($datas->type) {
			case 'join':
				$from->room_code = $datas->room_code;

				if(!isset($this->positions[$datas->room_code])){
					$this->positions[$datas->room_code] = [];
				}

				$obj = new \stdClass();
				$obj->type = 'sync';
				$obj->positions = $this->positions[$from->room_code];
				$from->send(json_encode($obj));
				break;
			case 'position':
				$datas->position->playerId = $from->resourceId;
				$this->positions[$from->room_code][] = $datas->position;

				$obj = new \stdClass();
				$obj->type = 'position';
				$obj->position = $datas->position;

				foreach ($this->clients as $client) {
					if ($from !== $client && $client->room_code == $from->room_code) {
						$client->send($msg);
					}
				}
				break;
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
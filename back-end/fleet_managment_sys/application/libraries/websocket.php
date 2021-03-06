<?php

class Websocket
    /**
     * Sample usage:
     * $websocket = new Websocket($ip ,$port ,$sourceId);
     * $websocket->send($message, $destination);
     *
     * */
{
    private $message = array(
        'source' => null,
        'message' => null,
        'destination' => null
    );
    private $context;
    private $socket;

    /**
     * @param $ip
     * @param $port
     * @param null $sourceId
     */
    function __construct($ip = 'localhost' ,$port = '5555',$sourceId = NULL)
    {

        $this->CI =& get_instance();
        $this->context = new ZMQContext();
        $this->socket = $this->context->getSocket(ZMQ::SOCKET_PUSH, 'my pusher');

        $this->socket->connect("tcp://$ip:$port");
        $this->message['source'] = $sourceId;

    }

    /**
     * @param $message
     * @param $destination
     * @return mixed
     */
    public function send($message, $destination)
    {
        $this->message['destination'] = $destination;
        $this->message['message'] = $message;
        $response = $this->socket->send(json_encode($this->message));
        return $response;
    }
}

<?php


namespace phpSonoffDiy;


use Httpful\Exception\ConnectionErrorException;
use Httpful\Request;
use Httpful\Response;

/**
 * Class phpSonoffDiyDevice
 *
 * @package phpSonoffDiy
 */
class phpSonoffDiyDevice {

    /**
     *
     */
    private const API_PORT = 8081;
    /**
     *
     */
    private const API_PATH = '/zeroconf/';
    /**
     *
     */
    private const API_INFO = 'info';
    /**
     *
     */
    private const API_SWITCH = 'switch';
    /**
     *
     */
    private const API_PULSE = 'pulse';


    /**
     * @var string
     */
    private string $restUri;
    /**
     * @var array
     */
    private array $data = [];


    /**
     * phpSonoffDiyDevice constructor.
     *
     * @param string $ipAddress
     */
    public function __construct(string $ipAddress) {
        $this->setRestUri('http://' . $ipAddress . ':' . self::API_PORT . self::API_PATH);
        $this->getInfo();
    }

    /**
     * @return array
     */
    public function getData() : array {
        return $this->data;
    }

    /**
     * @return $this
     * @throws ConnectionErrorException
     */
    public function turnOn() : self {
        $payload = '{"deviceid":"","data":{"switch":"on"}}';
        $this->getPostResponse(self::API_SWITCH, $payload);
        return $this;
    }

    /**
     * @return $this
     * @throws ConnectionErrorException
     */
    public function turnOff() : self {
        $payload = '{"deviceid":"","data":{"switch":"off"}}';
        $this->getPostResponse(self::API_SWITCH, $payload);
        return $this;
    }

    /**
     * @param int $pulseWidth
     * @return $this
     * @throws ConnectionErrorException
     */
    public function pulseOn(int $pulseWidth = 2000) : self {
        $payload = '{"deviceid":"","data":{"pulse":"on","pulseWidth":' . $pulseWidth . '}}';
        $this->getPostResponse(self::API_PULSE, $payload);
        return $this;
    }

    /**
     * @return $this
     * @throws ConnectionErrorException
     */
    public function pulseOff() : self {
        $payload = '{"deviceid":"","data":{"pulse":"off"}}';
        $this->getPostResponse(self::API_PULSE, $payload);
        return $this;
    }


    /**
     * @return string
     */
    private function getRestUri(): string {
        return $this->restUri;
    }

    /**
     * @param string $restUri
     */
    private function setRestUri(string $restUri): void {
        $this->restUri = $restUri;
    }


    /**
     *
     */
    private function getInfo() {
        $payload = '{"deviceid":"","data":{}}';
        if ($response = $this->getPostResponse(self::API_INFO, $payload)) {
            $this->setData($response);
        }
    }

    /**
     * @param Response $response
     */
    private function setData(Response $response) {
        foreach($response->body->data as $key => $val) {
            $this->data[$key] = $val;
        }
    }

    /**
     * @param string $path
     * @param string $payload
     * @return Response|null
     * @throws ConnectionErrorException
     */
    private function getPostResponse(string $path, string $payload): ?Response {
        $uri = $this->getRestUri() . $path;

        return Request::post($uri)
            ->body($payload)
            ->sendsType('application/json')
            ->send();
    }



}
<?php
namespace phpSonoffDiy;

use Httpful\Exception\ConnectionErrorException;

/**
 * Class phpSonoffDiy
 *
 * @package phpSonoffDiy
 */
class phpSonoffDiy {


    /**
     * @var array
     */
    private array $devices = [];

    /**
     * phpSonoffDiy constructor.
     *
     * @param string ...$devices
     */
    public function __construct(string ...$devices) {
        foreach ($devices as $device) {
            $this->devices[$device] = new phpSonoffDiyDevice($device);
        }
    }

    /**
     * @return array
     */
    public function getDevices() {
        return $this->devices;
    }

    /**
     * @throws ConnectionErrorException
     */
    public function turnAllOn() {
        /**
         * @var $device phpSonoffDiyDevice
         */
        foreach ($this->devices as $device) {
            $device->turnOn();
        }
    }

    /**
     * @throws ConnectionErrorException
     */
    public function turnAllOff() {
        /**
         * @var $device phpSonoffDiyDevice
         */
        foreach ($this->devices as $device) {
            $device->turnOff();
        }
    }

    /**
     * @param int $pulseWidth
     * @throws ConnectionErrorException
     */
    public function pulseAllOn(int $pulseWidth = 2000) {
        /**
         * @var $device phpSonoffDiyDevice
         */
        foreach ($this->devices as $device) {
            $device->pulseOn($pulseWidth);
        }
    }

    /**
     * @throws ConnectionErrorException
     */
    public function pulseAllOff() {
        /**
         * @var $device phpSonoffDiyDevice
         */
        foreach ($this->devices as $device) {
            $device->pulseOff();
        }
    }

}
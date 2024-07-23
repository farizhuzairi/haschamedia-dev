<?php

namespace HaschaDev\Production\Abstracts;

use HaschaDev\Dev;
use HaschaDev\Support\Config;
use HaschaDev\Production\Abstracts\Production;

abstract class AppBuilder
{
    protected string $_trace;
    protected Config $guarded;

    public function __construct(Dev $dev)
    {
        $trace = $dev->trace();
        if($trace !== csrf_token()){
            throw new \Exception("Invalid session. error_in_PHP_class: " . __CLASS__);
        }
        $this->_trace = $trace;
        $this->guarded = $dev->guarded();
    }

    /**
     * membangun koneksi
     * ke Production
     * 
     */
    abstract public function build(): Production;

    /**
     * membuat objek ke sumber daya
     * melalui Production
     * 
     */
    abstract public function make(array $validated): array;
    
    /**
     * get session key
     * 
     */
    abstract public function sessionKey(): string;

    /**
     * membuat objek Production
     * dengan session
     * 
     */
    abstract public function liveSession(array $validated): string|null;

    /**
     * memeriksa objek Production
     * pada session
     * berdasarkan key
     * 
     */
    abstract public function hasLiveSession(?string $key = null): bool;

    /**
     * mengambil objek Production
     * dari session
     * berdasarkan key
     * 
     */
    abstract public function getLiveSession(?string $key = null): array;
}
<?php

namespace HaschaDev\Support;

use HaschaDev\Dev;
use HaschaDev\Support\Config;
use HaschaDev\Contracts\Page\Pageable;

class Handler implements Dev
{
    private Config $guarded;
    private string $_trace;
    private string $routeName;
    private array $dataTemps;
    
    public function __construct(private Pageable $pageable)
    {
        $this->setGuarded();
    }

    /**
     * set configuration file
     * 
     */
    public function setGuarded(): void
    {
        $this->guarded = Config::set();
        \Illuminate\Support\Facades\Config::set('auth.providers.users.model', env('AUTH_MODEL', HaschaDev\Models\User::class));
    }

    /**
     * get Guarded
     * 
     */
    public function guarded(): Config
    {
        return $this->guarded;
    }

    /**
     * set Trace
     */
    public function setTrace(string $routeName, string $traceId): void
    {
        $this->routeName = (string) $routeName;
        $this->_trace = (string) $traceId;

        if(!empty($routeName)){
            $this->pageable->setRouter($routeName);
        }
    }

    /**
     * get Trace
     */
    public function trace(): string
    {
        if(!isset($this->_trace) || empty($this->_trace)){
            throw new \Exception("Invalid session. error_in_PHP_class: " . __CLASS__);
        }
        return $this->_trace;
    }

    /**
     * set data temporary
     * 
     */
    public function setDataTemps(array $data): void
    {
        if(!empty($data)) $this->dataTemps = $data;
    }

    /**
     * get data temporary
     * 
     */
    public function getDataTemps(): array|null
    {
        if(isset($this->dataTemps)) return $this->dataTemps;
        return null;
    }
}
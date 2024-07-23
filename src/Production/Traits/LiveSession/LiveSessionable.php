<?php

namespace HaschaDev\Production\Traits\LiveSession;

trait LiveSessionable
{
    protected static string $sessionKey = "_store_";

    /**
     * get session key
     * 
     */
    public function sessionKey(): string
    {
        return __CLASS__ . self::$sessionKey . $this->_trace;
    }

    /**
     * membuat objek Production
     * dengan session
     * 
     */
    public function liveSession(array $validated): string|null
    {
        $key = $this->sessionKey();
        $store = request()->session()->put($key, $validated);
        // dd($store);
        return $key;
    }

    /**
     * memeriksa objek Production
     * pada session
     * berdasarkan key
     * 
     */
    public function hasLiveSession(?string $key = null): bool
    {
        if(empty($key)) $key = $this->sessionKey();
        $has = request()->session()->has($key);
        if(! $has) return false;
        return true;
    }

    /**
     * mengambil objek Production
     * dari session
     * berdasarkan key
     * 
     */
    public function getLiveSession(?string $key = null): array
    {
        if(empty($key)) $key = $this->sessionKey();
        if(! $this->hasLiveSession($key)) return [];
        $attributes = request()->session()->get($key); // pull
        return !empty($attributes) ? $attributes : [];
    }
}
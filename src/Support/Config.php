<?php

namespace HaschaDev\Support;

use Illuminate\Support\Facades\Crypt;
use HaschaDev\Exceptions\InvalidConfig;
use Illuminate\Support\Facades\Config as DevConfig;

class Config
{
    private static self $config;
    private ?string $guarded;

    private function __construct()
    {
        if(empty(config('haschadev'))) throw new InvalidConfig();
        $this->guarded = Crypt::encrypt(config('haschadev'));
        DevConfig::set('haschadev', []);
    }

    public static function set(): self
    {
        if (!isset(self::$config) || empty(self::$config)) {
            self::$config = new self();
        }

        /**
         * produce self-objects
         */
        return self::$config;
    }

    /**
     * call method
     * 
     */
    public function __call(string $method, array $args)
    {
        $method = (string) $method;
        $instance = function($instance){
            if($instance instanceof Config) return $instance;
            return false;
        };

        try {

            $instance = $instance(self::$config);
            if($instance){

                // configuration array
                $data = Crypt::decrypt($instance->guarded);

                /**
                 * userTimezone(): string|null
                 * 
                 */
                if($method === 'userTimezone'){
                    return $data['userTimezone'];
                }
                
            }
            /**
             * unknown method
             * 
             */
            $arr = implode(',', $args);
            throw new InvalidConfig("method: {$method}, args: {$arr}. error_in_PHP_class: " . __CLASS__);

        } catch (\Throwable $th) {
            report($th);
        }

        /**
         * unknown method or invalid access root
         * 
         */
        return null;
    }

    private function __clone()
    {}

    public function __wakeup() {
        throw new InvalidConfig("Cannot deserialize a config. error_in_PHP_class: " . __CLASS__);
    }
}
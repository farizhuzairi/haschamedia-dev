<?php

namespace HaschaDev\Support;

use HaschaDev\Dev;
use HaschaDev\Support\Config;
use HaschaDev\Database\DBConnect;
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
        \Illuminate\Support\Facades\Config::set('auth.providers.users.model', env('AUTH_MODEL', \HaschaDev\Models\User::class));

        /**
         * set database connections
         * 
         */
        $this->set_db_connections();
    }

    protected function set_db_connections(): void
    {
        $appDB = \Illuminate\Support\Facades\Config::get('app.database');
        $getConnections = $appDB['connections'];

        $appDB['connections'] = array_merge($getConnections, [
            DBConnect::BASE->value => [
                'driver' => 'mysql',
                'url' => env('DB_URL'),
                'host' => env('DB_HOST', '127.0.0.1'),
                'port' => env('DB_PORT', '3306'),
                'database' => env('DB_DATABASE', 'laravel'),
                'username' => env('DB_USERNAME', 'root'),
                'password' => env('DB_PASSWORD', ''),
                'unix_socket' => env('DB_SOCKET', ''),
                'charset' => env('DB_CHARSET', 'utf8mb4'),
                'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
                'prefix' => '',
                'prefix_indexes' => true,
                'strict' => true,
                'engine' => null,
                'options' => extension_loaded('pdo_mysql') ? array_filter([
                    \PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
                ]) : [],
            ],
    
            DBConnect::PRODUCTION->value => [
                'driver' => 'mysql',
                'url' => env('DB_URL'),
                'host' => env('DB_HOST_PRODUCTION', '127.0.0.1'),
                'port' => env('DB_PORT_PRODUCTION', '3306'),
                'database' => env('DB_DATABASE_PRODUCTION', 'laravel'),
                'username' => env('DB_USERNAME_PRODUCTION', 'root'),
                'password' => env('DB_PASSWORD_PRODUCTION', ''),
                'unix_socket' => env('DB_SOCKET', ''),
                'charset' => env('DB_CHARSET', 'utf8mb4'),
                'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
                'prefix' => '',
                'prefix_indexes' => true,
                'strict' => true,
                'engine' => null,
                'options' => extension_loaded('pdo_mysql') ? array_filter([
                    \PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
                ]) : [],
            ],
    
            DBConnect::FILE->value => [
                'driver' => 'mysql',
                'url' => env('DB_URL'),
                'host' => env('DB_HOST_FILE', '127.0.0.1'),
                'port' => env('DB_PORT_FILE', '3306'),
                'database' => env('DB_DATABASE_FILE', 'laravel'),
                'username' => env('DB_USERNAME_FILE', 'root'),
                'password' => env('DB_PASSWORD_FILE', ''),
                'unix_socket' => env('DB_SOCKET', ''),
                'charset' => env('DB_CHARSET', 'utf8mb4'),
                'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
                'prefix' => '',
                'prefix_indexes' => true,
                'strict' => true,
                'engine' => null,
                'options' => extension_loaded('pdo_mysql') ? array_filter([
                    \PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
                ]) : [],
            ],
        ]);

        \Illuminate\Support\Facades\Config::set('app.database', $appDB);
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
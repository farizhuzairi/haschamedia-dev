<?php

namespace HaschaDev;

use HaschaDev\Models\User;
use Livewire\Livewire;
use Illuminate\Support\Facades\Blade;

class HaschaMedia
{
    public const APP_NAME = "Hascha Media Development";
    public const AUTHOR = "farizhuzairi@gmail.com";

    /**
     * image upload helper
     * 
     */
    public static string $defaultStorageDisk = "public";
    public static bool $defaultIsActiveFileMedia = true;

    /**
     * application product
     * attributes
     * 
     */
    public static string $productId = "application_product_id";

    /**
     * User Model Obersvers
     * 
     */
    public static function observers(): void
    {
        User::observe(\HaschaDev\Observers\UserObserver::class);
    }

    /**
     * Blade Templating
     * 
     */
    public static function bladeTemplates(): void
    {
        /**
         * Layouts
         * Default Theme - Public Web Application
         * 
         */
        Blade::component(
            'layout',
            \App\View\Components\Layout::class
        );
        Blade::component(
            'html-tags',
            \App\View\Components\HtmlTags::class
        );
        Blade::component(
            'auth-layout',
            \App\View\Components\Auth\Layout::class
        );

        /**
         * Home Page Template
         * 
         */
        Blade::componentNamespace('App\\View\\Components\\HomePage', 'homepage');

        /**
         * Dashboard Template
         * 
         */
        Blade::componentNamespace('App\\View\\Components\\Dashboard', 'dashboard');
    }

    /**
     * set app name
     * 
     */
    public static function appName(): string
    {
        return (string) self::APP_NAME;
    }

    /**
     * application product attributes
     * 
     */
    public static function productIdAliases(string $name): string
    {
        $realId = self::$productId;
        $result = false;

        switch ($name){

            case $realId:
                $result = true;
                break;

            case 'product_id':
                $result = true;
                break;

            case 'productId':
                $result = true;
                break;
            
            default:
                $result = false;
                break;

        }

        $return = $result ? $realId : $name;
        return (string) $return;
    }

    /**
     * Shuffle code
     * 
     */
    private static string $shuffle = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";

    /**
     * SHUFFLE CODE
     * 
     */
    private static function shuffle_code(int $length = 32, bool $isLowercase = true): string
    {
        $length = (int) $length;
        $length = $length < 10 || $length > 32 ? 32 : $length;
        $unique = substr(str_shuffle(str_repeat(self::$shuffle, mt_rand(1, $length))), 1, $length);
        return $isLowercase ? strtolower($unique) : $unique;
    }

    /**
     * Get Shuffle Code (Random)
     * Via Static Method
     * 
     */
    public static function random(int $length = 32, bool $isLowercase = true): string
    {
        return self::shuffle_code($length);
    }
}
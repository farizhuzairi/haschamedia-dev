<?php

namespace HaschaDev\Database;

use Carbon\Carbon;
use HaschaDev\Support\Config;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait TimestampModel
{
    public function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value) => Carbon::parse($value)->timezone(Config::set()->userTimezone())->format('d-m-Y H:i:s')
        );
    }


    public function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value) => Carbon::parse($value)->timezone(Config::set()->userTimezone())->format('d-m-Y H:i:s')
        );
    }
}
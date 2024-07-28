<?php

namespace HaschaDev\Models\Production;

use Publisher\Fundamentals\Config\DBConnect;
use HaschaDev\Enums\Periodically;
use HaschaDev\Database\TimestampModel;
use Illuminate\Database\Eloquent\Model;
use HaschaDev\Models\Production\ServicePackage;
use HaschaDev\Database\Abstracts\Modelable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use HaschaDev\Production\Package\Priceable\PeriodeState;

class ServicePackagePrice extends Model implements Modelable
{
    use SoftDeletes, TimestampModel;
    
    protected $fillable = [
        'service_package_id',
        'price',
        'currency',
        'period',
        'min_order_based_on_period'
    ];

    protected $connection = DBConnect::PRODUCTION->value;
    protected $table = 'service_package_prices';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    /**
     * appends
     * 
     */
    protected $appends = [
        'price_format',
        'price_format_idr',
        'periodically'
    ];

    /**
     * mutators
     * 
     */
    protected function price(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => str_replace('.', '', $value)
        );
    }

    /**
     * set mutator
     * append to price_format
     * 
     */
    protected function priceFormat(): Attribute
    {
        return new Attribute(
            get: fn() => number_format(str_replace('.', '', $this->price), 0, ',', '.')
        );
    }

    /**
     * set mutator
     * append to price_format_idr
     * 
     */
    protected function priceFormatIdr(): Attribute
    {
        return new Attribute(
            get: fn() => 'Rp ' . number_format(str_replace('.', '', $this->price), 0, ',', '.')
        );
    }

    /**
     * set mutator
     * append to periodically
     * 
     */
    protected function periodically(): Attribute
    {
        return new Attribute(
            get: fn() => PeriodeState::getPeriod($this->period)
        );
    }

    /**
     * relation to Service Package
     * 
     */
    protected function servicePackage(): BelongsTo
    {
        return $this->belongsTo(ServicePackage::class, 'service_package_id', 'id');
    }
}

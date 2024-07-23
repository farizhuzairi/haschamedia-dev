<?php

namespace HaschaDev\Http\Controllers\Product;

use HaschaDev\Dev;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use HaschaDev\Services\Page\Routerable;
use HaschaDev\Production\Package\PackageFactory;
use HaschaDev\Production\Service\ServiceFactory;

class PackageController extends Controller
{
    public function index(
        PackageFactory $factory,
        string $productId,
    ): View|RedirectResponse
    {
        try {
            $db = $factory->getByProduct($productId);
            if(! $db || ! isset($db['packages']) || ! isset($db['product'])){
                throw new \Exception("Error Processing Request: data Paket Layanan tidak ditemukan.");
            }

            $product = $db['product'];
            $packages = $db['packages'];
            
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect(Routerable::DASHBOARD->url());
        }
        
        return view('service-package.index', [
            'product' => $product,
            'packages' => $packages
        ]);
    }

    public function create(
        ServiceFactory $serviceFactory,
        string $productId,
        string $serviceId
    ): View|RedirectResponse
    {
        try {
            $service = $serviceFactory->find($serviceId);
            if(! $service || ! isset($service['product']['id'])){
                throw new \Exception("Error Processing Request: data Layanan tidak ditemukan.");
            }
    
            $product = $service['product'];
            if(! $product || $productId != $product['id']){
                throw new \Exception("Error Processing Request: data Produk tidak ditemukan.");
            }
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect(Routerable::DASHBOARD->url());
        }
        
        return view('service-package.create', [
            'product' => $product,
            'service' => $service,
        ]);
    }

    public function manage(
        PackageFactory $factory,
        string $productId,
        string $packageId
    ): View|RedirectResponse
    {
        try {
            $package = $factory->find($packageId);
            if(! $package || ! isset($package['product']['id'])){
                throw new \Exception("Error Processing Request: data Paket Layanan tidak ditemukan.");
            }
            if($productId != $package['product']['id']){
                throw new \Exception("Error Processing Request: data Produk tidak ditemukan.");
            }
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect(Routerable::DASHBOARD->url());
        }
        
        return view('service-package.manage', [
            'package' => $package,
            'product' => $package['product']
        ]);
    }
}

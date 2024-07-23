<?php

namespace HaschaDev\Http\Controllers\Product;

use HaschaDev\Dev;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use HaschaDev\Services\Page\Routerable;
use HaschaDev\Production\Product\ProductFactory;
use HaschaDev\Production\Service\ServiceFactory;

class ServiceController extends Controller
{
    // public function index(
    //     ServiceFactory $factory,
    //     ProductFactory $productFactory,
    //     string $productId
    // ): View|RedirectResponse
    // {
    //     try {
    //         $services = $factory->getWhere(['productId' => $productId]);
    //         $product = $services ? $services[0]['product'] : $productFactory->find($productId);
    //         if(! $product){
    //             throw new \Exception("Invalid Processing Request: data produk tidak ditemukan.");
    //         }
    //     } catch (\Throwable $th) {
    //         Log::error($th);
    //         return redirect(Routerable::DASHBOARD->url());
    //     }
        
    //     return view('service.index', [
    //         'product' => $product,
    //         'services' => $services
    //     ]);
    // }

    public function create(
        Dev $dev,
        ServiceFactory $factory,
        ProductFactory $productFactory,
        string $productId,
        string $key
    ): View|RedirectResponse
    {
        try {
            if(! $factory->hasLiveSession($key)){
                throw new \Exception("Invalid session");
            }
    
            $dev->setDataTemps(['key' => $key]);
            $product = $productFactory->find($productId);
            if(! $product){
                throw new \Exception("Invalid Product Id");
            }
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect(Routerable::DASHBOARD->url());
        }
        
        return view('service.create', [
            'product' => $product,
        ]);
    }

    public function manage(
        ServiceFactory $factory,
        string $productId,
        string $serviceId
    ): View|RedirectResponse
    {
        try {
            $service = $factory->find($serviceId);
            if(! $service || ! isset($service['product']['id'])){
                throw new \Exception("Error Processing Request: data Layanan tidak ditemukan.");
            }
            if($productId != $service['product']['id']){
                throw new \Exception("Error Processing Request: data Produk tidak ditemukan.");
            }
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect(Routerable::PRODUCT->url($productId));
        }
        
        return view('service.manage', [
            'service' => $service,
            'product' => $service['product']
        ]);
    }
}

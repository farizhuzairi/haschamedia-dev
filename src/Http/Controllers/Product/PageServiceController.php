<?php

namespace HaschaDev\Http\Controllers\Product;

use HaschaDev\Dev;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use HaschaDev\Services\Page\Routerable;
use HaschaDev\Production\Service\ServiceFactory;
use HaschaDev\Production\PageService\PageServiceFactory;

class PageServiceController extends Controller
{
    public function create(
        Dev $dev,
        PageServiceFactory $factory,
        ServiceFactory $serviceFactory,
        string $productId,
        string $serviceId,
        string $key
    ): View|RedirectResponse
    {
        try {
            if(! $factory->hasLiveSession($key)){
                throw new \Exception("Invalid session");
            }
    
            $dev->setDataTemps(['key' => $key]);
            $service = $serviceFactory->find($serviceId);
            if(! $service || ! isset($service['product']['id'])){
                throw new \Exception("Error Processing Request: data Layanan tidak ditemukan.");
            }
            if($productId != $service['product']['id']){
                throw new \Exception("Error Processing Request: data Produk tidak ditemukan.");
            }
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect(Routerable::DASHBOARD->url());
        }
        
        return view('service.page.create', [
            'product' => $service['product'],
            'service' => $service,
        ]);
    }

    public function manage(
        PageServiceFactory $factory,
        ServiceFactory $serviceFactory,
        string $productId,
        string $serviceId,
        string $pageServiceId,
    ): View|RedirectResponse
    {
        try {
            $pageService = $factory->find($pageServiceId);
            if(! $pageService){
                throw new \Exception("Error Processing Request: data Layanan tidak ditemukan.");
            }

            $service = $serviceFactory->find($serviceId);
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
        
        return view('service.page.manage', [
            'service' => $service,
            'product' => $service['product'],
            'pageService' => $pageService
        ]);
    }
}

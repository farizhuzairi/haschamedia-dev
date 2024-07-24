<?php

namespace HaschaDev\Http\Controllers\Product;

use HaschaDev\Dev;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use HaschaDev\Services\Page\Routerable;
use HaschaDev\Production\PageFeature\PageFeatureFactory;
use HaschaDev\Production\PageService\PageServiceFactory;

class PageFeatureController extends Controller
{
    public function create(
        Dev $dev,
        PageFeatureFactory $factory,
        PageServiceFactory $pageServiceFactory,
        string $productId,
        string $pageServiceId,
        string $key
    ): View|RedirectResponse
    {
        try {
            if(! $factory->hasLiveSession($key)){
                throw new \Exception("Invalid session");
            }

            $dev->setDataTemps(['key' => $key]);
            $pageService = $pageServiceFactory->find($pageServiceId);

            if(! $pageService || ! isset($pageService['service']['id']) || ! isset($pageService['product']['id'])){
                throw new \Exception("Error Processing Request: data Layanan tidak ditemukan.");
            }

            $service = $pageService['service'];
            $product = $pageService['product'];
            
            if($productId != $product['id']){
                throw new \Exception("Error Processing Request: data Produk tidak ditemukan.");
            }
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect(Routerable::DASHBOARD->url());
        }
        
        return view('service.page.feature.create', [
            'product' => $service['product'],
            'service' => $service,
            'pageService' => $pageService,
        ]);
    }
}

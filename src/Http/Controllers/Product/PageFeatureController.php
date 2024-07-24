<?php

namespace HaschaDev\Http\Controllers\Product;

use HaschaDev\Dev;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use HaschaDev\Services\Page\Routerable;
use HaschaDev\Production\PageFeature\PageFeatureFactory;

class PageFeatureController extends Controller
{
    public function create(
        Dev $dev,
        PageFeatureFactory $factory,
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
            $pageService = $factory->find($pageServiceId);
            if(! $pageService || ! isset($pageService['service']['id']) || ! isset($pageService['service']['product']['id'])){
                throw new \Exception("Error Processing Request: data Layanan tidak ditemukan.");
            }

            $service = $pageService['service'];
            $product = $service['product'];
            if($productId != $product['id']){
                throw new \Exception("Error Processing Request: data Produk tidak ditemukan.");
            }
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect(Routerable::DASHBOARD->url());
        }
        
        return view('service.page.create', [
            'product' => $service['product'],
            'service' => $service,
            'pageService' => $pageService,
        ]);
    }
}

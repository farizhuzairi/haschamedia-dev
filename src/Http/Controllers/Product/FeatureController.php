<?php

namespace HaschaDev\Http\Controllers\Product;

use HaschaDev\Dev;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use HaschaDev\Services\Page\Routerable;
use HaschaDev\Production\Feature\FeatureFactory;
use HaschaDev\Production\Product\ProductFactory;

class FeatureController extends Controller
{
    public function index(
        FeatureFactory $factory,
        ProductFactory $productFactory,
        string $productId
    ): View|RedirectResponse
    {
        try {
            $features = $factory->getWhere(['productId' => $productId]);
            $product = $features ? $features[0]['product'] : $productFactory->find($productId);
            if(! $product){
                throw new \Exception("Invalid Processing Request: data produk tidak ditemukan.");
            }
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect(Routerable::DASHBOARD->url());
        }
        
        return view('feature.index', [
            'product' => $product,
            'features' => $features
        ]);
    }

    public function create(
        Dev $dev,
        FeatureFactory $factory,
        ProductFactory $productFactory,
        string $productId,
        string $key
    ): View|RedirectResponse
    {
        try {
            if(! $factory->hasLiveSession($key)){
                throw new \Exception("Invalid session key.");
            }
    
            $dev->setDataTemps(['key' => $key]);
            $product = $productFactory->find($productId);
            if(! $product){
                throw new \Exception("Error Processing Request: data produk tidak ditemukan.");
            }
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect(Routerable::DASHBOARD->url());
        }
        
        return view('feature.create', [
            'product' => $product,
        ]);
    }

    public function manage(
        FeatureFactory $factory,
        string $productId,
        string $featureId
    ): View|RedirectResponse
    {
        try {
            $feature = $factory->find($featureId);
            if(! $feature){
                throw new \Exception("Error Processing Request: data Feature tidak ditemukan.");
                if($productId !== $feature['product']['id']){
                    throw new \Exception("Error Processing Request: data produk tidak ditemukan.");
                }
            }
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect(Routerable::FEATURE->url($productId));
        }
        
        return view('feature.manage', [
            'feature' => $feature,
            'product' => $feature['product']
        ]);
    }
}

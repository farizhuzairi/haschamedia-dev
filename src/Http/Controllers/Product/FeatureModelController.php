<?php

namespace HaschaDev\Http\Controllers\Product;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use HaschaDev\Services\Page\Routerable;
use HaschaDev\Production\Product\ProductFactory;
use HaschaDev\Production\Model\FeatureModelFactory;

class FeatureModelController extends Controller
{
    public function index(
        FeatureModelFactory $factory,
        ProductFactory $productFactory,
        string $productId
    ): View|RedirectResponse
    {
        $models = $factory->getWhere(['productId' => $productId]);
        $product = $models ? $models[0]['product'] : $productFactory->find($productId);
        if(! $product){
            return redirect(Routerable::DASHBOARD->url());
        }

        return view('feature-model.index', [
            'product' => $product,
            'models' => $models
        ]);
    }

    public function manage(
        FeatureModelFactory $factory,
        string $productId,
        string $featureModelId
    ): View|RedirectResponse
    {
        $model = $factory->find($featureModelId);
        if(! $model){
            return redirect(Routerable::MODEL->url($productId));
        }
        
        return view('feature-model.manage', [
            'model' => $model,
            'product' => $model['product']
        ]);
    }
}

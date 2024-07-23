<?php

namespace HaschaDev\Http\Controllers\Product;

use HaschaDev\Dev;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use HaschaDev\Services\Page\Routerable;
use HaschaDev\Production\Rule\RuleFactory;
use HaschaDev\Production\Product\ProductFactory;

class FeatureRuleController extends Controller
{
    public function index(
        RuleFactory $factory,
        string $productId
    ): View|RedirectResponse
    {
        try {
            $db = $factory->getByProduct($productId);
            if(! $db){
                throw new \Exception("Invalid Processing Request: data produk tidak ditemukan.");
            }
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect(Routerable::DASHBOARD->url());
        }

        return view('feature-rule.index', [
            'product' => $db['product'],
            'rules' => $db['rules']
        ]);
    }

    public function create(
        Dev $dev,
        RuleFactory $factory,
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
        
        return view('feature-rule.create', [
            'product' => $product,
        ]);
    }

    public function manage(
        RuleFactory $factory,
        string $productId,
        string $ruleId
    ): View|RedirectResponse
    {
        try {
            $rule = $factory->find($ruleId);
            if(! $rule || ! isset($rule['product']['id'])){
                throw new \Exception("Error Processing Request: data Feature Rule tidak ditemukan.");
            }
            if($productId != $rule['product']['id']){
                throw new \Exception("Error Processing Request: data produk tidak ditemukan.");
            }
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect(Routerable::RULE->url($productId));
        }
        
        return view('feature-rule.manage', [
            'rule' => $rule,
            'product' => $rule['product']
        ]);
    }
}

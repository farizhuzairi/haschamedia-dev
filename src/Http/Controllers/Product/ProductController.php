<?php

namespace HaschaDev\Http\Controllers\Product;

use HaschaDev\Dev;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use HaschaDev\Services\Page\Routerable;
use HaschaDev\Production\Product\ProductFactory;

class ProductController extends Controller
{
    public function index(ProductFactory $factory): View
    {
        return view('product.index', [
            'products' => $factory->get()
        ]);
    }

    public function create(Dev $dev, ProductFactory $factory, string $key): View|RedirectResponse
    {
        if(! $factory->hasLiveSession($key)){
            throw new \Exception("Invalid session");
        }
        $dev->setDataTemps(['key' => $key]);
        return view('product.create');
    }

    public function manage(ProductFactory $factory, string $productId): View|RedirectResponse
    {
        $product = $factory->find($productId);
        if(! $product){
            return redirect(Routerable::PRODUCT->url());
        }

        return view('product.manage', [
            'product' => $product
        ]);
    }
}

<?php

namespace HaschaDev\Contracts\Page;

use HaschaDev\Contracts\Page\Pageable;
use HaschaDev\Services\Page\Routerable;

trait LayoutRouting
{
    protected Routerable $routerable;
    protected array $data;
    public string $title = '';
    public string $subTitle = '';

    public function __construct(Pageable $pageable)
    {
        if(!empty($pageable->routerable())) $this->setPageData($pageable);
    }

    protected function setPageData(Pageable $pageable): void
    {
        try {
            if($pageable){
                $this->routerable = $pageable->routerable();
                $this->data = [
                    'route' => $pageable->route,
                    'url' => $pageable->url_request,
                    'title' => $pageable->title,
                    'name' => $pageable->name,
                    'tagline' => $pageable->tagline,
                    'description' => $pageable->description
                ];
                $this->title = $this->data['name'];
                $this->subTitle = $this->data['title'];
            }
        } catch (\Throwable $th) {
            throw new \Exception("Halaman tidak valid. Data Objek dalam Pageable::class belum diinisiasi dengan benar. error_in_PHP_class: " . __CLASS__);
        }
    }
}
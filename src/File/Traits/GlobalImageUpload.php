<?php

namespace HaschaDev\File\Traits;

use HaschaDev\File\Media\Media;
use HaschaDev\File\Media\Imageable;

trait GlobalImageUpload
{
    /**
     * image uploading
     * add new media with attribute requires
     * 
     */
    public function imageUpload(
        string|int $id,
        string $title,
        Imageable $imageable,
        object $root
    ): Media
    {
        $upload = new Media(
            id: $id,
            title: $title,
            imageable: $imageable,
            root: $root
        );
        $upload->upload();

        return $upload;
    }
}
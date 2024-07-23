<?php

namespace HaschaDev\File\Database;

use HaschaDev\File\Media\Media;
use HaschaDev\File\Media\Imageable;

trait WithFileMediaLabel
{
    /**
     * 
     */
    public function logo(): string
    {
        return $this->fileMedia($this->id, self::LOGO_MEDIA);
    }

    /**
     * instance Media
     * FileMedia
     * 
     */
    private function fileMedia(string $id, Imageable $imageable): string
    {
        $fileMedia = new Media($id, $imageable);
        return $fileMedia->firstWhereImageable();
    }
}
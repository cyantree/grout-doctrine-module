<?php
namespace Grout\Cyantree\DoctrineModule\Types;

use Doctrine\Common\Cache\FilesystemCache;

class SimplifiedFilesystemCache extends FilesystemCache
{
    protected $extension = '.cache';

    protected function getFilename($id)
    {
        $id = sha1($id);
        $id = chunk_split(substr($id, 0, 12), 3, DIRECTORY_SEPARATOR) . substr($id, 12);
        return $this->directory . DIRECTORY_SEPARATOR . $id . $this->extension;
    }
}

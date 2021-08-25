<?php


namespace App\Service;


use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    private $targetDirectory;
    private $slugger;

    public function __construct($targetDirectory, SluggerInterface $slugger)
    {
        $this->targetDirectory = $targetDirectory;
        $this->slugger = $slugger;
    }

    public function upload(UploadedFile $file)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        try {
            $file->move($this->getTargetDirectory(), $fileName);
        } catch (FileException $e) {
            echo $e;
        }

        return $fileName;
    }

    public function remove(string $fileName)
    {
        $fileSystem = new Filesystem();
        $file = $this->getTargetDirectory() . '/' . $fileName;
        try {
            $fileSystem->remove($file);
        } catch (Exception $e) {
            echo $e;
        }
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}
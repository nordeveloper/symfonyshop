<?php
// src/Service/FileUploader.php
namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class FileUploader
{
    
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }    

    public function upload($file)
    {  
        $fileName = md5( uniqid().time() ).'.'.$file->guessExtension() ;
        $uploadPath = $this->params->get('upload_folder');
        $filePath = $uploadPath.$fileName;
        $file->move($this->params->get('upload_path').$this->params->get('upload_folder'), $fileName);
   
        return $filePath;
    }

}
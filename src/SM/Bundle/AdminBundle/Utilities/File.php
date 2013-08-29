<?php
namespace SM\Bundle\AdminBundle\Utilities;

class File
{
    /**
     * create file
     * @param type $content
     * @param type $path
     * @return string
     */
    public static function createFileByContent($content = '', $path = '')
    {
        $orginalFile = uniqid() . ".xml";
        $fileName = $path . '/' . $orginalFile;
        $fileHandle = fopen($fileName, 'w') or die("can't open file");
        file_put_contents($fileName, $content);
        fclose($fileHandle);
        return $orginalFile;
    }

    /**
     * Edit content of the fileName
     * @param type $content
     * @param type $fileName
     */
    public static function editFileByContent($content = '', $fileName = '')
    {
        $fileHandle = fopen($fileName, 'w') or die("can't open file");
        file_put_contents($fileName, $content);
        fclose($fileHandle);
    }

    /**
     * delete images
     *
     * @param string $fileName
     */
    public static function deleteImages($fileName = '')
    {
        if (!empty($fileName)) {
            $container = \SM\Bundle\AdminBundle\SMAdminBundle::getContainer();
            $dirRoot = Utilities::getRootDir();
            
            $uploadPath = $dirRoot . $container->getParameter('upload') ;
            $thumbUploadPath = $dirRoot . $container->getParameter('thumbUpload') ;
            
            $fileImage = $uploadPath . $fileName;
            if (file_exists($fileImage)) {
                @unlink($fileImage);
            }
            $fileNameThumb = $thumbUploadPath . $fileName;
            if (file_exists($fileNameThumb)) {
                @unlink($fileNameThumb);
            }
        }
    }
}
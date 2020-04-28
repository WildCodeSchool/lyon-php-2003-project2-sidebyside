<?php


namespace App\Controller;

class UploadController extends AbstractController
{
    public static function uploadProfilImage(array $file)
    {
        $extensions = ['.png', '.jpg', '.jpeg'];
        $errors = [];
        $folder = "assets/uploads/profils/";
        $path = [];

        if (!empty($file)) {
            foreach ($file as $key => $array) {
                if (!empty($array['name'])) {
                    $extension = strrchr($array['name'], '.');
                    if (!in_array($extension, $extensions)) {
                        $errors['ext'] = "Vous devez uploader un fichier de type png, jpg, jpeg";
                    }
                    if ($array['size'] >= 1000000) {
                        $errors['size'] = "Taille du fichier trop grand";
                    }
                }
            }
            if (empty($errors)) {
                foreach ($file as $key => $array) {
                    if (!empty($array['name'])) {
                        $ext = pathinfo($array['name'], PATHINFO_EXTENSION);
                        $fileName = uniqid() . '.' . $ext;
                        move_uploaded_file($array['tmp_name'], $folder . $fileName);
                        $path[$key] = "assets/uploads/profils/$fileName";
                    }
                }
                return $path;
            }
        }
    }
}

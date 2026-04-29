<?php


class FileUploader {
    private string $targetDirectory;
    private array $allowedExtensions;
    private int $maxSize;
    private array $errors = [];
    public function __construct(
        string $targetDirectory = '../publicuploadsproducts/',
        array $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'],
        int $maxSize = 2097152
    ) {
        $this->targetDirectory = rtrim($targetDirectory, '/') . '/';
        $this->allowedExtensions = array_map('strtolower', $allowedExtensions);
        $this->maxSize = $maxSize;
    }
    public function upload(array $fileData): string|false {
        $this->errors = [];

        if ($fileData['error'] !== UPLOAD_ERR_OK) {
            $this->addErrorByCode($fileData['error']);
            return false;
        }

        
        $fileName = $fileData['name'];
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (!in_array($extension, $this->allowedExtensions)) {
            $this->errors[] = "Extension de fichier non autorisée : " . $extension;
            return false;
        }

        if ($fileData['size'] > $this->maxSize) {
            $this->errors[] = "Le fichier est trop lourd. Max autorisé : " . ($this->maxSize / 1024 / 1024) . " Mo.";
            return false;
        }

        if (!is_dir($this->targetDirectory)) {
            $this->errors[] = "Le dossier de destination est inaccessible";
            return false;
        }

        $newFileName = uniqid('file_', true) . '.' . $extension;
        $destination = $this->targetDirectory . $newFileName;

        if (move_uploaded_file($fileData['tmp_name'], $destination)) {
            return $newFileName;
        }

        $this->errors[] = "Erreur interne lors du déplacement du fichier.";
        return false;
    }

    public function getErrors(): array {
        return $this->errors;
    }

  
    private function addErrorByCode(int $errorCode): void {
        switch ($errorCode) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $this->errors[] = "Le fichier dépasse la taille limite autorisée.";
                break;
            case UPLOAD_ERR_PARTIAL:
                $this->errors[] = "Le fichier n'a été que partiellement téléchargé.";
                break;
            case UPLOAD_ERR_NO_FILE:
                $this->errors[] = "Aucun fichier n'a été téléchargé.";
                break;
            default:
                $this->errors[] = "Une erreur inconnue est survenue lors de l'upload.";
                break;
        }
    }

    public function setAllowedExtensions(array $extensions): void {
        $this->allowedExtensions = array_map('strtolower', $extensions);
    }
    public function setMaxSize(int $bytes): void {
        $this->maxSize = $bytes;
    }
}
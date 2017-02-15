<?php

namespace components;

class Uploader
{
    private static $_file;

    public static function construct() {
        if (isset($_FILES['file'])) {
            self::$_file = $_FILES['file'];
        }
    }

    public static function saveImage() {
        if (self::$_file) {
            // validate extensions
            $allowed = array('jpg', 'png', 'gif');
            $file_ext = explode('.', self::$_file['name']);
            $file_ext = strtolower(end($file_ext));

            if (in_array($file_ext, $allowed)) {
                if (self::$_file['error'] === 0) {
                    $image_name = uniqid('', true) . '.' . $file_ext;
                    $image_path = ROOT . '/uploads/' . $image_name;

                    // validate image size
                    list($width) = getimagesize(self::$_file['tmp_name']);
                    if ($width != 320) {
                        self::resize(self::$_file['tmp_name'], $image_path, 320, 0);
                        return $image_name;
                    } elseif (move_uploaded_file(self::$_file['tmp_name'], $image_path)) {
                        return $image_name;
                    }
                }
            }
        }

        return false;
    }

    /**
     * THANKS https://gist.github.com/janzikan/2994977
     */
    private static function resize($sourceImage, $targetImage, $maxWidth, $maxHeight, $quality = 80)
    {
        // Obtain image from given source file.
        if (!$image = @imagecreatefromjpeg($sourceImage))
        {
            return false;
        }

        // Get dimensions of source image.
        list($origWidth, $origHeight) = getimagesize($sourceImage);

        if ($maxWidth == 0)
        {
            $maxWidth  = $origWidth;
        }

        if ($maxHeight == 0)
        {
            $maxHeight = $origHeight;
        }

        // Calculate ratio of desired maximum sizes and original sizes.
        $widthRatio = $maxWidth / $origWidth;
        $heightRatio = $maxHeight / $origHeight;

        // Ratio used for calculating new image dimensions.
        $ratio = min($widthRatio, $heightRatio);

        // Calculate new image dimensions.
        $newWidth  = (int)$origWidth  * $ratio;
        $newHeight = (int)$origHeight * $ratio;

        // Create final image with new dimensions.
        $newImage = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);
        imagejpeg($newImage, $targetImage, $quality);

        // Free up the memory.
        imagedestroy($image);
        imagedestroy($newImage);

        return true;
    }

}
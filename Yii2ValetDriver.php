<?php
/* @link http://www.github.com/myomyintaung512
 * @copyright Myo Myint Aung (Juno)
 * Written by Myo Myint Aung <myomyintaung512@gmail.com>, February 2020
 */
 
class Yii2ValetDriver extends ValetDriver
{
    /**
     * Determine if the driver serves the request.
     *
     * @param  string  $sitePath
     * @param  string  $siteName
     * @param  string  $uri
     * @return bool
     */
    public function serves($sitePath, $siteName, $uri)
    {
        if (file_exists($sitePath.'/vendor/yiisoft/yii2/Yii.php')) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the incoming request is for a static file.
     *
     * @param  string  $sitePath
     * @param  string  $siteName
     * @param  string  $uri
     * @return string|false
     */
    public function isStaticFile($sitePath, $siteName, $uri)
    {
        if (file_exists($staticFilePath = $sitePath.'/web/'.$uri)) {
            return $staticFilePath;
        }

        if (file_exists($staticFilePath = $sitePath.$uri)) {
          if(!is_dir($staticFilePath))
            return $staticFilePath;
        }
        if (file_exists($staticFilePath = $sitePath.'/frontend/web/'.$uri)) {
            return $staticFilePath;
        }

        return false;
    }

    /**
     * Get the fully resolved path to the application's front controller.
     *
     * @param  string  $sitePath
     * @param  string  $siteName
     * @param  string  $uri
     * @return string
     */
    public function frontControllerPath($sitePath, $siteName, $uri)
    {
      $path = explode('/',trim($uri,'/'));
      if (file_exists($sitePath.'/web/')) {
        $_SERVER['SCRIPT_FILENAME'] = $sitePath.'/web/index.php';
        $_SERVER['SCRIPT_NAME'] = '/index.php';
        $_SERVER['PHP_SELF'] = '/index.php';
        $_SERVER['DOCUMENT_ROOT'] = $sitePath;
        return $sitePath.'/web/index.php';
      }

      if(isset($path[0]) && $path[0]=='backend'){
        if (file_exists($sitePath.'/backend/web/')) {

          $_SERVER['SCRIPT_FILENAME'] = $sitePath.'/backend/web/index.php';
          $_SERVER['SCRIPT_NAME'] = '/backend/web/index.php';
          $_SERVER['PHP_SELF'] = '/backend/web/index.php';
          $_SERVER['DOCUMENT_ROOT'] = $sitePath;
          return $sitePath.'/backend/web/index.php';
        }
      }

      if (file_exists($sitePath.'/frontend/web/')) {
        $_SERVER['SCRIPT_FILENAME'] = $sitePath.'/frontend/web/index.php';
        $_SERVER['SCRIPT_NAME'] = '/index.php';
        $_SERVER['PHP_SELF'] = '/index.php';
        $_SERVER['DOCUMENT_ROOT'] = $sitePath;
        return $sitePath.'/frontend/web/index.php';
      }

    }
}

<?php

namespace App\Core;

class App
{
   /**
    * View rendering methods
    */
   public static function View($view, $data = [])
   {
      extract($data);
      $viewPath = 'app/views/' . $view . '.php';
      
      if (file_exists($viewPath)) {
         require_once $viewPath;
      } else {
         throw new \Exception("View file '$view' not found.");
      }
   }

   public static function Component($component, $data = [])
   {
      extract($data);
      $componentPath = 'app/views/components/' . $component . '.php';
      
      if (file_exists($componentPath)) {
         require_once $componentPath;
      } else {
         throw new \Exception("Component file '$component' not found.");
      }
   }

   public static function Layout($layout, $view, $data = [])
   {
      // Menyimpan view yang akan dirender di dalam layout
      $data['content_view'] = $view;
      extract($data);
      
      $layoutPath = 'app/views/layouts/' . $layout . '.php';
      
      if (file_exists($layoutPath)) {
         require_once $layoutPath;
      } else {
         throw new \Exception("Layout file '$layout' not found.");
      }
   }
}

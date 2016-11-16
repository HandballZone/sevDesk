<?php
namespace HandballZone\sevDesk;

use Illuminate\Support\ServiceProvider;
use HandballZone\sevDesk\sevDesk;

class sevDeskServiceProvider extends ServiceProvider {
  public function register() {
    $app = $this -> app ?: app();
    
    $appVersion = method_exists($app, 'version') ? $app->version() : $app::VERSION;
    
    $laravelVersion = substr($appVersion, 0, strpos($appVersion, '.'));
    
    if($laravelVersion == 5) {
      $this -> mergeConfigFrom(__DIR__./../../config/config.php', 'sevDesk');
      
      $this -> publishes([__DIR__.'/../../config/config.php' => config_path('sevDesk.php')]);
    }
    
    $this -> app[sevDesk::class] = $this -> app -> share(function($app) {
      return new sevDesk($app['config'], $app['session.store']);
  }
  public function provides() {
    return ['sevDesk'];
  }
}
?>

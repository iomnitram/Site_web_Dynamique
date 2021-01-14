<?php
namespace MBFram;
 
class Page extends ApplicationComponent
{
  protected $layoutFile;
  protected $contentFile;
  protected $stylesheets = [];
  protected $scripts = [];
  protected $vars = [];
  protected $contentForced;
  
  public function addScript($script)
  {
    if(is_string($script) && !empty($script))
      array_push($this->scripts, $script);
    else if(is_array($script))
      $this->scripts = array_merge($this->scripts,$script);
    else
    {
      throw new \InvalidArgumentException('Le script n\'est pas valide');
    }
  }
  public function clearScriptt()
  {
    $this->script = [];
  }

  public function addStylesheet($stylesheet)
  {
    if(is_string($stylesheet) && !empty($stylesheet))
      array_push($this->stylesheets, $stylesheet);
    else if(is_array($stylesheet))
      $this->stylesheets = array_merge($this->stylesheets,$stylesheet);
    else
    {
      throw new \InvalidArgumentException('Le stylesheet n\'est pas valide');
    }
  }
  public function clearStylesheet()
  {
    $this->stylesheets = [];
  }

  public function removeStylesheet($stylesheet)
  {
    $pos = array_search($stylesheet, $this->stylesheets);
    if($pos != false)
      array_splice($this->stylesheets, $pos ,1);
  }

  public function addVar($var, $value)
  {
    if (!is_string($var) || is_numeric($var) || empty($var))
    {
      throw new \InvalidArgumentException('Le nom de la variable doit être une chaine de caractères non nulle');
    }
 
    $this->vars[$var] = $value;
  }
 
  public function getGeneratedPage()
  {
    if (!file_exists($this->contentFile) && $this->contentForced == null)
    {
      throw new \RuntimeException('La vue spécifiée n\'existe pas');
    }
    if (!file_exists($this->layoutFile))
    {
      throw new \RuntimeException('Le layout spécifié n\'existe pas');
    }
  
    $user = $this->app->user();
    $stylesheet = $this->generateStylesheet();
    $script = $this->generateScript();
    extract($this->vars);
 
    if($this->contentForced == null)
    {
      ob_start();
      require $this->contentFile;
      $content = ob_get_clean();
    }
    else
      $content = $this->contentForced;

    ob_start();
      require $this->layoutFile;
    return ob_get_clean();
  }
 
  public function setContentFile($contentFile)
  {
    if (!is_string($contentFile) || empty($contentFile))
    {
      throw new \InvalidArgumentException('La vue spécifiée est invalide');
    }
 
    $this->contentFile = $contentFile;
  }

  public function setLayoutFile($layoutFile)
  {
    if (!is_string($layoutFile) || empty($layoutFile))
    {
      throw new \InvalidArgumentException('Le layout spécifié est invalide');
    }
 
    $this->layoutFile = $layoutFile;
  }

  protected function generateStylesheet()
  {
    $stylesheet = "";
    if(is_array($this->stylesheets))
    {
      foreach ($this->stylesheets as $ss)
      {
        $stylesheet .= '<link rel="stylesheet" href="/css/' . $ss . '.css" type="text/css" />';
      }
    }
    return $stylesheet;
  }

  protected function generateScript()
  {
    $script = "";
    if(is_array($this->scripts))
    {
      foreach ($this->scripts as $ss)
      {
        $script .= '<script src="/js/' . $ss . '.js"></script>';
      }
    }
    return $script;
  }

  public function forceContent($content)
  {
    $this->contentForced = $content;
  }
}
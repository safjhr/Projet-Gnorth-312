<?php declare(strict_types=1);

namespace Framework312\Template;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigRenderer implements Renderer {
    // propriété privée sur le chemin des templates
    private string $TempPath;
    // pour gérer le chargement des templates
    private FilesystemLoader $loader;
    // instance de l'environnement Twig
    private Environment $twig;

    // constructeur qui initialise le loader et l'environnement Twig
    public function __construct(string $TempPath)
    {
        $this->TempPath = $TempPath;
        $this->loader = new FilesystemLoader($this->TempPath);
        $this->twig = new Environment($this->loader);
        $this->loader->addPath($this->TempPath, '@templates');
        
    }

    // méthode pour rendre un template avec des données
    public function render(mixed $data, string $template): string{
       return $this->twig->render($template, $data ?? []);

    }

    // méthode pour enregistrer un nouveau chemin de template avec un tag
    public function register(string $tag){
        $path = rtrim($this->TempPath, '/'). '/'.$tag;
        $this->loader->addPath($path,'@'.$tag);

    }

    
}


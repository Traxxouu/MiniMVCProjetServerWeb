<?php
// Active le mode strict pour les types
declare(strict_types=1);
// Espace de noms du noyau
namespace Mini\Core;
// Déclare le routeur HTTP minimaliste
final class Router
{
    // Tableau des routes : [méthode, chemin, [ClasseContrôleur, action]]
    /** @var array<int, array{0:string,1:string,2:array{0:class-string,1:string}} > */
    private array $routes;
    
    // Base path pour les sous-dossiers
    private string $basePath;

    /**
     * Initialise le routeur avec les routes configurées
     * @param array<int, array{0:string,1:string,2:array{0:class-string,1:string}} > $routes
     * @param string $basePath Le chemin de base (ex: '/mini_mvc/public')
     */
    public function __construct(array $routes, string $basePath = '')
    {
        // Mémorise les routes fournies
        $this->routes = $routes;
        $this->basePath = rtrim($basePath, '/');
    }

    // Dirige la requête vers le bon contrôleur en fonction méthode/URI
    public function dispatch(string $method, string $uri): void
    {
        // Extrait uniquement le chemin de l'URI
        $path = parse_url($uri, PHP_URL_PATH) ?? '/';
        
        // Enlève le base path du chemin
        if ($this->basePath !== '' && str_starts_with($path, $this->basePath)) {
            $path = substr($path, strlen($this->basePath));
        }
        
        // Si le path est vide après suppression du basePath, c'est la racine
        if ($path === '' || $path === false) {
            $path = '/';
        }

        // Parcourt chaque route enregistrée
        foreach ($this->routes as [$routeMethod, $routePath, $handler]) {
            // Vérifie correspondance stricte de méthode et de chemin
            if ($method === $routeMethod && $path === $routePath) {
                // Déstructure le gestionnaire en [classe, action]
                [$class, $action] = $handler;
                // Instancie le contrôleur cible
                $controller = new $class();
                // Appelle l'action sur le contrôleur
                $controller->$action();
                return;
            }
        }

        // Si aucune route ne correspond, renvoie un 404 minimaliste
        http_response_code(404);
        echo '404 Not Found';
    }
}
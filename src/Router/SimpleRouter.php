<?php declare(strict_types=1);

namespace Framework312\Router;

use Framework312\Router\Exception as RouterException;
use Framework312\Template\Renderer;
use Symfony\Component\HttpFoundation\Response;

class Route {
    private const VIEW_CLASS = 'Framework312\Router\View\BaseView';
    private const VIEW_USE_TEMPLATE_FUNC = 'use_template';
    private const VIEW_RENDER_FUNC = 'render';

    private string $view;

    public function __construct(string|object $class_or_view) {
        $reflect = new \ReflectionClass($class_or_view);
        $view = $reflect->getName();
        if (!$reflect->isSubclassOf(self::VIEW_CLASS)) {
            throw new RouterException\InvalidViewImplementation($view);
        }
        $this->view = $view;
    }

    public function call(Request $request, ?Renderer $engine): Response {
	    // TODO
    }
}

class SimpleRouter implements Router {
    private Renderer $engine;

    // constructeur qui initialise le moteur de rendu et les routes
    public function __construct(Renderer $engine) {
        $this->engine = $engine;
        $this->routes = [];
        
    }

    public function register(string $path, string|object $class_or_view) {
	    // TODO
    }

public function serve(mixed ...$args): void {

    $request = ($args[0] ?? null) instanceof Request 
        ? $args[0] 
        : Request::createFromGlobals();

    $path = $request->getPathInfo();

    if (isset($this->routes[$path])) {
        $route = $this->routes[$path];
        
        try {

            $htmlContent = $route->call($request, $this->engine);

            $view = new HTMLView();
            
            $viewData = is_array($htmlContent) ? $htmlContent : [$htmlContent];
            
            $response = $view->display($viewData);

        } catch (\Exception $e) {
            $response = new Response("Erreur serveur : " . $e->getMessage(), 500);
        }

    } else {
        $response = new Response("Page non trouvée", 404);
    }

    $response->send();
}
}

?>

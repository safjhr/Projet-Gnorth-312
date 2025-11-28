<?php declare(strict_types=1);

namespace Framework312\Router\View;

use Framework312\Router\Exception as RouterException;
use Framework312\Router\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class JSONView extends BaseView {
    static public function use_template(): bool { return false; }

    public function render(Request $request): Response {
        $method = strtolower($request->getMethod() ?: 'GET');

        if (!method_exists($this, $method)) {
            throw new RouterException\HttpMethodNotImplemented(static::class, strtoupper($method));
        }

        $data = $this->$method($request);

        if ($data instanceof Response) {
            return $data;
        }

        try {
            $payload = json_encode($data, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            return new Response(json_encode(['error' => 'Unable to encode JSON']), Response::HTTP_INTERNAL_SERVER_ERROR, ['Content-Type' => 'application/json']);
        }

        return new Response($payload, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
}

?>

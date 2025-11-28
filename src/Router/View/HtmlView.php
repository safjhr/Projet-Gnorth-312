<?php

namespace App\View;

use Symfony\Component\HttpFoundation\Response;

class HtmlView extends BaseView
{
    protected function use_template(): void { }    

    protected function render(mixed $data): Response
    {
        $content = $data;

        if (is_array($data)) {
            $content = reset($data);
        }
        $contentString = (string) $content;

        $response = new Response(
            $contentString,
            Response::HTTP_OK,
            ['Content-Type' => 'text/html'] 
        );

        return $response;
    }
}

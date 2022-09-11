<?php

namespace LifeSpikes\SSRExample;

use DOMNode;
use DOMElement;
use DOMDocument;
use DOMException;

class App
{
    protected DOMDocument $dom;

    public function __construct()
    {
        $this->dom = new DOMDocument();
        $this->dom->formatOutput = true;
    }

    /**
     * @throws DOMException
     */
    public function boot(): bool|string
    {
        $this->bootstrap();
        return $this->dom->saveHTML();
    }

    /**
     * @throws DOMException
     */
    private function bootstrap(): void
    {
        $div = $this->dom->createElement('div');
        $div->setAttribute('id', 'app');

        $script = $this->dom->createElement('script');
        $script->setAttribute('src', '/dist/App.js');

        $this->dom->append($div, $script);
    }
}

<?php

namespace PDF\Contracts;

interface PDFLogicInterface
{
    public function setHtml(?string $html): self;

    public function setConfig(?array $config): self;

    public function render();

    public function download(string $path, string $pdfName);
}

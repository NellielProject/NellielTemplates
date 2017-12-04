<?php

namespace NellielTemplates;

class NellielDOMDocument extends \DOMDocument
{
    private $escaper_instance;
    private $render_instance;
    private $template_instance;
    private $template;

    function __construct($render_instance = null)
    {
        parent::__construct();
        $this->render_instance = $render_instance;
        $this->template_instance = $render_instance->getTemplateInstance();
        $this->escaper_instance = new NellielEscaper();
        $this->registerNodeClass('DOMDocument', 'NellielTemplates\NellielDOMDocument');
        $this->registerNodeClass('DOMElement', 'NellielTemplates\NellielDOMElement');
        $this->formatOutput = true;
        $this->strictErrorChecking = false;
        $this->validateOnParse = true;
    }

    public function loadTemplateFromFile($template_file)
    {
        $this->template = $template_file;
        $source = $this->template_instance->getTemplate($template_file);
        $this->loadHTML($source);
    }

    public function outputHTML()
    {
        return $this->template_instance->outputHTMLFromDom($this, $this->template);
    }

    public function createTextNode($content, $escape_type = 'html')
    {
        $this->doEscaping($content, $escape_type);
        return parent::createTextNode($content);
    }

    public function createElement($name, $value = null, $escape_type = 'html')
    {
        if(!is_null($value))
        {
            $this->doEscaping($value, $escape_type);
        }

        return parent::createElement($name, $value);
    }

    public function createElementNS($namespaceURI, $qualifiedName, $value = null, $escape_type = 'html')
    {
        if(!is_null($value))
        {
            $this->doEscaping($value, $escape_type);
        }

        return parent::createElementNS($namespaceURI, $qualifiedName, $value);
    }
}
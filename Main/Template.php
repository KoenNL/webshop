<?php

namespace Main;

use Main\Config;
use Main\Format;
use Exception;

class Template
{

    /**
     * Template name in lowercase.
     * @var string 
     */
    private $template = 'default';
    
    /**
     * Page title.
     * @var string
     */
    private $title;
    
    /**
     * Meta data.
     * @var array
     */
    private $meta = array();
    
    /**
     * A concatenated string of all inline CSS.
     * @var string
     */
    private $inline_css = '';
    
    /**
     * A concatenated string of all loaded javascript.
     * @var string
     */
    private $inline_javascript = '';

    /**
     * HTML processed header.
     * @var string
     */
    private $header;

    /**
     * HTML processed body.
     * @var string
     */
    private $body;

    /**
     * HTML processed footer
     * @var string
     */
    private $footer;

    /**
     * @var array
     */
    private $breadcrumbs = array();

    /**
     * Set the tempalte name. If not set, default is used.
     * @param string $template
     * @return \Main\Template
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Set page title.
     * @param string $title
     * @return \Main\Template
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get page title.
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Add meta data.
     * @param string $name name of the meta data.
     * @param string $value content of the meta data.
     * @return \Main\Template
     */
    public function addMeta($name, $value)
    {
        $this->meta[$name] = $value;

        return $this;
    }

    /**
     * Get the meta data.
     * @param boolean $process true to process to HTML, false to return array. True by default.
     * @return string
     */
    public function getMeta($process = true)
    {
        if ($process) {
            $meta = '';
            foreach ($this->meta as $name => $value) {
                $meta .= '<meta name="' . $name . '" content="' . $value . '">' . "\r";
            }
            return $meta;
        }

        return $this->meta;
    }

    /**
     * Add custom CSS code.
     * @param sctring $css
     * @return \Main\Template
     */
    public function addInlineCss($css)
    {
        $this->inline_css .= Format::minifi($css);

        return $this;
    }

    /**
     * Get all of the CSS as one concatenated string.
     * @return string the concatenated CSS.
     */
    public function getCss()
    {
        return $this->inline_css;
    }

    /**
     * Add custom javascript code.
     * @param string $javascript
     * @return \Main\Template
     */
    public function addInlineJavascript($javascript)
    {
        $this->inline_javascript .= Format::minifi($javascript);

        return $this;
    }

    /**
     * Get all of the javascript as one concatenated string.
     * @return string the concatenated javascript.
     */
    public function getJavascript()
    {
        return $this->inline_javascript;
    }

    /**
     * Set the header content.
     * @param string $header HTML formatted header.
     * @return \Main\Template
     */
    public function setHeader($header)
    {
        $this->header = $header;

        return $this;
    }

    /**
     * Get the header.
     * @return string
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * Set the body content.
     * @param string $body HTML formatted body.
     * @return \Main\Template
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get the body.
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set the footer content.
     * @param string $footer HTML formatted footer.
     * @return \Main\Template
     */
    public function setFooter($footer)
    {
        $this->footer = $footer;

        return $this;
    }

    /**
     * Get the footer.
     * @return string
     */
    public function getFooter()
    {
        return $this->footer;
    }

    /**
     * Add a breadcrumb.
     * @param string $path
     * @param string $title
     * @return Template $this
     */
    public function addBreadcrumb($path, $title)
    {
        $this->breadcrumbs[] = array(
            'path' => $path,
            'title' => $title
        );

        return $this;
    }

    /**
     * Add an array of breadcrumbs.
     * @param array $breacrumbs
     * @return Template $this
     */
    public function setBreadcrumbs(array $breacrumbs)
    {
        foreach ($breacrumbs as $breacrumb) {
            if (empty($breacrumb['page']) || empty($breacrumb['title'])) {
                continue;
            }

            $this->addBreadcrumb($breacrumb['path'], $breacrumb['title']);
        }

        return $this;
    }

    /**
     * Get all breadcrumbs.
     * @return array
     */
    public function getBreadcrumbs()
    {
        return $this->breadcrumbs;
    }

    /**
     * Write the template.
     * @return boolean true on success, false on failure.
     * @throws Exception
     */
    public function writeTemplate()
    {
        $template_file = Config::getValue('path.base') . 'Template/' . Format::underscoreToCamelCase($this->template) . '.php';

        if (!file_exists($template_file)) {
            throw new Exception('Template ' . $template_file . ' does not exist.');
        }

        // Set template variable to use template functions inside the template.
        $template = $this;

        return require_once $template_file;
    }
}

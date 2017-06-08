<?php

namespace Main;

use SimpleXMLElement;
use Exception;

class Controller
{

    /**
     * List of available extensions
     * @var array
     */
    private $extensions = array(
        'json' => 'toJSON',
        'xml' => 'toXML',
    );

    /**
     * Currently set extension.
     * @var string
     */
    private $extension;

    /**
     * Currently set controller.
     * @var string
     */
    private $controller;

    /**
     * Currently set action.
     * @var string
     */
    private $action = 'mainIndexAction';

    /**
     * Template class.
     * @var Template
     */
    public $template;

    /**
     * Values used by the controller and view.
     * @var array
     */
    private $values = array();

    /**
     * @var string
     */
    private $language;

    public function __construct($controller, $action)
    {
        $this->controller = $controller;
        $this->action = $action;
        $this->template = new Template;
    }

    /**
     * Set the extension.
     * @param string $extension
     * @return \Main\Controller
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Default action.
     */
    public function indexAction()
    {
        $this->template->setTitle('Kore v' . Config::KORE_VERSION);

        return $this->write(array('message' => 'Welcome to the Kore framework!', 'version' => Config::KORE_VERSION));
    }

    /**
     * Not found action.
     * @param string $controller controller of the unfound action.
     * @param string $action the unfound action.
     */
    public function notFoundAction($controller, $action)
    {
        $this->write(array('controller' => $controller, 'action' => $action), 404);
    }

    /**
     * Write output.
     * @param array $values an array with all the values used for the output.
     * @param int $response_code the response code. 200 by default.
     * @return mixed
     * @throws Exception
     */
    protected function write(array $values, $response_code = 200)
    {
        http_response_code($response_code);
        if (empty($this->extension)) {
            return $this->renderTemplate($values);
        }

        if (empty($this->extensions[$this->extension])) {
            throw new Exception('Unsupported output format ' . $this->extension . ' selected.');
        }

        return $this->{$this->extensions[$this->extension]}($values);
    }

    /**
     * Render the template.
     * @param array $values an array with all values that can be used in the template.
     * @param string $view the name of the view. By default the name of the action.
     * @return boolean true on success.
     * @throws Exception
     */
    protected function renderTemplate(array $values, $view = null)
    {
        if (!$view) {
            $view = str_replace('Controller', '', $this->controller) . '/' . ucfirst($this->action);
        }

        $this->template->setBody($this->renderView($values, $view));

        return $this->template->writeTemplate();
    }

    /**
     * Process the given view and the set values and return a string with the resulting HTML.
     * @param array $values Values to use in the view.
     * @param string $view name of the view.
     * @return string processed HTML.
     * @throws Exception
     */
    protected function renderView(array $values, $view)
    {
        $this->values = $values;

        $view_file = Config::getValue('path.base') . 'View/' . $view . '.php';

        if (!file_exists($view_file)) {
            throw new Exception('View file for ' . $view . ' does not exist.');
        }

        ob_start();
        // Set controller variable so values can be accessed inside the view.
        $controller = $this;
        require $view_file;
        $body = ob_get_contents();
        ob_get_clean();

        return $body;
    }

    /**
     * Write a JSON array.
     * @param array $values an array with all the values to write as JSON array.
     */
    protected function toJSON(array $values)
    {
        header('Content-Type: application/json');
        exit(json_encode($values));
    }

    /**
     * Write an XML file.
     * @param array $values an array with all the values to write as XML file.
     * @param string $root
     */
    protected function toXML(array $values, $root = null)
    {
        header('Content-Type: application/xml');
        $xml = new SimpleXMLElement($root ? '<' . $root . '/>' : '<root/>');
        array_walk_recursive(array_flip($values), array($xml, 'addChild'));
        exit($xml->asXML());
    }

    /**
     * Get a value within a view.
     * @param string $name recursive name of the setting using "." as delimiter.
     * @return mixed
     */
    public function getValue($name)
    {
        $keys = explode('.', $name);

        $count = count($keys);
        $position = 0;

        $values = $this->values;
        foreach ($keys as $key) {
            $position++;
            if (!isset($values[$key])) {
                return null;
            }

            // Search recursively
            if ($position !== $count && is_array($values[$key])) {
                $values = $values[$key];
                continue;
            }

            return $values[$key];
        }

        return null;
    }

    /**
     * Redirect to the given controller and action.
     * @param string $controller
     * @param string $action
     */
    protected function redirect($controller, $action)
    {
        header('Location: ' . $controller . '/' . $action);
    }

    /**
     * Set the language. Will be stored in a _SESSION value.
     * @param int $language
     * @return Controller $this
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        $_SESSION['language'] = $this->language;

        return $this;
    }

    /**
     * Get the language. If no language is set it returns the _SESSION language.
     * If no _SESSION language is set it sets and returns the default language.
     * @return string
     */
    public function getLanguage()
    {
        if (!$this->language && empty($_SESSION['language'])) {
            $this->setLanguage(Config::getValue('translation.defaultLanguage'));
        } elseif (!$this->language && !empty($_SESSION['language'])) {
            $this->setLanguage($_SESSION['language']);
        }

        return $this->language;
    }
}

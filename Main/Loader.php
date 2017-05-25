<?php

namespace Main;

use Main\Config;
use Main\Format;
use Exception;

class Loader
{

    /**
     * Run the given request.
     * @param string $request the request URI.
     * @return boolean true on success.
     */
    public function run($request)
    {
        $params = explode('/', trim($request, '/'));
        
        $default_action = Config::getValue('loader.default_action') ? Config::getValue('loader.default_action') : 'index';
        
        if (empty($params[0])) {
            return $this->loadController(Config::getValue('loader.default_controller') ?
                        Config::getValue('loader.default_controller') :
                        'main', $default_action);
        }

        $controller = $params[0];
        $action = !empty($params[1]) ? $params[1] : $default_action;
        $extension = null;

        if (strpos($action, '.') !== false) {
            $action_array = explode('.', $action);
            $extension = array_pop($action_array);
            $action = implode('.', $action_array);
        }

        unset($params[0], $params[1]);

        return $this->loadController($controller, $action, array_values($params), $extension);
    }

    /**
     * Load a controller.
     * @param string $controller name of the controller in lowercase.
     * @param string $action name of the action in lowercase.
     * @param array $params an array with the parameters.
     * @param string $extension optional extension.
     * @return boolean true on success.
     * @throws Exception
     */
    private function loadController($controller, $action, array $params = array(), $extension = null)
    {
        $formatted_controller = Format::underscoreToCamelCase($controller) .'Controller';
        $formatted_action = Format::underscoreToCamelCase($action, false) . 'Action';
        $controller_class = $controller === 'main' ? 'Main\\Controller' : 'Controller\\' . $formatted_controller;

        if (!class_exists($controller_class)) {
            return $this->notFound($controller, $action);
        }

        $controller_object = new $controller_class($formatted_controller, $formatted_action);

        if ($controller !== 'main' && is_subclass_of($controller_object, 'Controller')) {
            throw new Exception('Class ' . $formatted_controller . ' is not a subclass of Main\\Controller.');
        }

        if (!method_exists($controller_object, $formatted_action)) {
            return $this->notFound($controller, $action);
        }

        $controller_object->setExtension($extension);

        return call_user_func_array(array($controller_object, $formatted_action), $params);
    }

    private function notFound($controller, $action)
    {
        return $this->loadController(Config::getValue('loader.default_controller') ?
                    Config::getValue('loader.default_controller') :
                    'main', Config::getValue('loader.not_found_action') ?
                    Config::getValue('loader.not_found_action') :
                    'not_found', array($controller, $action));
    }

    /**
     * Redirect to the given controller, action and parameters.
     * @param string $controller name of the controller in lowercase.
     * @param string $action name of the action in lowercase.
     * @param array $params an array with the parameters.
     */
    public function redirect($controller, $action, array $params = array())
    {
        header('Location: ' . Config::getValue('path.host') . '/' . $controller . '/' . $action . $params ? '/' . implode('/', $params) : '');
    }
}

<?php

namespace Controller;

use Main\Controller;

class TestController extends Controller
{
    
    public function TestAction($message = null) {
        $this->template->setTitle('Test titel');
        $this->template->addInlineCss('h1 { color: red;}');
        $this->write(array('message' => $message));
    }
    
}
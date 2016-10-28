<?php

/**
 * @package PHPmongoDB
 * @version 1.0.0
 * @link http://www.phpmongodb.org
 */
defined('PMDDA') or die('Restricted access');

class LoginController extends Controller {

    public function Index() {
        if ($this->request->isPost()) {
            if (Config::$authentication['authentication']) {
                $connectionURI = 'mongodb://';
                $username = '';
                if (strlen($this->request->getParam('username')) > 0) {
                    $username = $this->request->getParam('username');
                    if (strlen($this->request->getParam('password')) > 0) {
                        $username .= ':' . $this->request->getParam('password');
                    }
                    $connectionURI .= $username . '@';
                }

                if (isset(Config::$server['server']) && !empty(Config::$server['server'])) {
                    $connectionURI .= Config::$server['server'];
                } else {
                    $connectionURI .= Config::$server['host'] . ':' . Config::$server['port'];
                }

                if (strlen($this->request->getParam('db')) > 0) {
                    $connectionURI .= '/' . $this->request->getParam('db');
                }

                $options = array();
                $mongo = PHPMongoDB::getInstance($connectionURI, $options, Config::$driverOptions);
                if ($mongo->getConnection()) {
                    $session=Application::getInstance('Session');
                    $session->isLogedIn = TRUE;
                    $session->server=$connectionURI;
                    $session->options=$options;
                    $this->request->redirect(Theme::URL('Index/Index'));
                } else {
                    $this->message->error = $mongo->getExceptionMessage();
                }
            } else if ($this->request->getParam('username') == Config::$authentication['user'] && $this->request->getParam('password') == Config::$authentication['password']) {

                $connectionURI = 'mongodb://';
                $username = '';
                if (strlen(Config::$server['user']) > 0) {
                    $username = Config::$server['user'];
                    if (strlen(Config::$server['password']) > 0) {
                        $username .= ':' . Config::$server['password'];
                    }
                    $connectionURI .= $username . '@';
                }

                if (isset(Config::$server['server']) && !empty(Config::$server['server'])) {
                    $connectionURI .= Config::$server['server'];
                } else {
                    $connectionURI .= Config::$server['host'] . ':' . Config::$server['port'];
                }

                if (strlen(Config::$server['db']) > 0) {
                    $connectionURI .= '/' . Config::$server['db'];
                }

                $session=Application::getInstance('Session');
                $session->isLogedIn = TRUE;
                $session->server=$connectionURI;
                $session->options=array();
                $this->request->redirect(Theme::URL('Index/Index'));
            } else {
                $this->message->error = I18n::t('AUTH_FAIL');
            }
        }
        $data = array();
        $this->display('index', $data);
    }

    public function Logout() {
        Application::getInstance('Session')->destroy();
        $this->request->redirect(Theme::URL('Login/Index'));
    }

}

<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto_View
 * @subpackage  Driver
 * @link        https://github.com/kegren/fonto
 * @version     0.2
 */

namespace Fonto\View\Driver;

use Fonto\View\Driver\DriverInterface;
use Fonto\Facade\Fonto;

use Exception;

/**
 * PHP based view helper.
 *
 * Extends ObjectHandler and implements DriverInterface.
 *
 * @package    Fonto_View
 * @subpackage Driver
 * @link       https://github.com/kegren/fonto
 * @author     Kenny Damgren <kenny.damgren@gmail.com>
 */
class Native implements DriverInterface
{
    /**
     * Extension for this driver
     *
     * @var string
     */
    protected $extension = '.php';

    /**
     * Searchable path
     *
     * @var string
     */
    protected $path;

    /**
     * Data
     *
     * @var array
     */
    protected $data = array();

    /**
     * Constructor
     */
    public function __construct()
    {}

    /**
     * Loads a view
     *
     * @param  string $view
     * @return void
     */
    public function load($view)
    {
        echo $this->render($view);
    }

    /**
     * Cleans user data with purifier. Returns cleaned data
     *
     * @param  string $data
     * @return mixed
     */
    public function purify($data)
    {
        $purifier = $this->purifier();
        return $purifier->purify($data);
    }

    /**
     * Uses renderView
     *
     * @param  string $view
     * @param  array  $data
     * @return mixed
     */
    public function render($view, $data = array(), $module = null)
    {
        if ($module) {
            $module = ucfirst($module);
            $this->path = APPPATH . "/modules/{$module}/View/";
        } else {
            $this->path = APPPATH . "/modules/Demo/View/";
        }

        return $this->renderView($view, $data);
    }

    /**
     * Renders a view and extracts its data
     *
     * @param  string $view
     * @param  array  $data
     * @return mixed
     * @throws Exception
     */
    public function renderView($view, $data = array())
    {
        $view = strtolower($view);
        ob_start(); // Starts output buffering

        if (!empty($data)) {
            extract($data);
            unset($data); // Removes from local
        }

        $session = Fonto::grab('session');

        if ($session->has('redirectData')) {
            extract($session->get('redirectData')); // Extracts saved session data from redirect
            $session->forget('redirectData');
        }

        if ($this->findView($view, $this->path, $this->extension)) {
            require $this->path . $view . $this->extension;
            $view = ob_get_clean(); // Gets buffer and clear it
            return $view;
        } else {
            ob_end_clean();
            throw new Exception("The view file, {$view} wasn't found.");
        }
    }

    /**
     * Checks if a view file exists
     *
     * @param  string $view
     * @param  string $path
     * @param  string $extension
     * @return mixed
     */
    public function findView($view, $path, $extension)
    {
        if (file_exists($path . $view . $extension)) {
            return true;
        }

        return false;
    }

    /**
     * Returns a html link
     *
     * @param  array  $args
     * @param  string $text
     * @return string
     */
    protected function createLink($args = array(), $text)
    {
        return $this->html()->createLink($this->url()->baseUrl(), $args, $text);
    }

    /**
     * Returns a image
     *
     * @param  string $link
     * @param  string $alt
     * @return string
     */
    protected function createImgLink($link, $alt)
    {
        return $this->html()->createImgLink($this->url()->baseUrl(), $link, $alt);
    }

    /**
     * Returns a formatted source of a file
     *
     * @param  string $file
     * @return string
     */
    protected function getContent($file)
    {
        return "<pre>" . htmlentities(file_get_contents($file)) . "</pre>";
    }
}
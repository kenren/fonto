<?php
/**
 * Fonto - PHP framework
 *
 * @author      Kenny Damgren <kenny.damgren@gmail.com>
 * @package     Fonto.Core
 * @link        https://github.com/kenren/fonto
 * @version     0.5
 */

namespace Fonto\Validation\Components;

use Fonto\Validation\Validator;

class ValidateMin extends Validator
{
    /**
     * @var array
     */
    protected $rule = array();

    /**
     * @var
     */
    protected $message;

    /**
     * @var bool
     */
    protected $error = false;

    /**
     * Constructor.
     */
    public function __construct($options = array())
    {
        $this->rule = $this->validators['min'];

        $input = $options['input'];
        $value = $options['value'];
        $field = $options['field'];
        $message = $options['message'];

        if (strlen($input) < $value) {
            $this->error = true;

            if (!$message) {
                $this->message = $this->rule['message'];
                $this->message = str_replace(array('{field}', '{value}'), array($field, $value), $this->message);
            } else {
                $this->message = $message;
            }
        }
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return bool
     */
    public function hasError()
    {
        return $this->error;
    }
}
<?php defined('SYSPATH') or die('No direct script access.');

class Model_User extends ORM {
    protected $_table_name = 'auth_user';
    protected $_filters = array(
        TRUE => array('trim' => NULL)
    );
    protected $_rules = array
        (
            'email'				=> array
            (
                'not_empty'			=> NULL,
                'max_length'		=> array(127),
                'validate::email'	=> NULL,
            ),
            'password'			=> array
            (
                'not_empty'			=> NULL,
            ),
            'name'			=> array
            (
                'not_empty'			=> NULL,
            ),
            'role_id'			=> array
            (
                'not_empty'			=> NULL,
            ),
            'lang'			=> array
            (
                'not_empty'			=> NULL,
            )
        );

    /**
     * Validates an array for a matching password and password_confirm field.
     *
     * @param  array    values to check
     * @param  boolean   save the user if
     * @return boolean
     */
    public function change_password(array & $array, $save = FALSE)
    {
        $fields = $array;
        $array = Validate::factory($array)
            ->filter(TRUE, 'trim')
            ->rules('password', $this->_password_rules['password'])
            ->rules('password_confirm', $this->_password_rules['password_confirm']);

        if ($status = $array->check())
        {
            $this->where('email', '=', $fields['email'])->find();

            // Change the password
            $this->password = $array['password'];
            if ($save !== FALSE AND $status = $this->save())
            {
                if (is_string($save))
                {
                    // Redirect to the success page
                    Request::current()->redirect($save);
                }
            }
        }
        return $status;
    }

}


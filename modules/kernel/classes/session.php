<?php class Session extends Kohana_Session
{
    protected function __construct(array $config = NULL, $id = NULL)
    {
        if($id == NULL)
        {
            //for uploadify(flash with no cookie support)
            if(isset($_POST) AND !empty($_POST['sessionId']))
            {
                $id = $_POST['sessionId'];
            }
        }
        parent::__construct($config,$id);
    }

    protected function _read($id = NULL)
    {
        // Set the cookie lifetime
        session_set_cookie_params($this->_lifetime);

        // Set the session cookie name
        session_name($this->_name);

        if ($id)
        {
            // Set the session id
            session_id($id);
        }

        // Start the session
        session_start();

        // Use the $_SESSION global for storing data
        $this->_data =& $_SESSION;

        return NULL;
    }

    protected function _regenerate()
    {
        // Regenerate the session id
        session_regenerate_id();

        return session_id();
    }

    protected function _write()
    {
        // Write and close the session
        session_write_close();

        return TRUE;
    }

    protected function _destroy()
    {
        // Destroy the current session
        session_destroy();

        return ! session_id();
    }

}

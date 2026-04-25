<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * MY_Controller — Base controller for all AutoSmart controllers.
 * Handles auth checking and shared view data.
 */
class MY_Controller extends CI_Controller {

    protected $user_data = array();

    public function __construct() {
        parent::__construct();
    }

    /**
     * Require logged-in user. Optionally restrict to a role ('master').
     */
    protected function require_login($role = NULL) {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        if ($role && $this->session->userdata('user_type') !== $role) {
            show_error('Access denied. You do not have permission to view this page.', 403);
        }
        $this->user_data = array(
            'user_id'   => $this->session->userdata('user_id'),
            'user_name' => $this->session->userdata('user_name'),
            'user_type' => $this->session->userdata('user_type'),
        );
    }

    /**
     * Load a view with the layout, passing data and page title.
     */
    protected function render($view, $data = array(), $title = 'AutoSmart') {
        $data['page_title'] = $title;
        $data['user_name']  = $this->session->userdata('user_name');
        $data['user_type']  = $this->session->userdata('user_type');
        $data['content_view'] = $view;

        $this->load->view('layouts/main', $data);
    }
}


/**
 * Auth_Controller — For pages that should NOT be accessible when logged in.
 */
class Auth_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // If already logged in, redirect to dashboard
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }
    }
}

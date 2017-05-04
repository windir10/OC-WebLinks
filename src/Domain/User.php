<?php

namespace WebLinks\Domain;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Application user
 *
 * @author Steven DUMONT <windir10 at gmail.com>
 */
class User implements UserInterface {
	/**
     * User id.
     *
     * @var integer
     */
    private $id;

    /**
     * User name.
     *
     * @var string
     */
    private $username;

    /**
     * User password.
     *
     * @var string
     */
    private $password;

    /**
     * Salt that was originally used to encode the password.
     *
     * @var string
     */
    private $salt;

    /**
     * Role.
     * Values : ROLE_USER or ROLE_ADMIN.
     *
     * @var string
     */
    private $role;
	
	/**
	 * Get the user's id
	 * 
	 * @return interger User's id
	 */
	public function getId() {
        return $this->id;
    }

	/**
	 * Set the user's id
	 * 
	 * @param integer $id User's id
	 */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @inheritDoc
     */
    public function getUsername() {
        return $this->username;
    }

	/**
	 * Set the user's name
	 * 
	 * @param string $username User's name
	 */
    public function setUsername($username) {
		$this->username = $username;
    }

    /**
     * @inheritDoc
     */
    public function getPassword() {
        return $this->password;
    }

	/**
	 * Set user's password
	 * 
	 * @param string $password User's password
	 */
    public function setPassword($password) {
        $this->password = $password;
    }

    /**
     * @inheritDoc
     */
    public function getSalt() {
        return $this->salt;
    }

	/**
	 * Set user's salt for password security
	 * 
	 * @param string $salt User's salt
	 */
    public function setSalt($salt) {
        $this->salt = $salt;
    }

	/**
	 * Get user's role
	 * 
	 * @return string User's role
	 */
    public function getRole() {
        return $this->role;
    }

	/**
	 * Set user's role for setting firewall
	 * 
	 * @param string $role User's role
	 */
    public function setRole($role) {
        $this->role = $role;
    }

    /**
     * @inheritDoc
     */
    public function getRoles() {
        return array($this->getRole());
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials() {
        // Nothing to do here
    }
}

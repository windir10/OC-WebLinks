<?php

namespace WebLinks\Domain;

class Link 
{
    /**
     * Link id.
     *
     * @var integer
     */
    private $id;

    /**
     * Link title.
     *
     * @var string
     */
    private $title;

    /**
     * Link url.
     *
     * @var string
     */
    private $url;

	/**
	 * Get the link's id
	 * 
	 * @return integer Return the link's id
	 */
    public function getId() {
        return $this->id;
    }

	/**
	 * Set the link's id
	 * 
	 * @param integer $id Link's id
	 */
    public function setId($id) {
        $this->id = $id;
    }

	/**
	 * Get the link's title
	 * 
	 * @return string Return the link's title
	 */
    public function getTitle() {
        return $this->title;
    }
	
	/**
	 * Set the link's title
	 * 
	 * @param string $title Link's title
	 */
    public function setTitle($title) {
        $this->title = $title;
    }

	/**
	 * Get the link's URL
	 * 
	 * @return string Return the link's URL
	 */
    public function getUrl() {
        return $this->url;
    }

	/**
	 * Set the link's URL
	 * 
	 * @param string $url Link's URL
	 */
    public function setUrl($url) {
        $this->url = $url;
    }
}

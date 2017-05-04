<?php

namespace WebLinks\DAO;

use WebLinks\Domain\Link;

class LinkDAO extends DAO 
{
	/**
     * @var \WebLinks\DAO\UserDAO
     */
    private $userDAO;

	/**
	 * Setting the associated UserDAO
	 * 
	 * @param \WebLinks\DAO\UserDAO $userDAO
	 */
    public function setUserDAO(UserDAO $userDAO) {
        $this->userDAO = $userDAO;
    }
	
    /**
     * Returns a list of all links, sorted by id.
     *
     * @return array A list of all links.
     */
    public function findAll() {
        $sql = "select * from t_link order by link_id desc";
        $result = $this->getDb()->fetchAll($sql);
        
        // Convert query result to an array of domain objects
        $entities = array();
        foreach ($result as $row) {
            $id = $row['link_id'];
            $entities[$id] = $this->buildDomainObject($row);
        }
        return $entities;
    }
	
	/**
	 * Save a link into database
	 * 
	 * @param Link $link The link object to save
	 */
	public function save(Link $link) {
        $linkData = array(
            'link_title' => $link->getTitle(),
            'link_url' => $link->getUrl(),
            'user_id' => $link->getUser()->getId()
            );

        if ($link->getId()) {
            // The link has already been saved : update it
            $this->getDb()->update('t_link', $linkData, array('link_id' => $link->getId()));
        } else {
            // The link has never been saved : insert it
            $this->getDb()->insert('t_link', $linkData);
            // Get the id of the newly created comment and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $link->setId($id);
        }
    }
	
	/**
	 * Delete a link by id from database
	 * 
	 * @param integer $id The link's id to delete
	 */
	public function delete($id) {
        // Delete the link
        $this->getDb()->delete('t_link', array('link_id' => $id));
    }
	
	/**
	 * Delete a link by user's id from database
	 * 
	 * @param integer $id The user's id
	 */
	public function deleteAllByUser($id) {
        // Delete links
        $this->getDb()->delete('t_link', array('user_id' => $id));
    }

    /**
     * Creates an Link object based on a DB row.
     *
     * @param array $row The DB row containing Link data.
     * @return \WebLinks\Domain\Link
     */
    protected function buildDomainObject(array $row) {
        $link = new Link();
        $link->setId($row['link_id']);
        $link->setUrl($row['link_url']);
        $link->setTitle($row['link_title']);
		
		if(array_key_exists('user_id', $row)) {
            // Find and set the associated user
            $userId = $row['user_id'];
            $user = $this->userDAO->find($userId);
            $link->setUser($user);
        }
        
        return $link;
    }
}

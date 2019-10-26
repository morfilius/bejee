<?php


namespace app\Models;


use app\Core\Model;

class PostModel extends Model
{
    public function save($data)
    {
        $this->db->query("INSERT INTO post (name, email, description, created_at, updated_at)
                                        VALUES ('{$data['name']}', '{$data['email']}', '{$data['description']}', '{$data['created_at']}', '{$data['updated_at']}' );");
    }

    public function update($data)
    {
        $allowed = array("description", "status", "updated_at");
        $sql = "UPDATE post SET ".$this::pdoSet($allowed, $data)." WHERE id = :id";
        $query = $this->db->prepare($sql);
        return $query->execute($data);
    }

    public function getAllPosts($data = array())
    {
        $data = $this->data;

        if(!isset($data['offset'])) $data['offset'] = 0;

        $query = $this->db->query('SELECT id,name,email,description,status FROM post LIMIT 3 OFFSET '.(int)$data['offset']);

        return $query->fetchAll();
    }
    public function getAllPostsCount()
    {
        $query = $this->db->query('SELECT COUNT(*) as count FROM post');

        return $query->fetchColumn();
    }

    public function getAllPostsBySort()
    {
        $data = $this->data;

        if(!isset($data['offset'])) $data['offset'] = 0;

        $query = $this->db->query("SELECT id,name,email,description,status FROM post ORDER BY {$data['sort']} {$data['direction']} LIMIT 3 OFFSET ".(int)$data['offset']);

        return $query->fetchAll();
    }

    public function getPostById()
    {
        $id = $this->data['id'];

        $query = $this->db->query('SELECT id,name,email,description,status FROM post WHERE id='.$id);

        return $query->fetch();
    }
}
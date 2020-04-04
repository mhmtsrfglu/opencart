<?php

class ModelLocalisationNotifications extends Model
{

    public function getNotifications()
    {
        $notification_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "notifications ORDER BY title ASC");

        $index = 0;
        foreach ($query->rows as $result) {
            $notification_data[$index] = array(
                'id' => $result['id'],
                'title' => $result['title'],
                'content' => $result['content']
            );
            $index++;
        }


        $this->cache->set('notifications', $notification_data);

        return $notification_data;
    }
}
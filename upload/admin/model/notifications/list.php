<?php

class ModelNotificationsList extends Model
{
    public function addNotification($data)
    {
        $this->db->query("INSERT INTO "
            . DB_PREFIX . "notifications SET  
            sort_order = '" . (int)$data["sort_order"] . "', 
            title = '" . $this->db->escape($data["notification"][1]["name"]) . "', 
            content = '" . $this->db->escape($data["notification_content"][1]["description"]) . "'");

        return $this->db->getLastId();
    }

    public function editNotification($notification_id, $data)
    {
        $this->db->query("UPDATE " . DB_PREFIX . "notifications SET sort_order = '" . (int)$data['sort_order'] . "' WHERE id = '" . (int)$notification_id . "'");
    }

    public function deleteNotification($notification_id)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "notifications WHERE id = '" . (int)$notification_id . "'");
    }

    public function getNotifications($notification_id)
    {
        $query = $this->db->query("SELECT  * FROM " . DB_PREFIX . "notifications cg  WHERE cg.id = '" . (int)$notification_id . "'");
        return $query->row;
    }

    public function getAllNotifications($data = array())
    {
        $sql = "SELECT * FROM " . DB_PREFIX . "notifications cg";

        $sort_data = array(
            'cg.title',
            'cg.content'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY cg.title";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getTotalNotifications()
    {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "notifications");

        return $query->row['total'];
    }
}

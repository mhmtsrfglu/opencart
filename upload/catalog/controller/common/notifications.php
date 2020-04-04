<?php

class ControllerCommonNotifications extends Controller
{
    public function index()
    {
        $this->load->language('common/notifications');

        $url_data = $this->request->get;

        unset($url_data['_route_']);
        unset($url_data['route']);

        $data['notifications'] = array();

        $this->load->model('localisation/notifications');

        $results = $this->model_localisation_notifications->getNotifications();
        foreach ($results as $result) {
            $data['notifications'][] = array(
                'id' => $result['id'],
                'title' => $result['title'],
                'content' => $result['content'],
                'action' => $this->url->link('notification/read/?id=' . $result["id"])
            );
        }

        return $this->load->view('common/notifications', $data);
    }

}
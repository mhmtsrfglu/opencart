<?php

class ControllerNotificationsList extends Controller
{
    private $error = array();

    public function index() {
        $this->load->language('notifications/list');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('notifications/list');

        $this->getList();
    }

    public function add() {
        $this->load->language('notifications/list');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('notifications/list');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_notifications_list->addNotification($this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('notifications/list', 'user_token=' . $this->session->data['user_token'] . $url));
        }

        $this->getForm();
    }

    public function edit() {
        $this->load->language('notifications/list');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('notifications/list');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_notifications_list->editNotification($this->request->get['id'], $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('notifications/list', 'user_token=' . $this->session->data['user_token'] . $url));
        }

        $this->getForm();
    }

    public function delete() {
        $this->load->language('notifications/list');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('notifications/list');

        if (isset($this->request->post['selected'])) {
            foreach ($this->request->post['selected'] as $notification_id) {
                $this->model_notifications_list->deleteNotification($notification_id);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('notifications/list', 'user_token=' . $this->session->data['user_token'] . $url));
        }

        $this->getList();
    }

    protected function getList() {
        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'cg.title';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'ASC';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $data['add'] = $this->url->link('notifications/list/add', 'user_token=' . $this->session->data['user_token'] . $url);
        $data['delete'] = $this->url->link('notifications/list/delete', 'user_token=' . $this->session->data['user_token'] . $url);

        $data['notifications'] = array();

        $filter_data = array(
            'sort'  => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_pagination'),
            'limit' => $this->config->get('config_pagination')
        );

        $customer_group_total = $this->model_notifications_list->getTotalNotifications();

        $results = $this->model_notifications_list->getAllNotifications($filter_data);

        foreach ($results as $result) {
            $data['notifications'][] = array(
                'id' => $result['id'],
                'title'              => $result['title'],
                'sort_order'        => $result['sort_order'],
                'edit'              => $this->url->link('notifications/list/edit', 'user_token=' . $this->session->data['user_token'] . '&id=' . $result['id'] . $url)
            );
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        if (isset($this->request->post['selected'])) {
            $data['selected'] = (array)$this->request->post['selected'];
        } else {
            $data['selected'] = array();
        }

        $url = '';

        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $data['sort_name'] = $this->url->link('notifications/list', 'user_token=' . $this->session->data['user_token'] . '&sort=cg.title' . $url);
        $data['sort_sort_order'] = $this->url->link('notifications/list', 'user_token=' . $this->session->data['user_token'] . '&sort=cg.sort_order' . $url);

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $data['pagination'] = $this->load->controller('common/pagination', array(
            'total' => $customer_group_total,
            'page'  => $page,
            'limit' => $this->config->get('config_pagination'),
            'url'   => $this->url->link('customer/customer_group', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}')
        ));

        $data['results'] = sprintf($this->language->get('text_pagination'), ($customer_group_total) ? (($page - 1) * $this->config->get('config_pagination')) + 1 : 0, ((($page - 1) * $this->config->get('config_pagination')) > ($customer_group_total - $this->config->get('config_pagination'))) ? $customer_group_total : ((($page - 1) * $this->config->get('config_pagination')) + $this->config->get('config_pagination')), $customer_group_total, ceil($customer_group_total / $this->config->get('config_pagination')));

        $data['sort'] = $sort;
        $data['order'] = $order;

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('notifications/list', $data));
    }

    protected function getForm() {
        $data['text_form'] = !isset($this->request->get['id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['title'])) {
            $data['error_name'] = $this->error['title'];
        } else {
            $data['error_name'] = array();
        }

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }


        if (!isset($this->request->get['id'])) {
            $data['action'] = $this->url->link('notifications/list/add', 'user_token=' . $this->session->data['user_token'] . $url);
        } else {
            $data['action'] = $this->url->link('notifications/list/edit', 'user_token=' . $this->session->data['user_token'] . '&id=' . $this->request->get['id'] . $url);
        }

        $data['cancel'] = $this->url->link('notifications/list', 'user_token=' . $this->session->data['user_token'] . $url);

        if (isset($this->request->get['id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {

            $notifications = $this->model_notifications_list->getNotifications($this->request->get['id']);
            $data["title"] = $notifications["title"];
            $data["content"] = $notifications["content"];
            $data["sort_order"] = $notifications["sort_order"];
        }



        $this->load->model('localisation/language');

        $data['languages'] = $this->model_localisation_language->getLanguages();


        if (isset($this->request->post['sort_order'])) {
            $data['sort_order'] = $this->request->post['sort_order'];
        } elseif (!empty($customer_group_info)) {
            $data['sort_order'] = $customer_group_info['sort_order'];
        } else {
            $data['sort_order'] = '';
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('notifications/notification_form', $data));
    }

    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'notifications/list')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        foreach ($this->request->post['notification'] as $language_id => $value) {
            if ((utf8_strlen($value['name']) < 3) || (utf8_strlen($value['name']) > 32)) {
                $this->error['name'][$language_id] = $this->language->get('error_name');
            }
        }

        return !$this->error;
    }


}

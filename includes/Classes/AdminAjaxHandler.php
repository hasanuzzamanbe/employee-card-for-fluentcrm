<?php

namespace EmployeeCard\Classes;


class AdminAjaxHandler
{
    public function registerEndpoints()
    {
        add_action('wp_ajax_employee_card_admin_ajax', array($this, 'handleEndPoint'));
    }

    public function handleEndPoint()
    {
        if (!isset($_REQUEST['route'])) {
            wp_send_json_error(array(
                'message' => 'Please provide a route!'
            ));
        }

        $route = sanitize_text_field($_REQUEST['route']);

        $validRoutes = array(
            'get_employee' => 'getEmployee',
            'get_employees' => 'getEmployees',
            'edit_employee' => 'editEmployee',
            'update_employee' => 'updateEmployee',
            'delete_employee' => 'deleteEmployee'
        );
        if (isset($validRoutes[$route])) {
            do_action('buy-me-coffee/doing_ajax_forms_' . $route);
            return $this->{$validRoutes[$route]}($_REQUEST);
        }
        do_action('buy-me-coffee/admin_ajax_handler_catch', $route);
    }


    public function getEmployees()
    {
        $employees = emcDb()->table('employee_card_info')->get();

        foreach ($employees as $key => $employee) {
            $employees[$key]->social_info = json_decode($employee->social_info);
            $employees[$key]->other_info = json_decode($employee->other_info);
        }

        wp_send_json_success([
            'message' => 'Employee fetched successfully!',
            'data' => $employees
        ]);
    }

    public function deleteEmployee($request)
    {
        if (!isset($request['id'])) {
            wp_send_json_error(array(
                'message' => 'Please provide a employee id!'
            ));
        }
        $id = sanitize_text_field($request['id']);

        $employee = emcDb()->table('employee_card_info')->where('id', $id)->delete();

        if (is_wp_error($employee)) {
            wp_send_json_error(array(
                'message' => $employee->get_error_message()
            ));
        }
        wp_send_json_success([
            'message' => 'Employee deleted successfully!',
            'data' => $employee
        ]);
    }

    public function getEmployee()
    {
        $id = sanitize_text_field($_REQUEST['id']);
        if (!$id) {
            wp_send_json_error(array(
                'message' => 'Please provide a employee id!'
            ), 401);
        }

        $employee = emcDb()->table('employee_card_info')->where('id', $id)->first();

        $employee->social_info = json_decode($employee->social_info);
        $employee->other_info = json_decode($employee->other_info);

        wp_send_json_success(
            [
                'message' => 'Employee found!',
                'data' => $employee
            ]
        );
    }

    public function updateEmployee($request)
    {
        if (!isset($request['data']) || !is_array($request['data'])) {
            wp_send_json_error(array(
                'message' => 'Please provide a employee info!'
            ));
        }

        $employee = $request['data'];

        $id = sanitize_text_field(isset($employee['id']) ? $employee['id'] : 0);

        $data = [
            'name' => sanitize_text_field($employee['name']),
            'email' => sanitize_text_field($employee['email']),
            'phone' => sanitize_text_field($employee['phone']),
            'image' => sanitize_text_field($employee['image']),
            'description' => sanitize_text_field($employee['description']),
            'designation' => sanitize_text_field($employee['designation']),
            'address_1' => sanitize_text_field($employee['address_1']),
            'city' => sanitize_text_field($employee['city']),
            'state' => sanitize_text_field($employee['state']),
            'postcode' => sanitize_text_field($employee['postcode']),
            'status' => 'active',
        ];

        $social_info = $employee['social_info'];

        foreach ($social_info as $key => $value) {
            $social_info[$key] = sanitize_url($value);
        }

        $data['other_info'] = json_encode($employee['other_info']);
        $data['social_info'] = json_encode($social_info);

        if ($id) {
            $data['updated_at'] = current_time('mysql');

            $employee = emcDb()->table('employee_card_info')->where('id', $id)->update($data);

        } else {
            $data['created_at'] = current_time('mysql');
            $data['updated_at'] = current_time('mysql');
            $employee = emcDb()->table('employee_card_info')->insert([
                $data
            ]);
        }

        if (is_wp_error($employee)) {
            wp_send_json_error(array(
                'message' => $employee->get_error_message()
            ));
        }

        if (!$employee) {
            wp_send_json_error(array(
                'message' => 'Not added!'
            ), 401);
        }

        wp_send_json_success([
            'message' => 'Employee added successfully!',
            'data' => $employee
        ]);

    }

}

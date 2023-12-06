<?php

namespace EmployeeCard\Classes;

use FluentCrm\App\Models\Subscriber;
use FluentCrm\App\Services\Helper;

class ContactHelper
{
    public function getByHash($hash)
    {
        $defaultWith = ['tags', 'lists'];

        if (Helper::isCompanyEnabled()) {
            $defaultWith[] = 'companies';
        }

        $subscriber = false;
        if (!$hash) {
            $this->sendError([
                'message' => __('Subscriber not found', 'fluent-crm')
            ]);
        }

        $subscriber = Subscriber::with($defaultWith)->where('hash', $hash)->first();

        if (!$subscriber) {
            return $this->sendError([
                'message' => __('Subscriber not found', 'fluent-crm')
            ]);
        }

        if ($wpUser = $subscriber->getWpUser()) {
            $subscriber->user_edit_url = get_edit_user_link($wpUser->ID);
            $subscriber->user_roles = array_values($wpUser->roles);
        }

            $subscriber->stats = $subscriber->stats();

            $subscriber->custom_values = $subscriber->custom_fields();

        if ($subscriber->date_of_birth == '0000-00-00') {
            $subscriber->date_of_birth = '';
        }

        return $subscriber;
    }

}
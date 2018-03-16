<?php

use Uniform\Form;

return function ($site, $pages, $page)
{
    $form = new Form([
        'email' => [
            'rules' => ['required', 'email'],
            'message' => 'Please enter a valid email address',
        ],
    ]);

    if (r::is('POST')) {
        $form->emailAction([
            'to' => "{$page->list_name()->escape()}-request@{$page->list_domain()->escape()}",
            'from' => $site->email()->isNotEmpty() ? $site->email()->isNotEmpty() : 'info@' . $_SERVER['SERVER_NAME'],
            'subject' => "subscribe address=<{$form->old('email')}>"
        ]);
    }

    return compact('form');
};
<?php

$config = [
              'register_form_rules' => [
                                          [
                                            'field' => 'firstname',
                                            'label' => 'FirstName',
                                            'rules' => 'required|alpha'
                                          ],
                                          [
                                            'field' => 'lastname',
                                            'label' => 'LastName',
                                            'rules' => 'required|alpha'
                                          ],
                                          [
                                            'field' => 'email_id',
                                            'label' => 'Email Address',
                                            'rules' => 'required|valid_email'
                                          ],
                                          [
                                            'field' => 'password',
                                            'label' => 'Password',
                                            'rules' => 'required'
                                          ],
                                          [
                                            'field' => 'confirm_password',
                                            'label' => 'Confirm Password',
                                            'rules' => 'required|matches[password]'
                                          ]
                                       ],
                 'login_form_rules' => [
                                          [
                                            'field' => 'email_id',
                                            'label' => 'Email Address',
                                            'rules' => 'required|valid_email'
                                          ],
                                          [
                                            'field' => 'password',
                                            'label' => 'Password',
                                            'rules' => 'required'
                                          ]
                                       ]
          ];

 ?>

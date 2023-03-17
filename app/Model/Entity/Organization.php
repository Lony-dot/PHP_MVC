<?php

namespace App\Model\Entity;

class Organization
{
    /**
     * ID da organização
     * @var integer
     */
    public $id = 1;

    /**
     * Nome da organização
     */
    public $name = 'Canal WDEV';

    /**
     * Site da organização
     * @var string
     */
    public $site = 'htpps://youtube.com/wdevoficial';

    /**
     * Descrição da organização
     * @var string
     */
    public $description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
    incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, 
    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.';
   
}
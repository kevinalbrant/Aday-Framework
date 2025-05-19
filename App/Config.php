<?php declare(strict_types= 1);

namespace App;

/**
 * Application configuration
 * 
 * PHP version 5.4
 */
class Config{

    /**
     * Website with SSL-Certificate
     * @var boolean
     */
    const DOMAIN_SSL = true;

    /**
     * Show or hide error messages on screen
     * @var boolean
     */
    const SHOW_ERRORS = true;

    /**
     * Create Cache or not
     * @var boolean
     */
    const CREATE_CACHE = false;

    /**
     * Database host
     * @var string
     */
    const DB_HOST = 'db5016485756.hosting-data.io';

    /**
     * Database name
     * @var string
     */
    const DB_NAME = 'dbs13380962';

    /**
     * Database user
     * @var string
     */
    const DB_USER = 'dbu235939';

    /**
     * Database password
     * @var string
     */
    const DB_PASSWORD = 'fbuDa03#dFdsrew43-M_dsa';

    /**
     * Password Pepper Start
     * @var string
     */
    const PASSWORD_PEPPER_START = "6#nsa%ZI5@USO!5&";

    /**
     * Password Pepper End
     * @var string
     */
    const PASSWORD_PEPPER_END = "7phP7QJt68jEZavR";
}
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of password
 *
 * @author david
 */
class Password {

    const SALT = 'EstoEsUnSalt';

    public static function hash($password) {
        return hash('sha512', self::SALT . $password);
    }

    public static function verify($password, $hash) {
        return ($hash == self::hash($password));
    }

}

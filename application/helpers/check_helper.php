<?php

defined('BASEPATH') OR exit('No direct script access allowed');

function checkemail($Email) {
    $Data = (string) $Email;
    $Format = '/[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\.\-]+\.[a-z]{2,4}$/';

    if (preg_match($Format, $Data)):
        return true;
    else:
        return false;
    endif;
}

/*
     * <b>Tranforma URL:</b> Tranforma uma string no formato de URL amigável e retorna a string convertida!
     * @param STRING $Name = Uma string qualquer
     * @return STRING = $Data = Uma URL amigável válida
     */
  function checkName($Name) {
        $Format = array();
        $Format['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
        $Format['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';

        $Data = strtr(utf8_decode($Name), utf8_decode($Format['a']), $Format['b']);
        $Data = strip_tags(trim($Data));
        $Data = str_replace(' ', '-', $Data);
        $Data = str_replace(array('-----', '----', '---', '--'), '-', $Data);

        return strtolower(utf8_encode($Data));
    }

/*
 * <b>Checa CPF:</b> Informe um CPF para checar sua validade via algoritmo!
 * @param STRING $CPF = CPF com ou sem pontuação
 * @return BOLEAM = True se for um CPF válido
 */

function checkCPF($Cpf) {
    $Data = preg_replace('/[^0-9]/', '', $Cpf);

    if (strlen($Data) != 11):
        return false;
    endif;

    $digitoA = 0;
    $digitoB = 0;

    for ($i = 0, $x = 10; $i <= 8; $i++, $x--) {
        $digitoA += $Data[$i] * $x;
    }

    for ($i = 0, $x = 11; $i <= 9; $i++, $x--) {
        if (str_repeat($i, 11) == $Data) {
            return false;
        }
        $digitoB += $Data[$i] * $x;
    }

    $somaA = (($digitoA % 11) < 2 ) ? 0 : 11 - ($digitoA % 11);
    $somaB = (($digitoB % 11) < 2 ) ? 0 : 11 - ($digitoB % 11);

    if ($somaA != $Data[9] || $somaB != $Data[10]) {
        return false;
    } else {
        return true;
    }
}

/*
 * <b>Tranforma Data:</b> Transforma uma data no formato DD/MM/YY em uma data no formato YYYY-MM-DD!
 * @param STRING $Name = Data em (d/m/Y)
 * @return STRING = $Data = Data no formato YYYY-MM-DD!
 */

function checkNascimento($Data) {
    $Format = explode(' ', $Data);
    $Data = explode('/', $Format[0]);

    if (checkdate($Data[1], $Data[0], $Data[2])):
        $Data = $Data[2] . '-' . $Data[1] . '-' . $Data[0];
        return $Data;
    else:
        return false;
    endif;
}


 /*
     * <b>Tranforma TimeStamp:</b> Transforma uma data no formato DD/MM/YY em uma data no formato TIMESTAMP!
     * @param STRING $Name = Data em (d/m/Y) ou (d/m/Y H:i:s)
     * @return STRING = $Data = Data no formato timestamp!
     */
    function checkData($Data) {
        $Format = explode(' ', $Data);
        $Data = explode('/', $Format[0]);

        if (!checkdate($Data[1], $Data[0], $Data[2])):
            return false;
        else:
            if (empty($Format[1])):
                $Format[1] = date('H:i:s');
            endif;

            $Data = $Data[2] . '-' . $Data[1] . '-' . $Data[0] . ' ' . $Format[1];
            return $Data;
        endif;
    }

    
    /*
     * <b>Limita os Caracteres:</b> Limita a quantidade de letras a serem exibidas em uma string!
     * @param STRING $String = Uma string qualquer
     * @param INT $name Description INT = $Limite = String limitada pelo $Limite
     */
    function checkChars($String, $Limite) {
        $Data = strip_tags($String);
        $Format = $Limite;
        if (strlen($Data) <= $Format) {
            return $Data;
        } else {
            $subStr = strrpos(substr($Data, 0, $Format), ' ');
            return substr($Data, 0, $subStr) . '...';
        }
    }
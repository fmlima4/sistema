<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2018-01-10 23:48:54 --> 404 Page Not Found: Assets/img
ERROR - 2018-01-10 23:48:59 --> 404 Page Not Found: Assets/img
ERROR - 2018-01-10 23:49:10 --> Query error: Unknown column 'comentdate' in 'field list' - Invalid query: SELECT `comentdate`, `cliente`, `texto`, `comcod`, `cnome`, `username`
FROM `comentarios`
JOIN `clientes` ON `clientes`.`ccod` = `comentarios`.`cliente`
JOIN `users` ON `users`.`id` = `comentarios`.`autor`
ORDER BY `comcod` ASC
 LIMIT 9
ERROR - 2018-01-10 23:49:15 --> Query error: Unknown column 'orcdate' in 'field list' - Invalid query: SELECT `orcdate`, `situacao`, `ocod`, `valor`, `cnome`, `pnome`, `numero`, `rnome`
FROM `orcamentos`
JOIN `clientes` ON `clientes`.`ccod` = `orcamentos`.`cliente`
JOIN `produtos` ON `produtos`.`pcod` = `orcamentos`.`produto`
JOIN `representantes` ON `representantes`.`rcod` = `clientes`.`representante`
ORDER BY `ocod` ASC
 LIMIT 9

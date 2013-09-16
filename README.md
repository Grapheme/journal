Ptosnm
=================
------------------------------------------------------------------------------------------------------------------------------------
Update DB to 16.09.2013
ALTER TABLE `publications_resources` ADD `number` INT UNSIGNED NOT NULL AFTER `resource` ,
ADD `caption` VARCHAR( 255 ) NOT NULL AFTER `number` ;
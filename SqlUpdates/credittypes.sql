#credit types
ALTER TABLE `tbl_credit_types` 
ADD `credit_type_balance` DECIMAL(20,2) NOT NULL DEFAULT '0.00' 
AFTER `credit_type_type_description`;
ALTER TABLE `tbl_customer_sales` 
ADD `customer_sale_balance_before` DECIMAL(20,2) NOT NULL DEFAULT '0.00' 
AFTER `customer_sale_del_no`, 
ADD `customer_sale_balance_after` DECIMAL(20,3) NOT NULL DEFAULT '0.00' 
AFTER `customer_sale_balance_before`;

ALTER TABLE `tbl_customer_sales` ADD `customer_sale_price` DECIMAL(20,2) NOT NULL DEFAULT '0.00' AFTER `customer_sale_balance_after`;
ALTER TABLE `tbl_customer_sales` ADD `customer_sale_notes` VARCHAR(255) NULL AFTER `customer_sale_price`;
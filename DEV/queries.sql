ALTER TABLE `invoices` CHANGE `updated_at` `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `transactions` CHANGE `updated_at` `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `compliance` CHANGE `updated_at` `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE `compliance`  ADD `document` VARCHAR(20) NULL  AFTER `tax_id`;

ALTER TABLE `invoices`  ADD `pix_transation_id` VARCHAR(255) NULL  AFTER `updated_at`,  ADD `pix_copy_past` TEXT NULL  AFTER `pix_transation_id`,  ADD `pix_qrcode` TEXT NULL  AFTER `pix_copy_past`,  ADD `client_name` VARCHAR(255) NULL  AFTER `pix_qrcode`,  ADD `client_document` VARCHAR(20) NULL  AFTER `client_name`;



ALTER TABLE `transactions` CHANGE `updated_at` `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE `transactions`  ADD `pix_end_to_end_id` VARCHAR(40) NULL  AFTER `updated_at`,  ADD `pix_callback` TEXT NULL  AFTER `pix_end_to_end_id`;
ALTER TABLE `invoices` CHANGE `pix_transation_id` `pix_transaction_id` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;


/*  14-08-2021 */
ALTER TABLE `compliance` ADD `company_document_id` VARCHAR(20) NULL AFTER `updated_at`, ADD `mouth_revenue` DECIMAL(8,2) NOT NULL DEFAULT '0' AFTER `company_document_id`, ADD `patrimony` DECIMAL(8,2) NOT NULL DEFAULT '0' AFTER `mouth_revenue`, ADD `neighborhood` VARCHAR(40) NULL AFTER `patrimony`, ADD `mother_name` VARCHAR(40) NULL AFTER `neighborhood`, ADD `address_type` VARCHAR(40) NULL AFTER `mother_name`, ADD `address_number` VARCHAR(10) NULL AFTER `address_type`, ADD `address_complement` VARCHAR(40) NULL AFTER `address_number`, ADD `address_zipcode` VARCHAR(20) NULL AFTER `address_complement`, ADD `phone_country_code` VARCHAR(3) NULL AFTER `address_zipcode`;

ALTER TABLE `bank` CHANGE `updated_at` `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `compliance` ADD `phone_type` ENUM('CELULAR','COMERCIAL','RESIDENCIAL') NULL AFTER `phone_country_code`;
ALTER TABLE `bank` ADD `account_document` VARCHAR(40) NULL AFTER `updated_at`;
ALTER TABLE `bank` ADD `agency_no` VARCHAR(10) NULL AFTER `account_document`;
ALTER TABLE `users` ADD `original_hub_uuid` VARCHAR(100) NULL AFTER `shipping`;

CREATE TABLE `cronospay_v3`.`integrations` ( `id` BIGINT NOT NULL AUTO_INCREMENT , `partner_name` VARCHAR(80) NOT NULL , `code` VARCHAR(40) NOT NULL , `api_key` TEXT NULL , `public_key` TEXT NULL , `private_key` TEXT NULL , `enabled` TINYINT NOT NULL DEFAULT '1' , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `compliance` CHANGE `address_type` `address_type` ENUM('COMERCIAL','RESIDENTIAL') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;

ALTER TABLE `compliance` ADD `address_city` VARCHAR(40) NULL AFTER `phone_type`, ADD `address_state` VARCHAR(40) NULL AFTER `address_city`;
ALTER TABLE `compliance` CHANGE `patrimony` `patrimony` DECIMAL(16,2) NOT NULL DEFAULT '0.00';
ALTER TABLE `compliance` CHANGE `mouth_revenue` `mouth_revenue` DECIMAL(16,2) NOT NULL DEFAULT '0.00';
ALTER TABLE `gateways` ADD `sandbox` TINYINT NOT NULL DEFAULT '0' AFTER `status`;

/* 21-08-2022 */
ALTER TABLE `transactions` ADD `creditcard_callback` TEXT NULL AFTER `creditcard_installments`;
ALTER TABLE `transactions` ADD `creditcard_payment_id` VARCHAR(100) NULL AFTER `pix_callback`, ADD `creditcard_brand` VARCHAR(100) NULL AFTER `creditcard_payment_id`, ADD `creditcard_installments` INT NULL AFTER `creditcard_brand`;
ALTER TABLE `transactions` ADD `creditcard_status` ENUM('NOT_FINISHED','AUTHORIZED','PAYMENT_CONFIRMED','DENIED','VOIDED','REFUNDED','PENDING','ABORTED','SCHEDULED') NULL AFTER `creditcard_callback`;
ALTER TABLE `transactions` ADD `creditcard_status_description` TEXT NULL AFTER `creditcard_status`;
ALTER TABLE `transactions` ADD `gateway` VARCHAR(40) NULL AFTER `creditcard_status_description`;
ALTER TABLE `invoices` CHANGE `amount` `amount` DECIMAL(50,2) NOT NULL;
ALTER TABLE `invoices` CHANGE `discount` `discount` DECIMAL(50,2) NULL DEFAULT NULL;
ALTER TABLE `invoices` CHANGE `tax` `tax` DECIMAL(8,2) NULL DEFAULT NULL;
ALTER TABLE `invoices` CHANGE `charge` `charge` DECIMAL(50,2) NULL DEFAULT NULL;
ALTER TABLE `invoices` CHANGE `total` `total` DECIMAL(50,2) NULL DEFAULT NULL;
ALTER TABLE `transactions`  ADD `creditcard_proof_of_sale` VARCHAR(80) NULL  AFTER `gateway`,  ADD `creditcard_transaction_id` VARCHAR(80) NULL  AFTER `creditcard_proof_of_sale`,  ADD `creditcard_authorization_code` VARCHAR(80) NULL  AFTER `creditcard_transaction_id`;
ALTER TABLE `invoices`  ADD `boleto_transaction_id` VARCHAR(80) NULL  AFTER `client_document`,  ADD `boleto_url` TEXT NULL  AFTER `boleto_transaction_id`,  ADD `boleto_barcode` VARCHAR(200) NULL  AFTER `boleto_url`;
ALTER TABLE `invoices` ADD `boleto_digitable_line` VARCHAR(200) NULL AFTER `boleto_barcode`;

CREATE TABLE `states` (
  `id` BIGINT(20) NOT NULL,
  `name` varchar(75) DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL,
  `ibge` int(2) DEFAULT NULL,
  `country_id` int(3) DEFAULT NULL,
  `ddd` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Unidades Federativas';

--
-- Dumping data for table `dbt_states`
--

INSERT INTO `states` (`id`, `name`, `uf`, `ibge`, `country_id`, `ddd`) VALUES
(1, 'Acre', 'AC', 12, 30, '68'),
(2, 'Alagoas', 'AL', 27, 30, '82'),
(3, 'Amazonas', 'AM', 13, 30, '97,92'),
(4, 'Amapá', 'AP', 16, 30, '96'),
(5, 'Bahia', 'BA', 29, 30, '77,75,73,74,71'),
(6, 'Ceará', 'CE', 23, 30, '88,85'),
(7, 'Distrito Federal', 'DF', 53, 30, '61'),
(8, 'Espírito Santo', 'ES', 32, 30, '28,27'),
(9, 'Goiás', 'GO', 52, 30, '62,64,61'),
(10, 'Maranhão', 'MA', 21, 30, '99,98'),
(11, 'Minas Gerais', 'MG', 31, 30, '34,37,31,33,35,38,32'),
(12, 'Mato Grosso do Sul', 'MS', 50, 30, '67'),
(13, 'Mato Grosso', 'MT', 51, 30, '65,66'),
(14, 'Pará', 'PA', 15, 30, '91,94,93'),
(15, 'Paraíba', 'PB', 25, 30, '83'),
(16, 'Pernambuco', 'PE', 26, 30, '81,87'),
(17, 'Piauí', 'PI', 22, 30, '89,86'),
(18, 'Paraná', 'PR', 41, 30, '43,41,42,44,45,46'),
(19, 'Rio de Janeiro', 'RJ', 33, 30, '24,22,21'),
(20, 'Rio Grande do Norte', 'RN', 24, 30, '84'),
(21, 'Rondônia', 'RO', 11, 30, '69'),
(22, 'Roraima', 'RR', 14, 30, '95'),
(23, 'Rio Grande do Sul', 'RS', 43, 30, '53,54,55,51'),
(24, 'Santa Catarina', 'SC', 42, 30, '47,48,49'),
(25, 'Sergipe', 'SE', 28, 30, '79'),
(26, 'São Paulo', 'SP', 35, 30, '11,12,13,14,15,16,17,18,19'),
(27, 'Tocantins', 'TO', 17, 30, '63'),
(99, 'Exterior', 'EX', 99, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dbt_states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);
COMMIT;


CREATE TABLE `customers` ( `id` BIGINT NOT NULL AUTO_INCREMENT ,  `document` VARCHAR(20) NOT NULL ,  `document_type` ENUM('CPF','CNPJ') NOT NULL ,  `zipcode` VARCHAR(10) NOT NULL ,  `country_id` BIGINT NOT NULL ,  `state` VARCHAR(2) NOT NULL ,  `city` VARCHAR(100) NOT NULL ,  `district` VARCHAR(100) NOT NULL ,  `street` VARCHAR(100) NOT NULL ,  `number` VARCHAR(10) NOT NULL ,  `user_id` BIGINT NOT NULL ,  `email` VARCHAR(255) NOT NULL ,  `phone` VARCHAR(20) NOT NULL ,  `mobilephone` VARCHAR(20) NOT NULL ,  `creation_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,    PRIMARY KEY  (`id`)) ENGINE = InnoDB;
ALTER TABLE `customers` ADD `name` VARCHAR(120) NOT NULL AFTER `id`;
ALTER TABLE `customers` ADD `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP AFTER `creation_date`, ADD `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`;
ALTER TABLE `customers` DROP `creation_date`;
ALTER TABLE `invoices` ADD `customer_id` BIGINT NULL AFTER `user_id`;
ALTER TABLE `transactions` ADD `invoice_id` BIGINT NOT NULL AFTER `ip_address`;

CREATE TABLE `cronospay_v3`.`users_gateways` ( `id` BIGINT NOT NULL AUTO_INCREMENT ,  `user_id` BIGINT NULL ,  `gateway_id` BIGINT NOT NULL ,  `type` ENUM('CREDIT_CARD','DEBIT_CARD','BOLETO','PIX') NOT NULL ,    PRIMARY KEY  (`id`)) ENGINE = InnoDB;
ALTER TABLE `gateways` CHANGE `val1` `val1` VARCHAR(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `gateways` CHANGE `val2` `val2` VARCHAR(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `gateways` CHANGE `val3` `val3` VARCHAR(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `gateways` CHANGE `val4` `val4` VARCHAR(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;


ALTER TABLE `w_history` CHANGE `updated_at` `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `w_history`  ADD `method` ENUM('BANK_TRANSFER','PIX') NOT NULL DEFAULT 'BANK_TRANSFER'  AFTER `updated_at`,  ADD `pix_key` VARCHAR(255) NULL  AFTER `method`,  ADD `pix_key_type` ENUM('CPF','CNPJ','PHONE','EMAIL','EVP') NULL  AFTER `pix_key`;


/*   05/09/2022   */  


ALTER TABLE `settings` CHANGE `updated_at` `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `settings`  ADD `company_document` VARCHAR(20) NULL  AFTER `updated_at`,  ADD `company_address` VARCHAR(255) NULL  AFTER `company_document`;
ALTER TABLE `settings`  ADD `company_name` VARCHAR(255) NULL  AFTER `company_address`;

/*  28/09/2022  */


--
-- Table structure for table `oauth_original_hub`
--

CREATE TABLE `oauth_original_hub` (
  `id` bigint(20) NOT NULL,
  `access_token` text NOT NULL,
  `refresh_token` text NOT NULL,
  `token_type` varchar(20) NOT NULL,
  `expires_seconds` varchar(10) NOT NULL,
  `expires_at` timestamp NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_original_hub_errors`
--

CREATE TABLE `oauth_original_hub_errors` (
  `id` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `error_msg` text NOT NULL,
  `request_info` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `oauth_original_hub`
--
ALTER TABLE `oauth_original_hub`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_original_hub_errors`
--
ALTER TABLE `oauth_original_hub_errors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `oauth_original_hub`
--
ALTER TABLE `oauth_original_hub`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_original_hub_errors`
--
ALTER TABLE `oauth_original_hub_errors`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
COMMIT;

ALTER TABLE `compliance`  ADD `cpf` VARCHAR(14) NULL  AFTER `address_state`,  ADD `rg` VARCHAR(14) NULL  AFTER `cpf`,  ADD `business_phone_country_code` VARCHAR(3) NULL  AFTER `rg`,  ADD `business_phone` VARCHAR(20) NULL  AFTER `business_phone_country_code`,  ADD `mobilephone_country_code` VARCHAR(3) NULL  AFTER `business_phone`,  ADD `phone_ddd` VARCHAR(3) NULL  AFTER `mobilephone_country_code`,  ADD `mobilephone_ddd` VARCHAR(3) NULL  AFTER `phone_ddd`,  ADD `business_phone_ddd` VARCHAR(3) NULL  AFTER `mobilephone_ddd`,  ADD `mobilephone` VARCHAR(20) NULL  AFTER `business_phone_ddd`;


/* 05/10/2022 */
ALTER TABLE `users` ADD `compliance_gateway` ENUM('NORMAL','BANCO_ORIGINAL') NOT NULL DEFAULT 'NORMAL' AFTER `original_hub_uuid`;



/*  25/10/2022    */

ALTER TABLE `compliance` ADD `address_country_id` BIGINT NULL;

ALTER TABLE `compliance`  ADD `office_address_number` VARCHAR(10) NULL  AFTER `address_country_id`,  
                          ADD `office_address_complement` VARCHAR(40) NULL  AFTER `office_address_number`,  
                          ADD `office_address_neighborhood` VARCHAR(40) NULL  AFTER `office_address_complement`,  
                          ADD `office_address_postalcode` VARCHAR(20) NULL  AFTER `office_address_neighborhood`,  
                          ADD `office_address_city` VARCHAR(40) NULL  AFTER `office_address_postalcode`,  
                          ADD `office_address_country_id` BIGINT NULL  AFTER `office_address_city`,  
                          ADD `source_of_funds` VARCHAR(1000) NULL  AFTER `office_address_country_id`,  
                          ADD `business_status` INT NOT NULL DEFAULT '0'  AFTER `source_of_funds`,  
                          ADD `source_of_capital` VARCHAR(1000) NULL  AFTER `business_status`,  
                          ADD `source_of_wealth` VARCHAR(1000) NULL  AFTER `source_of_capital`;

ALTER TABLE `compliance`  ADD `birthday` DATE NULL  AFTER `source_of_wealth`,  ADD `company_fundation_date` DATE NULL  AFTER `birthday`;



/*  04/11/2022  */

ALTER TABLE `deposits`  ADD `pix_end_to_end_id` VARCHAR(40) NULL ,  ADD `pix_callback` TEXT NULL  AFTER `pix_end_to_end_id`,  ADD `creditcard_payment_id` VARCHAR(100) NULL  AFTER `pix_callback`,  ADD `creditcard_brand` VARCHAR(100) NULL  AFTER `creditcard_payment_id`,  ADD `creditcard_installments` INT NULL  AFTER `creditcard_brand`,  ADD `creditcard_callback` TEXT NULL  AFTER `creditcard_installments`,  ADD `creditcard_status` ENUM('NOT_FINISHED','AUTHORIZED','PAYMENT_CONFIRMED','DENIED','VOIDED','REFUNDED','PENDING','ABORTED','SCHEDULED') NULL  AFTER `creditcard_callback`,  ADD `creditcard_status_description` TEXT NULL  AFTER `creditcard_status`,  ADD `gateway` VARCHAR(40) NULL  AFTER `creditcard_status_description`,  ADD `creditcard_proof_of_sale` VARCHAR(80) NULL  AFTER `gateway`,  ADD `creditcard_transaction_id` VARCHAR(80) NULL  AFTER `creditcard_proof_of_sale`,  ADD `creditcard_authorization_code` VARCHAR(80) NULL  AFTER `creditcard_transaction_id`;
ALTER TABLE `deposits` ADD `pix_transaction_id` VARCHAR(255) NULL AFTER `creditcard_authorization_code`, ADD `pix_copy_past` TEXT NULL AFTER `pix_transaction_id`, ADD `pix_qrcode` TEXT NULL AFTER `pix_copy_past`, ADD `boleto_transaction_id` VARCHAR(255) NULL AFTER `pix_qrcode`, ADD `boleto_url` TEXT NULL AFTER `boleto_transaction_id`, ADD `boleto_barcode` VARCHAR(200) NULL AFTER `boleto_url`, ADD `boleto_digitable_line` VARCHAR(200) NULL AFTER `boleto_barcode`;
ALTER TABLE `deposits` ADD `payment_type` VARCHAR(80) NULL AFTER `boleto_digitable_line`;
ALTER TABLE `deposits` ADD `client_name` VARCHAR(255) NULL AFTER `payment_type`, ADD `client_document` VARCHAR(20) NULL AFTER `client_name`;
ALTER TABLE `deposits` ADD `due_date` TIMESTAMP NULL AFTER `client_document`;
ALTER TABLE `compliance` ADD `selfie` VARCHAR(255) NULL AFTER `company_fundation_date`;
ALTER TABLE `compliance` CHANGE `document` `document` VARCHAR(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;
ALTER TABLE `compliance`  ADD `status_personal` ENUM('PENDING','ANALYSIS','REJECTED','APPROVED') NOT NULL DEFAULT 'PENDING'  AFTER `selfie`,  ADD `status_business` ENUM('PENDING','ANALYSIS','REJECTED','APPROVED') NOT NULL DEFAULT 'PENDING'  AFTER `status_personal`;
ALTER TABLE `compliance` ADD `office_address_state` VARCHAR(40) NULL AFTER `status_business`;
ALTER TABLE `compliance` ADD `business_proof` VARCHAR(255) NULL AFTER `office_address_state`, ADD `business_national_registry` VARCHAR(255) NULL AFTER `business_proof`;
ALTER TABLE `users` ADD `original_hub_pix_key` VARCHAR(40) NULL AFTER `compliance_gateway`, ADD `original_hub_pix_fee` DECIMAL(8,2) NULL AFTER `original_hub_pix_key`;



/* 28/04/2023 */

ALTER TABLE `invoices` ADD `received_total` DECIMAL(25,2) NOT NULL DEFAULT '0' AFTER `boleto_digitable_line`;
ALTER TABLE `deposit` ADD `currency_id` BIGINT NULL AFTER `creditcard_authorization_code`;
ALTER TABLE `currency` CHANGE `updated_at` `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `currency` ADD `usd_quote` DECIMAL(16,2) NOT NULL DEFAULT '0' AFTER `updated_at`, ADD `brl_quote` DECIMAL(16,2) NOT NULL DEFAULT '0' AFTER `usd_quote`;
ALTER TABLE `deposits` ADD `currency_id` BIGINT NULL AFTER `due_date`, ADD `currency_name` VARCHAR(40) NULL AFTER `currency_id`, ADD `rate` DECIMAL(16,2) NULL AFTER `currency_name`;
ALTER TABLE `deposits` CHANGE `amount` `amount` DECIMAL(16,2) NULL DEFAULT NULL, CHANGE `charge` `charge` DECIMAL(16,2) NULL DEFAULT NULL;
ALTER TABLE `payment_link` CHANGE `updated_at` `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;
DROP TABLE `payment_link`;

CREATE TABLE `payment_link` (
  `id` int(32) NOT NULL,
  `user_id` int(32) NOT NULL,
  `ref_id` varchar(16) DEFAULT NULL,
  `amount` decimal(16,2) DEFAULT NULL,
  `rate` decimal(16,2) DEFAULT NULL,
  `currency` varchar(32) DEFAULT NULL,
  `type` int(2) DEFAULT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `redirect_link` text,
  `image` varchar(32) DEFAULT NULL,
  `status` int(1) DEFAULT '0',
  `active` int(1) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pix_end_to_end_id` varchar(40) DEFAULT NULL,
  `pix_callback` text,
  `creditcard_payment_id` varchar(100) DEFAULT NULL,
  `creditcard_brand` varchar(20) DEFAULT NULL,
  `creditcard_installments` int(11) DEFAULT NULL,
  `creditcard_callback` text,
  `creditcard_status` enum('NOT_FINISHED','AUTHORIZED','PAYMENT_CONFIRMED','DENIED','VOIDED','REFUNDED','PENDING','ABORTED','SCHEDULED') DEFAULT NULL,
  `creditcard_status_description` text,
  `gateway` varchar(40) DEFAULT NULL,
  `creditcard_proof_of_sale` varchar(80) DEFAULT NULL,
  `creditcard_transaction_id` varchar(80) DEFAULT NULL,
  `creditcard_authorization_code` varchar(80) DEFAULT NULL,
  `pix_transaction_id` varchar(255) DEFAULT NULL,
  `pix_copy_past` text,
  `pix_qrcode` text,
  `boleto_transaction_id` varchar(255) DEFAULT NULL,
  `boleto_url` text,
  `boleto_barcode` varchar(200) DEFAULT NULL,
  `boleto_digitable_line` varchar(200) DEFAULT NULL,
  `payment_type` varchar(80) DEFAULT NULL,
  `client_name` varchar(255) DEFAULT NULL,
  `client_document` varchar(20) DEFAULT NULL,
  `due_date` timestamp NULL DEFAULT NULL,
  `currency_id` bigint(20) DEFAULT NULL,
  `charge` decimal(16,2) DEFAULT NULL,
  `total` decimal(16,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `payment_link`
--
ALTER TABLE `payment_link`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `payment_link`
--
ALTER TABLE `payment_link`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;
COMMIT;


ALTER TABLE `payment_link` ADD `received_total` DECIMAL(16,2) NULL AFTER `total`;


ALTER TABLE `donations`  ADD `pix_transaction_id` VARCHAR(255) NULL  AFTER `updated_at`,  ADD `pix_copy_past` TEXT NULL  AFTER `pix_transaction_id`,  ADD `pix_qrcode` TEXT NULL  AFTER `pix_copy_past`,  ADD `boleto_transaction_id` VARCHAR(80) NULL  AFTER `pix_qrcode`,  ADD `boleto_url` TEXT NULL  AFTER `boleto_transaction_id`,  ADD `boleto_barcode` VARCHAR(200) NULL  AFTER `boleto_url`,  ADD `boleto_digitable_line` VARCHAR(200) NULL  AFTER `boleto_barcode`;
ALTER TABLE `transactions` ADD `donation_id` BIGINT NULL AFTER `received_total`;


/* ****** 02/05/2023 **** */

ALTER TABLE `donations` ADD `payment_type` VARCHAR(80) NULL AFTER `boleto_digitable_line`;

ALTER TABLE `transactions` CHANGE `invoice_id` `invoice_id` BIGINT(20) NULL;

DROP TABLE `orders`;

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `first_name` varchar(64) DEFAULT NULL,
  `last_name` varchar(64) DEFAULT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `ip_address` varchar(32) DEFAULT NULL,
  `card_number` varchar(32) DEFAULT NULL,
  `payment_type` varchar(32) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `amount` varchar(32) DEFAULT NULL,
  `rate` varchar(32) DEFAULT NULL,
  `currency` varchar(32) DEFAULT NULL,
  `total` varchar(32) DEFAULT NULL,
  `charge` varchar(32) DEFAULT NULL,
  `shipping_fee` varchar(32) DEFAULT NULL,
  `address` text,
  `country` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `town` text,
  `ref_id` varchar(32) NOT NULL,
  `status` int(1) DEFAULT '0',
  `phone` varchar(32) DEFAULT NULL,
  `note` text,
  `ship_id` int(32) DEFAULT NULL,
  `store_id` int(32) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pix_end_to_end_id` varchar(40) DEFAULT NULL,
  `pix_callback` text,
  `creditcard_payment_id` varchar(100) DEFAULT NULL,
  `creditcard_brand` varchar(100) DEFAULT NULL,
  `creditcard_installments` int(11) DEFAULT NULL,
  `creditcard_callback` text,
  `creditcard_status` enum('NOT_FINISHED','AUTHORIZED','PAYMENT_CONFIRMED','DENIED','VOIDED','REFUNDED','PENDING','ABORTED','SCHEDULED') DEFAULT NULL,
  `creditcard_status_description` text,
  `gateway` varchar(40) DEFAULT NULL,
  `creditcard_proof_of_sale` varchar(80) DEFAULT NULL,
  `creditcard_transaction_id` varchar(80) DEFAULT NULL,
  `creditcard_authorization_code` varchar(80) DEFAULT NULL,
  `pix_transaction_id` varchar(255) DEFAULT NULL,
  `pix_copy_past` text,
  `pix_qrcode` text,
  `boleto_transaction_id` varchar(255) DEFAULT NULL,
  `boleto_url` text,
  `boleto_barcode` varchar(200) DEFAULT NULL,
  `boleto_digitable_line` varchar(200) DEFAULT NULL,
  `client_name` varchar(255) DEFAULT NULL,
  `client_document` varchar(20) DEFAULT NULL,
  `due_date` timestamp NULL DEFAULT NULL,
  `currency_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--


ALTER TABLE `orders` ADD `total_received` DECIMAL(16,2) NOT NULL DEFAULT '0' AFTER `currency_id`;

ALTER TABLE `orders` CHANGE `amount` `amount` DECIMAL(16,2) NULL DEFAULT NULL, CHANGE `total` `total` DECIMAL(16,2) NULL DEFAULT NULL, CHANGE `charge` `charge` DECIMAL(16,2) NULL DEFAULT NULL, CHANGE `shipping_fee` `shipping_fee` DECIMAL(16,2) NULL DEFAULT NULL;

ALTER TABLE `users` CHANGE `balance` `balance` DECIMAL(16,2) NULL DEFAULT NULL;

CREATE TABLE `users_taxes` ( `id` BIGINT NOT NULL AUTO_INCREMENT ,  `user_id` BIGINT NOT NULL ,  `use_taxes` INT NOT NULL ,  `transfer_charge` DECIMAL(8,2) NOT NULL ,  `transfer_chargep` DECIMAL(8,2) NOT NULL ,  `merchant_charge` DECIMAL(8,2) NOT NULL ,  `merchant_chargep` DECIMAL(8,2) NOT NULL ,  `invoice_charge` DECIMAL(8,2) NOT NULL ,  `invoice_chargep` DECIMAL(8,2) NOT NULL ,  `product_charge` DECIMAL(8,2) NOT NULL ,  `product_chargep` DECIMAL(8,2) NOT NULL ,  `single_charge` DECIMAL(8,2) NOT NULL ,  `single_chargep` DECIMAL(8,2) NOT NULL ,  `donation_charge` DECIMAL(8,2) NOT NULL ,  `donation_chargep` DECIMAL(8,2) NOT NULL ,  `bill_charge` DECIMAL(8,2) NOT NULL ,  `bill_chargep` DECIMAL(8,2) NOT NULL ,  `created_at` TIMESTAMP NOT NULL ,  `updated_at` TIMESTAMP NOT NULL ,  `admin_id` BIGINT NOT NULL ,    PRIMARY KEY  (`id`)) ENGINE = InnoDB;

ALTER TABLE `users_taxes` ADD `withdraw_charge` DECIMAL(8,2) NOT NULL AFTER `admin_id`, ADD `withdraw_chargep` DECIMAL(8,2) NOT NULL AFTER `withdraw_charge`;




ALTER TABLE `users` ADD `enroller` BIGINT NULL AFTER `original_hub_pix_fee`;
ALTER TABLE `settings`  ADD `withdraw_comission` DECIMAL(8,2) NOT NULL DEFAULT '0' 
 AFTER `company_corporate_name`,  ADD `deposit_comission` DECIMAL(8,2) NOT NULL DEFAULT '0' 
  AFTER `withdraw_comission`,  ADD `invoice_comission` DECIMAL(8,2) NOT NULL DEFAULT '0'  
  AFTER `deposit_comission`,  ADD `payment_link_comission` DECIMAL(8,2) NOT NULL DEFAULT '0' 
   AFTER `invoice_comission`,  ADD `donation_comission` DECIMAL(8,2) NOT NULL DEFAULT '0'  
   AFTER `payment_link_comission`,  ADD `store_comission` DECIMAL(8,2) NOT NULL DEFAULT '0'  
   AFTER `donation_comission`;



ALTER TABLE `users_taxes`  ADD `withdraw_comission` DECIMAL(8,2) NOT NULL DEFAULT '0' 
 AFTER `withdraw_chargep`,  
 ADD `use_comissions` int NOT NULL DEFAULT '0' 
  AFTER `withdraw_comission`,
 ADD `deposit_comission` DECIMAL(8,2) NOT NULL DEFAULT '0' 
  AFTER `withdraw_comission`,  ADD `invoice_comission` DECIMAL(8,2) NOT NULL DEFAULT '0'  
  AFTER `deposit_comission`,  ADD `payment_link_comission` DECIMAL(8,2) NOT NULL DEFAULT '0' 
   AFTER `invoice_comission`,  ADD `donation_comission` DECIMAL(8,2) NOT NULL DEFAULT '0'  
   AFTER `payment_link_comission`,  ADD `store_comission` DECIMAL(8,2) NOT NULL DEFAULT '0'  
   AFTER `donation_comission`;


ALTER TABLE `history` CHANGE `updated_at` `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;

   ALTER TABLE `history` ADD `entity_type` ENUM('WITHDRAW','FUND','DONATION','PAYMENT_LINK','COMISSION','ORDER','INVOICE') NOT NULL DEFAULT 'INVOICE' AFTER `updated_at`;


   CREATE TABLE `callbacks` ( 
    `id` BIGINT NOT NULL , 
    `reference` VARCHAR(80) NOT NULL , 
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
    `entity_type` ENUM('INVOICE','WITHDRAW','FUND','PAYMENT_LINK','DONATION','STORE') NOT NULL , 
    `entity_ref` VARCHAR(80) NOT NULL , 
    `entity_id` BIGINT NOT NULL , 
    `body` TEXT NOT NULL , 
    `host_url` VARCHAR(255) NOT NULL , 
    `first_try` TIMESTAMP NULL , 
    `last_try` TIMESTAMP NULL , 
    `tries` INT NOT NULL DEFAULT '0' , 
    `http_response_code` VARCHAR(20) NULL , 
    `http_response_body` TEXT NULL 
) ENGINE = InnoDB;

ALTER TABLE `callbacks` CHANGE `id` `id` BIGINT(20) NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`id`);

ALTER TABLE `users` ADD `callback_url` VARCHAR(255) NULL AFTER `secret_key`;

ALTER TABLE `compliance` CHANGE `month_revenue` `month_revenue` DECIMAL(16,2) NULL DEFAULT '0.00';
ALTER TABLE `w_history` ADD `pix_txid` VARCHAR(100) NULL AFTER `pix_entoend`;


ALTER TABLE `invoices` CHANGE `invoice_no` `invoice_no` VARCHAR(100) NOT NULL;


/** 27-01-2024 **/

ALTER TABLE `compliance` 
CHANGE `status_personal` `status_personal` ENUM('PENDING','ANALYSIS','REJECTED','APPROVED','NONE') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'NONE', 
CHANGE `status_business` `status_business` ENUM('PENDING','ANALYSIS','REJECTED','APPROVED','NONE') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'NONE';


ALTER TABLE `compliance`  
ADD `personal_document_status` ENUM('NONE','PENDING','APPROVED','REJECTED') NOT NULL DEFAULT 'NONE'  AFTER `business_national_registry`,  
ADD `personal_proof_status` ENUM('NONE','PENDING','APPROVED','REJECTED') NOT NULL DEFAULT 'NONE'  AFTER `personal_document_status`,  
ADD `personal_selfie_status` ENUM('NONE','PENDING','APPROVED','REJECTED') NOT NULL DEFAULT 'NONE'  AFTER `personal_proof_status`,  
ADD `personal_document_msg` VARCHAR(255) NULL  AFTER `personal_selfie_status`,  
ADD `personal_proof_msg` VARCHAR(255) NULL  AFTER `personal_document_msg`,  
ADD `personal_selfie_msg` VARCHAR(255) NULL  AFTER `personal_proof_msg`;

ALTER TABLE `compliance` 
ADD `personal_status_msg` VARCHAR(255) NULL AFTER `personal_selfie_msg`, 
ADD `business_status_msg` VARCHAR(255) NULL AFTER `personal_status_msg`;


ALTER TABLE `compliance`  
ADD `business_registry_status` ENUM('NONE','PENDING','APPROVED','REJECTED') NOT NULL DEFAULT 'NONE'  AFTER `business_status_msg`,  
ADD `business_proof_status` ENUM('NONE','PENDING','APPROVED','REJECTED') NOT NULL DEFAULT 'NONE'  AFTER `business_registry_status`,  
ADD `business_registry_msg` VARCHAR(255) NULL  AFTER `business_proof_status`,  
ADD `business_proof_msg` VARCHAR(255) NULL  AFTER `business_registry_msg`;



CREATE TABLE `creditcard_fee_table` ( 
    `id` BIGINT NOT NULL AUTO_INCREMENT ,  
    `user_id` BIGINT NULL ,  
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,  
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,    
    PRIMARY KEY  (`id`)
) ENGINE = InnoDB;


CREATE TABLE `creditcard_fee_installment` ( 
    `id` BIGINT NOT NULL AUTO_INCREMENT ,  
    `creditcard_fee_table_id` BIGINT NOT NULL ,  
    `installments` TINYINT NOT NULL ,  
    `tax` DECIMAL(8,2) NOT NULL ,  
    `tax_p` DECIMAL(4,2) NOT NULL ,  
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,  
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,    
    PRIMARY KEY  (`id`)
) ENGINE = InnoDB;



ALTER TABLE `creditcard_fee_table` ADD `use_table` TINYINT NOT NULL AFTER `id`;

ALTER TABLE `settings` ADD `days_creditcard_liquidation` TINYINT NOT NULL DEFAULT '3' AFTER `store_comission`;
ALTER TABLE `users_taxes` ADD `days_creditcard_liquidation` TINYINT NOT NULL DEFAULT '3' AFTER `use_comissions`;

CREATE TABLE `pending_balances` ( 
  `id` BIGINT NOT NULL AUTO_INCREMENT ,  
  `user_id` BIGINT NOT NULL ,  
  `entity_type` ENUM('INVOICE','FUND','SINGLE_CHARGE','DONATION','STORE') NOT NULL ,  
  `entity_ref` VARCHAR(40) NOT NULL ,  
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,  
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,  
  `amount` DECIMAL(25,2) NOT NULL ,  
  `charge` DECIMAL(8,2) NOT NULL ,  
  `liquidation_date` TIMESTAMP NOT NULL ,  
  `liquidated` TINYINT NOT NULL DEFAULT '0' ,    
  PRIMARY KEY  (`id`)
) ENGINE = InnoDB;

ALTER TABLE `pending_balances` ADD `description` VARCHAR(255) NOT NULL AFTER `liquidated`;


ALTER TABLE `settings` ADD `business_limit` DECIMAL(25,2) NOT NULL DEFAULT '100000' AFTER `days_creditcard_liquidation`;
ALTER TABLE `users_gateways` CHANGE `type` `type` ENUM('CREDIT_CARD','DEBIT_CARD','BOLETO','PIX', 'PIX_OUT') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

ALTER TABLE `w_history` ADD `paid_at` TIMESTAMP NULL AFTER `pix_txid`;

ALTER TABLE `w_history` CHANGE `reference` `reference` VARCHAR(80) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

ALTER TABLE `history` CHANGE `ref` `ref` VARCHAR(80) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;


ALTER TABLE `w_history`  
ADD `destinatary_name` VARCHAR(255) NULL  AFTER `paid_at`,  
ADD `destinatary_document` VARCHAR(20) NULL  AFTER `destinatary_name`,  
ADD `destinatary_email` VARCHAR(255) NULL  AFTER `destinatary_document`;

ALTER TABLE `gateways` 
ADD `cashin` INT NOT NULL DEFAULT '0' AFTER `updated_at`, 
ADD `cashout` INT NOT NULL DEFAULT '0' AFTER `cashin`;

ALTER TABLE `users_gateways` 
ADD `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `type`, 
ADD `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`;


CREATE TABLE `gateways_calls` ( `id` BIGINT NOT NULL AUTO_INCREMENT ,  `created_at` TIMESTAMP NOT NULL ,  `updated_at` TIMESTAMP NOT NULL ,  `host` VARCHAR(255) NOT NULL ,  `request_body` TEXT NOT NULL ,  `method` VARCHAR(40) NOT NULL ,  `response` LONGTEXT NOT NULL ,  `http_code_response` VARCHAR(10) NOT NULL ,  `user_id` BIGINT NOT NULL ,    PRIMARY KEY  (`id`)) ENGINE = InnoDB;
ALTER TABLE `gateways_calls` CHANGE `user_id` `user_id` BIGINT(20) NULL;



update history set amount = 0 where amount is null;
update history set amount = 0.0 where amount = '0';
update history set amount = 0.0 WHERE amount LIKE 'INV%' OR amount LIKE 'ST%' OR amount LIKE 'INV%' OR amount LIKE 'DN%' OR amount LIKE 'COMISSION%';


alter table history modify amount decimal(16,2) not null default 0.0;

update history set charge = 0.0 WHERE charge is null;

update history set charge = 0.0 WHERE charge LIKE 'INV%' OR charge LIKE 'ST%' OR charge LIKE 'INV%' OR charge LIKE 'DN%' OR charge LIKE 'COMISSION%';

alter table history modify charge decimal(10,2) not null default 0.0
update history set rate = 1.0 WHERE rate = '0.0';
alter table history modify rate decimal(8,2) not null default 0.0

ALTER TABLE `settings`  
ADD `enable_account_payment` INT NOT NULL DEFAULT '1'  AFTER `business_limit`,  
ADD `enable_boleto_payment` INT NOT NULL DEFAULT '1'  AFTER `enable_account_payment`,  
ADD `enable_creditcard_payment` INT NOT NULL DEFAULT '1'  AFTER `enable_boleto_payment`,  
ADD `enable_pix_payment` INT NOT NULL DEFAULT '1'  AFTER `enable_creditcard_payment`;

ALTER TABLE `users_taxes`  
ADD `enable_account_payment` INT NOT NULL DEFAULT '1'  AFTER `days_creditcard_liquidation`,  
ADD `enable_boleto_payment` INT NOT NULL DEFAULT '1'  AFTER `enable_account_payment`,  
ADD `enable_creditcard_payment` INT NOT NULL DEFAULT '1'  AFTER `enable_boleto_payment`,  
ADD `enable_pix_payment` INT NOT NULL DEFAULT '1'  AFTER `enable_creditcard_payment`;
ALTER TABLE `users_taxes`  ADD `use_payment_configs` INT NOT NULL DEFAULT '0'  AFTER `enable_pix_payment`;


ALTER TABLE `gateways` 
ADD `boleto` INT NOT NULL DEFAULT '0' AFTER `cashout`, 
ADD `creditcard` INT NOT NULL DEFAULT '0' AFTER `boleto`;

ALTER TABLE `charges` CHANGE `ref_id` `ref_id` VARCHAR(80) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;


ALTER TABLE `settings` ADD `max_automatic_withdraw_value` DECIMAL(16,2) NOT NULL DEFAULT '1000' AFTER `enable_pix_payment`;

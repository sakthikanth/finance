
             insert into extra_expense (fin_id,exp_amount,discription,exp_type,date,tot_expense,`off_exp`, `slry_exp`, `rr_exp`, `ad_exp`, `otr_exp`, `bnk_exp`)values(2,77,'N','ad_jsk','24-12-2016 6:45 PM',4243,0,3046,42,1155,0,0)
             INSERT INTO `amount_status` (`log_id`, `date_entry`, `money_out`, `mo_reason`, `remain_bal`, `fin_id`, `cust_id`, `loan_type`,`my_date`,`exp_id`) VALUES (NULL, '2016-12-24', '77', 'N', 2147479538, 2, '', '','24-12-2016 6:45 PM','58');
             insert into extra_expense (fin_id,exp_amount,discription,exp_type,date,tot_expense,`off_exp`, `slry_exp`, `rr_exp`, `ad_exp`, `otr_exp`, `bnk_exp`)values(2,88,'Jjj','ad_jsk','24-12-2016 6:46 PM',4331,0,3046,42,1243,0,0)
             INSERT INTO `amount_status` (`log_id`, `date_entry`, `money_out`, `mo_reason`, `remain_bal`, `fin_id`, `cust_id`, `loan_type`,`my_date`,`exp_id`) VALUES (NULL, '2016-12-24', '88', 'Jjj', 2147479450, 2, '', '','24-12-2016 6:46 PM','59');
             insert into  amount_status (money_out,fin_id,remain_bal,delt,my_date,exp_id,mo_reason,date_entry)values(88,2,2147479538,1,'24-12-2016 6:47 PM',59,'Jjj','2016-12-24');
             delete from extra_expense where exp_id=59;
             insert into extra_expense (fin_id,off_exp,ad_exp,rr_exp,bnk_exp,otr_exp,slry_exp,tot_expense)values(2,0,1155,42,0,0,3046,0);
             insert into  amount_status (money_out,fin_id,remain_bal,delt,my_date,exp_id,mo_reason,date_entry)values(88,2,2147479626,1,'24-12-2016 6:48 PM',59,'','2016-12-24');
             delete from extra_expense where exp_id=59;
             insert into extra_expense (fin_id,off_exp,ad_exp,rr_exp,bnk_exp,otr_exp,slry_exp,tot_expense)values(2,0,1067,42,0,0,3046,0);
             insert into  amount_status (money_out,fin_id,remain_bal,delt,my_date,exp_id,mo_reason,date_entry)values(88,2,2147479714,1,'24-12-2016 6:48 PM',59,'','2016-12-24');
             delete from extra_expense where exp_id=59;
             insert into extra_expense (fin_id,off_exp,ad_exp,rr_exp,bnk_exp,otr_exp,slry_exp,tot_expense)values(2,0,979,42,0,0,3046,0);
             insert into  amount_status (money_out,fin_id,remain_bal,delt,my_date,exp_id,mo_reason,date_entry)values(77,2,2147479791,1,'24-12-2016 6:48 PM',58,'N','2016-12-24');
             delete from extra_expense where exp_id=58;
             insert into extra_expense (fin_id,off_exp,ad_exp,rr_exp,bnk_exp,otr_exp,slry_exp,tot_expense)values(2,0,902,42,0,0,3046,0);
             insert into extra_expense (fin_id,exp_amount,discription,exp_type,date,tot_expense,`off_exp`, `slry_exp`, `rr_exp`, `ad_exp`, `otr_exp`, `bnk_exp`)values(2,44,'4','s_jsk','24-12-2016 6:52 PM',44,0,3090,42,902,0,0);
             INSERT INTO `amount_status` (`log_id`, `date_entry`, `money_out`, `mo_reason`, `remain_bal`, `fin_id`, `cust_id`, `loan_type`,`my_date`,`exp_id`) VALUES (NULL, '2016-12-24', '44', '4', 2147479747, 2, '', '','24-12-2016 6:52 PM','64');;
             insert into extra_expense (fin_id,exp_amount,discription,exp_type,date,tot_expense,`off_exp`, `slry_exp`, `rr_exp`, `ad_exp`, `otr_exp`, `bnk_exp`)values(2,55,'D','s_jsk','24-12-2016 6:53 PM',99,0,3145,42,902,0,0);
             INSERT INTO `amount_status` (`log_id`, `date_entry`, `money_out`, `mo_reason`, `remain_bal`, `fin_id`, `cust_id`, `loan_type`,`my_date`,`exp_id`) VALUES (NULL, '2016-12-24', '55', 'D', 2147479692, 2, '', '','24-12-2016 6:53 PM','65');;
             insert into extra_expense (fin_id,exp_amount,discription,exp_type,date,tot_expense,`off_exp`, `slry_exp`, `rr_exp`, `ad_exp`, `otr_exp`, `bnk_exp`)values(2,33,'Sd','s_jsk','24-12-2016 6:53 PM',132,0,3178,42,902,0,0);
             INSERT INTO `amount_status` (`log_id`, `date_entry`, `money_out`, `mo_reason`, `remain_bal`, `fin_id`, `cust_id`, `loan_type`,`my_date`,`exp_id`) VALUES (NULL, '2016-12-24', '33', 'Sd', 2147479659, 2, '', '','24-12-2016 6:53 PM','66');;
             insert into extra_expense (fin_id,exp_amount,discription,exp_type,date,tot_expense,`off_exp`, `slry_exp`, `rr_exp`, `ad_exp`, `otr_exp`, `bnk_exp`)values(2,55,'N','s_jsk','24-12-2016 6:57 PM',187,0,3233,42,902,0,0);
             INSERT INTO `amount_status` (`log_id`, `date_entry`, `money_out`, `mo_reason`, `remain_bal`, `fin_id`, `cust_id`, `loan_type`,`my_date`,`exp_id`) VALUES (NULL, '2016-12-24', '55', 'N', 2147479604, 2, '', '','24-12-2016 6:57 PM','67');;
             insert into extra_expense (fin_id,exp_amount,discription,exp_type,date,tot_expense,`off_exp`, `slry_exp`, `rr_exp`, `ad_exp`, `otr_exp`, `bnk_exp`)values(2,33,'Ds','s_jsk','24-12-2016 6:57 PM',220,0,3266,42,902,0,0);
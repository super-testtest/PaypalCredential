<?php

class Company_Web_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getIp()
   	{
        /* Perticular Ip Can Access Admin Pennel Of Magento */
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        $table = $resource->getTableName('web/web');
        $ipaddress = $readConnection->fetchCol('SELECT ipaddress FROM '.$table.'');
        $count=sizeof($ipaddress);
        $falg=0;
        $ip = $_SERVER['REMOTE_ADDR'];
        for($i=0;$i<=$count;$i++)
        {
            if($ip==$ipaddress[$i])
            {
                 $flag=1; // DataBase Ip is Same with Our Pc Ip Address.
            }

        }
        if($flag==1)
        {

        }
        else
        {
            Mage::throwException(Mage::helper('admin')->__('can not Access admin panel'));
        }
        /**********************************************************/
    }
}

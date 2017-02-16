<?php
class Tailored_Helloworld_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
        if($data=$this->getRequest()->getPost())
        {
            $model = Mage::getModel('helloworld/helloworld');
            if(isset($_FILES['city']['name']) and (file_exists($_FILES['city']['tmp_name'])))
            {
                try
                {
                    $uploader = new Varien_File_Uploader('city');
                    $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
                    $uploader->setAllowRenameFiles(false);
                    $uploader->setFilesDispersion(false);
                    $path = Mage::getBaseDir('media') . DS .'blog'.DS;
                    $cleaned_image_name = str_replace(' ', '_', $_FILES['city']['name']);
                    $dest_featured_img = $path.$cleaned_image_name;
                    $new_fetaured_img_name = $uploader->getNewFileName($dest_featured_img);
                    $uploader->save($path, $new_fetaured_img_name);
                    $data['city'] = $new_fetaured_img_name;
                }
                catch(Exception $e)
                {
                    echo $e->getMessage();
                    exit;
                }
            }
            $model->setData($data);
            $model->save();
        }
    }
}
?>



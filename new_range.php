<?php

if (!defined('_PS_VERSION_'))
    exit;

class New_range extends Module
{
    public function __construct()
    {
        $this->name = 'new_range';
        $this->version = '1.0.0';
        $this->author = 'Николай';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
        $this->bootstrap = true;
        parent::__construct();
        $this->description = $this->l('Тестовый модуль.');
    }
    public function install()
    {
        Configuration::updateValue('min_price',NULL);
        Configuration::updateValue('max_price',NULL);
        return parent::install() 
        && $this->registerHook('DisplayFooter');
    }
    public function unistall()
    {
        Configuration::deleteByName('min_price');
        Configuration::deleteByName('max_price');
        return parent::unistall();
    }

    public function hookDisplayFooter($params)
    {
        $min = Configuration::get('min_price');
        $max = Configuration::get('max_price');

        $sql = "SELECT count(*) as c FROM `ps_layered_price_index` WHERE $min<price_max and price_max<$max";
        $results = Db::getInstance()->ExecuteS($sql);
        return '<h4>Колличество товаров в указанном диапазоне '.$results[0]['c'].'</h4>';
    }

    public function getContent()
    {
        $form=file_get_contents(__DIR__.'/views/form.html');
        if(isset($_POST['min_price'])&&isset($_POST['max_price']))
        {
            if(!is_numeric($_POST['min_price']) || !is_numeric($_POST['max_price']))
                $message='<b> Допускаются только числовые значения !</b>';
            else
                {
                    if($_POST['min_price']<=$_POST['max_price'])
                    {
                        Configuration::updateValue('min_price',$_POST['min_price']);
                        Configuration::updateValue('max_price',$_POST['max_price']);
                        $message='<b>Данные успешно записаны!</b>';
                    }
                    else $message='<b>Минимальное значение должно быть меньше максимального!</b>'; 
                }
        }
        $form=str_replace('#nim#',Configuration::get('min_price'),$form);
        $form=str_replace('#max#',Configuration::get('max_price'),$form);

        return $form.$message;
    }



}
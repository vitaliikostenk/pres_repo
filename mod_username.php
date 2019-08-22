<?php
defined('_JEXEC') or die;

class modUserName
{
    private $db;
    private $userInfo;

    public function __construct()
    {
        $this->db = JFactory::getDbo();
        $this->userInfo = JFactory::getUser();
    }

    public function getJoomlaUserName()
    {
        return $this->userInfo->username;
    }

    public function setUserInitials() 
    {
        $initials = "";
        $name = $this->getJoomlaUserName();

        if (ctype_upper(substr($name, 0, 2)))
        {
            $initials .= substr($name, 0, 2);
        }
        else
        {
            $dividedName = explode("_", $name);
            foreach ($dividedName as $value)
            {
                $initials .= strtoupper($value{0});
            }
        }
        return $initials;
    }

    public function showVersionNumber()
    {
      $version = 'V ';
      $isCCM = 11;
      $isAd = 70;

      $group = $this->getGroup();

      if (in_array($isCCM, $group))
      {
        $tablePrefix = 'ccm_';
        $id = 800;
      }
      else if (in_array($isAd, $group))
      {
        $tablePrefix = 'ad_';
        $id = 186;
      }
      
      if ($id)
      {
        $query = $this->db->getQuery(true)
        ->select('TextValue')
        ->from($tablePrefix.'code_item')
        ->where('id='.$id);
        try
        {
          $version .= $this->db->setQuery($query)
            ->loadResult();
        }
        catch (\RuntimeException $e) { $this->setError($e->getMessage()); }
      }
      
      return $version;
    }

    public function setProjectName()
    {
      $isCCM = 11;
      $isAd = 70;
      $group = $this->getGroup();

      if (in_array($isCCM, $group))
        $projName = 'Coastal Calibration';
      else if (in_array($isAd, $group))
        $projName = 'Access Direct';

      return $projName;
    }

    private function getGroup()
    {
      $group = $this->userInfo->groups;

      return $group;
    }

    protected function getUserColor()
    {
      try
      {
        $getColor = $this->db->setQuery(
            $this->db->getQuery(true)
                ->select($db->quoteName('UserColor'))
                ->from($db->quoteName('ccm_employee'))
                ->where($db->quoteName('Label') . ' = ' . $db->quote($name))
        )->loadResult();
      }
      catch (Exception $ex)
      {
          echo JText::sprintf('JLIB_DATABASE_ERROR_FUNCTION_FAILED', $e->getCode(), $e->getMessage()) . '<br />';
          return;
      }

      if (is_null($getColor))
      {
          $getColor = '#000000';
      } else {
          $RGB = explode(",", $getColor);
          $getColor = hexColor($RGB);
      }
      return false;
    }

    protected function hexColor($color) {
        $rgb = dechex(($color[0]<<16)|($color[1]<<8)|$color[2]);
        return("#".substr("000000".$rgb, -6));
    }
}

$modUserName = new modUserName();

require JModuleHelper::getLayoutPath('mod_username', 'default');

<?php
/*****************************************************************************************
 * X2Engine Open Source Edition is a customer relationship management program developed by
 * X2Engine, Inc. Copyright (C) 2011-2014 X2Engine Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY X2ENGINE, X2ENGINE DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact X2Engine, Inc. P.O. Box 66752, Scotts Valley,
 * California 95067, USA. or at email address contact@x2engine.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * X2Engine" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by X2Engine".
 *****************************************************************************************/

/**
 * Manages storage and retrieval of grid view settings.
 * Settings are stored in the generalGridViewSettings attribute of the user's profile record.
 * Grid view column settings and data provider results per page are not managed by this class.
 *
 * @package application.components.X2GridView
 */
class GridViewDbSettingsBehavior extends CBehavior {
    
    /**
     * @param string $gridViewUID The UID of the grid view
     * @param array (<setting name> => <setting val>) $settings The settings to save
     * @return bool true for success, false otherwise
     */
    public static function saveSettings ($gridViewUID, array $settings) {
        $profile = Yii::app()->params->profile;
        $gvSettings = CJSON::decode ($profile->generalGridViewSettings); 
        if (!is_array ($gvSettings))
            $gvSettings = array ();
        $gvSettings[$gridViewUID] = $settings;
        $profile->generalGridViewSettings = CJSON::encode ($gvSettings);
        return $profile->save ();
    }

    /**
     * @param string $gridViewUID The UID of the grid view
     */
    public static function getSettings ($gridViewUID) {
        $profile = Yii::app()->params->profile;
        $gvSettings = CJSON::decode ($profile->generalGridViewSettings); 
        return CJSON::decode ($gvSettings[$gridViewUID]);
    }

    /**
     * @param string $gridViewUID The UID of the grid view
     * @param string key the setting name
     * @param string key the setting value
     * @return bool true for success, false otherwise
     */
    public static function saveSetting ($gridViewUID, $key, $val) {
        $profile = Yii::app()->params->profile;
        $gvSettings = CJSON::decode ($profile->generalGridViewSettings); 
        if (!is_array ($gvSettings))
            $gvSettings = array ();
        if (!is_array ($gvSettings[$gridViewUID]))
            $gvSettings[$gridViewUID] = array ();
        $gvSettings[$gridViewUID][$key] = $val;
        $profile->generalGridViewSettings = CJSON::encode ($gvSettings);
        return $profile->save ();
    }

    /**
     * @param string $gridViewUID The UID of the grid view
     * @param string key the setting name
     * @return mixed The value of the gv setting
     */
    public static function getSetting ($gridViewUID, $key) {
        $profile = Yii::app()->params->profile;
        $gvSettings = CJSON::decode ($profile->generalGridViewSettings); 
        if (is_array ($gvSettings) && is_array ($gvSettings[$gridViewUID]) &&
            isset ($gvSettings[$gridViewUID][$key])) {

            return $gvSettings[$gridViewUID][$key];
        }
    }

}
?>


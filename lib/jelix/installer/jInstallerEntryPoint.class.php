<?php
/**
* @package     jelix
* @subpackage  installer
* @author      Laurent Jouanneau
* @contributor 
* @copyright   2009 Laurent Jouanneau
* @link        http://jelix.org
* @licence     GNU Lesser General Public Licence see LICENCE file or http://www.gnu.org/licenses/lgpl.html
*/

/**
 * container for module properties
 */
class jInstallerModuleInfos {
    public $name;
    public $access;
    public $dbProfile;
    public $isInstalled;
    public $version;
    public $sessionId;
    
    function __construct($name, $config) {
        $this->name = $name;
        $this->access = $config->modules[$name.'.access'];
        $this->dbProfile = $config->modules[$name.'.dbprofile'];
        $this->isInstalled = $config->modules[$name.'.installed'];
        $this->version = $config->modules[$name.'.version'];
        $this->sessionId = $config->modules[$name.'.sessionid'];
    }
}


/**
 * container for entry points properties
 */
class jInstallerEntryPoint {

    /** @var StdObj   configuration parameters. content of the config file */
    public $config;

    /** @var string the filename of the configuration file */
    public $configFile;

    /**
     * @var boolean true if the script corresponding to the configuration
     *                is a script for CLI
     */
    public $isCliScript;

    /**
     * @var string the url path of the entry point
     */
    public $scriptName;

    /**
     * @var string the filename of the entry point
     */
    public $file;

    /**
     * @param string $configFile the path of the configuration file, relative
     *                           to the var/config directory
     * @param string $file the filename of the entry point
     * @param boolean $isCliScript true if the script corresponding to the configuration
     *                is a script for CLI
     */
    function __construct($configFile, $file, $isCliScript) {
        $this->isCliScript = $isCliScript;
        $this->configFile = $configFile;
        $this->scriptName =  ($isCliScript?$file:'/'.$file);
        $this->file = $file;
        // we don't load yet a jIniMultiFilesModifier because installer
        // could modify defaultconfig file, so other installer should have
        // a jIniMultiFilesModifier loaded with the good version of the
        // defaultconfig file. However, we load a static version of
        // the configuration here because we need it.
        $this->config = jConfigCompiler::read($configFile, true,
                                        $isCliScript, $this->scriptName);
    }

    /**
     * @return string the entry point id
     */
    function getEpId() {
        return $this->config->urlengine['urlScriptId'];
    }

    /**
     * @return array the list of modules and their path, as stored in the
     * compiled configuration file
     */
    function getModulesList() {
        return $this->config->_allModulesPathList;
    }

    /**
     * @return jInstallerModuleInfos informations about a specific module used
     * by the entry point
     */
    function getModule($moduleName) {
        return new jInstallerModuleInfos($moduleName, $this->config);
    }

}

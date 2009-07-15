<?php
/**
* @package     jelix
* @subpackage  acl
* @author      Laurent Jouanneau
* @copyright   2006-2009 Laurent Jouanneau
* @link        http://www.jelix.org
* @licence     http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public Licence, see LICENCE file
* @since 1.1
*/


/**
 * This class is used to manage rights. Works only with db driver of jAcl2.
 * @package     jelix
 * @subpackage  acl
 * @static
 */
class jAcl2DbManager {

    /**
     * @internal The constructor is private, because all methods are static
     */
    private function __construct (){ }

    /**
     * add a right on the given subject/group/resource
     * @param int    $group the group id.
     * @param string $subject the key of the subject
     * @param string $resource the id of a resource
     * @return boolean  true if the right is set
     */
    public static function addRight($group, $subject, $resource=''){
        $profile = jAcl2Db::getProfile();
        $sbj = jDao::get('jacl2db~jacl2subject', $profile)->get($subject);
        if(!$sbj) return false;

        if($resource === null) $resource='';

        //  ajoute la nouvelle valeur
        $daoright = jDao::get('jacl2db~jacl2rights', $profile);
        $right = $daoright->get($subject,$group,$resource);
        if(!$right){
            $right = jDao::createRecord('jacl2db~jacl2rights', $profile);
            $right->id_aclsbj = $subject;
            $right->id_aclgrp = $group;
            $right->id_aclres = $resource;
            $daoright->insert($right);
        }
        jAcl2::clearCache();
        return true;
    }

    /**
     * remove a right on the given subject/group/resource
     * @param int    $group the group id.
     * @param string $subject the key of the subject
     * @param string $resource the id of a resource
     */
    public static function removeRight($group, $subject, $resource=''){
        if($resource === null) $resource='';
        jDao::get('jacl2db~jacl2rights', jAcl2Db::getProfile())
            ->delete($subject,$group,$resource);
        jAcl2::clearCache();
    }

    /**
     * set rights on the given group. Only rights on given subjects are changed.
     * Rights with resources are not changed.
     * @param int    $group the group id.
     * @param array  $rights, list of rights key=subject, value=true or non empty string
     */
    public static function setRightsOnGroup($group, $rights){
        $dao = jDao::get('jacl2db~jacl2rights', jAcl2Db::getProfile());
        
        $oldrights = array();
        $rs = $dao->getRightsByGroup($group);
        foreach($rs as $rec){
            $oldrights [$rec->id_aclsbj] = true;
        }
        
        $rightsToRemove = array();
        foreach($rights as $sbj=>$val) {
            if ($val != '' || $val == true) {
                if (!isset($oldrights[$sbj]))
                    self::addRight($group,$sbj);
            }
            else
                $rightsToRemove[] = $sbj;
        }

        if (count($rightsToRemove)) {
            $dao->deleteByGroupAndSubjects($group, $rightsToRemove);
        }

        jAcl2::clearCache();
    }

    /**
     * remove the right on the given subject/resource, for all groups
     * @param string  $subject the key of the subject
     * @param string $resource the id of a resource
     */
    public static function removeResourceRight($subject, $resource){
        jDao::get('jacl2db~jacl2rights', jAcl2Db::getProfile())->deleteBySubjRes($subject, $resource);
        jAcl2::clearCache();
    }

    /**
     * create a new subject
     * @param string  $subject the key of the subject
     * @param string $label_key the key of a locale which represents the label of the subject
     */
    public static function addSubject($subject, $label_key){
        // ajoute un sujet dans la table jacl_subject
        $p = jAcl2Db::getProfile();
        $subj = jDao::createRecord('jacl2db~jacl2subject',$p);
        $subj->id_aclsbj=$subject;
        $subj->label_key =$label_key;
        jDao::get('jacl2db~jacl2subject',$p)->insert($subj);
        jAcl2::clearCache();
    }

    /**
     * Delete the given subject
     * @param string  $subject the key of the subject
     */
    public static function removeSubject($subject){
        $p = jAcl2Db::getProfile();
        jDao::get('jacl2db~jacl2rights',$p)->deleteBySubject($subject);
        jDao::get('jacl2db~jacl2subject',$p)->delete($subject);
        jAcl2::clearCache();
    }
}

